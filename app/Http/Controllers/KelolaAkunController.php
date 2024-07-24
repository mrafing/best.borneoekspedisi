<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class KelolaAkunController extends Controller
{
    public function index() {
        $param = [
            'title' => 'Kelola Akun',
            'active' => 'kelolaakun',
            'listuser' => User::where('id_outlet', Auth::user()->id_outlet)->get()
        ];

        return view('integrasisystem.kelolaakun.index', $param);
    }

    public function tambah() {
        $param = [
            'title' => 'Tambah Akun',
            'active' => 'tambahakun',
        ];

        return view('integrasisystem.kelolaakun.tambah', $param);
    }

    public function save(Request $request) {
        // dd($request);
        $request->validate([
            'nama' => 'required|max:15',
            'role' => 'required',
            'password' => 'required|min:7'
        ]);
        
        if ($request->input('password') != $request->input('confirm_password')) {
            return back()->withErrors(['message' => 'Pasword tidak sama']);
        }

        $user = new User();
        $user->id_outlet = $request->input('id_outlet');
        $user->nama = $request->input('nama');
        $user->username = User::getUsername(Auth::user()->outlet->kode_agen);
        $user->password = Hash::make($request->input('password'));
        $user->role = $request->input('role');

        $user->save();

        return redirect('integrasisystem/kelolaakun')->with('success', 'User Berhasil Di Tambahkan!');
    }

    public function hapus (Request $request) {
        User::destroy($request->id);

        return redirect('integrasisystem/kelolaakun')->with('success', 'User Berhasil Di Hapus!');
    }
}
