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
                        <p style="margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->username) }} - {{ strtoupper(Auth::user()->outlet->nama_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                        <p style="margin-left: 200px; margin-bottom: 100px;"><b>{{ strtoupper(Auth::user()->username) }} - {{ strtoupper(Auth::user()->outlet->nama_agen) }} - {{ strtoupper(Auth::user()->role) }}</b></p>
                    </div>
                @endfor
            </div>
            {{-- CONTENT --}}
                <h6 class="mb-3"><b>Tambah Mitra Baru</b></h6>
                <hr>
                <form action="{{ URL::to('integrasisystem/mitra/save') }}" method="post">
                    @csrf
                    <div style="max-width: 500px">
                        <div>
                            <h4 class="text-primary"># Data Pendaftar</h4>
                            <hr>
                            <div class="form-group">
                                <label for="tipe">Tipe</label>
                                <select class="form-control" id="tipe" name="tipe" required>
                                    <option value="">Pilih</option>
                                    <option value="perusahaan">Perusahaan</option>
                                    <option value="perorangan">Perorangan</option>
                                    <option value="customer priority">Customer Priority</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="nama_pendaftar">Nama Pendaftar</label>
                                <input type="text" class="form-control @error('nama_pendaftar') is-invalid @enderror" id="nama_pendaftar" name="nama_pendaftar" value="{{ old('nama_pendaftar') }}" required placeholder="Cth: Budi Setiawan">
                                @error('nama_pendaftar')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nomor_kontak">Nomor Kontak</label>
                                <input type="number" class="form-control @error('nomor_kontak') is-invalid @enderror" id="nomor_kontak" name="nomor_kontak" value="{{ old('nomor_kontak') }}" required placeholder="Cth: 0895xxxxxxxx">
                                @error('nomor_kontak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="alamat_pendaftar">Alamat Pendaftar</label>
                                <input type="text" class="form-control" id="alamat_pendaftar" name="alamat_pendaftar" value="{{ old('alamat_pendaftar') }}" required placeholder="Cth: Jl. Prof. M. Yamin Gg. Amanah No.12">
                            </div>
                        </div>
                        <div id="resulttipe" class="mt-5">
                        </div>
                    </div>
                    <button class="btn btn-primary btn-sm" type="submit">+ Tambahkan</button>
                </form>
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
        $(document).ready(function () {
            $('#tipe').change(function () {
                var tipe = $(this).val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route("resulttipe") }}',
                    data: {
                        tipe: tipe
                    },
                    success: function (response) {
                        $('#resulttipe').html(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection