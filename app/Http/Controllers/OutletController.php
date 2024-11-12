<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;

class OutletController extends Controller
{
    public function searchoutlet(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->input('q');

        // Cari kecamatan berdasarkan kata kunci pada nama_kecamatan atau nama_kota
        $outlets = Outlet::where('kode_agen', 'like', '%' . $search . '%')
                           ->get();

        // Format hasil untuk Select2
        $formattedResults = $outlets->map(function($outlet) {
            return [
                'id' => $outlet->id,
                'text' => $outlet->kode_agen
            ];
        });

        return response()->json(['results' => $formattedResults]);
    }
}
