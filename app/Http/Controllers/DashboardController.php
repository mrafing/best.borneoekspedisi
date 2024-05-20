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

    public function mainmenu () {
        $param = [
            'title' => 'Main Menu',
            'active' => 'mainmenu'
        ];

        return view('dashboard.mainmenu', $param);
    }
}
