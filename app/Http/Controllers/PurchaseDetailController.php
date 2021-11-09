<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDetail;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('name')->get();
        $supplier = Supplier::find(session('supplier_id'));
        
        if(!session('supplier_id')) {
          abort(403, 'Silahkan buat transaksi baru');
        } 
        
        if(!session('purchase_id')) {
          abort(403, 'Silahkan buat transaksi baru');
        }
        
        return view('admin.purchase_detail.index', [
          'products' => $products,
          'supplier' => $supplier,
          'setting' => $this->setting()
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
      $activePurchase = Purchase::where('status', 'active')
      ->where('id', session('purchase_id'))
      ->first();
      
      $products = PurchaseDetail::with('product')->where('purchase_id', $activePurchase->id)->get();
      
      return datatables()
            ->of($products)
            ->addIndexColumn()
            ->addColumn('price', function($products) {
              return '<p>Rp '. number_format($products->product->purchase_price, 0, ',', '.') .'</p>';
            })
            ->addColumn('aksi', function($products) {
              return '<div class="button-group button-group-sm">
                <button class="btn btn-danger" onclick="deleteProduct('. "'/purchase_detail/ $products->id'" .')"><i class="fas fa-trash"></i></button>
              </div>';
            })
            ->addColumn('qty', function($products) {
              return '
              <input type="number" value="'. $products->qty .'" style="width: 50px" data-id="'. $products->id .'" onchange="editQty('. $products->id .', this.value)">';
            })
            ->addColumn('subtotal', function($products) {
              return 'Rp ' . number_format($products->subtotal, 0, ',', '.');
            })
            ->rawColumns(['aksi', 'price', 'qty'])
            ->make(true);
    }
    
    public function count_subtotal() 
    {
      $activePurchase = Purchase::with('purchase_detail')
      ->where('status', 'active')
      ->first();
      
      $products = $activePurchase->purchase_detail;
      
      $row = [];
      foreach ($products as $subtotal) {
        $row[] = $subtotal->subtotal;
      }
      
      $subtotal = array_sum($row);
      
      $paid = $subtotal;
      
      if($activePurchase->discount > 0) {
        $discountPrice = $subtotal * $activePurchase->discount / 100;
        $paid = $subtotal - $discountPrice;
      }
      
      return response()->json([
        'price' => 'Rp ' . number_format($paid, 0, ',', '.'),
        'num_price' => $subtotal,
        'discount' => $activePurchase->discount,
        'total_item' => $products->count(),
        'paid' => $paid
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $product = Product::find($request->product_id);
      
        PurchaseDetail::create([
          'purchase_id' => session('purchase_id'),
          'product_id' => $request->product_id,
          'price' => $product->purchase_price,
          'qty' => 1,
          'subtotal' => $product->purchase_price
          ]);
          
       return response()->json('Data berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function show(PurchaseDetail $purchaseDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(PurchaseDetail $purchaseDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $purchase_detail = PurchaseDetail::find($id);
      
      $purchase_detail->qty = $request->qty;
      $purchase_detail->subtotal = $request->qty * $purchase_detail->price;
      
      $purchase_detail->update();
      
      return response()->json('Qty berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\PurchaseDetail  $purchaseDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        PurchaseDetail::destroy($id);
        
        return response()->json('Produk berhasil dihapus');
    }
}
