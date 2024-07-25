<?php

namespace App\Http\Controllers;

use App\Models\Manifest;
use App\Models\Kota;
use App\Models\Layanan;
use App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ArsipManifestController extends Controller
{
    public function index()
    {
        $param = [
            'title' => 'Arsip Manifest',
            'active' => 'arsipmanifest'
        ];
        return view('arsipmanifest.index', $param);
    }

    public function arsipdomestik()
    {

        $query = Manifest::query();

        if (Auth::user()->role == 'gm') {

        } else {
            $query->where('id_outlet_terima', Auth::user()->id_outlet);
        }

        $listmanifest = $query->latest()->get();

        $param = [
            'title' => 'Arsip Manifest Domestik',
            'active' => 'arsipmanifestdomestik',
            'listmanifest' => $listmanifest,
            'listkota' => Kota::all(),
            'listlayanan' => Layanan::all(),
            'listoutlet' => Outlet::all(),
        ];

        return view('arsipmanifest.arsipdomestik', $param);
    }

    public function filterarsipdomestik(Request $request) {
        $id_outlet_terima = $request->input('id_outlet_terima');
        $id_layanan = $request->input('id_layanan');
        $id_kota_tujuan = $request->input('id_kota_tujuan');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');
        $pembayaran = $request->input('pembayaran');
        $no_resi = $request->input('no_resi');

        $query = Manifest::query();

        // Filter berdasarkan role user
        if (Auth::user()->role == 'gm') {
            if ($request->filled('id_outlet_terima')) {
                $query->where('id_outlet_terima', $id_outlet_terima);
            }
        } else {
            $query->where('id_outlet_terima', Auth::user()->id_outlet);
        }

        // Filter berdasarkan layanan
        if ($request->filled('id_layanan')) {
            $query->where('id_layanan', $id_layanan);
        }

        // Filter berdasarkan kota tujuan
        if ($request->filled('id_kota_tujuan')) {
            $query->whereHas('penerima.kecamatan.kota', function ($query) use ($id_kota_tujuan) {
                $query->where('id', $id_kota_tujuan);
            });
        }

        // Filter berdasarkan rentang tanggal
        if ($request->filled('dari_tanggal') && $request->filled('sampai_tanggal')) {
            $query->whereBetween(DB::raw('DATE(created_at)'), [$dari_tanggal, $sampai_tanggal]);
        }

        // Filter berdasarkan metode pembayaran
        if ($request->filled('pembayaran')) {
            $query->whereHas('ongkir', function ($query) use ($pembayaran) {
                $query->where('pembayaran', $pembayaran);
            });
        }

        // Filter berdasarkan nomor/kode resi
        if ($request->filled('no_resi')) {
            $query->where('no_resi', $no_resi);
        }

        // Urutkan berdasarkan terbaru
        $listmanifest = $query->latest()->get();

        $param = [
            'listmanifest' => $listmanifest,
        ];

        return view('arsipmanifest.filterarsipdomestik', $param)->render();
    }
}
