<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
      return view('admin.user.index', [
        'title' => 'Daftar User',
        'setting' => $this->setting(),
        'roles' => User::distinct()->pluck('role')
        ]);
    }
    
    public function data()
    {
      $users = User::notAdmin()->latest()->get();
      
      return datatables()
        ->of($users)
        ->addIndexColumn()
        ->addColumn('aksi', function($users) {
          return '<div class="btn-group">
            <button class="btn btn-info" onclick="addForm('. "'/user/ $users->id'" .')">
              <i class="fas fa-eye"></i>
            </button>
            <button class="btn btn-danger" onclick="deleteForm('. "'/user/$users->id'" .')">
              <i class="fas fa-trash"></i>
            </button>
          </div>';
        })
        ->rawColumns(['aksi'])
        ->make(true);
    }
    
    public function show($id)
    {
      return response()->json(User::find($id));
    }
    
    public function update(Request $request, $id)
    {
      $user = User::find($id);
      $user->role = $request->role;
      $user->update();
      
      return response()->json('Role user berhasil diubah');
    }
    
    
    public function destroy($id)
    {
      User::destroy($id);
      
      return response()->json('User berhasil dihapus');
    }
}
