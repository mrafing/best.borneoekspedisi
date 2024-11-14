{{-- @dd($listmitra); --}}
@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('integrasisystem.partials.sidebar')

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
                <h6><i class="fa-solid fa-house"></i> / Integrasi System / <span class="text-primary">Mitra</span></h6>
                <hr>

                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>{{ session('success') }}</strong>. click x to close
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <a href="{{ URL::to('integrasisystem/mitra/tambah') }}" class="btn btn-secondary btn-sm mb-2">+ Tambah mitra</a>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover shadow" id="table">
                        <thead class="bg-secondary text-light">
                          <tr>
                            <th class="border bg-secondary shadow" style="position: sticky; left: 0; z-index: 2;"><i class="fa-solid fa-gear"></i></th>
                            <th style="white-space: nowrap;"><small>Tipe</small></th>
                            <th style="white-space: nowrap;"><small>Status</small></th>
                            <th style="white-space: nowrap;"><small>Nama pendaftar</small></th>
                            <th style="white-space: nowrap;"><small>Nomor kontak</small></th>
                            <th style="white-space: nowrap;"><small>Alamat pendaftar</small></th>
                            <th style="white-space: nowrap;"><small>Nama perusahaan</small></th>
                            <th style="white-space: nowrap;"><small>Nama pimpinan</small></th>
                            <th style="white-space: nowrap;"><small>Alamat perusahaan</small></th>
                            <th style="white-space: nowrap;"><small>Kategori perusahaan</small></th>
                            <th style="white-space: nowrap;"><small>Nama toko</small></th>
                            <th style="white-space: nowrap;"><small>Jenis produk</small></th>
                            <th style="white-space: nowrap;"><small>Alamat toko</small></th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ( $listmitra as $mitra)
                            <tr>
                                <td class="align-middle border bg-white shadow d-flex" style="position: sticky; left: 0; z-index: 2;">
                                    <a href="{{ URL::to("integrasisystem/mitra/detail/$mitra->id") }}" class="btn btn-secondary btn-sm mr-1"><i class="fa-solid fa-circle-info"></i></a>
                                    <form action="{{ URL::to('integrasisystem/mitra/hapus') }}" method="post" onSubmit="if(!confirm('Yakin ingin menghapus data?')){return false;}">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $mitra->id }}">
                                        <button class="btn btn-danger btn-sm"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                                <td class="td-truncate"><small>{{ $mitra->tipe }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->status }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->nama_pendaftar }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->nomor_kontak }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->alamat_pendaftar }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->nama_perusahaan }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->nama_pemimpin_perusahaan }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->alamat_perusahaan }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->kategori_perusahaan }}</td>
                                <td class="td-truncate"><small>{{ $mitra->nama_toko }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->jenis_produk_toko }}</small></td>
                                <td class="td-truncate"><small>{{ $mitra->alamat_toko }}</small></td>
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
        // Datatable //
        $('#table').DataTable({
            lengthMenu:[[10,25,50,-1], [10,25,50, "All"]]
        });
    });
</script>
@endsection