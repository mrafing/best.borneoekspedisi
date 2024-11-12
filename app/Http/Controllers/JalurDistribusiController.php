<?php

namespace App\Http\Controllers;

use App\Models\DetailKarung, App\Models\SubManifest, App\Models\Tracking, App\Models\Outlet, App\Models\Manifest, App\Models\Karung, App\Models\Kota;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth, Illuminate\Support\Facades\DB, Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Dompdf\Dompdf;
use Nette\Utils\Json;


class JalurDistribusiController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Jalur distribusi',
            'active' => 'jalurdistribusi'
        ];
        return view('jalurdistribusi.index', $param);
    }

    public function menuscan() 
    {
        $param = [
            'title' => 'Menu scan',
            'active' => 'menuscan'
        ];

        return view('jalurdistribusi.menuscan', $param);
    }

    public function scanmasuk() 
    {
        $param = [
            'title' => 'Scan masuk',
            'active' => 'scanmasuk'
        ];

        return view('jalurdistribusi.scanmasuk', $param);
    }

    public function savescanmasuk(Request $request) 
    {
        // Ambil data input
        $no_resi = $request->input('no_resi', []); // default to an empty array
        $id_outlet_asal = Auth::user()->id_outlet;
        $keterangan = "Paket Telah masuk di - " . Auth::user()->outlet->kode_agen;
        $status_tracking = "scan masuk " . Auth::user()->outlet->tipe;
        $pemindai = Auth::user()->nama;
    
        // Validasi input
        $request->validate(
            ['no_resi.*' => 'required|min:12|max:15'],
            [
                'no_resi.*.required' => 'Nomor resi tidak boleh kosong!',
                'no_resi.*.min' => 'Format resi salah, mohon diulangi!',
                'no_resi.*.max' => 'Format resi salah, mohon diulangi!'
            ]
        );
    
        DB::beginTransaction();
        try {
            foreach ($no_resi as $resi) {
                // Cek apakah nomor resi sesuai dengan data SubManifest
                $sub_manifest = SubManifest::where('sub_resi', $resi)->first();
                if (!$sub_manifest) {
                    throw new \Exception("$resi tidak valid, mohon diulangi!");
                }
    
                // Cek apakah resi sudah discan masuk sebelumnya
                $tracking = Tracking::where('no_resi', $resi)
                                    ->where('status_tracking', $status_tracking)
                                    ->first();
                if ($tracking) {
                    // Jika sudah discan, beri pesan error
                    throw new \Exception("$resi sudah discan $status_tracking, mohon diulangi");
                }

                // Cek apakah resi sudah di scan kirim oleh outlet asal
                $tracking2 = Tracking::where('no_resi', $resi)
                                        ->where('id_outlet_tujuan', Auth::user()->id_outlet)
                                        ->first();
                if(!$tracking2) {
                    $manifest = Manifest::find($sub_manifest->id_manifest);
                    if($manifest->id_outlet_terima != Auth::user()->id_outlet) {
                        throw new \Exception("$resi belum discan kirim oleh outlet asal atau outlet tujuan tidak sesuai, mohon untuk diulangi!");
                    }
                }
    
                // Simpan data tracking baru
                $trackingData = [
                    'id_manifest' => $sub_manifest->id_manifest,
                    'no_resi' => $resi,
                    'id_outlet_asal' => $id_outlet_asal,
                    'keterangan' => $keterangan,
                    'status_tracking' => $status_tracking,
                    'pemindai' => $pemindai,
                    'status' => "belum dikirim"
                ];
                Tracking::create($trackingData);
    
                // Update data tracking scan kirim
                Tracking::where('no_resi', $resi)
                        ->whereIn('status_tracking', ["scan kirim mitra b", "scan kirim mitra a"])
                        ->update(['status' => 'diterima']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }
    
        return back()->with('success', 'Scan berhasil');
    }
    
    public function scankirim() 
    {
        $listmasukoutlet = Tracking::where('id_outlet_asal', Auth::user()->id_outlet)
                                    ->where('status_tracking', "scan masuk ". Auth::user()->outlet->tipe ."")
                                    ->where('status', 'belum dikirim')
                                    ->latest()
                                    ->get();

        $param = [
            'title' => 'Scan kirim',
            'active' => 'scankirim',
            'listmasukoutlet' => $listmasukoutlet,
            'listoutlet' => Outlet::whereIn('tipe', ['mitra a', 'gw'])->get()
        ];

        return view('jalurdistribusi.scankirim', $param);
    }

    public function savescankirim(Request $request)
    {
        // Ambil data input
        $no_resi = $request->input('no_resi', []); // default to an empty array
        $id_outlet_asal = Auth::user()->id_outlet;
        $id_outlet_tujuan = $request->input('id_outlet_tujuan');
        $keterangan = 'Paket telah dikirim ke - ' . Outlet::find($id_outlet_tujuan)->kode_agen;
        $status_tracking = "scan kirim ". Auth::user()->outlet->tipe ."";
        $nama_kurir = $request->input('nama_kurir');
        $armada = $request->input('armada');
        $plat_armada = $request->input('plat_armada');
        $pemindai = Auth::user()->nama;

        // Validasi input
        $request->validate(
            [
                'no_resi.*' => 'required|min:12|max:15',
                'nama_kurir' => 'required',
                'armada' => 'required',
                'plat_armada' => 'required'
            ],
            [
                'no_resi.*.required' => 'Nomor resi tidak boleh kosong!',
                'no_resi.*.min' => 'Format resi salah, mohon diulangi!',
                'no_resi.*.max' => 'Format resi salah, mohon diulangi!'
            ]
        );

        // Cek apakah ada nomor resi yang diinput
        if (empty($no_resi)) {
            return back()->withErrors(['message' => 'Maaf tidak ada nomor resi yang dicentang, mohon dicentang minimal satu nomor resi.']);
        }

        DB::beginTransaction();
        try {
            foreach ($no_resi as $resi) {
                // Cek apakah nomor resi sesuai dengan data SubManifest
                $sub_manifest = SubManifest::where('sub_resi', $resi)->first();
                if(!$sub_manifest) {
                    throw new \Exception("$resi tidak valid, mohon diulangi!");
                }

                // Cek apakah resi sudah discan kirim sebelumnya
                $tracking = Tracking::where('no_resi', $resi)
                                    ->where('status_tracking', $status_tracking)
                                    ->first();
                if($tracking) {
                    // Jika sudah discan, beri pesan error
                    throw new \Exception("$resi sudah discan $status_tracking, mohon diulangi!");
                }

                // Simpan data tracking baru
                $trackingData = [
                    'id_manifest' => $sub_manifest->id_manifest,
                    'no_resi' => $resi,
                    'id_outlet_asal' => $id_outlet_asal,
                    'id_outlet_tujuan' => $id_outlet_tujuan,
                    'keterangan' => $keterangan,
                    'status_tracking' => $status_tracking,
                    'nama_kurir' => $nama_kurir,
                    'armada' => $armada,
                    'plat_armada' => $plat_armada,
                    'pemindai' => $pemindai,
                    'status' => "belum diterima"
                ];
                Tracking::create($trackingData);

                // Update data tracking scan masuk outlet
                Tracking::where('no_resi', $resi)
                        ->where('status_tracking', "scan masuk ". Auth::user()->outlet->tipe ."")
                        ->update(['status' => 'dikirim']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Berhasil dikirim');
    }

    public function scankarung() 
    {
        $param = [
            'title' => 'Scan karung',
            'active' => 'scankarung',
            'listoutlet' => Outlet::all()
        ];

        return view('jalurdistribusi.scankarung', $param);
    }

    public function searchkodekarung(Request $request)
    {
        $search = $request->input('q');

        $outlets = Outlet::where('kode_agen', 'like', "%$search%")
                        ->get();
        $kota = Kota::where('nama_kota', 'like', "%$search%")
                    ->orWhere('kode_kota', 'like', "%$search%")
                    ->get();
    
        return response()->json([
            'outlets' => $outlets,
            'kota' => $kota,
        ]);
    }

    public function savescankarung(Request $request) 
    {
        // dd($request);
        
        // Ambil data karung
        $no_karung = Karung::getNoKarung();
        $no_smu = NULL;
        $nama_karung = $request->input('nama_karung');
        $id_outlet_asal = Auth::user()->id_outlet;
        $id_outlet_tujuan = NULL;
        $kode_karung = $request->input('kode_karung');
        $total_kilo = $request->input('total_kilo');
        $status_tracking = "scan masuk karung";
        $pemindai = Auth::user()->nama;
        $status = "belum dikirim";

        // Ambil data detail karung
        $no_resi = $request->input('no_resi', []);

        // Validasi input
        $request->validate(
            [
                'no_resi.*' => 'required|min:12|max:15',
                'nama_karung' => 'required|numeric',
                'kode_karung' => 'required',
                'total_kilo' => 'required|numeric'
            ],
            [
                'no_resi.*.required' => 'Nomor resi tidak boleh kosong!',
                'no_resi.*.min' => 'Format resi salah, mohon diulangi!',
                'no_resi.*.max' => 'Format resi salah, mohon diulangi!'
            ]
        );

        DB::beginTransaction();
        try {
            // Cek Apakah Karung Sudah Ada
            $karung = Karung::where('nama_karung', $nama_karung)
                            ->where('kode_karung', $kode_karung)
                            ->where('status_tracking', 'scan masuk karung')
                            ->whereDate('created_at', Carbon::today())
                            ->first();
            if($karung) {
                throw new \Exception("Nomor grub K$nama_karung dan kode karung $kode_karung sudah ada, mohon diulangi!");
            }

            // Simpan data karung
            $karungData = [
                'no_karung' => $no_karung,
                'no_smu' => $no_smu,
                'nama_karung' => $nama_karung,
                'id_outlet_asal' => $id_outlet_asal,
                'id_outlet_tujuan' => $id_outlet_tujuan,
                'kode_karung' => $kode_karung,
                'total_kilo' => $total_kilo,
                'status_tracking' => $status_tracking,
                'pemindai' => $pemindai,
                'status' => $status
            ];
            Karung::create($karungData);

            foreach($no_resi as $resi) {
                // Cek apakah nomor resi sesuai dengan data SubManifest
                $sub_manifest = SubManifest::where('sub_resi', $resi)->first();
                if (!$sub_manifest) {
                    throw new \Exception("$resi tidak valid, mohon diulangi!");
                }

                // Cek apakah resi sudah discan karung sebelumnya
                $detail_karung = DetailKarung::where('no_resi', $resi)->first();
                if ($detail_karung) {
                    // Jika sudah discan, beri pesan error
                    throw new \Exception("$resi sudah discan karung, mohon diulangi");
                    // throw new \Exception("$resi sudah discan karung di K". $detail_karung->karung->nama_karung ." ". $detail_karung->karung->kode_karung .", mohon diulangi");
                }

                // Cek apakah resi sudah discan masuk
                $tracking = Tracking::where('no_resi', $no_resi)
                                ->where('status_tracking', 'scan masuk gw')
                                ->first();
                if(!$tracking) {
                    throw new \Exception("$resi belum discan masuk ke gw, mohon untuk discan masuk terlebih dahulu!");
                }

                // Simpan data detail Karung
                $detailKarungData = [
                    'no_karung' => $no_karung,
                    'no_resi' => $resi
                ];
                DetailKarung::create($detailKarungData);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Scan berhasil');
    }

    public function editscankarung()
    {
        $param = [
            "title" => "Edit karung",
            "active" => "editkarung"
        ];

        return view('jalurdistribusi.editscankarung', $param);
    }

    public function hapusscankarung($no_karung) 
    {
        DB::beginTransaction();
        try{
            Karung::where('no_karung', $no_karung)->delete();
            DetailKarung::where('no_karung', $no_karung)->delete();
            DB::commit();
        }catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }
        return back()->with("success", "Karung $no_karung berhasil di hapus");
    }

    public function kirimpaketmuatan()
    {
        // $listkarung = Karung::where('id_outlet_asal', Auth::user()->id_outlet)
        //                     ->where(function ($q) {
        //                         $q->whereDate('created_at', Carbon::today())->orWhereDate('updated_at', Carbon::today());
        //                     })->get();

        $listkarung = Karung::where('id_outlet_asal', Auth::user()->id_outlet)
                            ->whereIn('status_tracking', ['scan masuk karung', 'scan karung sampai'])
                            ->whereDate('created_at', Carbon::today())->get();
        $param = [
            'title' => 'Kirim paket muatan',
            'active' => 'kirimpaketmuatan',
            'listkarung' => $listkarung
        ];

        return view('jalurdistribusi.kirimpaketmuatan', $param);
    }

    public function savekirimpaketmuatan(Request $request) 
    {
        // dd($request);

        // Ambil data karung
        $no_karung = $request->input('no_karung', []);
        $no_smu = $request->input('no_smu');
        
        // Ambil data tracking
        $id_outlet_asal = Auth::user()->id_outlet;
        $id_outlet_tujuan = $request->input('tujuan');
        $nama_kurir = $request->input('nama_kurir');
        $armada = $request->input('armada');
        $plat_armada = $request->input('plat_armada');
        $pemindai = Auth::user()->nama;
        
        // Jika outlet tujuan tidak tersedia
        $kode_agen = NULL;
        $outlet = Outlet::find($id_outlet_tujuan);
        if($outlet) {
            $kode_agen = $outlet->kode_agen;
        } else {
            $kode_agen = $id_outlet_tujuan;
        }

        // Validasi input
        $request->validate(
            [
                'no_karung.*' => 'required|min:12|max:12',
                'tujuan' => 'required'
            ],
            [
                'no_karung.*.required' => 'Nomor karung tidak boleh kosong!',
                'no_karung.*.min' => 'Format nomor karung salah, mohon diulangi!',
                'no_karung.*.max' => 'Format nomor karung salah, mohon diulangi!'
            ]
        );

        if (empty($no_karung)) {
            return back()->withErrors(['message' => 'Maaf tidak ada nomor karung yang dicentang, mohon dicentang minimal satu nomor karung.']);
        }

        DB::beginTransaction();
        try {
            foreach($no_karung as $karung) {
                
                // Cek apakah karung sudah dikirim
                // $karung2 = Karung::where('no_karung', $karung)
                //                 ->where('status_tracking', 'scan masuk karung')
                //                 ->where('status', 'dikirim')
                //                 ->first();
                // if ($karung2) {
                //     throw new \Exception("$karung status sudah dikirim!");
                // }

                // Simpan data karung baru
                $karung3 = Karung::where('no_karung', $karung)
                                ->where('status_tracking', 'scan masuk karung')
                                ->first();
                $karungData = [
                    'no_karung' => $karung3->no_karung,
                    'no_smu' => $no_smu,
                    'nama_karung' => $karung3->nama_karung,
                    'id_outlet_asal' => $id_outlet_asal,
                    'id_outlet_tujuan' => $id_outlet_tujuan,
                    'kode_karung' => $karung3->kode_karung,
                    'total_kilo' => $karung3->total_kilo,
                    'status_tracking' => 'scan kirim karung',
                    'pemindai' => $pemindai,
                    'status' => 'belum diterima'
                ];
                Karung::create($karungData);

                // Update data Karung
                Karung::where('no_karung', $karung)
                        ->whereIn('status_tracking', ['scan masuk karung', 'scan karung sampai'])
                        ->update([
                            "status" => "dikirim"
                        ]);

                // Ambil no resi dari detail karung
                $listDetailKarung = DetailKarung::where('no_karung', $karung)->get();
                foreach($listDetailKarung as $detailKarung) {

                    // Cek apakah nomor resi sesuai dengan data SubManifest
                    $sub_manifest = SubManifest::where('sub_resi', $detailKarung->no_resi)->first();
                    if(!$sub_manifest) {
                        throw new \Exception("$detailKarung->no_resi tidak valid, mohon diulangi!");
                    }

                    // Simpan data tracking baru
                    $trackingData = [
                        'id_manifest' => $sub_manifest->id_manifest,
                        'no_resi' => $detailKarung->no_resi,
                        'id_outlet_asal' => $id_outlet_asal,
                        'id_outlet_tujuan' => $id_outlet_tujuan,
                        'keterangan' => "Paket telah dikirim ke - " . $kode_agen,
                        'status_tracking' => "kirim paket muatan",
                        'nama_kurir' => $nama_kurir,
                        'armada' => $armada,
                        'plat_armada' => $plat_armada,
                        'pemindai' => $pemindai,
                        'status' => "belum diterima"
                    ];
                    Tracking::create($trackingData);

                    // Update data tracking scan masuk outlet
                    Tracking::where('no_resi', $detailKarung->no_resi)
                            ->whereIn('status_tracking', ["scan masuk ". Auth::user()->outlet->tipe ."", "bongkar paket sampai"])
                            ->update(['status' => 'dikirim']);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        } 

        return back()->with("success", "Scan berhasil");
    }

    public function filterkirimpaketmuatan(Request $request) 
    {
        $tanggal = $request->input('tanggal');
        $no_karung = $request->input('no_karung');
        $status = $request->input('status');
        $status_tracking = $request->input('status_tracking');

        $query = Karung::query()
                        ->where('id_outlet_asal', Auth::user()->id_outlet)
                        ->whereIn('status_tracking', ['scan masuk karung', 'scan karung sampai']);

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal')) {
            // $query->where(function ($q) use ($tanggal) {
            //     $q->whereDate('created_at', $tanggal)->orWhereDate('updated_at', $tanggal);
            // });
            $query->whereDate('created_at', $tanggal);
        }

        // Filter berdasarkan nomor karung
        if($request->input('no_karung')) {
            $query->where('no_karung', $no_karung);
        }

        // Filter berdasarkan status
        if($request->input('status')) {
            $query->where('status', $status);
        }

        // Filter berdasarkan status tracking
        if($request->input('status_tracking')) {
            $query->where('status_tracking', $status_tracking);
        }

        $listkarung = $query->get();

        $param = [
            'listkarung' => $listkarung
        ];

        return view('jalurdistribusi.filterkirimpaketmuatan', $param)->render();
    }

    public function searchtujuankirimpaketmuatan(Request $request)
    {
        $search = $request->input('q');

        $outlets = Outlet::where('kode_agen', 'like', "%$search%")
                        ->get();
        $kota = Kota::where('nama_kota', 'like', "%$search%")
                    ->orWhere('kode_kota', 'like', "%$search%")
                    ->get();
    
        return response()->json([
            'outlets' => $outlets,
            'kota' => $kota,
        ]);
    }

    public function bongkarpaketsampai()
    {
        $param = [
            'title' => 'Bongkar paket sampai',
            'active' => 'bongkarpaketsampai'
        ];

        return view('jalurdistribusi.bongkarpaketsampai', $param);
    }
    
    public function savebongkarpaketsampai(Request $request)
    {
        // Ambil data karung
        $no_karung = $request->input('no_karung', []);
        $no_smu = NULL;

        // Ambil data tracking
        $no_resi = [];
        $id_outlet_asal = Auth::user()->id_outlet;
        $id_outlet_tujuan = NULL;
        $nama_kurir = NULL;
        $armada = NULL;
        $plat_armada = NULL;
        $pemindai = Auth::user()->nama;


        // Validasi input
        $request->validate(
            [
                'no_karung.*' => 'required|min:12|max:12',
            ],
            [
                'no_karung.*.required' => 'Nomor karung tidak boleh kosong!',
                'no_karung.*.min' => 'Format nomor karung salah, mohon diulangi!',
                'no_karung.*.max' => 'Format nomor karung salah, mohon diulangi!'
            ]
        );

        DB::beginTransaction();
        try{
            foreach ($no_karung as $karung) {

                // Cek apakah karung sudah di scan kirim paket muatan
                $karung2 = Karung::where('no_karung', $karung)
                                 ->where('status_tracking', 'scan kirim karung')
                                 ->where('status', 'belum diterima')
                                 ->first();
                if(!$karung2){
                    throw new \Exception("$karung belum di scan kirim karung oleh outlet asal, Mohon diulangi!");
                }

                // Simpan data karung baru
                $karung3 = Karung::where('no_karung', $karung)
                                ->where('status_tracking', 'scan kirim karung')
                                ->first();
                $karungData = [
                    'no_karung' => $karung3->no_karung,
                    'no_smu' => $karung3->no_smu,
                    'nama_karung' => $karung3->nama_karung,
                    'id_outlet_asal' => $id_outlet_asal,
                    'id_outlet_tujuan' => $id_outlet_tujuan,
                    'kode_karung' => $karung3->kode_karung,
                    'total_kilo' => $karung3->total_kilo,
                    'status_tracking' => 'scan karung sampai',
                    'pemindai' => $pemindai,
                    'status' => 'belum dikirim'
                ];
                Karung::create($karungData);

                // Update data Karung
                Karung::where('no_karung', $karung)
                        ->where('status_tracking', 'scan kirim karung')
                        ->update([
                            "no_smu" => $no_smu,
                            "status" => "diterima"
                        ]);
                
                // Ambil no resi dari detail karung
                $listDetailKarung = DetailKarung::where('no_karung', $karung)->get();
                foreach($listDetailKarung as $detailKarung) {
                    $no_resi[] = $detailKarung->no_resi;

                    // Cek apakah nomor resi sesuai dengan data SubManifest
                    $sub_manifest = SubManifest::where('sub_resi', $detailKarung->no_resi)->first();
                    if(!$sub_manifest) {
                        throw new \Exception("$detailKarung->no_resi tidak valid, mohon diulangi!");
                    }

                    // Simpan data tracking baru
                    $trackingData = [
                        'id_manifest' => $sub_manifest->id_manifest,
                        'no_resi' => $detailKarung->no_resi,
                        'id_outlet_asal' => $id_outlet_asal,
                        'id_outlet_tujuan' => $id_outlet_tujuan,
                        'keterangan' => "Paket telah masuk di - " . Auth::user()->outlet->kode_agen,
                        'status_tracking' => "bongkar paket sampai",
                        'nama_kurir' => $nama_kurir,
                        'armada' => $armada,
                        'plat_armada' => $plat_armada,
                        'pemindai' => $pemindai,
                        'status' => "belum dikirim"
                    ];
                    Tracking::create($trackingData);

                    // Update data tracking scan masuk outlet
                    Tracking::where('no_resi', $detailKarung->no_resi)
                            ->where('status_tracking', "kirim paket muatan")
                            ->update(['status' => 'diterima']);
                }        
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        } 

        return back()->with("success", "Scan berhasil");
    }

    public function scanpaketsampai()
    {
        $param = [
            'title' => "Scan paket sampai",
            'active' => "scanpaketsampai"
        ];

        return view('jalurdistribusi.scanpaketsampai', $param);
    }

    public function savescanpaketsampai(Request $request)
    {
        // dd($request);

        // Ambil data
        $no_resi = $request->input('no_resi', []);
        $id_outlet_asal = Auth::user()->id_outlet;
        $keterangan = "Paket telah sampai di - " . Auth::user()->outlet->kode_agen;
        $status_tracking = "scan sampai";
        $pemindai = Auth::user()->nama;

        // Validasi input
        $request->validate(
            ['no_resi.*' => 'required|min:12|max:15'],
            [
                'no_resi.*.required' => 'Nomor resi tidak boleh kosong!',
                'no_resi.*.min' => 'Format resi salah, mohon diulangi!',
                'no_resi.*.max' => 'Format resi salah, mohon diulangi!'
            ]
        );

        DB::beginTransaction();
        try{
            foreach($no_resi as $resi) {
                // Cek apakah nomor resi sesuai dengan data SubManifest
                $sub_manifest = SubManifest::where('sub_resi', $resi)->first();
                if (!$sub_manifest) {
                    throw new \Exception("$resi tidak valid, mohon diulangi!");
                }

                // Cek apakah resi sudah discan sampai sebelumnya
                $tracking = Tracking::where('no_resi', $resi)
                                    ->where('status_tracking', $status_tracking)
                                    ->first();
                if ($tracking) {
                    // Jika sudah discan, beri pesan error
                    throw new \Exception("$resi sudah discan $status_tracking, mohon diulangi");
                }

                // Cek apakah resi sudah di scan kirim oleh outlet asal
                $tracking2 = Tracking::where('no_resi', $resi)
                                        ->where('id_outlet_tujuan', Auth::user()->id_outlet)
                                        ->where('status_tracking', 'kirim paket muatan')
                                        ->first();
                if(!$tracking2) {
                    throw new \Exception("$resi belum discan kirim oleh outlet asal atau outlet tujuan tidak sesuai, mohon untuk diulangi!");
                }

                // Simpan data tracking baru
                $trackingData = [
                    'id_manifest' => $sub_manifest->id_manifest,
                    'no_resi' => $resi,
                    'id_outlet_asal' => $id_outlet_asal,
                    'keterangan' => $keterangan,
                    'status_tracking' => $status_tracking,
                    'pemindai' => $pemindai,
                    'status' => "belum dikirim"
                ];
                Tracking::create($trackingData);

                // Update data tracking scan kirim
                Tracking::where('no_resi', $resi)
                        ->where('status_tracking', 'kirim paket muatan')
                        ->update(['status' => 'diterima']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Scan berhasil');
    }

    public function scankeluar()
    {
        $param = [
            'title' => 'Scan delivery',
            'active' => 'scandelivery'
        ];

        return view('jalurdistribusi.scankeluar', $param);
    }

    public function savescankeluar(Request $request)
    {
        // dd($request);

        // Ambil data
        $no_resi = $request->input('no_resi', []);
        $id_outlet_asal = Auth::user()->id_outlet;
        $keterangan = "Paket telah proses delivery ke tempat tujuan";
        $status_tracking = "scan keluar";
        $pemindai = Auth::user()->nama;

        // Validasi input
        $request->validate(
            ['no_resi.*' => 'required|min:12|max:15'],
            [
                'no_resi.*.required' => 'Nomor resi tidak boleh kosong!',
                'no_resi.*.min' => 'Format resi salah, mohon diulangi!',
                'no_resi.*.max' => 'Format resi salah, mohon diulangi!'
            ]
        );

        DB::beginTransaction();
        try{
            foreach($no_resi as $resi) {
                // Cek apakah nomor resi sesuai dengan data SubManifest
                $sub_manifest = SubManifest::where('sub_resi', $resi)->first();
                if (!$sub_manifest) {
                    throw new \Exception("$resi tidak valid, mohon diulangi!");
                }

                // Cek apakah resi sudah discan keluar sebelumnya
                $tracking = Tracking::where('no_resi', $resi)
                                    ->where('status_tracking', $status_tracking)
                                    ->first();
                if ($tracking) {
                    // Jika sudah discan, beri pesan error
                    throw new \Exception("$resi sudah discan $status_tracking, mohon diulangi");
                }

                // Cek apakah resi sudah di scan sampai
                $tracking2 = Tracking::where('no_resi', $resi)
                                        ->where('id_outlet_asal', Auth::user()->id_outlet)
                                        ->where('status_tracking', 'scan sampai')
                                        ->first();
                if(!$tracking2) {
                    throw new \Exception("$resi belum discan sampai, mohon untuk diulangi!");
                }

                // Simpan data tracking baru
                $trackingData = [
                    'id_manifest' => $sub_manifest->id_manifest,
                    'no_resi' => $resi,
                    'id_outlet_asal' => $id_outlet_asal,
                    'keterangan' => $keterangan,
                    'status_tracking' => $status_tracking,
                    'pemindai' => $pemindai,
                    'status' => "belum diterima"
                ];
                Tracking::create($trackingData);

                // Update data tracking scan sampai
                Tracking::where('no_resi', $resi)
                        ->where('status_tracking', 'scan sampai')
                        ->update(['status' => 'dikirim']);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }

        return back()->with('success', 'Scan berhasil');
    }

    public function scanttd()
    {
        $param = [
            'title' => 'Scan tanda terima paket',
            'active' => 'scanttd'
        ];

        return view('jalurdistribusi.scanttd', $param);
    }

    public function savescanttd(Request $request)
    {
        // Validasi data
        $validatedData = $request->validate([
            'no_resi.*' => 'required|min:12|max:15',
            'keterangan' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        // Ambil data
        $no_resi = $request->input('no_resi', []);
        $validatedData['id_outlet_asal'] = Auth::user()->id_outlet;
        $validatedData['keterangan'] = "Paket telah diterima oleh " . $request->input('keterangan');
        $validatedData['status_tracking'] = "tanda terima";
        $validatedData['pemindai'] = Auth::user()->nama;
        $validatedData['gambar'] = $request->file('gambar')->store('uploads/gambar', 'public');

        DB::beginTransaction();
        try{
            foreach($no_resi as $resi) {
                // Cek apakah nomor resi sesuai dengan data SubManifest
                $sub_manifest = SubManifest::where('sub_resi', $resi)->first();
                if (!$sub_manifest) {
                    throw new \Exception("$resi tidak valid, mohon diulangi!");
                }

                // Cek apakah resi sudah discan tanda terima sebelumnya
                $tracking = Tracking::where('no_resi', $resi)
                                    ->where('status_tracking', 'tanda terima')
                                    ->first();
                if ($tracking) {
                    // Jika sudah discan, beri pesan error
                    throw new \Exception("$resi sudah discan tanda terima, mohon diulangi");
                }

                // Cek apakah resi sudah di scan keluar
                $tracking2 = Tracking::where('no_resi', $resi)
                                        ->where('id_outlet_asal', Auth::user()->id_outlet)
                                        ->where('status_tracking', 'scan keluar')
                                        ->first();
                if(!$tracking2) {
                    throw new \Exception("$resi belum discan keluar, mohon untuk diulangi!");
                }

                $validatedData['id_manifest'] = $sub_manifest->id_manifest;
                $validatedData['no_resi'] = $resi;
                Tracking::create($validatedData);

                // Update data tracking scan keluar
                Tracking::where('no_resi', $resi)
                        ->where('status_tracking', 'scan keluar')
                        ->update(['status' => 'diterima']);
            }
        DB::commit();
        }catch(\Exception $e) {
            DB::rollBack();
            Log::error('Error while saving data: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error: ' . $e->getMessage()]);
        }

        return back()->with("success", "Scan berhasil");
    }

    public function downloadkarungpdf(Request $request)
    {
        $tanggal = $request->input('tanggal');

        $listkarung = Karung::where('id_outlet_asal', Auth::user()->id_outlet)
                            ->where('status_tracking', 'scan masuk karung')
                            ->whereDate('created_at', $tanggal)
                            ->orderBy('kode_karung')
                            ->orderBy('nama_karung')
                            ->get();

        $param = [
            'title' => 'Download pdf karung',
            'listkarung' => $listkarung,
            'tanggal' => $tanggal
        ];

        $html = view('jalurdistribusi.downloadkarungpdf', $param)->render();
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('F4', 'potrait');
        $dompdf->render();
        ob_end_clean();
        return $dompdf->stream('document.pdf', ['Attachment' => false]);
    }

}
