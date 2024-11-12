{{-- @dd($listlayanan) --}}
@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('operasional.partials.sidebar')

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

                        <form action="{{ URL::to('operasional/manifestinternational/save') }}" method="post">
                            @csrf
                            <!-- INFORMASI PENGIRIM -->
                                <div class="pb-1 mb-3 border-primary" style="border-bottom: 4px solid;"> 
                                    <p class="font-weight-bold text-primary mb-0"><i class="fa-solid fa-user fa-lg"></i> Informasi Pengirim</p>
                                </div>
                                <div class="mb-5">
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for="nama_pengirim" class="form-label"><span class="text-danger">*</span> Nama Pengirim</label>
                                            <input type="text" class="form-control form-control-sm @error('nama_pengirim') is-invalid @enderror" name="nama_pengirim" id="nama_pengirim" value="{{ old('nama_pengirim') }}" required autofocus>
                                            @error('nama_pengirim')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm mb-2">
                                            <label for="outlet_pengiriman" class="form-label">Outlet Pengiriman</label>
                                            <input type="text" class="form-control form-control-sm" name="outlet_pengiriman" id="outlet_pengiriman" value="{{ auth()->user()->outlet->kode_agen }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for="nama_perusahaan_pengirim" class="form-label">Nama Perusahaan</label>
                                            <input type="text" class="form-control form-control-sm @error('nama_perusahaan_pengirim') is-invalid @enderror" name="nama_perusahaan_pengirim" id="nama_perusahaan_pengirim" value="{{ old('nama_perusahaan_pengirim') }}">
                                            @error('nama_perusahaan_pengirim')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <div class="col-sm mb-2">
                                            <label for="no_pengirim" class="form-label"><span class="text-danger">*</span> Nomor Telepon</label>
                                            <input type="text" class="form-control form-control-sm @error('no_pengirim') is-invalid @enderror" name="no_pengirim" id="no_pengirim" value="{{ old('no_pengirim') }}" required>
                                            @error('no_pengirim')
                                                <div id="validationServer03Feedback" class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for="provinsi_pengirim" class="form-label">Provinsi</label>
                                            <input type="text" class="form-control form-control-sm" name="provinsi_pengirim" id="provinsi_pengirim" value="{{ auth()->user()->outlet->kecamatan->kota->provinsi->nama_provinsi }}" readonly>
                                        </div>
                                        <div class="col-sm mb-2">
                                            <label for="kota_pengirim" class="form-label">Kota</label>
                                            <input type="text" class="form-control form-control-sm" name="kota_pengirim" id="kota_pengirim" value="{{ auth()->user()->outlet->kecamatan->kota->nama_kota }}" readonly>
                                            <input type="hidden" id="id_kota_pengirim" value="{{ auth()->user()->outlet->kecamatan->kota->id }}">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm mb-2">
                                            <label for="nama_kecamatan_pengirim" class="form-label">Kecamatan</label>
                                            <input type="text" class="form-control form-control-sm" name="nama_kecamatan_pengirim" id="nama_kecamatan_pengirim" value="{{ auth()->user()->outlet->kecamatan->nama_kecamatan }}" readonly>
                                            <input type="hidden" name="id_kecamatan_pengirim" value="{{ auth()->user()->outlet->kecamatan->id }}">
                                        </div>
                                        <div class="col-sm mb-2">
                                            <label for="alamat_pengirim" class="form-label"><span class="text-danger">*</span> Detail Alamat</label>
                                            <input type="text" class="form-control form-control-sm @error('alamat_pengirim') is-invalid @enderror " name="alamat_pengirim" id="alamat_pengirim" value="{{ old('alamat_pengirim') }}" required>
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
                                        <input type="text" class="form-control form-control-sm @error('nama_penerima') is-invalid @enderror" name="nama_penerima" id="nama_penerima" value="{{ old('nama_penerima') }}" required>
                                        @error('nama_penerima')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm mb-2" id="resultOutletTujuan">
                                        <label for="outlet_tujuan" class="form-label">Outlet Tujuan</label>
                                        <input type="text" class="form-control form-control-sm" name="outlet_tujuan" id="outlet_tujuan" value="" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="nama_perusahaan_penerima" class="form-label">Nama Perusahaan</label>
                                        <input type="text" class="form-control form-control-sm @error('nama_perusahaan_penerima') is-invalid @enderror" name="nama_perusahaan_penerima" id="nama_perusahaan_penerima" value="{{ old('nama_perusahaan_penerima') }}">
                                        @error('nama_perusahaan_penerima')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>                                            
                                        @enderror
                                    </div>
                                    <div class="col-sm mb-2">
                                        <label for="no_penerima" class="form-label"><span class="text-danger">*</span> Nomor Telepon</label>
                                        <input type="text" class="form-control form-control-sm @error('no_penerima') is-invalid @enderror" name="no_penerima" id="no_penerima" value="{{ old('no_penerima') }}" required>
                                        @error('no_penerima')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="negara_penerima" class="form-label"><span class="text-danger">*</span> Negara Tujuan</label>
                                        <select class="form-control  form-control-sm" name="negara_penerima" id="negara_penerima" required>
                                            <option value="">-pilih-</option>
                                            @foreach ( $listnegara as $data )
                                                <option value="{{ $data->id }}">{{ $data->nama_negara }}</option>   
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="id_kota_ln_penerima" class="form-label"><span class="text-danger">*</span> Kota Tujuan</label>
                                        <select class="form-control form-control-sm" name="id_kota_ln_penerima" id="kota_penerima" required>
                                            <option value="" selected>-pilih-</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-sm mb-2">
                                        <label for="alamat_penerima" class="form-label"><span class="text-danger">*</span> Detail Alamat</label>
                                        <textarea class="form-control form-control-sm @error('alamat_penerima') is-invalid @enderror" name="alamat_penerima" id="alamat_penerima" cols="10" rows="1" required>{{ old('alamat_penerima') }}</textarea>
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

                                        @foreach ($listlayanan as $data)
                                            <div class="input-contain-layanan">
                                                <input type="radio" name="id_layanan" value="{{ $data->id }}" disabled>
                                                <div class="radio-layanan-disabled">
                                                    <label><b>{{ $data->nama_layanan }}</b> <br> <small>{{ $data->nama_komoditi }}</small> </label>
                                                </div>
                                            </div>
                                        @endforeach
                              
                                    </div>
                                </div>

                                <input type="hidden" name="id_komoditi" value="KM4">

                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="isi" class="form-label"><span class="text-danger">*</span> Isi Barang</label>
                                        <input type="text" class="form-control form-control-sm @error('isi') is-invalid @enderror" name="isi" id="isi" value="{{ old('isi') }}" required>
                                        @error('isi')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="col-sm mb-2">
                                        <label for="pembayaran" class="form-label"><span class="text-danger">*</span> Metode Pembayaran</label>
                                        <select class="form-control form-control-sm" name="pembayaran" id="pembayaran" required>
                                            <option value="">-pilih-</option>
                                            <option value="CASH" {{ (old('pembayaran')) == 'CASH' ? 'selected' : '' }}>CASH</option>
                                            <option value="TRANSFER" {{ (old('pembayaran')) == 'TRANSFER' ? 'selected' : '' }}>TRANSFER</option>
                                            <option value="TRANSFER (LUNAS)" {{ (old('pembayaran')) == 'TRANSFER (LUNAS)' ? 'selected' : '' }}>TRANSFER (LUNAS)</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm mb-2">
                                        <label for="informasi_tambahan" class="form-label">Informasi Tambahan</label>
                                        <textarea class="form-control form-control-sm @error('informasi_tambahan') is-invalid @enderror " name="informasi_tambahan" id="informasi_tambahan" rows="3">{{ old('informasi_tambahan') }}</textarea>
                                        @error('informasi_tambahan')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm mb-2">
                                        <label for="koli" class="form-label"><span class="text-danger">*</span> Jumlah Koli </label>
                                        <input type="number" min="0" class="form-control form-control-sm" name="koli" id="koli" value="1" required>
                                    </div>
                                </div>

                                <div class="row mb-5" id="resulttabelkoliln">
                                    <div class="col table-responsive">
                                        <p class="mb-0"><small><b>*Note :</b></small></p>
                                        <ul class="mb-0">
                                            <li><p class="mb-0"><small>Ketik nol "0" jika tidak ada</small></p></li>
                                            <li><small>Ketik nol "0" pada berat & volume, jika harga dihitung per koli/Q</small></li>
                                        </ul>
                                        <table class="table table-bordered" style="min-width: 400px; overflow: auto;">
                                            <thead class="table-primary">
                                                <tr>
                                                    <td>Q</td>
                                                    <td>Dimensi (PxLxT)</td>
                                                    <td>Berat Volume</td>
                                                    <td>Berat Barang (Kg)</td>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td class="align-bottom"><p>1</p></td>
                                                    <td class="pt-1 pb-1" style="min-width: 200px;">
                                                        <div class="row justify-content-between">
                                                            <div class="col-4">
                                                                <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Panjang</p></small>
                                                                <input type="number" class="form-control form-control-sm panjang" min="0" id="panjang" value="0" readonly>
                                                            </div>
                                                            <div class="col-4">
                                                                <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Lebar</p></small>
                                                                <input type="number" class="form-control form-control-sm lebar" min="0" id="lebar" value="0" readonly>
                                                            </div>
                                                            <div class="col-4">
                                                                <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Tinggi</p></small>
                                                                <input type="number" class="form-control form-control-sm tinggi" min="0" id="tinggi" value="0" readonly>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td class="pt-1 pb-1">
                                                        <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;"><b>Total PxLxT :</b></p></small>
                                                        <input type="number" class="form-control form-control-sm" min="0" id="sum_volumetrik<?=$i?>" value="0" readonly>
                                                    </td>
                                                    <td class="pt-1 pb-1">
                                                        <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">kg</p></small>
                                                        <input 
                                                            id="sum_aktual"
                                                            class="form-control form-control-sm sum_aktual" 
                                                            type="number" 
                                                            min="0"
                                                            value="0"
                                                            required
                                                            readonly
                                                        >
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2" class="pt-4 pb-4"></td>
                                                    <td class="pt-2 pb-2">
                                                        <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Total Berat Volumetrik</p></small>
                                                        <input type="number" class="form-control form-control-sm" min="0" name="berat_volumetrik" id="berat_volumetrik" value="0" readonly>
                                                    </td>
                                                    <td class="pt-2 pb-2">
                                                        <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Total Berat Aktual</p></small>
                                                        <input type="number" class="form-control form-control-sm" min="0" name="berat_aktual" id="berat_aktual" value="0" readonly>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            <!-- END INFORMASI BARANG KIRIMAN -->

                            <!-- INFORMASI BIAYA -->
                                <div class="pb-1 mb-3 border-primary" style="border-bottom: 4px solid;"> 
                                    <div class="row justify-content-between align-items-end">
                                        <div class="col-sm-auto text-primary text-center">
                                            <p class="font-weight-bold m-0" style="font-size: 1.2em;"><i class="fa-solid fa-money-bill-transfer fa-lg mr-2"></i>Informasi Biaya</p>
                                        </div>
                                        <div class="col-auto">
                                            <button type="button" id="refreshBiaya" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Refresh Informasi Biaya" value="refreshBiaya"><i class="fa-solid fa-rotate"></i> Refresh Biaya</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="resultinformasibiayaln">
                                    <div class="row">
                                        <div class="col-md mb-3">

                                            <label for="" class="form-label">Biaya/Kg*</label>
                                            <div id="resultHargaOngkir">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-primary text-light">Rp</span>
                                                    </div>
                                                    <input type="text" min="0" class="form-control" id="harga_ongkir" name="harga_ongkir" value="0" readonly required>
                                                </div>
                                            </div>

                                            <label for="harga_packing" class="form-label">Biaya Packing</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-light">Rp</span>
                                                </div>
                                                <input type="text" min="0" class="form-control" id="harga_packing" name="harga_packing" value="0" onfocus="totalOngkir(),totalModalOngkir()" onblur="endTotalOngkir(),endTotalModalOngkir(),handleHargaPacking()" oninput="handleHargaPacking()" required readonly>
                                            </div>

                                            <label for="harga_karantina" class="form-label">Biaya Surat Jalan/Karantina</label>
                                            <div class="input-group" id="resultHargaKarantina">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-light">Rp</span>
                                                </div>
                                                <input id="harga_karantina"
                                                    type="text" 
                                                    min="0" 
                                                    class="form-control" 
                                                    name="harga_karantina" 
                                                    value="0"
                                                    required
                                                    readonly
                                                >
                                            </div>

                                            <label for="" class="form-label">Biaya Transit</label>
                                            <div class="input-group mb-3" id="resultHargaTransit">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text bg-primary text-light">Rp</span>
                                                </div>
                                                <input type="text" min="0" class="form-control" id="harga_transit" name="harga_transit" value="0" readonly required>
                                            </div>
                                        
                                        </div>

                                        <div class="col-md mb-3">
                                            <label for="" class="form-label">Total Ongkos Kirim</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-danger text-light">Rp</span>
                                                    </div>
                                                    <input type="text" min="0" class="form-control" id="total_ongkir" name="total_ongkir" value="0" readonly required>
                                                </div>
                                            </div>

                                            <label for="" class="form-label">Total Modal</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-warning text-dark">Rp</span>
                                                    </div>
                                                    <input type="text" min="0" class="form-control" id="total_modal" name="total_modal" value="0" readonly required>
                                                </div>
                                            </div>

                                            <label for="" class="form-label">Laba Kotor</label>
                                            <div>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text bg-primary text-light">Rp</span>
                                                    </div>
                                                    <input type="text" min="0" class="form-control" id="" name="" value="0" readonly required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button class="btn btn-warning w-100 text-dark" type="submit" name="submit" disabled><b>Submit</b></button>
                                        </div>
                                    </div>
                                </div>
                            <!-- END INFORMASI BIAYA -->
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
    <script>
        $(document).ready(function() {
            $('#negara_penerima, #kota_penerima').select2();
        });

        // GET KOTA PENERIMA //
        $(document).ready(function() {
            $('#negara_penerima').on('change', function(){
                var id_negara_penerima = $(this).val();
                if (id_negara_penerima) {
                    $.ajax({
                        url: "{{ URL::to('/operasional/manifestinternational/getkota/') }}/" + id_negara_penerima,
                        type: 'GET',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        dataType: 'json',
                        success: function(data) {
                            if (data) {
                                $('#kota_penerima').empty();
                                $('#kota_penerima').append('<option value="">-pilih-</option>')
                                $.each(data, function(key, listkota) {
                                    $('select[name="id_kota_ln_penerima"]').append(
                                        '<option value="'+ listkota.id +'">' +
                                        listkota.nama_kota_ln + '</option>'
                                    );
                                });
                            } else {
                                $('#kota_penerima').empty();
                            }
                        }
                    })
                } else {
                }
            })
        })

        // RESULT LAYANAN //
        $(document).ready(function () {
            $('#kota_penerima').change(function () {
                var id_kota_penerima = $('#kota_penerima').val();
                $.ajax({
                    type: 'GET',
                    url: '{{ route("resultlayananln") }}',
                    data: {
                        id_kota_penerima: id_kota_penerima,
                    },
                    success: function (response) {
                        $('#resultlayananln').html(response);
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        });
    </script>
@endsection