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
                <h4 class="mb-3"><b>Daftar Mitra</b></h4>
                <a href="{{ URL::to('integrasisystem/mitra/tambah') }}" class="btn btn-primary btn-sm">+ Tambah Mitra Baru</a>
                @if(session()->has('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        <strong>{{ session('success') }}</strong>. click x to close
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <hr>
                <div class="table-responsive">
                    <table id="daftarmittra" class="table table-bordered table-hover shadow">
                        <thead class="bg-primary text-light">
                          <tr>
                            <th class="align-middle border bg-primary shadow" style="height: 20px; position: sticky; left: 0; z-index: 2;"><i class="fa-solid fa-gear"></i></th>
                            <th class="align-middle " style="min-width: 100px;">Tipe</th>
                            <th class="align-middle " style="min-width: 100px;">Status</th>
                            <th class="align-middle " style="min-width: 100px;">Nama Pendaftar</th>
                            <th class="align-middle " style="min-width: 100px;">Nomor Kontak</th>
                            <th class="align-middle " style="min-width: 300px;">Alamat Pendaftar</th>
                            <th class="align-middle " style="min-width: 100px;">Nama Perusahaan</th>
                            <th class="align-middle " style="min-width: 100px;">Nama Pimpinan</th>
                            <th class="align-middle " style="min-width: 300px;">Alamat Perusahaan</th>
                            <th class="align-middle " style="min-width: 100px;">Kategori Perusahaan</th>
                            <th class="align-middle " style="min-width: 100px;">Nama Toko</th>
                            <th class="align-middle " style="min-width: 100px;">Jenis Produk</th>
                            <th class="align-middle " style="min-width: 300px;">Alamat Toko</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ( $listmitra as $mitra)
                            <tr>
                                <td class="align-middle border bg-white shadow" style="position: sticky; left: 0; z-index: 2;">
                                    <a href="{{ URL::to("integrasisystem/mitra/show/$mitra->id") }}" class="btn btn-sm">
                                        <i class="fa-solid fa-eye text-primary"></i>
                                    </a>
                                    <form action="{{ URL::to('integrasisystem/mitra/hapus') }}" method="post" onSubmit="if(!confirm('Yakin ingin menghapus data?')){return false;}">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $mitra->id }}">
                                        <button class="btn btn-sm"><i class="fa-solid fa-trash text-danger"></i></button>
                                    </form>
                                </td>
                                <td>{{ $mitra->tipe }}</td>
                                <td>{{ $mitra->status }}</td>
                                <td>{{ $mitra->nama_pendaftar }}</td>
                                <td>{{ $mitra->nomor_kontak }}</td>
                                <td>{{ $mitra->alamat_pendaftar }}</td>
                                <td>{{ strtoupper($mitra->nama_perusahaan) }}</td>
                                <td>{{ $mitra->nama_pemimpin_perusahaan }}</td>
                                <td>{{ $mitra->alamat_perusahaan }}</td>
                                <td>{{ $mitra->kategori_perusahaan }}</td>
                                <td>{{ $mitra->nama_toko }}</td>
                                <td>{{ $mitra->jenis_produk_toko }}</td>
                                <td>{{ $mitra->alamat_toko }}</td>
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
            var table = $('#daftarmittra').DataTable({
                lengthMenu:[[10,25,50,-1], [10,25,50, "All"]]
            });
        });
    </script>
@endsection