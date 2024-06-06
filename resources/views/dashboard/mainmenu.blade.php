@extends('dashboard.layouts.main')

@section('container')

<div class="container" style="min-height: 80vh">
    {{-- Corousel --}}
    <div class="row mb-5">
        <div class="col-12 bg-primary">
            <div class="pt-5" id="resultTonaseHarian">
                <h1 class="text-center" style="color:yellow; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);"><b>1000 KG</b></h1>
                <h6 class="text-center text-light"><b>TONASE HARIAN SELURUH OUTLET KALIMANTAN BARAT</b></h6>
                <h6 class="text-center text-light mb-5"><b>PT. BORNEO CITRA EXPRESS</b></h6>
            </div>
            <div class="row justify-content-end mb-5">
                {{-- <input type="hidden" class="form-control form-control-sm" name="datefilter" id="date_filter" autocomplete="off"> --}}
                <div class="col-sm-2">
                    <select class="form-control form-control-sm js-example-basic-single" name="id_outlet">
                        <option value="SEMUA OUTLET" selected>SEMUA OUTLET</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Menu --}}
    <div class="row">
        <div class="col-7">
            <div class="row justify-content-around">
                <div class="col-md-4 mb-3">
                    <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('operasional') }}">
                        <div class="card-body text-light">
                            <img class="mb-3" src="{{ asset('img/img.svg') }}" style="width: 50px">
                            <p style="font-size: 12px">OPERASIONAL</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a class="card text-center bg-primary shadow main-menu m-auto" href="">
                        <div class="card-body text-light">
                            <img class="mb-3" src="{{ asset('img/img2.svg') }}" style="width: 34px">
                            <p style="font-size: 12px">ARSIP MANIFEST</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a class="card text-center bg-primary shadow main-menu m-auto" href="jalurDistribusi/menuJalurDistribusi.php">
                        <div class="card-body text-light">
                            <img class="mb-3" src="{{ asset('img/img3.svg') }}" style="width: 50px">
                            <p style="font-size: 12px">JALUR DISTRIBUSI</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a class="card text-center bg-primary shadow main-menu m-auto" href="">
                        <div class="card-body text-light">
                            <img class="mb-3" src="{{ asset('img/img4.svg') }}" style="width: 50px">
                            <p style="font-size: 12px">LAPORAN KEUANGAN</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a class="card text-center bg-primary shadow main-menu m-auto" href="">
                        <div class="card-body text-light">
                            <img class="mb-3" src="{{ asset('img/img5.svg') }}" style="width: 36px">
                            <p style="font-size: 12px">LAPORAN PENGIRIMAN</p>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 mb-3">
                    <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('integrasisystem') }}">
                        <div class="card-body text-light">
                            <img class="mb-3" src="{{ asset('img/img6.svg') }}" style="width: 52px">
                            <p style="font-size: 12px">INTEGRASI SYSTEM</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
        <div class="col" style="max-height: 284px; overflow: auto">
            <p>Pengumuman</p>
            <div class="card">
                <ul class="list-group">
                    <li class="list-group-item py-1 px-2">
                        <a href="#">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Berita acara</p>
                                <small>8 minutes ago</small>
                            </div>
                            <small>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit ...</small>
                        </a>
                    </li>
                    <li class="list-group-item py-1 px-2">
                        <a href="#">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Reward agen terbaik</p>
                                <small>2 days ago</small>
                            </div>
                            <small>Lorem ipsum, dolor sit amet consectetur adipisicing elit ...</small>
                        </a>
                    </li>
                    <li class="list-group-item py-1 px-2">
                        <a href="#">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Sop Pengiriman</p>
                                <small>1 years ago</small>
                            </div>
                            <small>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ratione? ...</small>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection