{{-- @dd($listmanifest) --}}
{{-- @dd($listlayanan) --}}
@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('operasional.partials.sidebar')

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
                <h6><i class="fa-solid fa-house"></i> / Operasional / <span class="text-primary">Cek ongkir</span></h6>
                <hr>
                <div class="row align-items-end mb-5" style="max-width: 1000px">
                    <div class="col-sm-7">
                        <label for="basic-url">Alamat Asal & Tujuan</label>
                        <div class="input-group">
                            <select class="form-control form-control-sm" id="id_kecamatan_asal"></select>
                            <select class="form-control form-control-sm" id="id_kecamatan_tujuan"></select>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <label for="basic-url">Berat Paket</label>
                        <div class="input-group input-group-sm">
                            <input type="number" class="form-control form-control-sm" id="kg">
                            <div class="input-group-append">
                              <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm">
                        <button type="submit" class="btn btn-primary btn-sm" id="cari">Cari <i class="fa-solid fa-magnifying-glass"></i></button>
                    </div>
                </div>
                <hr>
                <div id="resultcekongkir">
                    <div class="row justify-content-center mt-5">
                        <div class="col-auto text-center">
                            <img src="{{ asset('img/no_data.png') }}" alt="" width="200">
                            <p><small>Belum ada data cek ongkir yang di tampilkan</small></p>
                        </div>
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

@section('script')
<script>
    $(document).ready(function() {
        // Search kecamatan //
        $('#id_kecamatan_asal, #id_kecamatan_tujuan').select2({
            placeholder: '[pilih]',
            ajax: {
                url : '{{ route("searchkecamatan") }}',
                dataType: 'json',
                delay: 250, // Delay sebelum pencarian dimulai
                data: function (params) {
                    return {
                        q: params.term // Kata kunci yang diketik
                    };
                },
                processResults: function (data) {
                    // Proses hasil dari response dan tampilkan di select2
                    return {
                        results: data.results.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1, // Mulai pencarian setelah mengetik 1 karakter
        });
    });

    // GET FILTER //
        $('#cari').click(function () {
            let id_kecamatan_asal = $('#id_kecamatan_asal').val();
            let id_kecamatan_tujuan = $('#id_kecamatan_tujuan').val();
            let kg = $('#kg').val();
            $.ajax({
                type: 'GET',
                url: '{{ route("resultcekongkir") }}',
                data: {
                    id_kecamatan_asal : id_kecamatan_asal,
                    id_kecamatan_tujuan : id_kecamatan_tujuan,
                    kg : kg,
                },
                success: function (response) {
                    $('#resultcekongkir').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    // END //
</script>
@endsection