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
                    <h5 class="mb-3">Update Delivery - <b class="text-danger">Scan Kirim Paket Muatan</b></h5>
                      
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

                    <div class="d-flex justify-content-between align-items-end mb-2">
                        <div>
                            <button class="btn btn-sm btn-danger" type="submit" id="pdf">PDF <i class="fa-solid fa-file-pdf"></i></button>
                            <button class="btn btn-sm btn-success" type="submit" name="action" value="excel" disabled>Excel <i class="fa-solid fa-table"></i></button>
                        </div>
                        <div class="ml-5">
                            <button class="btn btn-secondary btn-sm" type="button" data-toggle="collapse" data-target="#collapseFilter" aria-expanded="false">
                                Filter <i class="fa-solid fa-filter"></i>
                            </button>
                        </div>
                    </div>

                    <div class="show collapse mb-3" id="collapseFilter">
                        <div class="card card-body">
                            <div class="row">
                                <div class="col-3 form-group">
                                    <label for=""><small>Tanggal</small></label>
                                    <input type="text" class="form-control form-control-sm" id="tanggal" name="tanggal" value="">
                                </div>
                                <div class="col-3 form-group">
                                    <label for=""><small>Nomor karung</small></label>
                                    <input class="form-control form-control-sm" name="no_karung" id="no_karung" placeholder="Cth: KR1017xxxxxx">
                                </div>
                                <div class="col-3 form-group">
                                    <label for="status"><small>Status</small></label>
                                    <select class="form-control form-control-sm" name="status" id="status">
                                        <option value="">-Pilih-</option>
                                        <option value="dikirim">dikirim</option>
                                        <option value="belum dikirim">belum dikirim</option>
                                    </select>
                                </div>
                                <div class="col-3 form-group">
                                    <label for="status_tracking"><small>Status tracking</small></label>
                                    <select class="form-control form-control-sm" name="status_tracking" id="status_tracking">
                                        <option value="">-Pilih-</option>
                                        <option value="scan masuk karung">scan masuk karung</option>
                                        <option value="scan karung sampai">scan karung sampai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row justify-content-between">
                                <div class="col-auto">
                                    <button class="btn btn-secondary btn-sm" role="button" id="filter">Cek <i class="fa-solid fa-magnifying-glass fa-sm"></i></button>
                                </div>
                                <div class="col-auto">
                                    <a data-toggle="collapse" href="#collapseFilter" aria-expanded="false"><small>Sembunyikan <i class="fa-solid fa-filter"></i></small></a>
                                </div>
                            </div>
                        </div>
                    </div>
                <form action="{{ URL::to('jalurdistribusi/savekirimpaketmuatan') }}" method="post">
                    @csrf
                    <div class="table-responsive rounded" id="filterkirimpaketmuatan">
                        <table class="table table-bordered table-hover shadow" id="table">
                            <thead>
                                <tr class="bg-secondary text-light">
                                    <th style="white-space: nowrap;"></th>
                                    <th style="white-space: nowrap;"><small>Nomor karung</small></th>
                                    <th style="white-space: nowrap;"><small>Nomor grub</small></th>
                                    <th style="white-space: nowrap;"><small>Kode karung</small></th>
                                    <th style="white-space: nowrap;"><small>Total kilo</small></th>
                                    <th style="white-space: nowrap;"><small>Status</small></th>
                                    <th style="white-space: nowrap;"><small>Status tracking</small></th>
                                    <th style="white-space: nowrap;"><small>Tanggal</small></th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($listkarung as $data )
                                    <tr>
                                        <td style="white-space: nowrap;">
                                            <input type="checkbox" class="checkItem" name="no_karung[]" value="{{ $data->no_karung }}">
                                            @if ( $data->status_tracking == "scan masuk karung" && $data->status == "belum dikirim")
                                                {{-- <a class="btn p-0" href=""><i class="fa-solid fa-pen-to-square text-primary"></i></a> --}}
                                                <!-- Trigger Modal -->
                                                <button type="button" class="btn p-0" data-toggle="modal" data-target="#deleteModal{{ $data->no_karung }}">
                                                    <i class="fa-solid fa-trash text-danger"></i>
                                                </button>

                                                {{-- Modal --}}
                                                <div class="modal fade" id="deleteModal{{ $data->no_karung }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>
                                                            <div class="modal-body">
                                                                Apa anda yakin ingin menghapus grub karung?
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                                {{-- <form action="{{ URL::to('jalurdistribusi/hapusscankarung') }}" method="post" style="display:inline;">
                                                                    @csrf
                                                                    @method('delete')
                                                                    <input type="text" name="no_karung" value="{{ $data->no_karung }}">
                                                                    <button class="btn btn-danger" type="submit">Delete</button>
                                                                </form> --}}
                                                                <a class="btn btn-danger" href="{{ URL::to("jalurdistribusi/hapusscankarung") }}/{{ $data->no_karung }}">Hapus</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @else
                                                {{-- <i class="fa-solid fa-pen-to-square text-secondary"></i> --}}
                                                <i class="fa-solid fa-trash text-secondary"></i>
                                            @endif
                                        </td>
                                        <td style="white-space: nowrap;"><small>{{ $data->no_karung }}</small></td>
                                        <td style="white-space: nowrap;"><small>K{{ $data->nama_karung }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->kode_karung }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->total_kilo }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->status }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->status_tracking }}</small></td>
                                        <td style="white-space: nowrap;"><small>{{ $data->created_at }}</small></td>
                                    </tr>
                                @empty
                                    
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="row align-items-end mt-3 bg-secondary text-light rounded">
                        <div class="col-sm-auto my-3">
                            <img src="{{ asset('img/arrow_ltr.png') }}" alt="" class="mr-1">
                            <input type="checkbox" id="checkAll"> Pilih Semua
                        </div>
                        <div class="col-sm-auto my-3">
                            {{-- <label for="tujuan">Tujuan</label> --}}
                            <select class="form-control form-control-sm" style="min-width: 200px" id="tujuan" name="tujuan" required></select>
                        </div>
                        <div class="col-sm-auto my-3">
                            <label for="no_smu">Nomor SMU / resi kapal</label>
                            <input class="form-control form-control-sm" type="text" id="no_smu" name="no_smu" placeholder="Optional">
                        </div>
                        <div class="col-sm-auto my-3">
                            <label for="nama_kurir">Nama vendor / Kurir</label>
                            <input class="form-control form-control-sm" type="text" id="nama_kurir" name="nama_kurir" placeholder="Optional">
                        </div>
                        <div class="col-sm-auto my-3">
                            <label for="armada">Jenis armada angkutan</label>
                            <input class="form-control form-control-sm" type="text" id="armada" name="armada" placeholder="Optional">
                        </div>
                        <div class="col-sm-auto my-3">
                            <label for="plat_armada">Plat armada angkutan</label>
                            <input class="form-control form-control-sm" type="text" id="plat_armada" name="plat_armada" placeholder="Optional">
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
<script>

</script>

<script>
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

        $('#tanggal').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            locale: {
                format: 'YYYY-MM-DD'
            },
        }), 

        // SELECT 2 //
        $('#tujuan').select2({
            placeholder: 'Pilih Tujuan',
            ajax: {
                url : '{{ route("searchtujuankirimpaketmuatan") }}',
                dataType: 'json',
                delay: 250, // Delay sebelum pencarian dimulai
                data: function (params) {
                    return {
                        q: params.term // Kata kunci yang diketik
                    };
                },
                // processResults: function (data) {
                //     // Proses hasil dari response dan tampilkan di select2
                //     return {
                //         results: data.map(function(tujuan) {
                //             return {
                //                 id: tujuan.id,
                //                 text: tujuan.kode_agen
                //             };
                //         })
                //     };
                // },
                processResults: function (data){
                    // Proses hasil dari response JSON
                    const outletsResults = data.outlets.map(function (outlet) {
                        return {
                            id: outlet.id,
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

        // GET FILTER //
        $('#filter').click(function () {
            let tanggal = $('#tanggal').val();
            let no_karung = $('#no_karung').val();
            let status = $('#status').val();
            let status_tracking = $('#status_tracking').val();
            $.ajax({
                type: 'GET',
                url: '{{ route("filterkirimpaketmuatan") }}',
                data: {
                    tanggal : tanggal,
                    no_karung : no_karung,
                    status : status,
                    status_tracking : status_tracking
                },
                success: function (response) {
                    $('#filterkirimpaketmuatan').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
        // END //
    });

    // Datatables //
    var table = $('#table').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });

    // Download Pdf //
    $('#pdf').click(function () {
        let tanggal = $('#tanggal').val();
        // Buat URL dengan query string menggunakan name route
        let url = '{!! route("downloadkarungpdf", ["tanggal" => "__tanggal__"]) !!}';

        // Ganti placeholder dengan nilai yang diambil dari input
        url = url.replace('__tanggal__', tanggal);

        url = decodeURIComponent(url);

        // Arahkan ke URL untuk mengunduh PDF
        window.location.href = url;
    });
    // End //
</script>
@endsection