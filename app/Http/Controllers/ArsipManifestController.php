<?php

namespace App\Http\Controllers;

use App\Models\Barang, App\Models\Ongkir, App\Models\Manifest, App\Models\Kota, App\Models\Layanan, App\Models\ManifestLn, App\Models\NegaraLn, App\Models\OngkirLn, App\Models\Outlet, App\Models\Penerima, App\Models\PenerimaLn, App\Models\Pengirim, App\Models\Tracking;
use Illuminate\Support\Facades\Auth, Illuminate\Support\Facades\DB, Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Dompdf\Dompdf;

class ArsipManifestController extends Controller
{
    public function index()
    {
        $param = [
            'title' => 'Arsip manifest',
            'active' => 'arsipmanifest'
        ];
        return view('arsipmanifest.index', $param);
    }

    public function manifestdomestik()
    {

        $query = Manifest::query();

        if (Auth::user()->role == 'gm') {
            
        } else {
            $query->where('id_outlet_terima', Auth::user()->id_outlet);
        }

        $listmanifest = $query->latest()->get();

        $param = [
            'title' => 'Arsip manifest domestik',
            'active' => 'arsipmanifestdomestik',
            'listmanifest' => $listmanifest,
            'listkota' => Kota::all(),
            'listlayanan' => Layanan::all(),
            'listoutlet' => Outlet::all(),
        ];

        return view('arsipmanifest.manifestdomestik.index', $param);
    }

    public function filtermanifestdomestik(Request $request) 
    {
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

        return view('arsipmanifest.manifestdomestik.filter', $param)->render();
    }

    public function detailmanifestdomestik($id) 
    {
        $param = [
            'title' => 'Detail manifest domestik',
            'active' => 'detailmanifestdomestik',
            'data' => Manifest::find($id),
            'dataTracking' => Tracking::where('id_manifest', $id)->latest()->first()
        ];

        return view('arsipmanifest.manifestdomestik.detail', $param);
    }

    public function editmanifestdomestik($id) 
    {
        $param = [
            'title' => 'Edit manifest domestik',
            'active' => 'editmanifestdomestik',
            'data' => Manifest::find($id)
        ];

        return view('arsipmanifest.manifestdomestik.edit', $param);
    }

    public function updatemanifestdomestik(Request $request) 
    {
        // dd($request);
        $request->validate([
            // Validasi Informasi Pengirim
            'nama_pengirim' => 'required|max:15',
            'nama_perusahaan_pengirim' => 'max:20',
            'alamat_pengirim' => 'required|max:100',
            'no_pengirim' => 'required|numeric',

            // Validasi Informasi Penerima
            'nama_penerima' => 'required|max:15',
            'nama_perusahaan_penerima' => 'max:20',
            'alamat_penerima' => 'required|max:100',
            'no_penerima' => 'required|numeric',

            // Validasi Barang Kiriman
            'isi' => 'required|max:20',
            'informasi_tambahan' => 'max:50',

            // Validasi Informasi Biaya
            'pembayaran' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $pengirimData = $request->only([
                'nama_pengirim', 'nama_perusahaan_pengirim', 'alamat_pengirim', 'no_pengirim'
            ]);
            Pengirim::find($request->id_pengirim)->update($pengirimData);

            $penerimaData = $request->only([
                'nama_penerima', 'nama_perusahaan_penerima', 'alamat_penerima', 'no_penerima'
            ]);
            Penerima::find($request->id_penerima)->update($penerimaData);

            $barangData = $request->only([
                'isi', 'informasi_tambahan'
            ]);
            Barang::find($request->id_barang)->update($barangData);

            $ongkirData = $request->only([
                'pembayaran'
            ]);
            Ongkir::find($request->id_ongkir)->update($ongkirData);
            
            DB::commit();
            return back()->with('success', 'Nomor resi berhasil diubah');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat mengubah nomor resi.']);
        }
    }

    public function pdfmanifestdomestik(Request $request) 
    {
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

        $html = view('arsipmanifest.manifestdomestik.pdf', $param)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('F4', 'landscape');
        $dompdf->render();
        return $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function excelmanifestdomestik(Request $request) 
    {
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

        return view('arsipmanifest.manifestdomestik.excel', $param);
    }

    public function manifestinternational()
    {

        $query = ManifestLn::query();

        if (Auth::user()->role == 'gm') {

        } else {
            $query->where('id_outlet_terima', Auth::user()->id_outlet);
        }

        $listmanifest = $query->latest()->get();

        $param = [
            'title' => 'Arsip manifest international',
            'active' => 'arsipmanifestinternational',
            'listmanifest' => $listmanifest,
            'listnegara' => NegaraLn::all(),
            'listoutlet' => Outlet::all(),
        ];

        return view('arsipmanifest.manifestinternational.index', $param);
    }

    public function filtermanifestinternational(Request $request)
    {
        $id_outlet_terima = $request->input('id_outlet_terima');
        $id_layanan = $request->input('id_layanan');
        $id_negara_tujuan = $request->input('id_negara_tujuan');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');
        $pembayaran = $request->input('pembayaran');
        $no_resi = $request->input('no_resi');

        $query = ManifestLn::query();

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
            $query->whereHas('ongkirLn', function ($query) use ($pembayaran) {
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

        return view('arsipmanifest.manifestinternational.filter', $param)->render();
    }

    public function detailmanifestinternational($id) 
    {
        $manifestLn = ManifestLn::find($id);
        $dataTracking = Tracking::where('no_resi', $manifestLn->no_resi)->latest()->first();

        $param = [
            'title' => 'Detail manifest international',
            'active' => 'detailmanifestinternational',
            'data' => $manifestLn,
            'dataTracking' => $dataTracking
        ];

        return view('arsipmanifest.manifestinternational.detail', $param);
    }

    public function editmanifestinternational($id) 
    {
        $param = [
            'title' => 'Edit manifest international',
            'active' => 'editmanifestinternational',
            'data' => ManifestLn::find($id)
        ];

        return view('arsipmanifest.manifestinternational.edit', $param);
    }

    public function updatemanifestinternational(Request $request) 
    {
        // dd($request);
        $request->validate([
            // Validasi Informasi Pengirim
            'nama_pengirim' => 'required|max:15',
            'nama_perusahaan_pengirim' => 'max:20',
            'alamat_pengirim' => 'required|max:100',
            'no_pengirim' => 'required|numeric',

            // Validasi Informasi Penerima
            'nama_penerima' => 'required|max:15',
            'nama_perusahaan_penerima' => 'max:20',
            'alamat_penerima' => 'required|max:100',
            'no_penerima' => 'required|numeric',

            // Validasi Barang Kiriman
            'isi' => 'required|max:20',
            'informasi_tambahan' => 'max:50',

            // Validasi Informasi Biaya
            'pembayaran' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $pengirimData = $request->only([
                'nama_pengirim', 'nama_perusahaan_pengirim', 'alamat_pengirim', 'no_pengirim'
            ]);
            Pengirim::find($request->id_pengirim)->update($pengirimData);

            $penerimaLnData = $request->only([
                'nama_penerima', 'nama_perusahaan_penerima', 'alamat_penerima', 'no_penerima'
            ]);
            PenerimaLn::find($request->id_penerima_ln)->update($penerimaLnData);

            $barangData = $request->only([
                'isi', 'informasi_tambahan'
            ]);
            Barang::find($request->id_barang)->update($barangData);

            $ongkirLnData = $request->only([
                'pembayaran'
            ]);
            OngkirLn::find($request->id_ongkir_ln)->update($ongkirLnData);
            
            DB::commit();
            return back()->with('success', 'Nomor resi berhasil diubah');
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat mengubah nomor resi.']);
        }
    }

    public function pdfmanifestinternational(Request $request)
    {
        $id_outlet_terima = $request->input('id_outlet_terima');
        $id_layanan = $request->input('id_layanan');
        $id_negara_tujuan = $request->input('id_negara_tujuan');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');
        $pembayaran = $request->input('pembayaran');
        $no_resi = $request->input('no_resi');

        $query = ManifestLn::query();

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

        // Filter berdasarkan nomor/kode resi
        if ($request->filled('no_resi')) {
            $query->where('no_resi', $no_resi);
        }

        // Urutkan berdasarkan terbaru
        $listmanifest = $query->latest()->get();

        $param = [
            'listmanifest' => $listmanifest,
        ];

        $html = view('arsipmanifest.manifestinternational.pdf', $param)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('F4', 'landscape');
        $dompdf->render();
        return $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function excelmanifestinternational (Request $request) 
    {
        $id_outlet_terima = $request->input('id_outlet_terima');
        $id_layanan = $request->input('id_layanan');
        $id_negara_tujuan = $request->input('id_negara_tujuan');
        $dari_tanggal = $request->input('dari_tanggal');
        $sampai_tanggal = $request->input('sampai_tanggal');
        $pembayaran = $request->input('pembayaran');
        $no_resi = $request->input('no_resi');

        $query = ManifestLn::query();

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

        // Filter berdasarkan nomor/kode resi
        if ($request->filled('no_resi')) {
            $query->where('no_resi', $no_resi);
        }

        // Urutkan berdasarkan terbaru
        $listmanifest = $query->latest()->get();

        $param = [
            'listmanifest' => $listmanifest,
        ];

        return view('arsipmanifest.manifestinternational.excel', $param);
    }

}
