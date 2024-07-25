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
                <div class="d-flex justify-content-between align-items-end mb-2">
                    <div>
                        <p class="mb-2">Unduh Manifest Harian</p>
                        <button class="btn btn-sm btn-danger" type="submit" name="action" value="pdf">PDF <i class="fa-solid fa-file-pdf"></i></button>
                        <button class="btn btn-sm btn-success" type="submit" name="action" value="excel">Excel <i class="fa-solid fa-table"></i></button>
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

                <div class="table-responsive border rounded" id="filterManifestHarian">
                    <table class="table table-bordered table-hover shadow" id="manifestHarian">
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
                            @forelse ($listmanifest as $data)
                                <tr>
                                    <td class="bg-white border shadow" style="position: sticky; left: 0; z-index: 2;">
                                        <div class="d-flex">
                                            <a href="{{ URL::to('operasional/manifestdomestik/printresi') }}/{{ $data->id }}" class="btn btn-primary btn-sm mr-1" target="_blank"><i class="fa-solid fa-print fa-sm"></i></a>
                                            <a href="{{ URL::to('operasional/manifestdomestik/hapus') }}/{{ $data->id }}" class="btn btn-danger btn-sm mr-1" onSubmit="if(!confirm('Yakin Ingin Void?')){return false;}"><i class="fa-solid fa-trash-can fa-sm"></i></a>
                                            {{-- <form onSubmit="if(!confirm('Yakin Ingin Void?')){return false;}" action="{{ URL::to('operasional/manifestdomestik/hapus') }}" method="post">
                                                @method('delete')
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <button class="btn btn-danger btn-sm" type="submit"><i class="fa-solid fa-trash-can fa-sm"></i></button>
                                            </form>  --}}
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
                            @empty
                                <tr>
                                    <td colspan="17" class="text-center"><small>Not Found</small></td>
                                </tr>
                            @endforelse
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

        $('#id_kota_tujuan').select2();
    });

    // GET FILTER //
        $('#filter').click(function () {
            let id_layanan = $('#id_layanan').val();
            let id_kota_tujuan = $('#id_kota_tujuan').val();
            let tanggal_terima = $('#tanggal_terima').val();
            let pembayaran = $('#pembayaran').val();
            let no_resi = $('#no_resi').val();
            console.log(id_layanan)
            $.ajax({
                type: 'GET',
                url: '{{ route("filtermanifestharian") }}',
                data: {
                    id_layanan : id_layanan,
                    id_kota_tujuan : id_kota_tujuan,
                    tanggal_terima : tanggal_terima,
                    pembayaran : pembayaran,
                    no_resi : no_resi
                },
                success: function (response) {
                    $('#filterManifestHarian').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    // END //
</script>
@endsection