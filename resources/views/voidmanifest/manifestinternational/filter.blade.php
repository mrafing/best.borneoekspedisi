<table class="table table-bordered table-hover shadow" id="table">
    <thead>
        <tr class="bg-secondary text-light">
            <th class="bg-secondary border shadow" style="position: sticky; left: 0; z-index: 2;">
                <i class="fa-solid fa-gear"></i>
            </th>
            <th style="white-space: nowrap;"><small>Nama Pengirim</small></th>
            <th style="white-space: nowrap;"><small>Nama Penerima</small></th>
            <th style="white-space: nowrap;"><small>Tujuan</small></th>
            <th style="white-space: nowrap;"><small>Koli</small></th>
            <th style="white-space: nowrap;"><small>Berat Aktual</small></th>
            <th style="white-space: nowrap;"><small>Berat Volumetrik</small></th>
            <th style="white-space: nowrap;"><small>Isi Barang</small></th>
            <th style="white-space: nowrap;"><small>Harga Transit</small></th>
            <th style="white-space: nowrap;"><small>Harga Karantina</small></th>
            <th style="white-space: nowrap;"><small>Harga Packing</small></th>
            <th style="white-space: nowrap;"><small>Harga Ongkir</small></th>
            <th style="white-space: nowrap;"><small>Total</small></th>
            <th style="white-space: nowrap;"><small>Metode Pembayaran</small></th>
            <th style="white-space: nowrap;"><small>Admin</small></th>
            <th style="white-space: nowrap;"><small>Deleted By</small></th>
            <th style="white-space: nowrap;"><small>Tanggal Void</small></th>
            <th style="white-space: nowrap;"><small>Keterangan</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listvoidmanifest as $data)
            {{-- Delete modal --}}
            <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p class="modal-title" id="deleteModalLabel">Apa anda yakin ingin menghapus resi? resi akan hilang permanen</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                            <form action="{{ URL::to("voidmanifest/manifestinternational/delete") }}" method="post">
                                @csrf
                                @method('delete')
                                <input type="hidden" name="id" value="{{ $data->id }}">
                                <button type="submit" class="btn btn-danger">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <tr>
                <td class="bg-white border shadow" style="position: sticky; left: 0; z-index: 2;">
                    <div class="d-flex">
                        <button type="button" class="btn btn-danger btn-sm mr-1" data-toggle="modal" data-target="#deleteModal{{ $data->id }}"><i class="fa-solid fa-trash-can fa-sm"></i></button>
                    </div>
                </td>
                <td style="white-space: nowrap;"><small>{{ $data->pengirim->nama_pengirim }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->penerimaLn->nama_penerima }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->penerimaLn->kotaLn->nama_kota_ln }}, {{ $data->penerimaLn->kotaLn->negaraLn->nama_negara }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->barang->koli }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->barang->berat_aktual }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->barang->berat_volumetrik }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->barang->isi }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_transit }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_karantina }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_packing }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->harga_ongkir }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->total_ongkir }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->ongkirLn->pembayaran }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->admin }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->deleted_by }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->created_at }}</small></td>
                <td style="white-space: nowrap;"><small>{{ $data->keterangan_hapus }}</small></td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        // Datatables //
        $('#table').DataTable({
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
        });
    });
</script>