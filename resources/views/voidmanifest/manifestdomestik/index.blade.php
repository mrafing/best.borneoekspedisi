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
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
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
                        <p class="mb-2">Unduh Void Manifest</p>
                        <button class="btn btn-sm btn-danger disabled" type="submit" name="action" value="pdf" disabled>PDF <i class="fa-solid fa-file-pdf"></i></button>
                        <button class="btn btn-sm btn-success disabled" type="submit" name="action" value="excel" disabled>Excel <i class="fa-solid fa-table"></i></button>
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

            <div class="table-responsive border rounded py-2" id="filtervoidmanifestdomestik">
                <table class="table table-bordered table-hover shadow" id="table">
                    <thead>
                        <tr class="bg-secondary text-light">
                            <th class="bg-secondary border shadow" style="position: sticky; left: 0; z-index: 2;">
                                <i class="fa-solid fa-gear"></i>
                            </th>
                            <th style="white-space: nowrap;"><small>Outlet Asal</small></th>
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
                            <th style="white-space: nowrap;"><small>Deleted By</small></th>
                            <th style="white-space: nowrap;"><small>Tanggal Void</small></th>
                            <th style="white-space: nowrap;"><small>Keterangan</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($listvoidmanifest as $data)
                            {{-- Restore modal --}}
                            <div class="modal fade" id="restoreModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="restoreModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="restoreModalLabel">Konfirmasi restore</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="modal-title" id="restoreModalLabel">Apa anda yakin ingin memulihkan resi?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <a href="{{ URL::to("voidmanifest/manifestdomestik/restore/$data->id") }}" class="btn btn-primary">Pulihkan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- Delete modal --}}
                            <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="modal-title" id="deleteModalLabel">Apa anda yakin ingin menghapus resi? resi akan hilang permanen</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                            <form action="{{ URL::to("voidmanifest/manifestdomestik/delete") }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $data->id }}">
                                                <button type="submit" class="btn btn-danger">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <tr>
                                <td class="bg-white border shadow" style="position: sticky; left: 0; z-index: 2;">
                                    <div class="d-flex">
                                        <button type="button" class="btn btn-primary btn-sm mr-1" data-toggle="modal" data-target="#restoreModal{{ $data->id }}"><i class="fa-solid fa-arrows-rotate"></i></button>
                                        <button type="button" class="btn btn-danger btn-sm mr-1" data-toggle="modal" data-target="#deleteModal{{ $data->id }}"><i class="fa-solid fa-trash-can fa-sm"></i></button>
                                    </div>
                                </td>
                                <td style="white-space: nowrap;"><small>{{ $data->outlet->kode_agen }}</small></td>
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
                                <td style="white-space: nowrap;"><small>{{ $data->deleted_by }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->created_at }}</small></td>
                                <td style="white-space: nowrap;"><small>{{ $data->keterangan_hapus }}</small></td>
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
        $('#id_kota_tujuan, #id_outlet_terima').select2();

        // Datatables //
        $('#table').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    });

    // Get filter //
        $('#filter').click(function () {
            let id_outlet_terima = $('#id_outlet_terima').val();
            let id_layanan = $('#id_layanan').val();
            let id_kota_tujuan = $('#id_kota_tujuan').val();
            let dari_tanggal = $('#dari_tanggal').val();
            let sampai_tanggal = $('#sampai_tanggal').val();
            let pembayaran = $('#pembayaran').val();
            $.ajax({
                type: 'GET',
                url: '{{ route("filtervoidmanifestdomestik") }}',
                data: {
                    id_outlet_terima : id_outlet_terima,
                    id_layanan : id_layanan,
                    id_kota_tujuan : id_kota_tujuan,
                    dari_tanggal : dari_tanggal,
                    sampai_tanggal : sampai_tanggal,
                    pembayaran : pembayaran,
                },
                success: function (response) {
                    $('#filtervoidmanifestdomestik').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    // End //
</script>
@endsection