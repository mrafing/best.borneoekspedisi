@extends('layouts.main')


@section('container')
{{-- Sidebar --}}
@include('jalurdistribusi.partials.sidebar')

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
            <div class="card border-0 mb-4 p-0">
                <div class="card-body p-0">
                    <p class="text-primary">Jalur Distribusi Pengiriman Barang Domestik & International</p>
                    <h5 class="mb-0">Update Delivery - <b class="text-danger">Scan tanda terima paket</b></h5>
    
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="#">
                        <button class="btn" type="submit" onclick="add();" ></button>
                        <div class="row align-items-center">
                            <div class="col">
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text table-secondary"><i class="fa-solid fa-plus mr-2"></i>Tambah No Resi</span>
                                    </div>
                                    <input class="form-control" maxlength="15" type="text" id="nomor" autofocus autocomplete="off"/>
                                </div>
                            </div>
                        </div>
                    </form>
                    <form action="{{ URL::to('jalurdistribusi/savescanttd') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="border rounded mb-3" style="height: 300px; overflow: auto;">
                            <table class="table">
                                <thead class="table-secondary">
                                    <tr>
                                        <th style="width: 10px;"><p class="mb-0">NO</p></th>
                                        <th><p class="mb-0">NO RESI</p></th>
                                    </tr>
                                </thead>
                                <tbody id="tampil">
                                    <input type="hidden" class='form-control form-control-sm' type='text' name='no_resi[]' readonly>
                                </tbody>
                            </table>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="keterangan" class="form-label"><p class="mb-0">Diterima Oleh : </p></label>
                                <select class="form-control" id="keterangan" name="keterangan" required>
                                    <option value="" selected>Pilih</option>
                                    <option value="Penerima Langsung">Penerima Langsung</option>
                                    <option value="Kerabat/Tetangga">Kerabat/Tetangga</option>
                                </select>
                            </div>
                            <div class="col-md-auto mb-3">
                                <label for="" class="form-label"><p class="mb-0">Unggah Gambar : </p></label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text bg-success"><i class="fa-solid fa-plus text-white"></i></span>
                                    </div>
                                     <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="inputGroupFile01" name="gambar" onchange="previewImage()">
                                        <label class="custom-file-label bg-primary text-white" for="inputGroupFile01">Masukkan Gambar</label>
                                     </div>
                                </div>
                            </div>
                            <div class="col-md-auto mb-3">
                                <img class="img-preview img-fluid mb-3 col-sm-5">
                            </div>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col">
                                <button class="btn btn-success" style="width: 100%;" type="submit" name="submit">Submit</button>
                            </div>
                        </div>
                    </form>

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
<script type="text/javascript">
    var tampung_array = [];
    
    function add() {
        var masukan = document.getElementById('nomor');
        tampung_array.push(masukan.value);
        masukan.value = '';
        show();
        }
        
        function show() {
        var html = '';
        var no = 1;
        for (var i= tampung_array.length - 1; i>=0 ; i--) {
            html += '<tr><td><p class=\'text-center m-0\'>'+ no +'</p></td><td><input class=\'form-control form-control-sm\' type=\'text\' value=\'' + tampung_array[i] + ' \' name=\' no_resi[] \' readonly></td></tr>';
            no++;
        }
        var tampil = document.getElementById('tampil');
        tampil.innerHTML = html;
    }

    function previewImage () {
        const image = document.querySelector('#inputGroupFile01');
        const imgPreview = document.querySelector('.img-preview');

        imgPreview.style.display = 'block';

        const oFReader = new FileReader();
        oFReader.readAsDataURL(image.files[0]);

        oFReader.onload = function(oFREvent) {
            imgPreview.src = oFREvent.target.result;
        }
    }
</script>
@endsection