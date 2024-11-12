{{-- @dd($listmanifest) --}}
@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('arsipmanifest.partials.sidebar')

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
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div>
                        <p class="mb-2">Unduh Arsip Manifest</p>
                        <button class="btn btn-sm btn-danger" type="submit" id="pdf">PDF <i class="fa-solid fa-file-pdf"></i></button>
                        <button class="btn btn-sm btn-success" type="submit" id="excel">Excel <i class="fa-solid fa-table"></i></button>
                    </div>
                    <div class="ml-5">
                        <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                            Filter <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>
                </div>
                <div class="show collapse mb-3" id="collapseFilter">
                    <div class="card card-body">
                        <div class="row">
                            @if (Auth::user()->role == 'gm')
                                <div class="col-3 form-group">
                                    <label for="id_outlet_terima"><small>Outlet Terima</small></label>
                                    <select class="form-control form-control-sm" id="id_outlet_terima" name="id_outlet_terima">
                                        <option value="">-pilih-</option>
                                        @foreach ( $listoutlet as $data )
                                            <option value="{{ $data->id }}">{{ $data->kode_agen }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @else
                                <div class="col-3 form-group">
                                    <label for="id_outlet_terima"><small>Outlet Terima</small></label>
                                    <select class="form-control form-control-sm" id="id_outlet_terima" name="id_outlet_terima" readonly>
                                        <option value="{{ Auth::user()->id_outlet }}" selected>{{ Auth::user()->outlet->kode_agen }}</option>
                                    </select>
                                </div>
                            @endif
                            <div class="col-3 form-group">
                                <label for="id_layanan"><small>Layanan</small></label>
                                <select class="form-control form-control-sm" id="id_layanan" name="id_layanan">
                                    <option value="">-pilih-</option>
                                    @foreach ($listlayanan as $data )
                                        <option value="{{ $data->id }}">{{ $data->nama_layanan }} - {{ $data->nama_komoditi }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label for="id_kota_tujuan"><small>Kota/Kab Tujuan</small></label>
                                <select class="form-control form-control-sm" name="id_kota_tujuan" id="id_kota_tujuan">
                                    <option value="">-pilih-</option>
                                    @foreach ( $listkota as $data )
                                        <option value="{{ $data->id }}">{{ $data->nama_kota }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label for=""><small>Dari Tanggal</small></label>
                                <input type="text" class="form-control form-control-sm" id="dari_tanggal" name="dari_tanggal" value="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 form-group">
                                <label for=""><small>Sampai Tanggal</small></label>
                                <input type="text" class="form-control form-control-sm" id="sampai_tanggal" name="sampai_tanggal" value="">
                            </div>
                            <div class="col-3 form-group">
                                <label for=""><small>Metode Pembayaran</small></label>
                                <select class="form-control form-control-sm" name="pembayaran" id="pembayaran">
                                    <option value="">-pilih-</option>
                                    <option value="CASH">Cash</option>
                                    <option value="TRANSFER">Transfer</option>
                                    <option value="TRANSFER (LUNAS)">Transfer (Lunas)</option>
                                    <option value="COD">COD</option>
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label for=""><small>Nomor/kode Resi</small></label>
                                <input class="form-control form-control-sm" name="no_resi" id="no_resi" placeholder="Cth: BE240611xxxxxx">
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-auto">
                                <button class="btn btn-secondary btn-sm" role="button" id="filter">Cek <i class="fa-solid fa-magnifying-glass fa-sm"></i></button>
                            </div>
                            <div class="col-auto">
                                <a data-toggle="collapse" href="#collapseFilter" aria-expanded="false"><small>Sembunyikan <i class="fa-solid fa-filter"></i></small></a>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="table-responsive border rounded py-2" id="filtermanifestdomestik">
                <table class="table table-bordered table-hover shadow" id="table">
                    <thead>
                        <tr class="bg-secondary text-light">
                            <th class="bg-secondary border shadow" style="position: sticky; left: 0; z-index: 2;">
                                <i class="fa-solid fa-gear"></i>
                            </th>
                            <th class="bg-secondary border shadow" style="position: sticky; left: 88px; z-index: 2; white-space: nowrap;"><small>Nomor Resi</small></th>
                            <th style="white-space: nowrap;"><small>Nama Pengirim</small></th>
                            <th style="white-space: nowrap;"><small>Nama Penerima</small></th>
                            <th style="white-space: nowrap;"><small>Tujuan</small></th>
                            <th style="white-space: nowrap;"><small>Koli</small></th>
                            <th style="white-space: nowrap;"><small>Berat Aktual</small></th>
                            <th style="white-space: nowrap;"><small>Berat Volumetrik</small></th>
                            <th style="white-space: nowrap;"><small>Isi Barang</small></th>
                            <th style="white-space: nowrap;"><small>Harga Transit</small></th>
                            <th style="white-space: nowrap;"><small>Harga Karantina</small></th>
                            <th style="white-space: nowrap;"><small>Harga Packing</small></th>
                            <th style="white-space: nowrap;"><small>Harga Ongkir</small></th>
                            <th style="white-space: nowrap;"><small>Total</small></th>
                            <th style="white-space: nowrap;"><small>Metode Pembayaran</small></th>
                            <th style="white-space: nowrap;"><small>Admin</small></th>
                            <th style="white-space: nowrap;"><small>Tanggal Terima</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listmanifest as $data)
                            <tr>
                                <td class="bg-white border shadow" style="position: sticky; left: 0; z-index: 2;">
                                    <div class="d-flex">
                                        <a href="{{ URL::to("arsipmanifest/manifestdomestik/detail/$data->id") }}" class="btn btn-secondary btn-sm mr-1" ><i class="fa-solid fa-circle-info"></i></a>
                                        <a href="{{ URL::to('operasional/manifestdomestik/printresi') }}/{{ $data->id }}" class="btn btn-primary btn-sm mr-1" target="_blank"><i class="fa-solid fa-print fa-sm"></i></a>
                                    </div>
                                </td>
                                <td class="bg-white border shadow" style="position: sticky; left: 88px; z-index: 2; white-space: nowrap;"><small>{{ $data->no_resi }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->pengirim->nama_pengirim }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->penerima->nama_penerima }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->penerima->kecamatan->nama_kecamatan }}, {{ $data->penerima->kecamatan->kota->nama_kota }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->barang->koli }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->barang->berat_aktual }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->barang->berat_volumetrik }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->barang->isi }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->ongkir->harga_transit }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->ongkir->harga_karantina }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->ongkir->harga_packing }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->ongkir->harga_ongkir }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->ongkir->total_ongkir }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->ongkir->pembayaran }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->admin }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->created_at }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
        // Date range picker
        $('#dari_tanggal, #sampai_tanggal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
        }),

        // Select2 
        $('#id_kota_tujuan').select2();
        $('#id_outlet_terima').select2();

        // Datatables //
        var table = $('#table').DataTable( {
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
        // table.buttons().container().appendTo( '#manifest_wrapper .col-md-6:eq(0)' );
    });

    // GET FILTER //
        $('#filter').click(function () {
            let id_outlet_terima = $('#id_outlet_terima').val();
            let id_layanan = $('#id_layanan').val();
            let id_kota_tujuan = $('#id_kota_tujuan').val();
            let dari_tanggal = $('#dari_tanggal').val();
            let sampai_tanggal = $('#sampai_tanggal').val();
            let pembayaran = $('#pembayaran').val();
            let no_resi = $('#no_resi').val();
            console.log(id_layanan)
            $.ajax({
                type: 'GET',
                url: '{{ route("filtermanifestdomestik") }}',
                data: {
                    id_outlet_terima : id_outlet_terima,
                    id_layanan : id_layanan,
                    id_kota_tujuan : id_kota_tujuan,
                    dari_tanggal : dari_tanggal,
                    sampai_tanggal : sampai_tanggal,
                    pembayaran : pembayaran,
                    no_resi : no_resi
                },
                success: function (response) {
                    $('#filtermanifestdomestik').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    // END //

    // Download Pdf //
        $('#pdf').click(function () {
            let id_outlet_terima = $('#id_outlet_terima').val();
            let id_layanan = $('#id_layanan').val();
            let id_kota_tujuan = $('#id_kota_tujuan').val();
            let dari_tanggal = $('#dari_tanggal').val();
            let sampai_tanggal = $('#sampai_tanggal').val();
            let pembayaran = $('#pembayaran').val();
            let no_resi = $('#no_resi').val();

            // Buat URL dengan query string menggunakan name route
            let url = '{!! route("pdfmanifestdomestik", ["id_outlet_terima" => "__id_outlet_terima__", "id_layanan" => "__id_layanan__", "id_kota_tujuan" => "__id_kota_tujuan__", "dari_tanggal" => "__dari_tanggal__", "sampai_tanggal" => "__sampai_tanggal__", "pembayaran" => "__pembayaran__", "no_resi" => "__no_resi__"]) !!}';

            // Ganti placeholder dengan nilai yang diambil dari input
            url = url.replace('__id_outlet_terima__', id_outlet_terima)
                    .replace('__id_layanan__', id_layanan)
                    .replace('__id_kota_tujuan__', id_kota_tujuan)
                    .replace('__dari_tanggal__', dari_tanggal)
                    .replace('__sampai_tanggal__', sampai_tanggal)
                    .replace('__pembayaran__', pembayaran)
                    .replace('__no_resi__', no_resi);

            url = decodeURIComponent(url);

            // Arahkan ke URL untuk mengunduh PDF
            window.location.href = url;
        });
    // End //

    // Download Excel //
        $('#excel').click(function () {
            let id_outlet_terima = $('#id_outlet_terima').val();
            let id_layanan = $('#id_layanan').val();
            let id_kota_tujuan = $('#id_kota_tujuan').val();
            let dari_tanggal = $('#dari_tanggal').val();
            let sampai_tanggal = $('#sampai_tanggal').val();
            let pembayaran = $('#pembayaran').val();
            let no_resi = $('#no_resi').val();

            // Buat URL dengan query string menggunakan name route
            let url = '{!! route("excelmanifestdomestik", ["id_outlet_terima" => "__id_outlet_terima__", "id_layanan" => "__id_layanan__", "id_kota_tujuan" => "__id_kota_tujuan__", "dari_tanggal" => "__dari_tanggal__", "sampai_tanggal" => "__sampai_tanggal__", "pembayaran" => "__pembayaran__", "no_resi" => "__no_resi__"]) !!}';

            // Ganti placeholder dengan nilai yang diambil dari input
            url = url.replace('__id_outlet_terima__', id_outlet_terima)
                    .replace('__id_layanan__', id_layanan)
                    .replace('__id_kota_tujuan__', id_kota_tujuan)
                    .replace('__dari_tanggal__', dari_tanggal)
                    .replace('__sampai_tanggal__', sampai_tanggal)
                    .replace('__pembayaran__', pembayaran)
                    .replace('__no_resi__', no_resi);

            url = decodeURIComponent(url);

            // Arahkan ke URL untuk mengunduh PDF
            window.location.href = url;
        });
    // End //
</script>
@endsection