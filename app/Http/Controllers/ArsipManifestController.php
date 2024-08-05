<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Ongkir;
use App\Models\Manifest;
use App\Models\SubManifest;
use App\Models\Kota;
use App\Models\Layanan;
use App\Models\Outlet;
use App\Models\Penerima;
use App\Models\Pengirim;
use App\Models\VoidManifest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function voiddomestik() {
        $param = [
            'title' => 'Void Manifest Domestik',
            'active' => 'voiddomestik',
            'listvoidmanifest' => VoidManifest::all(),
            'listoutlet' => Outlet::all(),
            'listlayanan' => Layanan::all(),
            'listkota' => Kota::all(),
        ];

        return view('arsipmanifest/voiddomestik', $param);
    }

    public function filtervoiddomestik(Request $request) {
        $id_outlet_terima = $request->input('id_outlet_terima');
        $id_layanan = $request->input('id_layanan');
        $id_kota_tujuan = $request->input('id_kota_tujuan');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');
        $pembayaran = $request->input('pembayaran');

        $query = VoidManifest::query();

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

        // Urutkan berdasarkan terbaru
        $listvoidmanifest = $query->latest()->get();

        $param = [
            'listvoidmanifest' => $listvoidmanifest,
        ];

        return view('arsipmanifest.filtervoiddomestik', $param)->render();
    }

    public function restoredomestik($id) {
        $voidManifest = VoidManifest::find($id);

        // Jika Data Void Manifest Tidak ada
        if (!$voidManifest) {
            return back()->withErrors(['message' => 'Data Void Manifest tidak ditemukan.']);
        }

        DB::beginTransaction();
        try {
            // Restore data manifest
            $manifestData = [
                'no_resi' => Manifest::getNoResi(),
                'id_outlet_terima' => $voidManifest->id_outlet_terima,
                'id_pengirim' => $voidManifest->id_pengirim,
                'id_penerima' => $voidManifest->id_penerima,
                'id_barang' => $voidManifest->id_barang,
                'id_ongkir' => $voidManifest->id_ongkir,
                'id_layanan' => $voidManifest->id_layanan,
                'admin' => $voidManifest->admin,
            ];
            $manifestInstance = Manifest::create($manifestData);
            // Membuat Sub Manifest
            for ($i = 2; $i <= $voidManifest->barang->koli; $i++) {
                SubManifest::create([
                    'id_manifest' => $manifestInstance->id,
                    'sub_resi' => $manifestInstance->no_resi . str_pad($i, 3, '0', STR_PAD_LEFT)
                ]);
            }


            VoidManifest::destroy($id);
            DB::commit();
            return back()->with('success', 'Manifest Berhasil Di Pulihkan');

        } catch(\Exception $e) {
            DB::rollback();
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat Restore Manifest.']);
        }
    }

    public function savehapusvoiddomestik(Request $request) {
        DB::beginTransaction();
        $voidManifest = VoidManifest::find($request->id);

        try{
            Pengirim::destroy($voidManifest->id_pengirim);
            Penerima::destroy($voidManifest->id_penerima);
            Barang::destroy($voidManifest->id_barang);
            Ongkir::destroy($voidManifest->id_ongkir);
            VoidManifest::destroy($request->id);

            DB::commit();
            return back()->with('success', 'Manifest Berhasil Di Hapus Permanen!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat Hapus Manifest.']);
        }
    }
}
