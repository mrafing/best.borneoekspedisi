<?php

namespace App\Http\Controllers;

class IntegrasisystemController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Integrasi system',
        ];
        return view('integrasisystem.index', $param);
    }
}
