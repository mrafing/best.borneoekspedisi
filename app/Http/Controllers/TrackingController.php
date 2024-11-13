<?php

namespace App\Http\Controllers;

use App\Models\SubManifest, App\Models\Tracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function lacakpaket(Request $request)
    {
        $no_resi = $request->input('no_resi');
        $submanifest = SubManifest::where('sub_resi', $no_resi)->first();
        $tracking = Tracking::where('no_resi', $no_resi)->latest()->get();

        $param = [
            'title' => 'Lacak paket',
            'active' => 'lacakpaket',
            'submanifest' => $submanifest,
            'tracking' => $tracking
        ];

        return view('tracking.lacakpaket', $param);
    }
}
