<?php

namespace App\Http\Controllers;

use App\Models\ItemKhusus;
use App\Http\Requests\StoreItemKhususRequest;
use App\Http\Requests\UpdateItemKhususRequest;

class ItemKhususController extends Controller
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
     * @param  \App\Http\Requests\StoreItemKhususRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreItemKhususRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ItemKhusus  $itemKhusus
     * @return \Illuminate\Http\Response
     */
    public function show(ItemKhusus $itemKhusus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ItemKhusus  $itemKhusus
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemKhusus $itemKhusus)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateItemKhususRequest  $request
     * @param  \App\Models\ItemKhusus  $itemKhusus
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateItemKhususRequest $request, ItemKhusus $itemKhusus)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ItemKhusus  $itemKhusus
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemKhusus $itemKhusus)
    {
        //
    }
}
