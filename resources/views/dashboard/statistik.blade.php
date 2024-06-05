@extends('dashboard.layouts.main')

@section('container')
<div class="container p-0" style="min-width: 1136px;">
    <div class="alert alert-primary p-0">
        <div class="d-flex">
            <img class="rounded mr-5" src="{{ asset('img/hero-statistik.png') }}" style="width: 700px">
            <div class="py-1">
                <p class="mb-2"><i class="fa-solid fa-face-smile fa-lg"></i> <b>Hallo, Selamat Datang {{ Auth::user()->nama }}</b></p>
                <div>
                    <div class="alert alert-light p-1 mb-2"><small><i class="fa-solid fa-credit-card text-primary"></i> Nominal di Sistem : Rp. 1.500.000</small></div>
                    <div class="alert alert-light p-1 mb-2"><small><i class="fa-solid fa-sack-xmark text-warning"></i> Nominal di Bekukan : Rp. 1.000.000</small></div>
                    <div class="alert alert-light p-1"><small><i class="fa-solid fa-hourglass-half text-danger"></i> Hitung Mundur Ditutup Sistem : --,Min</small></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection