<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kecamatan;

class KecamatanController extends Controller
{
    public function searchkecamatan(Request $request)
    {
        // Ambil query pencarian dari request
        $search = $request->input('q');

        // Cari kecamatan berdasarkan kata kunci pada nama_kecamatan atau nama_kota
        $kecamatans = Kecamatan::where('nama_kecamatan', 'like', '%' . $search . '%')
            ->orWhereHas('kota', function($query) use ($search) {
                $query->where('nama_kota', 'like', '%' . $search . '%');
            })
            // ->with('kota') // Sertakan relasi kota untuk ditampilkan dalam hasil
            ->get();

        // Format hasil untuk Select2
        $formattedResults = $kecamatans->map(function($kecamatan) {
            return [
                'id' => $kecamatan->id,
                'text' => strtoupper(optional($kecamatan->kota)->provinsi->nama_provinsi) .'/'. strtoupper(optional($kecamatan->kota)->nama_kota) . '/' . strtoupper($kecamatan->nama_kecamatan)
            ];
        });

        return response()->json(['results' => $formattedResults]);
    }
}
