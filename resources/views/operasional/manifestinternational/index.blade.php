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
                <div class="d-flex justify-content-start align-items-end mb-2">
                    <div>
                        <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                            Filter <i class="fa-solid fa-filter"></i>
                        </button>
                    </div>
                </div>
                <div class="show collapse mb-3" id="collapseFilter">
                    <div class="card card-body">
                        <div class="row">
                            <div class="col-3 form-group">
                                <label for="id_outlet_terima"><small>Outlet Terima</small></label>
                                <select class="form-control form-control-sm" id="id_outlet_terima" name="id_outlet_terima" readonly>
                                    <option value="{{ Auth::user()->id_outlet }}" selected>{{ Auth::user()->outlet->kode_agen }}</option>
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label for="id_layanan"><small>Layanan</small></label>
                                <select class="form-control form-control-sm" id="id_layanan" name="id_layanan">
                                    <option value="">-pilih-</option>
                                    <option value="LY8">INTERNATIONAL - (GENERAL CARGO / Barang Umum)</option>
                                    <option value="LY9">INTERNATIONAL - (SENSITIVE ITEM)</option>
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label for="id_negara_tujuan"><small>Negara Tujuan</small></label>
                                <select class="form-control form-control-sm" name="id_negara_tujuan" id="id_negara_tujuan">
                                    <option value="">-pilih-</option>
                                    @foreach ( $listnegara as $data )
                                        <option value="{{ $data->id }}">{{ $data->nama_negara }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-3 form-group">
                                <label for=""><small>Tanggal Terima</small></label>
                                <input type="text" class="form-control form-control-sm" id="tanggal_terima" name="tanggal_terima" value="">
                            </div>
                        </div>
                        <div class="row">
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

                <div class="table-responsive border rounded" id="filterManifestLnHarian">
                    <table class="table table-bordered table-hover shadow" id="table">
                        <thead>
                            <tr class="bg-secondary text-light">
                                <th class="bg-secondary border shadow" style="position: sticky; left: 0; z-index: 2;">
                                    <i class="fa-solid fa-gear"></i>
                                </th>
                                <th class="bg-secondary border shadow" style="position: sticky; left: 58px; z-index: 2; white-space: nowrap;"><small>Nomor Resi</small></th>
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
                                            <a href="{{ URL::to("operasional/manifestinternational/printresi/$data->id") }}" class="btn btn-primary btn-sm mr-1" target="_blank"><i class="fa-solid fa-print fa-sm"></i></a>
                                        </div>
                                    </td>
                                    <td class="bg-white border shadow" style="position: sticky; left: 58px; z-index: 2; white-space: nowrap;"><small>{{ $data->no_resi }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->pengirim->nama_pengirim }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->penerimaLn->nama_penerima }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->penerimaLn->kotaLn->nama_kota_ln }}, {{ $data->penerimaLn->kotaLn->negaraLn->nama_negara }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->barang->koli }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->barang->berat_aktual }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->barang->berat_volumetrik }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->barang->isi }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_transit }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_karantina }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_packing }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_ongkir }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->total_ongkir }}</small></td>
                                    <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->pembayaran }}</small></td>
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
        $('#tanggal_terima').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
        }), 

        $('#id_negara_tujuan').select2();

        // Datatables //
        $('#table').DataTable( {
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    });

    // GET FILTER //
        $('#filter').click(function () {
            let id_layanan = $('#id_layanan').val();
            let id_negara_tujuan = $('#id_negara_tujuan').val();
            let tanggal_terima = $('#tanggal_terima').val();
            let pembayaran = $('#pembayaran').val();
            let no_resi = $('#no_resi').val();
            $.ajax({
                type: 'GET',
                url: '{{ route("filtermanifestlnharian") }}',
                data: {
                    id_layanan : id_layanan,
                    id_negara_tujuan : id_negara_tujuan,
                    tanggal_terima : tanggal_terima,
                    pembayaran : pembayaran,
                    no_resi : no_resi
                },
                success: function (response) {
                    $('#filterManifestLnHarian').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    // END //
</script>
@endsection