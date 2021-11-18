<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\PurchaseDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Gate;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('name')->get();
        
        return view('admin.purchase.index', [
          'suppliers' => $suppliers,
          'setting' => Setting::first()
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    
    public function data()
    {
      $purchases = Purchase::with('supplier')->latest()->get();
      
      return datatables()
            ->of($purchases)
            ->addIndexColumn()
            ->addColumn('total_price', function($purchases) {
              return 'Rp ' . number_format($purchases->total_price, 0, ',', '.');
            })
            ->addColumn('discount', function($purchases) {
              return $purchases->discount . '%';
            })
            ->addColumn('paid', function($purchases) {
              return 'Rp ' . number_format($purchases->paid, 0, ',', '.');
            })
            ->addColumn('created_at', function($purchases) {
              return $purchases->created_at->locale('id_ID')->isoFormat('Do MMMM YYYY');
            })
            ->addColumn('aksi', function($purchases) {
              return '
                <div class="btn-group btn-group-sm">
                  <button class="btn btn-info"><i class="fas fa-eye" onclick="itemPurchase('. "$purchases->id" .')"></i></button>
                    <button class="btn btn-danger" onclick="deletePurchase('. "$purchases->id" .')"><i class="fas fa-times"></i></button>
                </div>
              ';
            })
            ->rawColumns(['aksi', 'paid', 'total_price', 'created_at', 'discount'])
            ->make(true);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storePurchase = Purchase::create([
          'supplier_id' => $request->supplier_id,
          'total_item' => 0,
          'total_price' => 0,
          'discount' => 0,
          'paid' => 0,
          'status' => 'active'
          ]);
          
        session(['supplier_id' => $storePurchase->supplier_id]);
        session(['purchase_id' => $storePurchase->id]);
        
        return redirect('/purchase_detail');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $purchase = Purchase::find($id);
        
        $purchase->discount = $request->discount;
        $purchase->update();
        
        return response()->json('Diskon berhasil diupdate');
    }
    
    public function save_purchase(Request $request)
    {
      $findPurchase = Purchase::find(session('purchase_id'));
      $purchase_detail = PurchaseDetail::with('product')
        ->where('purchase_id', $findPurchase->id)->get();
      
      $products = [];
      foreach ($purchase_detail as $row) {
        $products[] = $row->product;
      }
      
      foreach ($products as $product) {
        foreach ($purchase_detail as $purchase) {
          if($product->id === $purchase->product_id) {
            $updateStock = Product::find($product->id);
            $updateStock->stock += $purchase->qty;
            $updateStock->update();
          }
        }
      }
      
      $findPurchase->status = null;
      $findPurchase->total_price = $request->paid;
      $findPurchase->total_item = $request->total_item;
      $findPurchase->paid = $request->paid;
      $findPurchase->update();
      
      $request->session()->forget(['purchase_id', 'supplier_id']);
      
      return redirect('/purchases');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      if(auth()->user()->id !== Purchase::find($id)->user_id) {
        return response()->json('Anda tidak memiliki izin menghapus ini', 422);
      }
      
        //kembalikan stok produk 
        $getPurchaseDetail = Purchase::find($id)->purchase_detail;
        
        foreach ($getPurchaseDetail as $row) {
          $updateStock = Product::find($row->product_id);
          $updateStock->stock = $updateStock->stock - $row->qty;
          $updateStock->update();
          
          PurchaseDetail::destroy($row->id);
        }
        
        //hapus pembelian
        Purchase::destroy($id);
        
        return response()->json('Pembelian berhasil dibatalkan');
    }
    
    public function item_purchase($id)
    {
      $getPurchase = Purchase::find($id)->purchase_detail;
      
      $getItem = [];
      foreach ($getPurchase as $key => $row) {
        $getItem[] = $row->product;
        $getItem[$key]['qty'] = $row->qty;
      }
      
      return datatables()
            ->of($getItem)
            ->addIndexColumn()
            ->addColumn('code', function($getItem) {
              return '<span class="badge badge-success">'. $getItem->code .'</span>';
            })
            ->addColumn('subtotal', function($getItem) {
              return 'Rp ' . number_format($getItem->purchase_price * $getItem->qty, 0, ',', '.');
            })
            ->addColumn('purchase_price', function($getItem) {
              return 'Rp ' . number_format($getItem->purchase_price, 0, ',', '.');
            })
            ->rawColumns(['purchase_price', 'subtotal', 'code'])
            ->make(true);
      
      return response()->json($getItem);
    }
}
