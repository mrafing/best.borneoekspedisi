@extends('dashboard.layouts.main')

@section('container')
<div class="container" style="min-height: 80vh">
    <div class="row justify-content-center mb-5">
        <div class="col-sm-8 mt-5">
            <div class="card bg-primary text-light text-center py-3">
                <p class="mb-0"><b style="color:yellow;">Selamat Beraktivitas</b>, Rafi ! </p>
                <p class="mb-0"><b style="color:yellow;">Jangan lupa berdoa</b>, Semoga usaha kita setiap hari semakin meningkat,</p>
                <p class="mb-0">dan apa yang kita dapat  bisa bermanfaat untuk orang banyak, Amin.</p>
            </div>
        </div>
    </div>
    <div class="row justify-content-center mb-5">
        <div class="col-auto">
            <div class="d-flex align-items-end">
                <img src="{{ asset('img/img7.png') }}" style="width: 500px;">
                <a href="{{ URL::to('dashboard/mainmenu') }}" class="btn btn-primary" style="width: 140px">
                    <small class="mb-0">MASUK KE RUANG KERJA</small>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection