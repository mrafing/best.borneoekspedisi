<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth, Illuminate\Support\Facades\Hash;

class KelolaAkunController extends Controller
{
    public function index()
    {
        $param = [
            'title' => 'Kelola akun',
            'active' => 'kelolaakun',
            'listuser' => User::all(),
        ];

        return view('integrasisystem.kelolaakun.index', $param);
    }

    public function tambah()
    {
        $param = [
            'title' => 'Tambah akun',
            'active' => 'tambahakun',
        ];

        return view('integrasisystem.kelolaakun.tambah', $param);
    }

    public function save(Request $request) 
    {
        $request->validate(
            [
                'nama' => 'required|max:255',
                'id_outlet' => 'required|exists:tb_outlet,id',
                'role' => 'required',
                'password' => 'required|min:7|confirmed',
            ], 
            [
                'password.confirmed' => 'Password tidak sama'
            ]
        );

        // Get info outlet by id outlet
        $outlet = Outlet::find($request->id_outlet);

        User::create([
            'id_outlet' => $request->id_outlet,
            'nama' => $request->nama,
            'username' => User::getUsername($outlet->kode_agen),
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('integrasisystem.kelolaakun')
                         ->with('success', 'Akun berhasil ditambahkan');
    }

    public function hapus (Request $request)
    {
        User::destroy($request->id);
        return redirect('integrasisystem/kelolaakun')->with('success', 'Akun berhasil dihapus');
    }
}
