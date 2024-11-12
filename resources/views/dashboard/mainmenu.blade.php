@extends('dashboard.layouts.main')

@section('container')

<div class="container" style="min-height: 80vh">
    {{-- Corousel --}}
    <div class="row mb-5">
        <div class="col-12 bg-primary">
            <div class="pt-5" id="resulttonaseharian">
                <h1 class="text-center" style="color:yellow; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);"><b>{{ $tonaseharian }} KG</b></h1>
                <h6 class="text-center text-light"><b>{{ $pesantonase }}</b></h6>
                <h6 class="text-center text-light mb-5"><b>PT. BORNEO CITRA EXPRESS</b></h6>
            </div>
            <div class="row justify-content-end mb-5">
                @if (Auth::user()->role == 'gm')
                    <div class="col-sm-2">
                        <select class="form-control form-control-sm" name="id_outlet" id="searchoutlet"></select>
                    </div>
                @else
                    <div class="col-sm-2">
                        <select class="form-control form-control-sm" name="id_outlet">
                            <option value="{{ Auth::user()->id_outlet }}">{{ Auth::user()->outlet->kode_agen }}</option>
                        </select>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Main Menu --}}
    <div class="row">
        <div class="col-7">
            <div class="row justify-content-around">
                @if (Auth::user()->outlet->tipe == 'gw')
                    <div class="col-md-4 mb-3">
                        <div class="card text-center bg-secondary shadow m-auto">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img.svg') }}" style="width: 50px">
                                <p style="font-size: 12px">OPERASIONAL</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('arsipmanifest') }}">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img2.svg') }}" style="width: 34px">
                                <p style="font-size: 12px">ARSIP MANIFEST</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('jalurdistribusi') }}">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img3.svg') }}" style="width: 50px">
                                <p style="font-size: 12px">JALUR DISTRIBUSI</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center bg-secondary shadow m-auto">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img4.svg') }}" style="width: 50px">
                                <p style="font-size: 12px">LAPORAN KEUANGAN</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center bg-secondary shadow m-auto">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img5.svg') }}" style="width: 36px">
                                <p style="font-size: 12px">LAPORAN PENGIRIMAN</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('integrasisystem') }}">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img6.svg') }}" style="width: 52px">
                                <p style="font-size: 12px">INTEGRASI SYSTEM</p>
                            </div>
                        </a>
                    </div>
                @elseif (Auth::user()->outlet->tipe == 'mitra a' || Auth::user()->outlet->tipe == 'mitra b')
                    <div class="col-md-4 mb-3">
                        <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('operasional') }}">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img.svg') }}" style="width: 50px">
                                <p style="font-size: 12px">OPERASIONAL</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('arsipmanifest') }}">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img2.svg') }}" style="width: 34px">
                                <p style="font-size: 12px">ARSIP MANIFEST</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('jalurdistribusi') }}">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img3.svg') }}" style="width: 50px">
                                <p style="font-size: 12px">JALUR DISTRIBUSI</p>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center bg-secondary shadow m-auto" href="">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img4.svg') }}" style="width: 50px">
                                <p style="font-size: 12px">LAPORAN KEUANGAN</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="card text-center bg-secondary shadow m-auto" href="">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img5.svg') }}" style="width: 36px">
                                <p style="font-size: 12px">LAPORAN PENGIRIMAN</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <a class="card text-center bg-primary shadow main-menu m-auto" href="{{ URL::to('integrasisystem') }}">
                            <div class="card-body text-light">
                                <img class="mb-3" src="{{ asset('img/img6.svg') }}" style="width: 52px">
                                <p style="font-size: 12px">INTEGRASI SYSTEM</p>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>
        <div class="col" style="max-height: 284px; overflow: auto">
            <p>Pengumuman</p>
            <div class="card">
                <ul class="list-group">
                    <li class="list-group-item py-1 px-2">
                        <a>
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Belum ada postingan</p>
                                <small>~,</small>
                            </div>
                            <small>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Fugit ...</small>
                        </a>
                    </li>
                    {{-- <li class="list-group-item py-1 px-2">
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
                    </li> --}}
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            // Search outlet Select 2 //
            $('#searchoutlet').select2({
                placeholder: '-Pilih-',
                ajax: {
                    url : '{{ route("searchoutlet") }}',
                    dataType: 'json',
                    delay: 250, // Delay sebelum pencarian dimulai
                    data: function (params) {
                        return {
                            q: params.term // Kata kunci yang diketik
                        };
                    },
                    processResults: function (data){
                        return {
                            results: data.results.map(function(item) {
                                return {
                                    id: item.id,
                                    text: item.text
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 1, // Mulai pencarian setelah mengetik 1 karakter
            });

            // Get tonase harian select by outlet
            $('#searchoutlet').change(function () {
                var id_outlet = $('#searchoutlet').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route("resulttonaseharian") }}',
                    data: {
                        id_outlet: id_outlet,
                    },
                    success: function (response) {
                        $('#resulttonaseharian').html(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection