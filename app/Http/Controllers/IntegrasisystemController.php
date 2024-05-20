<?php

namespace App\Http\Controllers;

use App\Models\Mitra;
use Illuminate\Http\Request;

class IntegrasisystemController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Integrasi System',
        ];
        return view('integrasisystem.index', $param);
    }
}
