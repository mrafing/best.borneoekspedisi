<?php

namespace App\Http\Controllers;

use App\Models\VoidManifest, App\Models\Outlet, App\Models\Layanan, App\Models\Kota, App\Models\Manifest, App\Models\SubManifest, App\Models\Tracking, App\Models\Pengirim, App\Models\Penerima, App\Models\Barang, App\Models\Ongkir, App\Models\VoidManifestLn, App\Models\NegaraLn, App\Models\PenerimaLn, App\Models\OngkirLn;
use Illuminate\Support\Facades\Auth, Illuminate\Support\Facades\DB, Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class VoidManifestController extends Controller
{
    public function manifestdomestik() 
    {
        $param = [
            'title' => 'Void manifest domestik',
            'active' => 'voidmanifestdomestik',
            'listvoidmanifest' => VoidManifest::latest()->get(),
            'listoutlet' => Outlet::all(),
            'listlayanan' => Layanan::all(),
            'listkota' => Kota::all(),
        ];

        return view('voidmanifest.manifestdomestik.index', $param);
    }

    public function filtermanifestdomestik(Request $request) 
    {
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

        return view('voidmanifest.manifestdomestik.filter', $param)->render();
    }

    
    public function restoremanifestdomestik($id) 
    {
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

            // Membuat Sub Manifest Dan Tracking Paket
            SubManifest::create([
                'id_manifest' => $manifestInstance->id,
                'sub_resi' => $manifestInstance->no_resi
            ]);

            Tracking::create([
                'id_manifest' => $manifestInstance->id,
                'no_resi' => $manifestInstance->no_resi,
                'id_outlet_asal' => $manifestInstance->id_outlet_terima,
                'id_outlet_tujuan' => NULL,
                'keterangan' => 'Paket telah di ambil outlet - ' . $manifestInstance->outlet->kode_agen,
                'status_tracking' => 'Pengambilan Paket',
                'nama_kurir' => NULL,
                'armada' => NULL,
                'plat_armada' => NULL,
                'pemindai' => Auth::user()->nama,
            ]);

            for ($i = 2; $i <= $voidManifest->barang->koli; $i++) {
                SubManifest::create([
                    'id_manifest' => $manifestInstance->id,
                    'sub_resi' => $manifestInstance->no_resi . str_pad($i, 3, '0', STR_PAD_LEFT)
                ]);
                Tracking::create([
                    'id_manifest' => $manifestInstance->id,
                    'no_resi' => $manifestInstance->no_resi . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'id_outlet_asal' => $manifestInstance->id_outlet_terima,
                    'id_outlet_tujuan' => NULL,
                    'keterangan' => 'Paket telah di ambil outlet - ' . $manifestInstance->outlet->kode_agen,
                    'status_tracking' => 'Pengambilan Paket',
                    'nama_kurir' => NULL,
                    'armada' => NULL,
                    'plat_armada' => NULL,
                    'pemindai' => Auth::user()->nama,
                ]);
            }


            VoidManifest::destroy($id);
            DB::commit();
            return back()->with('success', 'Nomor resi berhasil dipulihkan');

        } catch(\Exception $e) {
            DB::rollback();
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat memulihkan nomor resi.']);
        }
    }

    public function deletemanifestdomestik(Request $request) 
    {
        DB::beginTransaction();
        $voidManifest = VoidManifest::find($request->id);

        try{
            Pengirim::destroy($voidManifest->id_pengirim);
            Penerima::destroy($voidManifest->id_penerima);
            Barang::destroy($voidManifest->id_barang);
            Ongkir::destroy($voidManifest->id_ongkir);
            VoidManifest::destroy($request->id);

            DB::commit();
            return back()->with('success', 'Nomor resi berhasil  dihapus permanen');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat manghapus nomor resi']);
        }
    }

    public function manifestinternational() 
    {
        $param = [
            'title' => 'Void manifest international',
            'active' => 'voidmanifestinternational',
            'listvoidmanifest' => VoidManifestLn::all(),
            'listoutlet' => Outlet::all(),
            'listnegara' => NegaraLn::all(),
        ];

        return view('voidmanifest.manifestinternational.index', $param);
    }

    public function filtermanifestinternational(Request $request) 
    {
        $id_outlet_terima = $request->input('id_outlet_terima');
        $id_layanan = $request->input('id_layanan');
        $id_negara_tujuan = $request->input('id_negara_tujuan');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');
        $pembayaran = $request->input('pembayaran');

        $query = VoidManifestLn::query();

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

        // Filter berdasarkan Negara tujuan
        if ($request->filled('id_negara_tujuan')) {
            $query->whereHas('penerimaLn.kotaLn.negaraLn', function ($query) use ($id_negara_tujuan) {
                $query->where('id', $id_negara_tujuan);
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

        return view('voidmanifest.manifestinternational.filter', $param)->render();
    }

    public function restoremanifestinternational($id) 
    {
        // COMING SOON //
    }

    public function deletemanifestinternational(Request $request)
    {
        $voidManifestLn = VoidManifestLn::find($request->id);

        DB::beginTransaction();
        try{
            PenerimaLn::destroy($voidManifestLn->id_penerima_ln);
            OngkirLn::destroy($voidManifestLn->id_ongkir_ln);
            VoidManifestLn::destroy($request->id);

            DB::commit();
            return back()->with('success', 'Nomor resi berhasil dihapus permanen');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat manghapus nomor resi']);
        }
    }
}
