<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Setting;
use PDF;

class SaleController extends Controller
{
    public function index()
    {
      return view('admin.sale.index', [
        'title' => 'Sales',
        ]);
    }
    
    public function data()
    {
      $sales = Sale::with(['member', 'user'])->latest()->get();
      
         return datatables()
            ->of($sales)
            ->addIndexColumn()
            ->addColumn('aksi', function($sales) {
              return '
              <div class="btn-group btn-sm">
                <button class="btn btn-info" onclick="salePreview('. "'/sales/$sales->id'" .')"><i class="fas fa-eye"></i></button>
                <button class="btn btn-danger" onclick="deleteSale('. "'/sales/$sales->id'" . ')"><i class="fas fa-times"></i></button>
              </div>
              ';
            })
            ->addColumn('tanggal', function($sales) {
              return $sales->created_at->locale('ID_id')->isoFormat('Do MMMM YYYY');
            })
            ->addColumn('total_price', function($sales) {
              return 'Rp ' . number_format($sales->total_price, 0, ',', '.');
            })
            ->addColumn('paid', function($sales) {
              return 'Rp ' . number_format($sales->paid, 0, ',', '.');
            })
            ->addColumn('discount', function($sales) {
              return $sales->discount . '%';
            })
            ->addColumn('accepted', function($sales) {
              return 'Rp ' . number_format($sales->accepted, 0, ',', '.');
            })
            ->rawColumns(['aksi', 'discount', 'paid', 'total_price'])
            ->make(true);
    }
    
    public function store(Request $request)
    {
      $sale = Sale::create([
        'user_id' => auth()->user()->id,
        'member_id' => 0,
        'total_item' => 0,
        'total_price' => 0,
        'discount' => 0,
        'paid' => 0,
        'accepted' => 0
        ]);
      
      session(['sale_id' => $sale->id]);
      
      return redirect('/transaction');
    }
    
    public function update($id, Request $request)
    {
      $sale =  Sale::find($id);
      $sale->member_id = $request->member;
      
      //update diskon member
      $setting = Setting::first();
      
      if($sale->discount === 0) {
        $sale->discount = $setting->discount;
      }
      
      $sale->update();
      
      $transaction = SaleDetail::where('sale_id', session('sale_id'))->get();
      
      $price_member = [];
      foreach ($transaction as $row) {
        $price_member[] = $row->subtotal;
      }
      
      $price_member = array_sum($price_member);
      
      $price_discount = $price_member * $sale->discount / 100;
      
      $price_member = $price_member - $price_discount;
      
      return response()->json([
        'discount_member' => $sale->discount,
        'price_member' => $price_member,
        'num_price_member' => 'Rp ' . number_format($price_member, 0, ',', '.')
        ]);
    }
    
    public function save_selling(Request $request)
    {
      //tambah qty tiap produk
      $productList = SaleDetail::with('product')
        ->where('sale_id', session('sale_id'))
        ->get();
        
      foreach ($productList as $row) {
        if($row->product->id === $row->product_id) {
          $product = Product::find($row->product->id);
          $product->stock -= $row->qty;
          $product->update();
        }
      }
      
      $sale = Sale::find(session('sale_id'));
      $sale->total_item = $request->total_item;
      $sale->total_price = $request->total_price;
      $sale->discount = $request->discount;
      $sale->paid = $request->paid;
      $sale->accepted = $request->accepted;
      $sale->update();
      
      session(['print_nota' => $sale->id]);
      
      $request->session()->forget(['sale_id']);
      
      return redirect('/print_nota')->with('sale', Sale::where('user_id', auth()->user()->id)->first());
    }
    
    public function print_nota() {
      
      if(session('print_nota') === null) {
        return redirect('/sales');
      }
      
      $sale_detail = SaleDetail::with('product')->where('sale_id', session('print_nota'))->get();
      
      $pdf = PDF::loadView('admin.sale.print_nota', ['sale_detail' => $sale_detail, 'setting' => Setting::first(), 'sale' => Sale::with('member')->find(session('print_nota')) ]);
      
      $paperSize = array(0, 0, 184.252, 198.425);
      
      $pdf->setPaper($paperSize, 'portrait');
      
      session(['print_nota' => null]);
      
      return $pdf->stream('nota.pdf'); 
    }
    
    public function show($id)
    {
      $getSale = Sale::with('sale_detail')->find($id);
      
      $saleDetail = [];
      foreach ($getSale->sale_detail as $key => $row) {
        $saleDetail[] = $row->product;
        $saleDetail[$key]['qty'] = $row->qty;
        $saleDetail[$key]['subtotal'] = $row->subtotal;
      }
      
      return datatables()
            ->of($saleDetail)
            ->addIndexColumn()
            ->addColumn('code', function($saleDetail) {
              return '<span class="badge badge-success">'. $saleDetail->code .'</span>';
            })
            ->addColumn('selling_price', function($saleDetail) {
              return 'Rp ' . number_format($saleDetail->selling_price, 0, ',', '.');
            })
            ->addColumn('subtotal', function($saleDetail) {
              return 'Rp ' . number_format($saleDetail->subtotal, 0, ',', '.');
            })
            ->addColumn('discount', function($saleDetail) {
              return $saleDetail->discount . '%';
            })
            ->rawColumns(['code'])
            ->make(true);
    }
    
    public function destroy($id)
    {
      //kembalikan stok produk 
      $sale = Sale::with('sale_detail')->find($id)->sale_detail;
      
      foreach ($sale as $row) {
        $updateStock = Product::find($row->product_id);
        $updateStock->stock = $updateStock->stock + $row->qty;
        $updateStock->update();
        
        SaleDetail::destroy($row->id);
      }
      
      //hapus penjualan 
      Sale::destroy($id);
      
      return response()->json('Penjualan berhasil dibatalkan');
    }
}
