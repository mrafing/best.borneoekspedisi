@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('jalurdistribusi.partials.sidebar')

{{-- Content wrapper --}}
<div id="content-wrapper" class="d-flex flex-column bg-white">
    {{-- Main content --}}
    <div id="content">
        {{-- Top bar --}}
        @include('partials.topbar')

        {{-- Page content --}}
        <div class="container-fluid p-2 p-lg-4 bg-white">
            <div class="watermark row justify-content-around">
                @for ($i=0; $i<500; $i++)
                    <div>
                        <p style="margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->nama) }} - {{ strtoupper(Auth::user()->outlet->kode_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                        <p style="margin-left: 200px; margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->nama) }} - {{ strtoupper(Auth::user()->outlet->kode_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                    </div>
                @endfor
            </div>
            {{-- CONTENT --}}
            <p>Operasi Outlet</p>
            <hr>
            <div class="row mb-5">
                <div class="col-2">
                    <a class="d-flex flex-column align-items-center text-center">
                        <div>
                            <i class="fa-solid fa-house fa-lg"></i>
                        </div>
                        <p>Scan Masuk Outlet</p>
                    </a>
                </div>
                <div class="col-2">
                    <a class="d-flex flex-column align-items-center text-center">
                        <div>
                            <i class="fa-solid fa-truck fa-lg"></i>
                        </div>
                        <p>Scan Kirim</p>
                    </a>
                </div>
                <div class="col-2">
                    <a class="d-flex flex-column align-items-center text-center">
                        <div>
                            <i class="fa-solid fa-warehouse fa-lg"></i>
                        </div>
                        <p>Scan Paket Sampai</p>
                    </a>
                </div>
                <div class="col-2">
                    <a class="d-flex flex-column align-items-center text-center">
                        <div>
                            <i class="fa-solid fa-right-from-bracket fa-lg"></i>
                        </div>
                        <p>Scan Keluar Outlet</p>
                    </a>
                </div>
            </div>

            <p>Operasi Gateway</p>
            <hr>
            <div class="row mb-5">
                <div class="col-2">
                    <a class="d-flex flex-column align-items-center text-center">
                        <div>
                            <i class="fa-solid fa-truck-ramp-box fa-lg"></i>
                        </div>
                        <p>Bongkar Paket Sampai</p>
                    </a>
                </div>
                <div class="col-2">
                    <a class="d-flex flex-column align-items-center text-center">
                        <div>
                            <i class="fa-solid fa-truck-plane fa-lg"></i>
                        </div>
                        <p>Kirim Paket Muatan</p>
                    </a>
                </div>
            </div>

            <p>Operasi Tidak Normal</p>
            <hr>
            <div class="row">
                <div class="col-2">
                    <a class="d-flex flex-column align-items-center text-center">
                        <div>
                            <i class="fa-solid fa-circle-exclamation fa-lg"></i>
                        </div>
                        <p>Scan Paket Bermasalah</p>
                    </a>
                </div>
            </div>
            {{-- END CONTENT --}}
        </div>
    </div>

    {{-- Footer --}}
    <footer class="sticky-footer bg-white border-top">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; PT. Borneo Citra Express 2020 - {{ date('Y') }}</span>
            </div>
        </div>
    </footer>
</div>
@endsection