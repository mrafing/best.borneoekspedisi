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
                        <p style="margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->username) }} - {{ strtoupper(Auth::user()->outlet->kode_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                        <p style="margin-left: 200px; margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->username) }} - {{ strtoupper(Auth::user()->outlet->kode_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                    </div>
                @endfor
            </div>
            {{-- CONTENT --}}
                <h6 class="mb-3"><b>Kelola Akun</b></h6>
                <hr>

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <a href="{{ URL::to('integrasisystem/kelolaakun/tambah') }}" class="btn btn-primary mb-3">+ Tambah Akun</a>
                <table class="table table-bordered table-hover shadow rounded" id="table">
                    <thead>
                        <tr>
                            <th><p class="text-center mb-0">ID</p></th>
                            <th><p class="text-center mb-0">OUTLET</p></th>
                            <th><p class="text-center mb-0">NAMA</p></th>
                            <th><p class="text-center mb-0">USERNAME</p></th>
                            <th><p class="text-center mb-0">TIPE</p></th>
                            <th class="bg-white border shadow" style="position: sticky; right: 0; z-index: 2; max-width: 50px;">
                                <p class="text-center mb-0"><i class="fa-solid fa-gear"></i></p>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ( $listuser as $data )
                            <tr class="text-center">
                                <td class="align-middle"><p class="mb-0">{{ $data->id }}</p></td>
                                <td class="align-middle"><p class="mb-0">{{ $data->outlet->kode_agen }}</p></td>
                                <td class="align-middle"><p class="mb-0">{{ $data->nama }}</p></td>
                                <td class="align-middle"><p class="mb-0">{{ $data->username }}</p></td>
                                <td class="align-middle"><p class="mb-0">{{ $data->role }}</p></td>
                                <td class="align-middle bg-white border shadow" style="position: sticky; right: 0; z-index: 2;">
                                    <a href="" class="btn btn-sm border mb-1">
                                        <i class="fa-solid fa-pen-to-square text-primary"></i>
                                    </a>
                                    <form action="{{ URL::to('integrasisystem/kelolaakun/hapus') }}" method="post" onSubmit="if(!confirm('yakin ingin menghapus Akun?')){return false;}">
                                        @method('delete')
                                        @csrf
                                        <input type="hidden" name="id" value="{{ $data->id }}">
                                        <button href="" class="btn btn-sm border">
                                            <i class="fa-solid fa-trash text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center"><small>Not Found</small></td>
                            </tr>
                        @endforelse
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
            var table = $('#table').DataTable({
                lengthMenu:[[10,25,50,-1], [10,25,50, "All"]]
            });
        });
    </script>
@endsection