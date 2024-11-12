<?php

namespace App\Http\Controllers;

use App\Models\Manifest, App\Models\Outlet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate, Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {   
        $param = [
            'title' => 'Selamat datang',
            'active' => 'selamatdatang'
        ];

        return view('dashboard.index', $param);
    }

    public function mainmenu()
    {
        // Jika role user gudang atau kurir
        if (Gate::allows('gudang') || Gate::allows('kurir')) {
            return view('jalurdistribusi.index', [
                'title' => 'Jalur distribusi',
                'active' => 'jalurdistribusi'
            ]);
        }

        $pesantonase = "TONASE HARIAN SELURUH OUTLET KALIMANTAN BARAT";
        $query = manifest::query();
        
        // Jika role master atau admin
        if (Gate::allows('master') || Gate::allows('admin')) {
            $query->where('id_outlet_terima', Auth::user()->id_outlet);
            $pesantonase = "TONASE HARIAN OUTLET " . Auth::user()->outlet->kode_agen;
        }

        $manifest = $query->whereDate('created_at', Carbon::today())->get();

        // Get tonase harian
        $tonaseharian = 0;
        foreach ($manifest as $data) {
            $tonaseharian += $data->barang->berat_aktual;
        }

        $param = [
            'title' => 'Main menu',
            'active' => 'mainmenu',
            'tonaseharian' => $tonaseharian,
            'pesantonase' => $pesantonase
        ];

        return view('dashboard.mainmenu', $param);
    }

    public function resulttonaseharian(Request $request)
    {
        $outlet = Outlet::find($request->id_outlet);

        $pesantonase = "TONASE HARIAN OUTLET " . $outlet->kode_agen;
        $manifest = manifest::where('id_outlet_terima', $outlet->id)
                              ->whereDate('created_at', Carbon::today())
                              ->get();

        // Get tonase
        $tonaseharian = 0;
        foreach ($manifest as $data) {
            $tonaseharian += $data->barang->berat_aktual;
        }

        $param = [
            'tonaseharian' => $tonaseharian,
            'pesantonase' => $pesantonase
        ];
        return view('dashboard.resulttonaseharian', $param);
    }

    public function statistik() 
    {
        $param = [
            'title' => 'Statistik',
            'active' => 'statistik'
        ];

        return view('dashboard.statistik', $param);
    }
}
