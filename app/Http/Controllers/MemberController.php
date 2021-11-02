<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.member.index', [
          'title' => 'Members'
          ]);
    }
    
    public function data()
    {
      $members = Member::latest()->get();
      
      return datatables()
            ->of($members)
            ->addIndexColumn()
            ->addColumn('select_all', function($members) {
              return '
              <input type="checkbox" name="products_id[]" value='. "'$members->id'" . '>
              ';
            })
            ->addColumn('code', function($members) {
              return '
              <span class="badge badge-success">'. $members->code . '</span>
              ';
            })
            ->addColumn('aksi', function($members) {
              return '
              <div class="btn-group btn-sm">
                <button class="btn btn-warning" onclick="editForm('. "'/products/$members->id'" .')"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger" onclick="deleteForm('. "'/products/$members->id'" . ')"><i class="fas fa-trash"></i></button>
              </div>
              ';
            })
           ->rawColumns(['aksi', 'select_all', 'code'])
           ->make(true);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'code' => 'required|unique:members',
          'name' => 'required|string|unique:products|min:3',
          'phone' => 'required|min:1|integer',
          'address' => 'required|min:5',
          ]);

       Member::create($validatedData);
       
       return response()->json('Member berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $products = Product::find($id);
        
        return response()->json($products);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        
        $rules = [
          'stock' => 'required|min:1',
          'selling_price' => 'required|min:1|integer',
          'purchase_price' => 'required|min:1|integer'
          ];
        
        if($request->code === $product->code) {
          $rules['code'] = 'required';
        }
        else {
          $rules['code'] = 'required|unique:products';
        }
        
        if($request->name === $product->name) {
          $rules['name'] = 'required';
        }
        else {
          $rules['name'] = 'required|unique:products';
        }
        
        $validatedData = $request->validate($rules);
        
        $validatedData['category_id'] = $request->category_id;
        $validatedData['discount'] = $request->discount;
        
        $product->update($validatedData);
        
        return response()->json('Produk berhasil diperbarui');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        
        return response()->json('Produk berhasil dihapus');
    }
    
    public function delete_all_products(Request $request) 
    {
      Product::destroy($request->products_id);
      
      return response()->json('Produk berhasil dihapus');
    }
    
    public function print_barcode(Request $request) 
    {
      $products = [];
      foreach ($request->products_id as $id) {
        $products[] = Product::find($id);
      }
      
      $pdf = PDF::loadView('admin.product.barcode', ['products' => $products, 'no' => 1]);
      $pdf->setPaper('A4', 'potrait');
      return $pdf->stream('produk.pdf');
    }
}
