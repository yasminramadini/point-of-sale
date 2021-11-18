<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Setting;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.category.index', [
            'setting' => Setting::first(),
            'title' => 'Categories'
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
      $categories = Category::latest()->get();
  
      return datatables()
            ->of($categories)
            ->addIndexColumn()
            ->addColumn('aksi', function($categories) {
              return '
              <div class="btn-group btn-sm">
                <button class="btn btn-warning" onclick="editForm('. "'/categories/$categories->id'" .')"><i class="fas fa-pencil-alt"></i></button>
                <button class="btn btn-danger" onclick="deleteForm('. "'/categories/$categories->id'" . ')"><i class="fas fa-trash"></i></button>
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
        'name' => 'required|min:3|string|unique:categories'
        ]);
        
        Category::create($validatedData);
        
        return response()->json('Kategori berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $category = Category::find($id);
        
        return response()->json($category);
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
        $validatedData = $request->validate([
          'name' => 'required|unique:categories|min:3|string'
          ]);
          
        Category::where('id', $id)
              ->update($validatedData);
        
        return response()->json('Kategori berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = Category::find($id);
        $category->delete();
        
        return response()->json('Kategori berhasil dihapus');
    }
}
