{{-- @dd($listmanifest); --}}
@php
    header("Content-type: application/vnd-ms-excel");
    header("Content-Disposition: attachment; filename=LAPORAN MANIFEST INTERNATIONAL.xls");
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Unduh Manifest</title>
</head>
<body>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead>
            <tr>
                <th colspan="19"><h3 style="height: 50px; text-align: center; color: #3d3d3d;">LAPORAN MANIFEST INTERNATIONAL</h3></th>
            </tr>
            <tr>
                <th style="height: 50px; background-color: blue; color: #fff;"><p>NO</p></th>
                <th style="background-color: blue; color: #fff;"><p>RESI</p></th>
                <th style="background-color: blue; color: #fff;"><p>AGEN</p></th>
                <th style="background-color: blue; color: #fff;"><p>KODE</p></th>
                <th style="background-color: blue; color: #fff;"><p>LAYANAN</p></th>
                <th style="background-color: blue; color: #fff;"><p>PENGIRIM</p></th>
                <th style="background-color: blue; color: #fff;"><p>PENERIMA</p></th>
                <th style="background-color: blue; color: #fff;"><p style="width: 300px;">ALAMAT</p></th>
                <th style="background-color: blue; color: #fff;"><p>KOLI</p></th>
                <th style="background-color: blue; color: #fff;"><p>BA</p></th>
                <th style="background-color: blue; color: #fff;"><p>BV</p></th>
                <th style="background-color: blue; color: #fff;"><p>ISI</p></th>
                <th style="background-color: blue; color: #fff;"><p>TRANSIT</p></th>
                <th style="background-color: blue; color: #fff;"><p>KARANTINA</p></th>
                <th style="background-color: blue; color: #fff;"><p>PACKING</p></th>
                <th style="background-color: blue; color: #fff;"><p>TOTAL</p></th>
                <th style="background-color: blue; color: #fff;"><p>PEMBAYARAN</p></th>
                <th style="background-color: blue; color: #fff;"><p>ADMIN</p></th>
                <th style="background-color: blue; color: #fff;"><p>TANGGAL</p></th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
                $total_koli = 0;
                $total_kilo = 0;
                $total_volume = 0;
                $total_ongkir = 0;
            @endphp
            @forelse ( $listmanifest as $data )
                @php
                    $total_koli += $data->barang->koli;        
                    $total_kilo += $data->barang->berat_aktual;
                    $total_volume += $data->barang->berat_volumetrik;
                    $total_ongkir += $data->ongkirLn->total_ongkir;      
                @endphp
                <tr>
                    <td style="vertical-align: middle;"><p>{{ $no++ }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->no_resi }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->outlet->kode_agen }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->penerimaLn->kotaLn->kode_kota_ln }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->layanan->nama_layanan }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->pengirim->nama_pengirim }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->penerimaLn->nama_penerima }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->penerimaLn->alamat_penerima }} {{ $data->penerimaLn->kotaLn->nama_kota_ln }}, {{ $data->penerimaLn->kotaLn->negaraLn->nama_negara }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->barang->koli }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->barang->berat_aktual }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->barang->berat_volumetrik }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->barang->isi }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->ongkirLn->harga_transit }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->ongkirLn->harga_karantina }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->ongkirLn->harga_packing }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->ongkirLn->total_ongkir }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->ongkirLn->pembayaran }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->admin }}</p></td>
                    <td style="vertical-align: middle;"><p>{{ $data->created_at }}</p></td>
                </tr>
            @empty
                <tr>
                    <td colspan="19"><p style="text-align: center;"> DATA NOT FOUND</p></td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8"><p>TOTAL</p></td>
                <td><p style="text-align: center;">{{ $total_koli }} Q</p></td>
                <td><p style="text-align: center;">{{ $total_kilo }} KG</p></td>
                <td><p style="text-align: center;">{{ $total_volume }} V</p></td>
                <td colspan="4"></td>
                <td><p style="text-align: center;">Rp. {{ $total_ongkir }}</p></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>