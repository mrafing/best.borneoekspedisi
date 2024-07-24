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
                <div class="row align-items-center no-gutters mb-3">
                    <div class="col-auto mr-3">
                        <a href="{{ URL::to('integrasisystem/kelolaakun') }}" class="btn btn-primary rounded-circle"><i class="fa-solid fa-chevron-left"></i></a>
                    </div>
                    <div class="col-auto">
                        <h6 class="mb-0"><b>Mitra</b> / Kelola Akun / Tambah Akun</h6>
                    </div>
                </div>
                <div class="card p-3" style="max-width: 1000px">
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
                    
                    <form action="{{ URL::to('integrasisystem/kelolaakun/save') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Outlet</label>
                                    <input class="form-control" type="text" value="{{ Auth::user()->outlet->kode_agen }}" readonly>
                                    <input type="hidden" name="id_outlet" value="{{ Auth::user()->id_outlet }}">
                                </div>
                                <div class="form-group">
                                    <label>Nama <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="nama" value="{{ old('nama') }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Tipe <span class="text-danger">*</span></label>
                                    <select class="form-control" name="role" required>
                                        <option value="">Pilih</option>
                                        <option value="master" {{ old('role') == 'master' ? 'selected' : '' }} >Master</option>
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                                {{-- <div class="form-group">
                                    <label>Username <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="username" required>
                                </div> --}}
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" class="form-control" name="confirm_password" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary btn-sm mr-2" type="submit" name="submit"><i class="fa-solid fa-plus"></i> Tambah Akun</button>
                            </div>
                        </div>
                    </form>
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