<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Setting;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.expenses.index', [
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
          'description' => 'required|min:5|string',
          'nominal' => 'required|integer|min:1'
          ]);
          
       Expense::create($validatedData);
       
       return response()->json('Pengeluaran berhasil ditambahkan');
    }
    
   public function data()
    {
      $expenses = Expense::latest()->get();
      
      return datatables()
            ->of($expenses)
            ->addIndexColumn()
            ->addColumn('aksi', function($expenses) {
              return '
              <div class="btn-group btn-sm">
                <button type="button" class="btn btn-warning" onclick="editForm('. "'/expenses/$expenses->id'" .')"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn btn-danger" onclick="deleteForm('. "'/expenses/$expenses->id'" . ')"><i class="fas fa-trash"></i></button>
              </div>
              ';
            })
           ->addColumn('nominal', function($expenses) {
             return "Rp " . number_format($expenses->nominal, 0, ',', '.');
           })
           ->addColumn('tanggal', function($expenses) {
             return "<p>" . $expenses->created_at->locale('id_ID')->isoFormat('Do MMMM YYYY') . "</p>";
           })
           ->rawColumns(['aksi', 'tanggal'])
           ->make(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = Expense::find($id);
        
        return response()->json($expense);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function edit(Expenses $expenses)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
          'description' => 'required|min:5|string',
          'nominal' => 'required|integer|min:1'
          ]);
          
        Expense::find($id)->update($validatedData);
        
        return response()->json('Pengeluaran berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenses  $expenses
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Expense::destroy($id);
    }
}
