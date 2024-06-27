<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class JalurDistribusiController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Jalur Distribusi',
            'active' => 'jalurdistribusi'
        ];
        return view('jalurdistribusi.index', $param);
    }
}
