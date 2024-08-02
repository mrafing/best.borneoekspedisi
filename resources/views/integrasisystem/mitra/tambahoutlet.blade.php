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
            <div class="row align-items-center no-gutters mb-3">
                <div class="col-auto mr-3">
                    <a href="{{ URL::to('integrasisystem/mitra') }}" class="btn btn-primary rounded-circle"><i class="fa-solid fa-chevron-left"></i></a>
                </div>
                <div class="col-auto">
                    <h6 class="mb-0"><b>Mitra</b> / Detail Mitra / Tambah Outlet</h6>
                </div>
            </div>

            <div class="card p-3">
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
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nama Mitra</label>
                                <input class="form-control" type="text" value="{{ $data->nama_mitra }}" readonly>
                                <input type="hidden" name="id_mitra" value="{{ $data->id }}">
                            </div>
                            <div class="form-group">
                                <label>Kode Agen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="kode_agen" value="{{ old('kode_agen') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Tipe <span class="text-danger">*</span></label>
                                <select class="form-control" name="tipe" required>
                                    <option value="">Pilih</option>
                                    <option value="mitra a" {{ old('tipe') == 'mitra a' ? 'selected' : '' }} >Mitra A</option>
                                    <option value="mitra b" {{ old('tipe') == 'mitra b' ? 'selected' : '' }}>Mitra B</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Kecamatan <span class="text-danger">*</span></label>
                                <select class="form-control" id="id_kecamatan" name="id_kecamatan" required>
                                    <option value="">-Pilih-</option>
                                    @foreach ($listkecamatan as $kecamatan )
                                        <option value="{{ $kecamatan->id }}" {{ old('id_kecamatan') == $kecamatan->id ? 'selected' : '' }}>{{ strtoupper($kecamatan->nama_kecamatan) }}, {{ strtoupper(optional($kecamatan->kota)->nama_kota) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Alamat <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="alamat" value="{{ old('alamat') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Nama Customer Service <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nama_cs" value="{{ old('nama_cs') }}" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Nomor Kontak Agen <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="nomor_kontak" value="{{ old('nomor_kontak') }}" required>
                            </div>
                            <div class="form-group">
                                <label>Link Alamat (Google Maps) <span>(Opsional)</span></label>
                                <input type="text" class="form-control" name="link_alamat" value="{{ old('link_alamat') }}" placeholder="Contoh : https://goo.gl/maps/AP2m8djNetQe4PYE9">
                            </div>
                            <div class="form-group">
                                <label>Lokasi <span class="text-danger">*</span></label>
                                <select class="form-control" name="lokasi" required>
                                    <option value="">Pilih</option>
                                    <option value="Mall / Pusat Perbelanjaan" {{ old('lokasi') == 'Mall / Pusat Perbelanjaan' ? 'selected' : '' }}>Mall / Pusat Perbelanjaan</option>
                                    <option value="Perkantoran" {{ old('lokasi') == 'Perkantoran' ? 'selected' : '' }}>Perkantoran</option>
                                    <option value="Perumahan" {{ old('lokasi') == 'Perumahan' ? 'selected' : '' }} >Perumahan</option>
                                    <option value="Jalan Raya / Utama" {{ old('lokasi') == 'Jalan Raya / Utama' ? 'selected' : '' }}>Jalan Raya / Utama</option>
                                    <option value="Lainnya" {{ old('lokasi') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status Bangunan <span class="text-danger">*</span></label>
                                <select class="form-control" name="status_bangunan" required>
                                    <option value="">Pilih</option>
                                    <option value="Milik Sendiri" {{ old('status_bangunan') == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Sewa" {{ old('status_bangunan') == 'Sewa' ? 'selected' : '' }}>Sewa</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Jenis Bangunan <span class="text-danger">*</span></label>
                                <select class="form-control" name="jenis_bangunan" required>
                                    <option value="">Pilih</option>
                                    <option value="Ruko" {{ old('jenis_bangunan') == 'Ruko' ? 'selected' : '' }}>Ruko</option>
                                    <option value="Kios" {{ old('jenis_bangunan') == 'Kios' ? 'selected' : '' }}>Kios</option>
                                    <option value="Rumah" {{ old('jenis_bangunan') == 'Rumah' ? 'selected' : '' }}>Rumah</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <select class="form-control" name="status" required>
                                    <option value="">Pilih</option>
                                    <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="nonactive" {{ old('status') == 'nonactive' ? 'selected' : '' }}>Nonactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-primary btn-sm mr-2" type="submit"><i class="fa-solid fa-plus"></i> Tambah Agen</button>
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
            $('#id_kecamatan').select2();
        });
    </script>
@endsection