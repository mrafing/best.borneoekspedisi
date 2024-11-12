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

<script>
    // Datatables //
    var table = $('#table').DataTable({
        lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
    });
    table.buttons().container().appendTo( '#manifest_wrapper .col-md-6:eq(0)' );
</script>