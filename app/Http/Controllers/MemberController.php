<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use PDF;

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
          'title' => 'Members',
          'setting' => $this->setting()
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
              <input type="checkbox" name="members_id[]" value='. "'$members->id'" . '>
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
                <button type="button" class="btn btn-warning" onclick="editForm('. "'/members/$members->id'" .')"><i class="fas fa-pencil-alt"></i></button>
                <button type="button" class="btn btn-danger" onclick="deleteForm('. "'/members/$members->id'" . ')"><i class="fas fa-trash"></i></button>
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
          'phone' => 'required|min:1|integer'
          ]);
       $validatedData['address'] = $request->address;

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
        $member = Member::find($id);
        
        return response()->json($member);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $member = Member::where('id', $id)->first();
        
        $rules = [
          'name' => 'required',
          'phone' => 'required|integer',
          ];
        
        if($request->code === $member->code) {
          $rules['code'] = 'required';
        }
        else {
          $rules['code'] = 'required|unique:members';
        }
        
        $validatedData = $request->validate($rules);
        $validatedData['address'] = $request->address;
        
        $member->update($validatedData);
        
        return response()->json('Member berhasil diperbarui');
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
        $member = Member::find($id);
        $member->delete();
        
        return response()->json('Member berhasil dihapus');
    }
    
    public function delete_all_members(Request $request) 
    {
      Member::destroy($request->members_id);
      
      return response()->json('Member berhasil dihapus');
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
    
    public function print_card(Request $request)
    {
      $members = [];
      
      foreach ($request->members_id as $id) {
        $members[] = Member::find($id);
      }
      
      $pdf = PDF::loadView('admin.member.card', ['members' => $members, 'no' => 1]);
      $pdf->setPaper('A4', 'portrait');
      return $pdf->stream('member_card.pdf');
    }
}
