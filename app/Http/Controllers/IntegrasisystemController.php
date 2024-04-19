<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IntegrasisystemController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Integrasi System',
            'active' => 'integrasisystem'
        ];

        return view('integrasisystem.index', $param);
    }

    public function mitra ()
    {
        $param = [
            'title' => 'Mitra',
            'active' => 'mitra'
        ];

        return view('integrasisystem.mitra.mitra', $param);
    }

    public function tambahmitra ()
    {
        $param = [
            'title' => 'Tambah Mitra',
            'active' => 'tambahmitra'
        ];

        return view('integrasisystem.mitra.tambahmitra', $param);
    }

    public function store(Request $request) {
        dd($request);
    }

    public function resulttipe(Request $request)
    {
        $tipe = $request->input('tipe');

        return view('integrasisystem.mitra.resulttipe', ['result' => $tipe])->render();
    }
}
