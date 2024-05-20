<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mitra; 
use App\Models\Outlet; 

class MitraController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Mitra',
            'active' => 'mitra',
            'listmitra' => Mitra::all(),
        ];

        return view('integrasisystem.mitra.index', $param);
    }

    public function show ($id)
    {
        $param = [
            'title' => 'Detail Mitra',
            'active' => 'detailmitra',
            'data' => Mitra::find($id),
            'listoutlet' => Outlet::where('id_mitra', $id)->get()
        ];

        return view('integrasisystem.mitra.detailmitra', $param);
    }

    public function tambah ()
    {
        $param = [
            'title' => 'Tambah Mitra',
            'active' => 'tambahmitra'
        ];

        return view('integrasisystem.mitra.tambahmitra', $param);
    }

    public function save (Mitra $mitra ,Request $request) {
        $request->validate([
            'tipe' => 'required',
            'nama_pendaftar' => 'required|max:15',
            'nomor_kontak' => 'required|numeric',
            'alamat_pendaftar' => 'required|max:255',
        ]);

        $data = $request->all();
        $mitra->create($data);

        return redirect(url('integrasisystem/mitra'))->with('success', 'Mitra berhasil di tambahkan');
    }

    public function hapus (Mitra $mitra, Request $request) {
        $mitra->destroy($request->id);
        return redirect(url('integrasisystem/mitra'))->with('success', 'Mitra berhasil di hapus');
    }

    public function resulttipe(Request $request)
    {
        $tipe = $request->input('tipe');

        return view('integrasisystem.mitra.resulttipe', ['result' => $tipe])->render();
    }
}
