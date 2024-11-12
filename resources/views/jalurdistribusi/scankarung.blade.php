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
                    <h5 class="mb-0">Update Delivery - <b class="text-danger">Scan Karung</b></h5>
                      
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
                    <form action="{{ URL::to('jalurdistribusi/savescankarung') }}" method="post">
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
                        
                        <div class="row mb-3">
                            <div class="col-md">
                                <label for="nama_karung" class="col-form-label fw-bold">Nomor Grub</label>
                                <input class="form-control form-control-sm" type="number" min="1" name="nama_karung" id="nama_karung" placeholder="Cth: K1" required>
                            </div>

                            <div class="col-md">
                                <label for="kode_karung" class="col-form-label fw-bold" >Kode Karung</label>
                                <select class="form-control form-control-sm" name="kode_karung" id="kode_karung" required></select>
                            </div>
            
                            <div class="col-md">
                                <label for="total_kilo" class="col-form-label fw-bold">Total KG*</label>
                                <input class="form-control form-control-sm" type="number" min="1" name="total_kilo" placeholder="Kg" required>
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

    $(document).ready(function() {
        // SELECT 2 //
        $('#kode_karung').select2({
            placeholder: '-Pilih-',
            ajax: {
                url : '{{ route("searchkodekarung") }}',
                dataType: 'json',
                delay: 250, // Delay sebelum pencarian dimulai
                data: function (params) {
                    return {
                        q: params.term // Kata kunci yang diketik
                    };
                },
                processResults: function (data){
                    // Proses hasil dari response JSON
                    const outletsResults = data.outlets.map(function (outlet) {
                        return {
                            id: outlet.kode_agen,
                            text: outlet.kode_agen // Tampilkan kode agen dari Outlet
                        };
                    });

                    const kotaResults = data.kota.map(function (kota) {
                        return {
                            id: kota.kode_kota,
                            text: kota.nama_kota + " " + "("+ kota.kode_kota +")"// Tampilkan nama kota dari Kota
                        };
                    });

                    // Gabungkan kedua hasil pencarian
                    return {
                        results: [
                            {
                                // text: 'Outlets',
                                children: outletsResults
                            },
                            {
                                // text: 'Kota',
                                children: kotaResults
                            }
                        ]
                    };
                },
                cache: true
            },
            minimumInputLength: 1, // Mulai pencarian setelah mengetik 1 karakter
        });
    });
</script>
@endsection