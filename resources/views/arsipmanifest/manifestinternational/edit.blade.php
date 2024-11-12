{{-- @dd($listlayanan) --}}
@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('arsipmanifest.partials.sidebar')

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
                <div class="row">
                    <div class="col-7" style="max-width: 700px">
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

                        <form action="{{ URL::to('arsipmanifest/manifestinternational/update') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $data->id }}">
                            <input type="hidden" name="id_pengirim" value="{{ $data->id_pengirim }}">
                            <input type="hidden" name="id_penerima_ln" value="{{ $data->id_penerima_ln }}">
                            <input type="hidden" name="id_barang" value="{{ $data->id_barang }}">
                            <input type="hidden" name="id_ongkir_ln" value="{{ $data->id_ongkir_ln }}">
                            <!-- INFORMASI PENGIRIM -->
                                <div class="pb-1 mb-3 border-primary" style="border-bottom: 4px solid;"> 
                                    <p class="font-weight-bold text-primary mb-0"><i class="fa-solid fa-user fa-lg"></i> Informasi Pengirim</p>
                                </div>
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for="nama_pengirim" class="form-label"><span class="text-danger">*</span> Nama Pengirim</label>
                                            <input type="text" class="form-control form-control-sm @error('nama_pengirim') is-invalid @enderror" name="nama_pengirim" id="nama_pengirim" value="{{ $data->pengirim->nama_pengirim }}" required autofocus>
                                            @error('nama_pengirim')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm mb-2">
                                            <label for="outlet_pengiriman" class="form-label">Outlet Pengiriman</label>
                                            <input type="text" class="form-control form-control-sm" id="outlet_pengiriman" value="{{ $data->outlet->kode_agen }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for="nama_perusahaan_pengirim" class="form-label">Nama Perusahaan</label>
                                            <input type="text" class="form-control form-control-sm @error('nama_perusahaan_pengirim') is-invalid @enderror" name="nama_perusahaan_pengirim" id="nama_perusahaan_pengirim" value="{{ $data->pengirim->nama_perusahaan_pengirim }}">
                                            @error('nama_perusahaan_pengirim')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm mb-2">
                                            <label for="no_pengirim" class="form-label"><span class="text-danger">*</span> Nomor Telepon</label>
                                            <input type="text" class="form-control form-control-sm @error('no_pengirim') is-invalid @enderror" name="no_pengirim" id="no_pengirim" value="{{ $data->pengirim->no_pengirim }}" required>
                                            @error('no_pengirim')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for=""><span class="text-danger">*</span> Kecamatan, Kota asal</label>
                                            <input type="text" class="form-control form-control-sm" value="{{ strtoupper($data->pengirim->kecamatan->kota->provinsi->nama_provinsi) . "/" . strtoupper($data->pengirim->kecamatan->kota->nama_kota) . "/" . strtoupper($data->pengirim->kecamatan->nama_kecamatan) }}" readonly>
                                            {{-- <input type="hidden" name="id_kecamatan_pengirim" value="{{ $data->pengirim->id_kecamatan_pengirim }}"> --}}
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for="alamat_pengirim" class="form-label"><span class="text-danger">*</span> Detail Alamat</label>
                                            <input type="text" class="form-control form-control-sm @error('alamat_pengirim') is-invalid @enderror " name="alamat_pengirim" id="alamat_pengirim" value="{{ $data->pengirim->alamat_pengirim }}" required>
                                            @error('alamat_pengirim')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            <!-- END INFORMASI PENGIRIM -->

                            <!-- INFORMASI PENERIMA -->
                                <div class="pb-1 mb-3 border-primary" style="border-bottom: 4px solid;"> 
                                    <p class="font-weight-bold text-primary mb-0"><i class="fa-solid fa-user fa-lg"></i> Informasi Penerima</p>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="nama_penerima" class="form-label"><span class="text-danger">*</span> Nama Penerima</label>
                                        <input type="text" class="form-control form-control-sm @error('nama_penerima') is-invalid @enderror" name="nama_penerima" id="nama_penerima" value="{{ $data->penerimaLn->nama_penerima }}" required>
                                        @error('nama_penerima')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm mb-2" id="resultOutletTujuan">
                                        <label for="outlet_tujuan" class="form-label">Outlet Tujuan</label>
                                        <input type="text" class="form-control form-control-sm" id="outlet_tujuan" value="" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="nama_perusahaan_penerima" class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control form-control-sm @error('nama_perusahaan_penerima') is-invalid @enderror" name="nama_perusahaan_penerima" id="nama_perusahaan_penerima" value="{{ $data->penerimaLn->nama_perusahaan_penerima }}">
                                        @error('nama_perusahaan_penerima')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>                                            
                                        @enderror
                                    </div>
                                    <div class="col-sm mb-2">
                                        <label for="no_penerima" class="form-label"><span class="text-danger">*</span> Nomor Telepon</label>
                                        <input type="text" class="form-control form-control-sm @error('no_penerima') is-invalid @enderror" name="no_penerima" id="no_penerima" value="{{ $data->penerimaLn->no_penerima }}" required>
                                        @error('no_penerima')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="">Kota, Negara tujuan</label>
                                        <input type="text" class="form-control form-control-sm" value="{{ strtoupper($data->penerimaLn->kotaLn->negaraLn->nama_negara) . "/" . strtoupper($data->penerimaLn->kotaLn->nama_kota_ln) }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm mb-2">
                                        <label for="alamat_penerima" class="form-label"><span class="text-danger">*</span> Detail Alamat</label>
                                        <textarea class="form-control form-control-sm @error('alamat_penerima') is-invalid @enderror" name="alamat_penerima" id="alamat_penerima" cols="10" rows="1" required>{{ $data->penerimaLn->alamat_penerima }}</textarea>
                                        @error('alamat_penerima')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            <!-- END INFORMASI PENERIMA -->

                            <!-- INFORMASI BARANG KIRIMAN -->
                                <div class="pb-1 mb-3 border-primary" style="border-bottom: 4px solid;"> 
                                    <p class="font-weight-bold text-primary mb-0"><i class="fa-solid fa-box-open fa-lg"></i> Informasi Barang Kiriman</p>
                                </div>

                                <div class="container-layanan mb-3" id="resultlayananln">
                                    <div class="radio-group-layanan">
                                            <div class="input-contain-layanan">
                                                <input type="radio" value="{{ $data->id_layanan }}" disabled>
                                                <div class="radio-layanan-disabled">
                                                    <label><b>{{ $data->layanan->nama_layanan }}</b> <br> <small>{{ $data->layanan->nama_komoditi }}</small> </label>
                                                </div>
                                            </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="isi" class="form-label"><span class="text-danger">*</span> Isi Barang</label>
                                        <input type="text" class="form-control form-control-sm @error('isi') is-invalid @enderror" name="isi" id="isi" value="{{ $data->barang->isi }}" required>
                                        @error('isi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm mb-2">
                                        <label for="pembayaran" class="form-label"><span class="text-danger">*</span> Metode Pembayaran</label>
                                        <select class="form-control form-control-sm" name="pembayaran" id="pembayaran" required>
                                            <option value="CASH" {{ ($data->ongkirLn->pembayaran == "CASH") ? 'selected' : '' }} >CASH</option>
                                            <option value="TRANSFER" {{ ($data->ongkirLn->pembayaran == "TRANSFER") ? 'selected' : '' }}>TRANSFER</option>
                                            <option value="TRANSFER (LUNAS)" {{ ($data->ongkirLn->pembayaran == "TRANSFER (LUNAS)") ? 'selected' : '' }}>TRANSFER (LUNAS)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm mb-2">
                                        <label for="informasi_tambahan" class="form-label">Informasi Tambahan</label>
                                        <textarea class="form-control form-control-sm @error('informasi_tambahan') is-invalid @enderror " name="informasi_tambahan" id="informasi_tambahan" rows="3">{{ $data->barang->informasi_tambahan }}</textarea>
                                        @error('informasi_tambahan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            <!-- END INFORMASI BARANG KIRIMAN -->

                            <div class="row">
                                <div class="col-12">
                                    <button class="btn btn-warning w-100 text-dark" type="submit" name="submit"><b>Simpan perubahan</b></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-5">

                    </div>
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
@endsection