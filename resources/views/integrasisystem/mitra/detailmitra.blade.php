{{-- @dd($data); --}}
{{-- @dd($listoutlet); --}}
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
                <h6><i class="fa-solid fa-house"></i> / Integrasi System / Mitra / <span class="text-primary">Detail mitra</span></h6>
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

                <form action="{{ URL::to('integrasisystem/mitra/update') }}" method="post">
                    @csrf
                    <input type="hidden" name="id" value="{{ $data->id }}">
                    <div class="row mb-2">
                        <div class="col-lg-6">
                            <div class="form-group row align-items-baseline">
                                <label class="col-4 col-form-label">Tipe mitra</label>
                                <div class="col-7 d-flex">
                                    <p class="mb-0 mr-2">:</p>
                                    <input class="form-control form-control-sm" type="text" name="tipe" value="{{ $data->tipe }}" readonly>
                                </div>
                            </div>
                            <div class="form-group row align-items-baseline">
                                <label class="col-4 col-form-label">Pendaftar</label>
                                <div class="col-7 d-flex">
                                    <p class="mb-0 mr-2">:</p>
                                    <input class="form-control form-control-sm" type="text" name="nama_pendaftar" value="{{ $data->nama_pendaftar }}" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-baseline">
                                <label class="col-4 col-form-label">Nama mitra</label>
                                <div class="col-7 d-flex">
                                    <p class="mb-0 mr-2">:</p>
                                    <input class="form-control form-control-sm" type="text" name="nama_mitra" value="{{ $data->nama_mitra }}" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-baseline">
                                <label class="col-4 col-form-label">Kontak pendaftar</label>
                                <div class="col-7 d-flex">
                                    <p class="mb-0 mr-2">:</p>
                                    <input class="form-control form-control-sm" type="text" name="nomor_kontak" value="{{ $data->nomor_kontak }}" required>
                                </div>
                            </div>
                            <div class="form-group row align-items-baseline">
                                <label class="col-4 col-form-label">Alamat pendaftar</label>
                                <div class="col-7 d-flex">
                                    <p class="mb-0 mr-2">:</p>
                                    <textarea class="form-control" name="alamat_pendaftar" cols="auto">{{ $data->alamat_pendaftar }}</textarea>
                                </div>
                            </div>
                        </div>
                        @if ($data->tipe == "perusahaan")
                            <div class="col-lg-6">
                                <div class="form-group row align-items-baseline">
                                    <label class="col-4 col-form-label">Nama perusahaan</label>
                                    <div class="col-7 d-flex">
                                        <p class="mb-0 mr-2">:</p>
                                        <input class="form-control form-control-sm" type="text" name="nama_perusahaan" value="{{ $data->nama_perusahaan }}" required>
                                    </div>
                                </div>  
                                <div class="form-group row align-items-baseline">
                                    <label class="col-4 col-form-label">Owner perusahaan</label>
                                    <div class="col-7 d-flex">
                                        <p class="mb-0 mr-2">:</p>
                                        <input class="form-control form-control-sm" type="text" name="nama_pemimpin_perusahaan" value="{{ $data->nama_pemimpin_perusahaan }}" required>
                                    </div>
                                </div>  
                                <div class="form-group row align-items-baseline">
                                    <label class="col-4 col-form-label">Alamat perusahaan</label>
                                    <div class="col-7 d-flex">
                                        <p class="mb-0 mr-2">:</p>
                                        <textarea class="form-control" name="alamat_perusahaan">{{ $data->alamat_perusahaan }}</textarea>
                                    </div>
                                </div>  
                                <div class="form-group row align-items-baseline">
                                    <label class="col-4 col-form-label">Kategori perusahaan</label>
                                    <div class="col-7 d-flex">
                                        <p class="mb-0 mr-2">:</p>
                                        <input class="form-control form-control-sm" type="text" name="kategori_perusahaan" value="{{ $data->kategori_perusahaan }}" required>
                                    </div>
                                </div>  
                            </div>
                        @elseif($data->tipe == "customer priority")
                            <div class="col-lg-6">
                                <div class="form-group row align-items-baseline">
                                    <label class="col-4 col-form-label">Nama toko</label>
                                    <div class="col-7 d-flex">
                                        <p class="mb-0 mr-2">:</p>
                                        <input class="form-control form-control-sm" type="text" name="nama_toko" value="{{ $data->nama_toko }}" required>
                                    </div>
                                </div>  
                                <div class="form-group row align-items-baseline">
                                    <label class="col-4 col-form-label">Produk</label>
                                    <div class="col-7 d-flex">
                                        <p class="mb-0 mr-2">:</p>
                                        <input class="form-control form-control-sm" type="text" name="jenis_produk_toko" value="{{ $data->jenis_produk_toko }}" required>
                                    </div>
                                </div>  
                                <div class="form-group row align-items-baseline">
                                    <label class="col-4 col-form-label">Alamat toko</label>
                                    <div class="col-7 d-flex">
                                        <p class="mb-0 mr-2">:</p>
                                        <textarea class="form-control" name="alamat_toko">{{ $data->alamat_toko }}</textarea>
                                    </div>
                                </div>        
                            </div>
                        @endif
                    </div>
                    <button class="col-auto btn btn-primary btn-sm mr-2" type="submit"><i class="fa-solid fa-floppy-disk"></i> Simpan perubahan</button>
                </form>

                <hr>

                {{-- List Outlet --}}
                    <div class="mb-3">
                        <h5>Daftar outlet mitra {{ strtoupper($data->nama_mitra) }}</h5>
                        <a href="{{ URL::to("integrasisystem/mitra/tambahoutlet/$data->id") }}" class="btn btn-secondary btn-sm"><i class="fa-solid fa-plus"></i> Tambah outlet</a>
                    </div>
                    <div id="accordion">
                        @if($listoutlet->count() > 0 )
                            @foreach ( $listoutlet as $outlet )
                                <div class="card mb-3">
                                    <div class="card-header p-0">
                                        <button class="btn d-flex justify-content-between p-3 w-100" data-toggle="collapse" data-target="#collapseOne{{ $outlet->id }}">
                                            <p class="mb-0">Id outlet : {{ $outlet->kode_agen }}</p>
                                            <p class="mb-0">{{ strtoupper($outlet->tipe) }}</p>
                                            <div class="mb-0 align-items-center d-flex">
                                                <i class="fa-solid fa-circle fa-xs mr-1 {{ ($outlet->status === "active") ? 'text-success' : 'text-danger'  }}"></i> 
                                                <p class="mb-0">{{ $outlet->status }}</p>
                                            </div>
                                        </button>
                                    </div>
                            
                                    <div id="collapseOne{{ $outlet->id }}" class="collapse show" data-parent="#accordion">
                                        <div class="card-body">
                                            <form action="{{ URL::to('integrasisystem/mitra/updateoutlet') }}" method="post">
                                                @csrf
                                                <input type="hidden" name="id_outlet" value="{{ $outlet->id }}">
                                                <input type="hidden" name="id_mitra" value="{{ $outlet->id_mitra }}">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Kode Agen</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <input type="text" class="form-control form-control-sm" name="kode_agen" value="{{ $outlet->kode_agen }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Tipe</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <select class="form-control form-control-sm" name="tipe" required>
                                                                    <option value="gw" {{   ($outlet->tipe == "gw") ? 'selected': '' }}>GW</option>
                                                                    <option value="mitra a" {{   ($outlet->tipe == "mitra a") ? 'selected': '' }}>Mitra A</option>
                                                                    <option value="mitra b" {{   ($outlet->tipe == "mitra b") ? 'selected': '' }}>Mitra B</option>
                                                                    <option value="mitra c" {{   ($outlet->tipe == "mitra c") ? 'selected': '' }}>Mitra C</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Alamat</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <textarea class="form-control form-control-sm" name="alamat" required>{{ $outlet->alamat }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Customer Service</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <input type="text" class="form-control form-control-sm" name="nama_cs" value="{{ $outlet->nama_cs }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Kecamatan</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <select class="form-control form-control-sm" name="id_kecamatan" required> 
                                                                    <option value="{{ $outlet->id_kecamatan }}" selected>{{ $outlet->id_kecamatan }}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Kontak Agen</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <input type="text" class="form-control form-control-sm" name="nomor_kontak" value="{{ $outlet->nomor_kontak }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Lokasi</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <select class="form-control form-control-sm" name="lokasi" required>
                                                                <option value="" {{ ($outlet->lokasi == NULL) ? 'selected' : '' }}>Pilih</option>
                                                                    <option value="Mall / Pusat Perbelanjaan" {{ ($outlet->lokasi == 'Mall / Pusat Perbelanjaan') ? 'selected' : '' }}>Mall / Pusat Perbelanjaan</option>
                                                                    <option value="Perkantoran" {{ ($outlet->lokasi == 'Perkantoran') ? 'selected' : '' }}>Perkantoran</option>
                                                                    <option value="Perumahan" {{ ($outlet->lokasi == 'Perumahan') ? 'selected' : '' }}>Perumahan</option>
                                                                    <option value="Jalan Raya / Utama" {{ ($outlet->lokasi == 'Jalan Raya / Utama') ? 'selected' : '' }}>Jalan Raya / Utama</option>
                                                                    <option value="Lainnya" {{ ($outlet->lokasi == 'Lainnya') ? 'selected' : '' }}>Lainnya</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Status Bangunan</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <select class="form-control form-control-sm" name="status_bangunan" required>
                                                                    <option value="" {{ ($outlet->status_bangunan == NULL ? 'selected' : '') }} >Pilih</option>
                                                                    <option value="Milik Sendiri" {{ ($outlet->status_bangunan == 'Milik Sendiri' ? 'selected' : '') }}>Milik Sendiri</option>
                                                                    <option value="Sewa" {{ ($outlet->status_bangunan == 'Sewa' ? 'selected' : '') }}>Sewa</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Jenis Bangunan</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <select class="form-control form-control-sm" name="jenis_bangunan" required>
                                                                    <option value="" {{ ($outlet->jenis_bangunan === NULL) ? 'selected' : '' }}>Pilih</option>
                                                                    <option value="Ruko" {{ ($outlet->jenis_bangunan === 'Ruko') ? 'selected' : '' }}>Ruko</option>
                                                                    <option value="Kios" {{ ($outlet->jenis_bangunan === 'Kios') ? 'selected' : '' }}>Kios</option>
                                                                    <option value="Rumah" {{ ($outlet->jenis_bangunan === 'Rumah') ? 'selected' : '' }}>Rumah</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="form-group row">
                                                            <label class="col-4 col-form-label">Status</label>
                                                            <div class="col-8 d-flex">
                                                                <p class="mb-0 mr-2">:</p>
                                                                <select class="form-control form-control-sm" name="status" required>
                                                                    <option value="active" {{ ($outlet->status === 'active') ? 'selected' : '' }}>active</option>
                                                                    <option value="nonactive" {{ ($outlet->status === 'nonactive') ? 'selected' : '' }}>nonactive</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row p-2 justify-content-end">
                                                    <button class="col-auto btn btn-primary btn-sm mr-2" type="submit"><i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan</button>
                                                    <a href="{{ URL::to("integrasisystem/mitra/hapusoutlet/$outlet->id") }}" class="col-auto btn btn-danger btn-sm mr-2" onclick="return confirm('yakin ingin menghapus Outlet?');"> 
                                                        <i class="fa-solid fa-trash"></i> Hapus Outlet
                                                    </a>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning" role="alert">
                                <p class="my-3">Belum Ada Outlet Yang Terdaftar</p>
                          </div>
                        @endif
                    </div>
                {{-- End --}}
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