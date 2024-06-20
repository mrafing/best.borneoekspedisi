<?php

namespace App\Http\Controllers;

use App\Models\Pengirim;
use App\Http\Requests\StorePengirimRequest;
use App\Http\Requests\UpdatePengirimRequest;

class PengirimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePengirimRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePengirimRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pengirim  $pengirim
     * @return \Illuminate\Http\Response
     */
    public function show(Pengirim $pengirim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pengirim  $pengirim
     * @return \Illuminate\Http\Response
     */
    public function edit(Pengirim $pengirim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePengirimRequest  $request
     * @param  \App\Models\Pengirim  $pengirim
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePengirimRequest $request, Pengirim $pengirim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pengirim  $pengirim
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pengirim $pengirim)
    {
        //
    }
}
