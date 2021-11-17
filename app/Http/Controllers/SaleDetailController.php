<?php

namespace App\Http\Controllers;

use App\Models\SaleDetail;
use App\Models\Product;
use App\Models\Member;
use App\Models\Sale;
use Illuminate\Http\Request;
use App\Models\Setting;

class SaleDetailController extends Controller
{
    public function index()
    {
      if(!session('sale_id')) {
        return redirect('/sales');
      }
      
      $products = Product::orderBy('name')->get();
      $members = Member::orderBy('name')->get();
      
      return view('admin.sale_detail.index', [
        'title' => 'Transaction',
        'setting' => Setting::first(),
        'products' => $products,
        'members' => $members
        ]);
    }
    
    public function store(Request $request)
    {
      //ambil data produk yang dibeli
      $product = Product::find($request->product_id);
      
      //jika ada diskon produk 
      if($product->discount > 0) {
        $discountPrice = $product->selling_price * $product->discount / 100;
        $subtotal = $product->selling_price - $discountPrice;
      }
      else {
        $subtotal = $product->selling_price;
      }
      
      SaleDetail::create([
        'sale_id' => session('sale_id'),
        'product_id' => $product->id,
        'qty' => 1,
        'price' => $product->selling_price,
        'discount' => $product->discount,
        'subtotal' => $subtotal
        ]);
    }
    
    public function data()
    {
      $detailTransaction = SaleDetail::where('sale_id', session('sale_id'))->get();

         return datatables()
            ->of($detailTransaction)
            ->addIndexColumn()
            ->addColumn('aksi', function($detailTransaction) {
              return '<div class="button-group button-group-sm">
                <button class="btn btn-danger" onclick="deleteProduct('. "'/transaction/$detailTransaction->id'" .')"><i class="fas fa-trash"></i></button>
              </div>';
            })
            ->addColumn('subtotal', function($detailTransaction) {
              return number_format($detailTransaction->subtotal, 0, ',', '.');
            })
            ->addColumn('price', function($detailTransaction) {
              return number_format($detailTransaction->product->selling_price, 0, ',', '.');
            })
            ->addColumn('discount', function ($detailTransaction) {
              return $detailTransaction->product->discount . '%';
            })
            ->addColumn('qty', function($detailTransaction) {
              return '<input type="number" value="'. $detailTransaction->qty .'" style="width: 50px" data-id="'. $detailTransaction->id .'" onchange="editQty('. $detailTransaction->id .', this.value)">';
            })
            ->rawColumns(['aksi', 'discount', 'price', 'subtotal', 'qty'])
            ->make(true);
    }
    
    public function count_subtotal()
    {
      $product = SaleDetail::where('sale_id', session('sale_id'))->get();
      
      $subtotal = [];
      $total_price = [];
      $total_item = [];
      
      foreach ($product as $row) {
        $subtotal[] = $row->subtotal;
        $total_price[] = $row->price * $row->qty;
        $total_item[] = $row->qty;
      }
      
      return response()->json([
        'paid' => 'Rp ' . number_format(array_sum($subtotal), 0, ',', '.'),
        'num_paid' => array_sum($subtotal),
        'total_item' => array_sum($total_item),
        'total_price' => array_sum($total_price)
        ]);
    }
    
    public function update($id, Request $request)
    {
      $transaction = SaleDetail::find($id);
      
      $subtotal = 0;
      
      if($transaction->discount > 0) {
        $discountPrice = $transaction->price * $transaction->discount / 100;
        $subtotal = $transaction->price * $request->qty;
        $subtotal = $subtotal - $discountPrice;
      }
      else {
        $subtotal = $transaction->price * $request->qty;
      }
      
      $transaction->qty = $request->qty;
      $transaction->subtotal = $subtotal;
      $transaction->update();
    }
    
    public function destroy($id)
    {
      SaleDetail::destroy($id);
      return 'data berhasil dihapus';
    }
    
}
