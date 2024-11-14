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
                <h6><i class="fa-solid fa-house"></i> / Integrasi System / Kelola akun / <span class="text-primary">Tambah akun</span></h6>
                <hr>

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

                <div style="max-width: 700px">
                    <form action="{{ URL::to('integrasisystem/kelolaakun/save') }}" method="post">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-6">
                                <div class="form-group">
                                    <label>Nama lengkap</label>
                                    <input type="text" class="form-control form-control-sm @error('nama') is-invalid @enderror" name="nama" value="{{ old('nama') }}" autofocus="on">
                                    @error('nama')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Outlet asal</label>
                                    <select class="form-control form-control-sm @error('id_outlet') is-invalid @enderror" name="id_outlet" id="searchoutlet"></select>
                                    @error('id_outlet')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Tipe user</label>
                                    <select class="form-control form-control-sm @error('role') is-invalid @enderror" name="role">
                                        <option value="">[pilih]</option>
                                        <option value="gm" {{ old('role') == 'gm' ? 'selected' : '' }} >Grand master</option>
                                        {{-- <option value="master" {{ old('role') == 'master' ? 'selected' : '' }} >Master admin</option> --}}
                                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Staff admin</option>
                                        <option value="gudang" {{ old('role') == 'gudang' ? 'selected' : '' }}>Staff gudang</option>
                                        {{-- <option value="kurir" {{ old('role') == 'kurir' ? 'selected' : '' }}>Kurir / sprinter</option> --}}
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="password" class="form-control form-control-sm @error('password') is-invalid @enderror" name="password">
                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" id="confirm_password" class="form-control form-control-sm" name="password_confirmation">
                                    <div id="password-match-feedback" class="invalid-feedback d-none">
                                        Passwords tidak sama
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <button class="btn btn-primary btn-sm w-100" type="submit" name="submit"><i class="fa-solid fa-plus"></i> Tambah akun</button>
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

@section('script')
<script>
    $(document).ready(function() {
        // Search outlet Select 2 //
        $('#searchoutlet').select2({
            placeholder: '[pilih]',
            ajax: {
                url : '{{ route("searchoutlet") }}',
                dataType: 'json',
                delay: 250, // Delay sebelum pencarian dimulai
                data: function (params) {
                    return {
                        q: params.term // Kata kunci yang diketik
                    };
                },
                processResults: function (data){
                    return {
                        results: data.results.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            }
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1, // Mulai pencarian setelah mengetik 1 karakter
        });
    });

    // Matching Password
    document.getElementById('confirm_password').addEventListener('input', function () {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        const feedback = document.getElementById('password-match-feedback');

        if (confirmPassword === password) {
            feedback.classList.add('d-none');
            this.classList.remove('is-invalid');
        } else {
            feedback.classList.remove('d-none');
            this.classList.add('is-invalid');
        }
    });
</script>
@endsection