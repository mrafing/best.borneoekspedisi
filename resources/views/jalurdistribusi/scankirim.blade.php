{{-- @dd($listmasukoutlet) --}}
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
                    <h5>Scan Update Delivery - <b class="text-danger">Scan Kirim</b></h5>
                      
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
                <form action="{{ URL::to('jalurdistribusi/savescankirim') }}" method="post">
                    @csrf
                    @if (in_array(Auth::user()->outlet->tipe, ['mitra a', 'mitra b', 'mitra c']))
                        <input type="hidden" name="status_tracking" value="scan kirim {{ Auth::user()->outlet->tipe }}">
                    @endif
                    <div class="table-responsive rounded">
                        <table class="table table-bordered table-hover shadow" id="table">
                            <thead>
                                <tr class="bg-secondary text-light">
                                    <th style="white-space: nowrap;"></th>
                                    <th style="white-space: nowrap;"><small>Nomor Resi</small></th>
                                    <th style="white-space: nowrap;"><small>Outlet Asal</small></th>
                                    <th style="white-space: nowrap;"><small>Keterangan</small></th>
                                    <th style="white-space: nowrap;"><small>Status Tracking</small></th>
                                    <th style="white-space: nowrap;"><small>Waktu Masuk</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listmasukoutlet as $data )
                                    <tr>
                                        <td style="white-space: nowrap;"><input type="checkbox" class="checkItem" name="no_resi[]" value="{{ $data->no_resi }}"></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->no_resi }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->id_outlet_asal }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->keterangan }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->status_tracking }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->created_at }}</small></td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="row align-items-end bg-secondary text-light mt-3 rounded">
                        <div class="col-sm-auto my-3">
                            <img src="{{ asset('img/arrow_ltr.png') }}" alt="" class="mr-1">
                            <input type="checkbox" id="checkAll"> Pilih Semua
                        </div>
                        <div class="col-sm-auto my-3">
                            <select class="form-control form-control-sm" style="min-width: 200px;" id="daftar_outlet" name="id_outlet_tujuan" required>
                                <option value="" selected >Tujuan</option>
                                @foreach ($listoutlet as $data)
                                    <option value="{{ $data->id }}">{{ $data->kode_agen }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-auto my-3">
                            <label for="nama_kurir">Kurir/driver</label>
                            <input type="text" class="form-control form-control-sm" id="nama_kurir" name="nama_kurir" placeholder="Cth: Iyan Setiawan" required>
                        </div>
                        <div class="col-sm-auto my-3">
                            <label for="armada">Jenis armada angkutan</label>
                            <input type="text" class="form-control form-control-sm" id="armada" name="armada" placeholder="Cth: Grandmax" required>
                        </div>
                        <div class="col-sm-auto my-3">
                            <label for="plat_armada">Plat armada angkutan</label>
                            <input type="text" class="form-control form-control-sm" id="plat_armada" name="plat_armada" placeholder="Cth: KB 1234 QQ" required>
                        </div>
                        <div class="col-sm-auto my-3">
                            <button type="submit" class="btn btn-success btn-sm">Submit</button>
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
    // Datatables //
    var table = $('#table').DataTable( {
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    table.buttons().container().appendTo( '#manifest_wrapper .col-md-6:eq(0)' );
</script>

<script type="text/javascript">
    $(document).ready(function(){
        // Ketika checkbox checkAll dicentang
        $("#checkAll").click(function(){
            // Semua checkbox dengan class checkItem akan mengikuti status checkAll
            $(".checkItem").prop('checked', this.checked);
        });
        
        // Jika salah satu checkbox dalam daftar dicentang/dilepas
        $(".checkItem").click(function(){
            if($(".checkItem").length == $(".checkItem:checked").length) {
                $("#checkAll").prop('checked', true);
            } else {
                $("#checkAll").prop('checked', false);
            }
        });

        // Select 2 script //
        $(document).ready(function() {
            $('#daftar_outlet').select2();
        });
    });
</script>
@endsection