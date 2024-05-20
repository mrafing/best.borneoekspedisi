<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Outlet;

class LoginController extends Controller
{
    public function index () {
        return view('auth.login');
    }

    public function authenticate (Request $request) 
    {
         $request->validate([
            'username' => 'required',
            'password' => 'required'
        ], [
            'username' => 'Username wajib diisi',
            'password' => 'Password wajib diisi'
        ]);

        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ]; 
        
        if (Auth::attempt($credentials)) {
            return redirect('dashboard');
        } else {
            return redirect('')->withErrors('Username atau password yang di masukkan tidak sesuai');
        }
    }

    public function logout (Request $request) 
    {
        Auth::logout();
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect ('/');

    }
}
