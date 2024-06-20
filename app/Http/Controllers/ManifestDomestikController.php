<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\HargaKarantina;
use App\Models\HargaOngkir;
use App\Models\HargaItemKhusus;
use App\Models\ItemKhusus;
use App\Models\Kecamatan;
use App\Models\Provinsi;
use App\Models\Kota;
use App\Models\Layanan;
use App\Models\Manifest;
use App\Models\Ongkir;
use App\Models\Pengirim;
use App\Models\Penerima;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ManifestDomestikController extends Controller
{
    public function tambah() {
        $param = [
            'title' => 'Tambah Manifest Domestik',
            'active' => 'tambahManifestDomestik',
            'listprovinsi' => Provinsi::all(),
            'listlayanan' => Layanan::all(),
            'listkarantina' => HargaKarantina::all()
        ];

        return view('operasional.manifestdomestik.tambah', $param);
    }
    
    public function save(Pengirim $pengirim, Penerima $penerima, Barang $barang, Ongkir $ongkir, Manifest $manifest, Request $request) {
        // Validasi data dari request
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
            'id_kecamatan_penerima' => 'required',
            'no_penerima' => 'required|numeric',
    
            // Validasi Barang Kiriman
            'koli' => 'required|numeric',
            'berat_aktual' => 'required|numeric',
            'berat_volumetrik' => 'required|numeric',
            'isi' => 'required|max:10',
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
    
        // Menggunakan transaksi untuk memastikan integritas data
        DB::beginTransaction();
    
        try {
            // Membuat data pengirim
            $pengirimData = $request->only([
                'nama_pengirim', 'nama_perusahaan_pengirim', 'alamat_pengirim', 
                'id_kecamatan_pengirim', 'no_pengirim'
            ]);
            $pengirimInstance = $pengirim->create($pengirimData);
    
            // Membuat data penerima
            $penerimaData = $request->only([
                'nama_penerima', 'nama_perusahaan_penerima', 'alamat_penerima', 
                'id_kecamatan_penerima', 'no_penerima'
            ]);
            $penerimaInstance = $penerima->create($penerimaData);
    
            // Membuat data barang
            $barangData = $request->only([
                'koli', 'berat_aktual', 'berat_volumetrik', 'isi', 
                'id_komoditi', 'informasi_tambahan'
            ]);
            $barangInstance = $barang->create($barangData);
    
            // Membuat data ongkir
            $ongkirData = $request->only([
                'pembayaran', 'harga_transit', 'harga_karantina', 'harga_packing', 
                'harga_modal', 'total_modal', 'harga_ongkir', 'total_ongkir'
            ]);
            $ongkirInstance = $ongkir->create($ongkirData);
    
            // Membuat data manifest
            $manifestData = [
                'no_resi' => $manifest->getNoResi(),
                'id_outlet_terima' => Auth::user()->id_outlet,
                'id_pengirim' => $pengirimInstance->id, // Asosiasi dengan pengirim
                'id_penerima' => $penerimaInstance->id, // Asosiasi dengan penerima
                'id_barang' => $barangInstance->id, // Asosiasi dengan barang
                'id_ongkir' => $ongkirInstance->id, // Asosiasi dengan ongkir
                'id_layanan' => $request->input('id_layanan'),
                'admin' => Auth::user()->username,
            ];
            $manifestInstance = $manifest->create($manifestData);
    
            // Commit transaksi jika semuanya berhasil
            DB::commit();
            return redirect('operasional/manifestdomestik/tambah')->with('success', 'Data Berhasil Di Tambahkan!');
            
        } catch (\Exception $e) {
            // Rollback transaksi jika terjadi kesalahan
            DB::rollBack();
            // Log the error for debugging
            Log::error('Error while saving data: '.$e->getMessage());
            return back()->withErrors(['message' => 'Terjadi kesalahan saat menambahkan data.']);
        }
    }
    

    public function getKota($id) {
        $kota = Kota::where('id_provinsi', $id)->get();
        return response()->json($kota);
    }

    public function getKecamatan($id) {
        $kecamatan = Kecamatan::where('id_kota', $id)->get();
        return response()->json($kecamatan);
    }

    public function resultlayanan (Request $request) {

        $id_kota_pengirim = $request->input('id_kota_pengirim');
        $id_kecamatan_penerima = $request->input('id_kecamatan_penerima');

        $param = [
            'listhargaongkir' => HargaOngkir::where('id_kota_asal', $id_kota_pengirim)
                                            ->where('id_kecamatan_tujuan', $id_kecamatan_penerima)
                                            ->get()
        ];


        return view('operasional.manifestdomestik.resultlayanan', $param)->render();
    }

    public function resultitemkhusus (Request $request) {

        $id_layanan = $request->input('id_layanan');
        $param = [
            'id_layanan' => $id_layanan,
            'listitemkhusus' => ItemKhusus::all()
        ];
        return view('operasional.manifestdomestik.resultitemkhusus', $param)->render();
    }

    public function resulttabelkoli (Request $request) {
        $id_layanan = $request->input('id_layanan');
        $id_item_khusus = $request->input('id_item_khusus');
        $koli = $request->input('koli');
        $param = [
            'id_layanan' => $id_layanan,
            'id_item_khusus' => $id_item_khusus,
            'koli' => $koli,
            'detail_ik' => ItemKhusus::where('id', $id_item_khusus)->first()
        ];
        return view('operasional.manifestdomestik.resulttabelkoli', $param)->render();
    }

    public function resultjumlahitemkomodit (Request $request) {
        $id_komoditi = $request->input('id_komoditi');
        $param = [
            'id_komoditi' => $id_komoditi
        ];

        return view('operasional.manifestdomestik.resultjumlahitemkomodit', $param)->render();
    }

    public function resultinformasibiaya (Request $request) {
        $id_kota_pengirim = $request->input('id_kota_pengirim');
        $id_kecamatan_penerima = $request->input('id_kecamatan_penerima');
        $id_layanan = $request->input('id_layanan');
        $id_komoditi = $request->input('id_komoditi');
        $jumlah_item_komoditi = $request->input('jumlah_item_komoditi');
        $id_item_khusus = $request->input('id_item_khusus');
        $bv = $request->input('bv');
        $ba = $request->input('ba');

        // jika layanan cargo
        if ($id_layanan == "LY4" || $id_layanan == "LY5") {
            if ($bv < 0 || $ba < 10) {
                $ba = 10;
                $bv = 10;
            }
        }

        // ambil yang terberat
        if ($ba >= $bv) {
            $terberat = $ba;
        } else {
            $terberat = $bv;
        }



        $refreshBiaya = $request->input('refreshBiaya');

        if ($id_item_khusus) {
            $param = [
                'item_khusus' => true,
                'terberat' => $terberat,
                'resultitemkhusus' => ItemKhusus::where('id', $id_item_khusus)->first(),
                'resulthargaongkir' => HargaItemKhusus::where('id_kota_asal', $id_kota_pengirim)
                                                        ->where('id_kecamatan_tujuan', $id_kecamatan_penerima)
                                                        ->where('id_ik', $id_item_khusus)
                                                        ->first(),
                'refreshbiaya' => $refreshBiaya,
            ];
        } else {
            $param = [
                'item_khusus' => false,
                'terberat' => $terberat,
                'hargapacking' => 0,
                'jumlahitemkomoditi' => $jumlah_item_komoditi,
                'resulthargakarantina' => HargaKarantina::where('id', $id_komoditi)->first(),
                'resulthargaongkir' => HargaOngkir::where('id_kota_asal', $id_kota_pengirim)
                                        ->where('id_kecamatan_tujuan', $id_kecamatan_penerima)
                                        ->where('id_layanan', $id_layanan)
                                        ->first(),
                'refreshbiaya' => $refreshBiaya,
                ];
        }

        return view('operasional.manifestdomestik.resultinformasibiaya', $param)->render();
    }
}
