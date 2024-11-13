{{-- @dd($listmanifest) --}}
@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('tracking.partials.sidebar')

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
                @if ($submanifest)
                    <div class="table-responsive pb-4">
                        <table class="table">
                            <thead class="bg-primary text-light">
                                <tr>
                                    <th><p class="text-center mb-0">NO RESI</p></th>
                                    <th><p class="text-center mb-0">LAYANAN</p></th>
                                    <th><p class="text-center mb-0">KOLI</p></th>
                                    <th><p class="text-center mb-0">BA</p></th>
                                    <th><p class="text-center mb-0">BV</p></th>
                                    <th><p class="text-center mb-0">TRANSIT</p></th>
                                    <th><p class="text-center mb-0">KARANTINA</p></th>
                                    <th><p class="text-center mb-0">PACKING</p></th>
                                    <th><p class="text-center mb-0">TOTAL BIAYA</p></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><p class="text-center my-4">{{ $submanifest->sub_resi }}</p></td>
                                    <td><p class="text-center my-4">{{ $submanifest->manifest->layanan->nama_layanan }} - {{ $submanifest->manifest->layanan->nama_komoditi }}</p></td>
                                    <td><p class="text-center my-4">{{ $submanifest->manifest->barang->koli }}</p></td>
                                    <td><p class="text-center my-4">{{ $submanifest->manifest->barang->berat_aktual }}</p></td>
                                    <td><p class="text-center my-4">{{ $submanifest->manifest->barang->berat_volumetrik }}</p></td>
                                    <td><p class="text-center my-4">Rp. {{ $submanifest->manifest->ongkir->harga_transit }}</p></td>
                                    <td><p class="text-center my-4">Rp. {{ $submanifest->manifest->ongkir->harga_karantina }}</p></td>
                                    <td><p class="text-center my-4">Rp. {{ $submanifest->manifest->ongkir->harga_packing }}</p></td>
                                    <td><p class="text-center my-4">Rp. {{ $submanifest->manifest->ongkir->total_ongkir }}</p></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <hr>
                    <div class="table-responsive mb-5">
                        <table style="width: 100%;">
                            <tr>
                                <th><p class="mb-0">PENGIRIM</p></th>
                                <th><p class="mb-0">PENERIMA</p></th>
                            </tr>
                            <tr>
                                <td><p class="mb-4">{{ strtoupper($submanifest->manifest->pengirim->nama_pengirim) }}</p></td>
                                <td><p class="mb-4">{{ strtoupper($submanifest->manifest->penerima->nama_penerima) }}</p></td>
                            </tr>
                            <tr>
                                <th><p class="mb-0">ASAL</p></th>
                                <th><p class="mb-0">TUJUAN</p></th>
                            </tr>
                            <tr>
                                <td><p class="mb-0">{{ strtoupper($submanifest->manifest->pengirim->kecamatan->nama_kecamatan) }}</p></td>
                                <td><p class="mb-0">{{ strtoupper($submanifest->manifest->penerima->kecamatan->nama_kecamatan) }}, {{ strtoupper($submanifest->manifest->penerima->kecamatan->kota->nama_kota) }}</p></td>
                            </tr>
                        </table>
                    </div>
                    <hr>
            
                    <div class="row justify-content-between align-items-center mb-3">
                        <div class="col-sm-auto">
                            <h6 class="text-center mb-3 mb-sm-0"><b>RIWAYAT PENGIRIMAN</b></h6>
                        </div>
                    </div>
            
                    <div class="table-responsive">
                        <table class="table">
                            <thead class="bg-primary text-light">
                                <tr>
                                    <th><p class="text-center mb-0">TANGGAL</p></th>
                                    <th><p class="text-center mb-0">STATUS TERKINI</p></th>
                                    <th><p class="text-center mb-0">KETERANGAN</p></th>
                                    <a href=""></a>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tracking as $data )
                                    
                                {{-- Lihat foto modal --}}
                                    <div class="modal fade" id="lihatFotoModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Bukti terima</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <a href="{{ URL::to("storage/$data->gambar") }}" target="_blank">
                                                        <img src="{{ asset("storage/$data->gambar") }}" style="width: 100%;">
                                                    </a>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <td><p class="text-center my-3" style="font-size: 0.8em;">{{ $data->created_at }} WIB</p></td>
                                        <td><p class="text-center my-3">{{ $data->status_tracking }}</p></td>
                                        <td>
                                            <div class="my-3">
                                                <p class="my-0">
                                                    {{ $data->keterangan }}
                                                    {{ $data->status_tracking == 'scan kirim mitra b' ? ' - driver/kurir : ' . $data->nama_kurir . ' - armada : ' . $data->armada . ' ' . $data->plat_armada : '' }}
                                                    {{ $data->status_tracking == 'scan kirim mitra a' ? ' - driver/kurir : ' . $data->nama_kurir . ' - armada : ' . $data->armada . ' ' . $data->plat_armada : '' }}
                                                    {{ $data->status_tracking == 'kirim paket muatan' ? ' - driver/kurir : ' . $data->nama_kurir . ' - armada : ' . $data->armada . ' ' . $data->plat_armada : '' }}
                                                    <?= ($data->status_tracking == 'tanda terima') ? "<button type='button' class='btn btn-primary btn-sm mr-1' data-toggle='modal' data-target='#lihatFotoModal". $data->id ."'>Lihat foto</button>" : '' ?>
                                                    {{ ' - pemindai : ' . $data->pemindai }}
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="card py-5">
                        <div class="row justify-content-center mb-3">
                            <div class="col-auto">
                                <img src="{{ asset('img/no_data.png') }}" alt="NO DATA" width="120px">
                            </div>
                        </div>
                        <p class="text-center">Not Found</p>
                    </div>
                @endif
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
@endsection