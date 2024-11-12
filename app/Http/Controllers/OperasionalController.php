<?php

namespace App\Http\Controllers;

use App\Models\HargaOngkir, App\Models\Kecamatan;
use Illuminate\Http\Request;

class OperasionalController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Operasional',
            'active' => 'operasional'
        ];
        return view('operasional.index', $param);
    }

    public function cekongkir()
    {
        $param = [
            'title' => 'Cek ongkir',
            'active' => 'cekongkir',
            'listkecamatan' => Kecamatan::all()
        ];

        return view('operasional.cekongkir.index', $param);
    }

    public function resultcekongkir(Request $request)
    {
        $kecamatan_asal = Kecamatan::find($request->input('id_kecamatan_asal'));
        $id_kota_asal = $kecamatan_asal->id_kota;
        $id_kecamatan_tujuan = $request->input('id_kecamatan_tujuan');
        $kg = $request->input('kg');

        $listongkir = HargaOngkir::where('id_kota_asal', $id_kota_asal)
                                    ->where('id_kecamatan_tujuan', $id_kecamatan_tujuan)
                                    ->get();

        $param = [
            'listongkir' => $listongkir,
            'kg' => $kg
        ];

        return view('operasional.cekongkir.resultcekongkir', $param)->render();
    }
}
