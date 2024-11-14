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

            <div class="container m-0">
                <h6><i class="fa-solid fa-house"></i> / Integrasi System / Mitra / Detail mitra / <span class="text-primary">Tambah outlet</span></h6>
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

                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong> {{ session('success') }}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form action="{{ URL::to('integrasisystem/mitra/saveoutlet') }}" method="post">
                    @csrf
                    <div class="row mb-3" style="max-width: 700px;">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama mitra</label>
                                <input class="form-control form-control-sm" type="text" value="{{ $data->nama_mitra }}" readonly>
                                <input type="hidden" name="id_mitra" value="{{ $data->id }}">
                            </div>
                            <div class="form-group">
                                <label>Kode agen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm @error('kode_agen') is-invalid @enderror" name="kode_agen" value="{{ old('kode_agen') }}" required>
                                @error('kode_agen')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Tipe <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm @error('tipe') is-invalid @enderror" name="tipe" required>
                                    <option value="">[pilih]</option>
                                    <option value="mitra a" {{ old('tipe') == 'mitra a' ? 'selected' : '' }} >Mitra A</option>
                                    <option value="mitra b" {{ old('tipe') == 'mitra b' ? 'selected' : '' }}>Mitra B</option>
                                </select>
                                @error('tipe')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm @error('id_kecamatan') is-invalid @enderror" id="searchkecamatan" name="id_kecamatan" required></select>
                                @error('id_kecamatan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" required>
                                @error('alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Nama customer service <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm @error('nama_cs') is-invalid @enderror" name="nama_cs" value="{{ old('nama_cs') }}" required>
                                @error('nama_cs')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor kontak agen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control form-control-sm @error('nomor_kontak') is-invalid @enderror" name="nomor_kontak" value="{{ old('nomor_kontak') }}" required>
                                @error('nomor_kontak')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Link alamat (Google maps) <span>(opsional)</span></label>
                                <input type="text" class="form-control form-control-sm @error('link_alamat') is-invalid @enderror" name="link_alamat" value="{{ old('link_alamat') }}" placeholder="Contoh : https://goo.gl/maps/AP2m8djNetQe4PYE9">
                                @error('link_alamat')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Lokasi <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm @error('lokasi') is-invalid @enderror" name="lokasi" required>
                                    <option value="">[pilih]</option>
                                    <option value="Mall / Pusat Perbelanjaan" {{ old('lokasi') == 'Mall / Pusat Perbelanjaan' ? 'selected' : '' }}>Mall / Pusat Perbelanjaan</option>
                                    <option value="Perkantoran" {{ old('lokasi') == 'Perkantoran' ? 'selected' : '' }}>Perkantoran</option>
                                    <option value="Perumahan" {{ old('lokasi') == 'Perumahan' ? 'selected' : '' }} >Perumahan</option>
                                    <option value="Jalan Raya / Utama" {{ old('lokasi') == 'Jalan Raya / Utama' ? 'selected' : '' }}>Jalan Raya / Utama</option>
                                    <option value="Lainnya" {{ old('lokasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('lokasi')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Status bangunan <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm @error('status_bangunan') is-invalid @enderror" name="status_bangunan" required>
                                    <option value="">[pilih]</option>
                                    <option value="Milik Sendiri" {{ old('status_bangunan') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa" {{ old('status_bangunan') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                </select>
                                @error('status_bangunan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Jenis bangunan <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm @error('jenis_bangunan') is-invalid @enderror" name="jenis_bangunan" required>
                                    <option value="">[pilih]</option>
                                    <option value="Ruko" {{ old('jenis_bangunan') == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                                    <option value="Kios" {{ old('jenis_bangunan') == 'Kios' ? 'selected' : '' }}>Kios</option>
                                    <option value="Rumah" {{ old('jenis_bangunan') == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                </select>
                                @error('jenis_bangunan')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control form-control-sm @error('status') is-invalid @enderror" name="status" required>
                                    <option value="">[pilih]</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="nonactive" {{ old('status') == 'nonactive' ? 'selected' : '' }}>Nonactive</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-primary btn-sm mr-2" type="submit"><i class="fa-solid fa-plus"></i> + Tambah outlet</button>
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
        // Search kecamatan //
        $('#searchkecamatan').select2({
            placeholder: '[pilih]',
            ajax: {
                url : '{{ route("searchkecamatan") }}',
                dataType: 'json',
                delay: 250, // Delay sebelum pencarian dimulai
                data: function (params) {
                    return {
                        q: params.term // Kata kunci yang diketik
                    };
                },
                processResults: function (data) {
                    // Proses hasil dari response dan tampilkan di select2
                    return {
                        results: data.results.map(function(item) {
                            return {
                                id: item.id,
                                text: item.text
                            };
                        })
                    };
                },
                cache: true
            },
            minimumInputLength: 1, // Mulai pencarian setelah mengetik 1 karakter
        });
    });
</script>
@endsection