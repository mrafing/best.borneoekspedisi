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
            <div>
                <p class="font-weight-bold"><a href="{{ URL::to('arsipmanifest/manifestinternational') }}"><i class="fa-solid fa-arrow-left fa-md mr-1"></i></a> Nomor Resi : {{ $data->no_resi }}</p>
                <hr>
                <div class="row">
                    <div class="col-9">
                        <div class="pb-3 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
                            <h5 class="font-weight-bold mb-3">Detail Pengiriman</h5>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Layanan</small></p>
                                <p><small>{{ strtoupper($data->layanan->nama_layanan) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">No. Resi</small></p>
                                <p><small>{{ $data->no_resi }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Kecamatan, Kota asal</small></p>
                                <p><small>{{ strtoupper($data->pengirim->kecamatan->nama_kecamatan) }}, {{ strtoupper($data->pengirim->kecamatan->kota->nama_kota) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Kota, Negara tujuan</small></p>
                                <p><small>{{ strtoupper($data->penerimaLn->kotaLn->nama_kota_ln) }}, {{ strtoupper($data->penerimaLn->kotaLn->NegaraLn->nama_negara) }}</small></p>
                            </div>
                        </div>
                        <div class="pb-3 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
                            <h5 class="font-weight-bold mb-3">Info pengirim</h5>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Nama pengirim</small></p>
                                <p><small>{{ strtoupper($data->pengirim->nama_pengirim) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Nama perusahaan</small></p>
                                <p><small>{{ strtoupper($data->pengirim->nama_perusahaan_pengirim) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Alamat</small></p>
                                <p><small>{{ strtoupper($data->pengirim->alamat_pengirim) }} {{ strtoupper($data->pengirim->kecamatan->nama_kecamatan) }}, {{ strtoupper($data->pengirim->kecamatan->kota->nama_kota) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">No hp</small></p>
                                <p><small>{{ strtoupper($data->pengirim->no_pengirim) }}</small></p>
                            </div>
                        </div>
                        <div class="pb-3 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
                            <h5 class="font-weight-bold mb-3">Info penerima</h5>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Nama penerima</small></p>
                                <p><small>{{ strtoupper($data->penerimaLn->nama_penerima) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Nama perusahaan</small></p>
                                <p><small>{{ strtoupper($data->penerimaLn->nama_perusahaan_penerima) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">Alamat</small></p>
                                <p><small>{{ strtoupper($data->penerimaLn->alamat_penerima) }} {{ strtoupper($data->penerimaLn->kotaLn->nama_kota_ln) }}, {{ strtoupper($data->penerimaLn->kotaLn->negaraLn->nama_negara) }}</small></p>
                            </div>
                            <div class="mb-3">
                                <p class="mb-0"><small class="font-weight-bold">No hp</small></p>
                                <p><small>{{ strtoupper($data->penerimaLn->no_penerima) }}</small></p>
                            </div>
                        </div>
                        <div class="pb-3 mb-3" style="border-bottom: 1px solid rgba(0, 0, 0, 0.1);">
                            <h5 class="font-weight-bold mb-3">Info barang</h5>
                            <div class="d-flex">
                                <div class="mr-5">
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Komoditi</small></p>
                                        <p><small>{{ strtoupper($data->layanan->nama_komoditi) }}</small></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Isi barang</small></p>
                                        <p><small>{{ strtoupper($data->barang->isi) }}</small></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Outlet asal</small></p>
                                        <p><small>{{ strtoupper($data->outlet->kode_agen) }}</small></p>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Koli (jumlah paket)</small></p>
                                        <p><small>{{ strtoupper($data->barang->koli) }} Q</small></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Berat aktual</small></p>
                                        <p><small>{{ strtoupper($data->barang->berat_aktual) }} KG</small></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Berat volumetrik</small></p>
                                        <p><small>{{ strtoupper($data->barang->berat_volumetrik) }} V</small></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="pb-3 mb-3">
                            <h5 class="font-weight-bold mb-3">Info biaya</h5>
                            <div class="d-flex">
                                <div class="mr-5">
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Biaya ongkir /kg</small></p>
                                        <p><small>{{ 'Rp ' . number_format($data->ongkirLn->harga_ongkir, 0, ',', '.') }}</small></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Biaya packing</small></p>
                                        <p><small>{{ 'Rp ' . number_format($data->ongkirLn->harga_packing, 0, ',', '.') }}</small></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Biaya surat jalan / karantina</small></p>
                                        <p><small>{{ 'Rp ' . number_format($data->ongkirLn->harga_karantina, 0, ',', '.') }}</small></p>
                                    </div>
                                </div>
                                <div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Biaya transit</small></p>
                                        <p><small>{{ 'Rp ' . number_format($data->ongkirLn->harga_transit, 0, ',', '.') }}</small></p>
                                    </div>
                                    <div class="mb-3">
                                        <p class="mb-0"><small class="font-weight-bold">Total ongkir</small></p>
                                        <p class="font-weight-bold text-danger">{{ 'Rp ' . number_format($data->ongkirLn->total_ongkir, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col" style="border-left: 1px solid rgba(0, 0, 0, 0.1)">
                        <div class="mb-3">
                            <p class="mb-0"><small class="font-weight-bold">Status tracking terkini</small></p>
                            <p><small>{{ $dataTracking->keterangan }}</small></p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0"><small class="font-weight-bold">Status bermasalah</small></p>
                            <p><small>-</small></p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0"><small class="font-weight-bold">Tanggal diubah</small></p>
                            <p><small>{{ $data->updated_at }}</small></p>
                        </div>
                        <div class="mb-3">
                            <p class="mb-0"><small class="font-weight-bold">Tanggal dibuat</small></p>
                            <p><small>{{ $data->created_at }}</small></p>
                        </div>

                        @if ($dataTracking->status_tracking == 'Pengambilan Paket')
                            <div class="d-flex flex-column">
                                <a href="{{ URL::to("arsipmanifest/manifestinternational/edit/$data->id") }}" class="btn btn-primary mb-3"><i class="fa-solid fa-pen-to-square"></i> Ubah resi</a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#deleteModal"><i class="fa-solid fa-trash"></i> Hapus resi</button>
                            </div>

                            {{-- Modal --}}
                            <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel">Apa anda yakin ingin menghapus?</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ URL::to('operasional/manifestinternational/delete') }}" method="post">
                                                @csrf
                                                @method('delete')
                                                <input type="hidden" name="id" value="{{ $data->id }}">

                                                <label class="form-label">Keterangan Hapus</label>
                                                <textarea class="form-control mb-3" name="keterangan_hapus" cols="30" rows="5"></textarea>

                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                <button class="btn btn-danger" type="submit">Hapus</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="d-flex flex-column">
                                <a class="btn btn-primary mb-3 disabled" role="button" aria-disabled="true"><i class="fa-solid fa-pen-to-square"></i> Ubah resi</a>
                                <a class="btn btn-danger disabled" role="button" aria-disabled="true"><i class="fa-solid fa-trash"></i> Hapus resi</a>
                            </div>
                        @endif
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