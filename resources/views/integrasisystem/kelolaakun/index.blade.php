{{-- @dd($listuser); --}}
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
                <h6><i class="fa-solid fa-house"></i> / Integrasi System / <span class="text-primary">Kelola akun</span></h6>
                <hr>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <a href="{{ URL::to('integrasisystem/kelolaakun/tambah') }}" class="btn btn-secondary btn-sm mb-2">+ Tambah akun</a>
                <table class="table table-bordered table-hover shadow rounded" id="table">
                    <thead>
                        <tr class="bg-secondary text-light">
                            <th class="border shadow" style="position: sticky; left: 0; z-index: 2; max-width: 50px;"><i class="fa-solid fa-gear"></i></th>
                            <th style="white-space: nowrap;"><small>Id</small></th>
                            <th style="white-space: nowrap;"><small>Kode Outlet</small></th>
                            <th style="white-space: nowrap;"><small>Nama</small></th>
                            <th style="white-space: nowrap;"><small>Username</small></th>
                            <th style="white-space: nowrap;"><small>Tipe</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ( $listuser as $data )
                            <tr>
                                <td class="bg-white border shadow d-flex" style="position: sticky; left: 0; z-index: 2;">
                                    <a href="#" class="btn btn-sm btn-primary mr-1">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ URL::to('integrasisystem/kelolaakun/hapus') }}" method="post" onSubmit="if(!confirm('yakin ingin menghapus Akun?')){return false;}">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <button href="" class="btn btn-sm btn-danger">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="td-truncate"><small>{{ $data->id }}</small></td>
                                <td class="td-truncate"><small>{{ $data->outlet->kode_agen }}</small></td>
                                <td class="td-truncate"><small>{{ $data->nama }}</small></td>
                                <td class="td-truncate"><small>{{ $data->username }}</small></td>
                                <td class="td-truncate"><small>{{ $data->role }}</small></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
            // Datatable
            $('#table').DataTable({
                lengthMenu:[[10,25,50,-1], [10,25,50, "All"]]
            });
        });
    </script>
@endsection