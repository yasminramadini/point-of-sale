<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login()
    {
      return view('auth.login', [
        'title' => 'Login',
        'setting' => $this->setting()
        ]);
    }
    
    public function register()
    {
      return view('auth.register', [
        'title' => 'Register',
        'setting' => $this->setting()
        ]);
    }
    
    public function register_store(Request $request)
    {
      //validasi
      $validatedData = $request->validate([
        'name' => 'required',
        'password' => ['required', Password::min(8)->letters()->mixedCase()->numbers()],
        'username' => 'required|min:3|max:10',
        'email' => 'required|email'
        ]);
        
      $validatedData['role'] = 0;
      
      //hash password
      $validatedData['password'] = bcrypt($validatedData['password']);
        
       User::create($validatedData);
       
       return redirect()->route('login')->with('success', 'Anda berhasil mendaftar! Silahkan login');
    }
    
    public function login_store(Request $request) 
    {
      $validatedData = $request->validate([
        'username' => 'required',
        'password' => 'required'
        ]);
        
      if(Auth::attempt($validatedData)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
      }
      
      return back()->with('error', 'Username atau password salah');
    }
    
    public function logout(Request $request)
    {
      Auth::logout();
      $request->session()->invalidate();
      $request->session()->regenerateToken();
      return redirect('/');
    }
}
