<?php

namespace App\Http\Controllers;

use App\Models\Kecamatan, App\Models\Mitra, App\Models\Outlet;
use Illuminate\Http\Request;

class MitraController extends Controller
{
    public function index()
    {
        $param = [
            'title' => 'Mitra',
            'active' => 'mitra',
            'listmitra' => Mitra::all(),
        ];

        return view('integrasisystem.mitra.index', $param);
    }

    public function show($id)
    {
        $param = [
            'title' => 'Detail Mitra',
            'active' => 'detailmitra',
            'data' => Mitra::find($id),
            'listoutlet' => Outlet::where('id_mitra', $id)->get()
        ];

        return view('integrasisystem.mitra.detailmitra', $param);
    }

    public function tambah()
    {
        $param = [
            'title' => 'Tambah Mitra',
            'active' => 'tambahmitra'
        ];

        return view('integrasisystem.mitra.tambahmitra', $param);
    }

    public function save(Mitra $mitra ,Request $request)
    {
        $request->validate([
            'tipe' => 'required',
            'nama_pendaftar' => 'required|max:15',
            'nama_mitra' => 'required',
            'nomor_kontak' => 'required|numeric',
            'alamat_pendaftar' => 'required|max:255',
        ]);

        $data = $request->all();
        $mitra->create($data);

        return redirect(url('integrasisystem/mitra'))->with('success', 'Mitra berhasil di tambahkan');
    }

    public function hapus(Mitra $mitra, Request $request)
    {
        $mitra->destroy($request->id);
        return redirect(url('integrasisystem/mitra'))->with('success', 'Mitra berhasil di hapus');
    }

    public function update(Mitra $mitra, Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'nama_pendaftar' => 'required|max:15',
            'nama_mitra' => 'required',
            'nomor_kontak' => 'required|numeric',
            'alamat_pendaftar' => 'required|max:255',
        ]);

        if ($request->input('tipe') == 'perusahaan') {
            $validatedData['nama_perusahaan'] = $request->input('nama_perusahaan');
            $validatedData['nama_pemimpin_perusahaan'] = $request->input('nama_pemimpin_perusahaan');
            $validatedData['alamat_perusahaan'] = $request->input('alamat_perusahaan');
            $validatedData['kategori_perusahaan'] = $request->input('kategori_perusahaan');
        } elseif ($request->input('tipe') == 'customer priority') {
            $validatedData['nama_toko'] = $request->input('nama_toko');
            $validatedData['jenis_produk_toko'] = $request->input('jenis_produk_toko');
            $validatedData['alamat_toko'] = $request->input('alamat_toko');
        }

        $mitra->where('id', $request->id)->update($validatedData);

        return redirect(url("integrasisystem/mitra/show/" .$request->id. ""))->with('success', 'Mitra Berhasil di ubah');
    }

    public function resulttipe(Request $request)
    {
        $tipe = $request->input('tipe');

        return view('integrasisystem.mitra.resulttipe', ['result' => $tipe])->render();
    }

    public function tambahoutlet($id)
    {
        $param = [
            'title' => 'Tambah Outlet',
            'active' => 'tambahoutlet',
            'data' => Mitra::find($id),
            'listkecamatan' => Kecamatan::all()
        ];

        return view('integrasisystem.mitra.tambahoutlet', $param);
    }

    public function saveoutlet(Outlet $outlet, Request $request)
    {
        $validatedData = $request->validate([
            'id_mitra' => 'required',
            'kode_agen' => 'required|unique:tb_outlet,kode_agen',
            'tipe' => 'required',
            'id_kecamatan' => 'required',
            'alamat' => 'required|max:255',
            'nama_cs' => 'required|max:15',
            'nomor_kontak' => 'required|numeric',
            'link_alamat' => 'max:255',
            'lokasi' => 'required',
            'status_bangunan' => 'required',
            'jenis_bangunan' => 'required',
            'status' => 'required',
        ]);

        $outlet->create($validatedData);

        return redirect(url("integrasisystem/mitra/tambahoutlet/$request->id_mitra"))->with('success', 'Outlet berhasil di tambahkan');
    }
    
    public function updateoutlet(Outlet $outlet,Request $request)
    {
        // dd($request);
        $validatedData = $request->validate([
            'kode_agen' => 'required',
            'tipe' => 'required',
            'alamat' => 'required|max:255',
            'nama_cs' => 'required|max:15',
            'id_kecamatan' => 'required',
            'nomor_kontak' => 'required|numeric',
            'lokasi' => 'required',
            'status_bangunan' => 'required',
            'jenis_bangunan' => 'required',
            'status' => 'required',
        ]);

        $outlet->where('id', $request->id_outlet)->update($validatedData);
        return redirect(url("integrasisystem/mitra/show/" .$request->id_mitra. ""))->with('success', 'Outlet Berhasil di ubah');
    }

    public function hapusoutlet($id)
    {
        Outlet::destroy($id);
        return back()->with('success', 'Outlet Berhasil Dihapus!');
    }
}
