<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index', [
          'title' => 'Products',
          'categories' => Category::latest()->get()
          ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }
    
    public function data()
    {
      $products = Product::latest()->get();
      
      return datatables()
            ->of($products)
            ->addIndexColumn()
            ->addColumn('aksi', function($products) {
              return '
              <div class="btn-group btn-sm">
                <button class="btn btn-warning" onclick="editForm('. "'/products/$products->id'" .')"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger" onclick="deleteForm('. "'/products/$products->id'" . ')"><i class="fas fa-trash"></i></button>
              </div>
              ';
            })
           ->rawColumns(['aksi'])
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
        $validatedData = $request->validate([
          'code' => 'required|unique:products',
          'name' => 'required|string|unique:products|min:3',
          'stock' => 'required|min:1|integer',
          'purchase_price' => 'required|min:1|integer',
          'selling_price' => 'required|min:1|integer'
          ]);
       $validatedData['category_id'] = $request->category_id;
       $validatedData['discount'] = $request->discount;
       
       Product::create($validatedData);
       
       return response()->json('Produk berhasil ditambahkan');
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
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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
}
