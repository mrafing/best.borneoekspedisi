<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index () {
        $param = [
            'title' => 'Selamat Datang',
            'active' => 'selamatdatang'
        ];

        return view('dashboard.index', $param);
    }

    public function ruangkerja () {
        $param = [
            'title' => 'Ruang Kerja',
            'active' => 'ruangkerja'
        ];

        return view('dashboard.ruangkerja', $param);
    }
}
