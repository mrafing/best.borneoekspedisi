<table class="table table-bordered table-hover shadow" id="manifest">
    <thead>
        <tr class="bg-secondary text-light">
            <th class="bg-secondary border shadow" style="position: sticky; left: 0; z-index: 2;">
                <i class="fa-solid fa-gear"></i>
            </th>
            <th class="bg-secondary border shadow" style="position: sticky; left: 88px; z-index: 2; white-space: nowrap;"><small>Nomor Resi</small></th>
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
            <th style="white-space: nowrap;"><small>Tanggal Terima</small></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($listmanifest as $data)
            <tr>
                <td class="bg-white border shadow" style="position: sticky; left: 0; z-index: 2;">
                    <div class="d-flex">
                        <a href="{{ URL::to("arsipmanifest/manifestinternational/detail/$data->id") }}" class="btn btn-secondary btn-sm mr-1" ><i class="fa-solid fa-circle-info"></i></a>
                        <a href="{{ URL::to("operasional/manifestinternational/printresi/$data->id") }}" class="btn btn-primary btn-sm mr-1" target="_blank" ><i class="fa-solid fa-print fa-sm"></i></a>
                    </div>
                </td>
                <td class="bg-white border shadow" style="position: sticky; left: 88px; z-index: 2; white-space: nowrap;"><small>{{ $data->no_resi }}</small></td>
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
                <td style="white-space: nowrap;"><small>{{ $data->created_at }}</small></td>
            </tr>
        @endforeach
    </tbody>
</table>

<script>
    $(document).ready(function() {
        // Datatables //
        var table = $('#manifest').DataTable( {
            lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            // buttons: [
            //     {
            //         extend: 'pdfHtml5',
            //         orientation: 'landscape',
            //         pageSize: 'Legal',
            //         download: 'open',
            //         className: 'btn-datatables',
            //         exportOptions: {
            //             columns: ':visible'
            //         }
            //     },
            //     {
            //         extend: 'excel',
            //         className: 'btn-datatables',
            //         exportOptions: {
            //             columns: ':visible'
            //         }
            //     },
            //     {
            //         extend: 'colvis',
            //         className: 'btn-datatables'
            //     }
            // ]
        } );
        table.buttons().container().appendTo( '#manifest_wrapper .col-md-6:eq(0)' );
    });
</script>