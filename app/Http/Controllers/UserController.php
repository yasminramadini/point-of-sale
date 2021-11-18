<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Setting;

class UserController extends Controller
{
    public function index()
    {
      return view('admin.user.index', [
        'title' => 'Daftar User',
        'roles' => User::distinct()->pluck('role'),
        'setting' => Setting::first()
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
    
    public function profil()
    {
      return view('admin.user.profil', [
        'title' => 'Profil',
        'profil' => auth()->user(),
        'setting' => Setting::first()
        ]);
    }
    
    public function updateProfil(Request $request)
    {
      $user = auth()->user();
      
      $rules = [
        'name' => 'required|min:3|string',
        'username' => 'required|min:3|max:10|alpha_dash'
        ];
        
      //cek apakah ganti avatar
      if($request->hasFile('avatar')) {
        $rules['avatar'] = 'image|max:1024|dimensions:ratio=1/1';
      }
      
      $validatedData = $request->validate($rules);
      
      if($request->hasFile('avatar')) {
        $avatarName = time() . '_' . $request->avatar->getClientOriginalName();
        
        $request->avatar->move('image', $avatarName);
        
        if($user->avatar !== 'avatar.png' && $user->avatar !== null) {
          unlink("./image/$user->avatar");
        }
      }
      else {
        $avatarName = $user->avatar;
      }
      
      $user->name = $validatedData['name'];
      $user->username = $validatedData['username'];
      $user->avatar = $avatarName;
      $user->update();
      
      return response()->json(auth()->user());
    }
    
    public function change_password(Request $request)
    {
      $user = auth()->user();
      
      $validatedData = $request->validate([
        'newPassword' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
        ]);
      
      //cek password lama apakah cocok
      if(!Hash::check($request->oldPassword, $user->password)) {
        $error = ['oldPassword' => 'Password anda salah'];
        return response()->json($error, 422);
      } else {
        $user->password = bcrypt($validatedData['newPassword']);
        $user->update();
        return response()->json('Password berhasil diubah');
      }
    }
}
