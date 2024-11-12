<?php

namespace App\Http\Controllers;

use App\Models\Barang, App\Models\HargaOngkirLn, App\Models\KotaLn, App\Models\Layanan, App\Models\Manifest, App\Models\ManifestLn, App\Models\NegaraLn, App\Models\Ongkir, App\Models\OngkirLn, App\Models\Penerima, App\Models\PenerimaLn, App\Models\Pengirim, App\Models\SubManifest, App\Models\SubManifestLn, App\Models\VoidManifest, App\Models\VoidManifestLn, App\Models\Tracking;
use Illuminate\Support\Facades\Auth, Illuminate\Support\Facades\DB, Illuminate\Support\Facades\Log;
use Dompdf\Dompdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ManifestInternationalController extends Controller
{
    public function index() 
    {
        $param = [
            'title' => 'Manifest harian international',
            'listmanifest' => ManifestLn::where('id_outlet_terima', Auth::user()->id_outlet)
                         ->whereDate('created_at', Carbon::today())
                         ->latest()
                         ->get(),
            'listnegara' => NegaraLn::all(),
        ];

        return view('operasional.manifestinternational.index', $param);
    }
    
    public function filter(Request $request) 
    {
        $id_layanan = $request->input('id_layanan');
        $id_negara_tujuan = $request->input('id_negara_tujuan');
        $tanggal_terima = $request->input('tanggal_terima');
        $pembayaran = $request->input('pembayaran');
        $no_resi = $request->input('no_resi');

        $query = ManifestLn::query()->where('id_outlet_terima', Auth::user()->id_outlet);

    
        // Filter berdasarkan layanan
        if ($request->filled('id_layanan')) {
            $query->where('id_layanan', $id_layanan);
        }
    
        // Filter berdasarkan negara tujuan
        if ($request->filled('id_negara_tujuan')) {
            $query->whereHas('penerimaLn.kotaLn.negaraLn', function ($query) use ($id_negara_tujuan) {
                $query->where('id', $id_negara_tujuan);
            });
        }

        // Filter berdasarkan tanggal terima
        if ($request->filled('tanggal_terima')) {
            $query->whereDate('created_at', $tanggal_terima);
        } else {
            // Default: data hari ini
            $query->whereDate('created_at', Carbon::today());
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

        return view('operasional.manifestinternational.filter', $param)->render();
    }

    public function tambah() 
    {
        $param = [
            'title' => 'Tambah manifest international',
            'listnegara' => NegaraLn::all(),
            'listlayanan' => Layanan::all(),
            // 'listkarantina' => HargaKarantina::all()
        ];

        return view('operasional.manifestinternational.tambah', $param);
    }

    public function save(Request $request) 
    {
        // dd($request);
        $request->validate([
            // Validasi Informasi Pengirim
            'nama_pengirim' => 'required|max:15',
            'nama_perusahaan_pengirim' => 'max:20',
            'alamat_pengirim' => 'required|max:70',
            'id_kecamatan_pengirim' => 'required',
            'no_pengirim' => 'required|numeric',
            
            // Validasi Informasi Penerima
            'nama_penerima' => 'required|max:15',
            'nama_perusahaan_penerima' => 'max:20',
            'alamat_penerima' => 'required|max:70',
            'id_kota_ln_penerima' => 'required',
            'no_penerima' => 'required|numeric',
            
            // Validasi Barang Kiriman
            'koli' => 'required|numeric',
            'berat_aktual' => 'required|numeric',
            'berat_volumetrik' => 'required|numeric',
            'isi' => 'required|max:20',
            'id_komoditi' => 'required',
            'informasi_tambahan' => 'max:50',
            
            // Validasi Informasi Biaya
            'pembayaran' => 'required',
            'harga_transit' => 'required|numeric',
            'harga_karantina' => 'required|numeric',
            'harga_packing' => 'required|numeric',
            'harga_modal' => 'required|numeric',
            'total_modal' => 'required|numeric',
            'harga_ongkir' => 'required|numeric',
            'total_ongkir' => 'required|numeric',
            
            // Validasi Manifest
            'id_layanan' => 'required'
        ]);

        DB::beginTransaction();

        try {
            // Membuat data pengirim
            $pengirimData = $request->only([
                'nama_pengirim', 'nama_perusahaan_pengirim', 'alamat_pengirim', 
                'id_kecamatan_pengirim', 'no_pengirim'
            ]);
            $pengirimInstance = Pengirim::create($pengirimData);

            // Membuat data penerima
            $penerimaData = [
                'nama_penerima' => 'OVIAN',
                'nama_perusahaan_penerima' => '',
                'alamat_penerima' => 'JL. UTAMA VII, MELATI 1, NO.8A RT.009 RW.001, (SAMPING WARTEG OJOLALI, GERBANG WARNA PUTIH)',
                'id_kecamatan_penerima' => '31.73.01',
                'no_penerima' => '081298657593'
            ];
            $penerimaInstance = Penerima::create($penerimaData);

            // Membuat data penerima Luar Negeri
            $penerimaDataLn = $request->only([
                'nama_penerima', 'nama_perusahaan_penerima', 'alamat_penerima', 
                'id_kota_ln_penerima', 'no_penerima'
            ]);
            $penerimaLnInstance = PenerimaLn::create($penerimaDataLn);

            // Membuat data barang
            $barangData = $request->only([
                'koli', 'berat_aktual', 'berat_volumetrik', 'isi', 
                'id_komoditi', 'informasi_tambahan'
            ]);
            $barangInstance = Barang::create($barangData);

            // Membuat data ongkir
            $ba = $request->input('berat_aktual');
            $bv = $request->input('berat_volumetrik');

            if ($ba >= $bv) {
                $terberat = $ba;
            } else {
                $terberat = $bv;
            }

            $ongkirData = [
                'pembayaran' => $request->input('pembayaran'),
                'harga_transit' => 0,
                'harga_karantina' => $request->input('harga_karantina'),
                'harga_packing' => $request->input('harga_packing'),
                'harga_modal' => 0,
                'total_modal' => 0,
                'harga_ongkir' => 27000,
                'total_ongkir' => $terberat * 27000 + $request->input('harga_packing') + $request->input('harga_karantina'),
            ];
            $ongkirInstance = Ongkir::create($ongkirData);

            // Membuat data ongkir Luar Negeri
            $ongkirDataLn = $request->only([
                'pembayaran', 'harga_transit', 'harga_karantina', 'harga_packing', 
                'harga_modal', 'total_modal', 'harga_ongkir', 'total_ongkir'
            ]);
            $ongkirLnInstance = OngkirLn::create($ongkirDataLn);

            // Membuat data manifest
            $manifestData = [
                'no_resi' => Manifest::getNoResi(),
                'id_outlet_terima' => Auth::user()->id_outlet,
                'id_pengirim' => $pengirimInstance->id,
                'id_penerima' => $penerimaInstance->id,
                'id_barang' => $barangInstance->id,
                'id_ongkir' => $ongkirInstance->id,
                'id_layanan' => 'LY1',
                'admin' => Auth::user()->nama,
            ];
            $manifestInstance = Manifest::create($manifestData);

            // Membuat data manifest Luar Negeri
            $manifestDataLn = [
                'no_resi' => $manifestInstance->no_resi,
                'id_outlet_terima' => Auth::user()->id_outlet,
                'id_pengirim' => $pengirimInstance->id,
                'id_penerima_ln' => $penerimaLnInstance->id,
                'id_barang' => $barangInstance->id,
                'id_ongkir_ln' => $ongkirLnInstance->id,
                'id_layanan' => $request->input('id_layanan'),
                'admin' => Auth::user()->nama,
            ];
            $manifestLnInstance = ManifestLn::create($manifestDataLn);

            // Membuat Sub Manifest Dan Tracking Paket
            SubManifest::create([
                'id_manifest' => $manifestInstance->id,
                'sub_resi' => $manifestInstance->no_resi
            ]);

            Tracking::create([
                'id_manifest' => $manifestInstance->id,
                'no_resi' => $manifestInstance->no_resi,
                'id_outlet_asal' => Auth::user()->id_outlet,
                'id_outlet_tujuan' => NULL,
                'keterangan' => 'Paket telah di ambil outlet - ' . Auth::user()->outlet->kode_agen,
                'status_tracking' => 'Pengambilan Paket',
                'nama_kurir' => NULL,
                'armada' => NULL,
                'plat_armada' => NULL,
                'pemindai' => Auth::user()->nama,
            ]);

            for ($i = 2; $i <= $request->koli; $i++) {
                SubManifest::create([
                    'id_manifest' => $manifestInstance->id,
                    'sub_resi' => $manifestInstance->no_resi . str_pad($i, 3, '0', STR_PAD_LEFT)
                ]);
                Tracking::create([
                    'id_manifest' => $manifestInstance->id,
                    'no_resi' => $manifestInstance->no_resi . str_pad($i, 3, '0', STR_PAD_LEFT),
                    'id_outlet_asal' => Auth::user()->id_outlet,
                    'id_outlet_tujuan' => NULL,
                    'keterangan' => 'Paket telah di ambil outlet - ' . Auth::user()->outlet->kode_agen,
                    'status_tracking' => 'Pengambilan Paket',
                    'nama_kurir' => NULL,
                    'armada' => NULL,
                    'plat_armada' => NULL,
                    'pemindai' => Auth::user()->nama,
                ]);
            }

            // Membuat Sub Manifest Luar Negeri
            SubManifestLn::create([
                'id_manifest_ln' => $manifestLnInstance->id,
                'sub_resi' => $manifestLnInstance->no_resi
            ]);

            for ($i = 2; $i <= $request->koli; $i++) {
                SubManifestLn::create([
                    'id_manifest_ln' => $manifestLnInstance->id,
                    'sub_resi' => $manifestLnInstance->no_resi . str_pad($i, 3, '0', STR_PAD_LEFT)
                ]);
            }

            DB::commit();
            return back()->with('success', 'Nomor resi berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data :'.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat menambahkan nomor resi.']);
        }

    }

    public function printresi($id)
    {
        $data = ManifestLn::find($id);
        $submanifest = SubManifestLn::where('id_manifest_ln', $id)
                        ->orderby('sub_resi')
                        ->get();

        $param = [
            'title' => 'Print Manifest International',
            'data' => $data,
            'submanifest' => $submanifest,
        ];

        $html = view('operasional.manifestinternational.printresi', $param)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('F4', 'portrait');
        $dompdf->render();
        ob_end_clean();
        return $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

    public function delete(Request $request) 
    {   
        $manifestLn = ManifestLn::find($request->id);
        $manifest = Manifest::where('no_resi', $manifestLn->no_resi)->first();

        DB::beginTransaction();
        try{
            // Membuat Data Void Manifest
            $voidManifestData = [
                'id_outlet_terima' => $manifest->id_outlet_terima,
                'id_pengirim' => $manifest->id_pengirim,
                'id_penerima' => $manifest->id_penerima,
                'id_barang' => $manifest->id_barang,
                'id_ongkir' => $manifest->id_ongkir,
                'id_layanan' => $manifest->id_layanan,
                'keterangan_hapus' => $request->keterangan_hapus,
                'admin' => $manifest->admin,
                'deleted_by' => Auth::user()->nama,
            ];
            VoidManifest::create($voidManifestData);
            Manifest::where('no_resi', $manifest->no_resi)->delete();
            SubManifest::where('id_manifest', $manifest->id)->delete();
            Tracking::where('id_manifest', $manifest->id)->delete();

            // Membuat Data Void Manifest International
            $voidManifestLnData = [
                'id_outlet_terima' => $manifestLn->id_outlet_terima,
                'id_pengirim' => $manifestLn->id_pengirim,
                'id_penerima_ln' => $manifestLn->id_penerima_ln,
                'id_barang' => $manifestLn->id_barang,
                'id_ongkir_ln' => $manifestLn->id_ongkir_ln,
                'id_layanan' => $manifestLn->id_layanan,
                'keterangan_hapus' => $request->keterangan_hapus,
                'admin' => $manifestLn->admin,
                'deleted_by' => Auth::user()->nama,
            ];
            VoidManifestLn::create($voidManifestLnData);
            ManifestLn::destroy($request->id);
            SubManifestLn::where('id_manifest_ln', $request->id)->delete();

            DB::commit();
            return redirect('/arsipmanifest/manifestinternational/')->with('success', 'Nomor resi berhasil divoid');
            
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat void nomor resi.']);
        }
    }

    public function getkota($id)
    {
        $kota = KotaLn::where('id_negara', $id)->get();
        return response()->json($kota);
    }

    public function resultlayananln(Request $request)
    {

        $id_kota_penerima = $request->input('id_kota_penerima');

        $param = [
            'listhargaongkir' => HargaOngkirLn::where('id_kota_ln', $id_kota_penerima)->get()
        ];


        return view('operasional.manifestinternational.resultlayananln', $param)->render();
    }

    public function resulttabelkoliln (Request $request)
    {
        $id_layanan = $request->input('id_layanan');
        $koli = $request->input('koli');
        $param = [
            'id_layanan' => $id_layanan,
            'koli' => $koli,
        ];
        return view('operasional.manifestinternational.resulttabelkoliln', $param)->render();
    }

    public function resultinformasibiayaln (Request $request)
    {
        $id_kota_penerima = $request->input('id_kota_penerima');
        $id_layanan = $request->input('id_layanan');
        $bv = $request->input('bv');
        $ba = $request->input('ba');

        // ambil yang terberat
        if ($ba >= $bv) {
            $terberat = $ba;
        } else {
            $terberat = $bv;
        }



        $refreshBiaya = $request->input('refreshBiaya');

        $param = [
            'terberat' => $terberat,
            'hargapacking' => 0,
            'resulthargaongkir' => HargaOngkirLn::where('id_kota_ln', $id_kota_penerima)
                                    ->where('id_layanan', $id_layanan)
                                    ->first(),
            'refreshbiaya' => $refreshBiaya,
        ];

        // $param = [
        //     'id_kota_penerima' => $id_kota_penerima,
        //     'id_layanan' => $id_layanan,
        //     'terberat' => $terberat,
        // ];

        return view('operasional.manifestinternational.resultinformasibiayaln', $param)->render();
    }
}
