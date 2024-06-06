<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OperasionalController extends Controller
{
    public function index ()
    {
        $param = [
            'title' => 'Operasional',
        ];
        return view('operasional.index', $param);
    }
}
