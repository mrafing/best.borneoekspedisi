<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Unduh Manifest</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');
        * {
            font-family: 'Roboto', sans-serif;
            font-size: 6px;
        }
    </style>
</head>
<body>
    <h2 style="text-align: center; color: 3d3d3d;">LAPORAN MANIFEST DOMESTIK</h2>
    <table border="1" cellpadding="10" cellspacing="0">
        <thead style="background-color: blue; color: #ffff;">
            <tr>
                <th><p>NO</p></th>
                <th><p>RESI</p></th>
                <th><p>AGEN</p></th>
                <th><p style="white-space: nowrap">KODE</p></th>
                <th><p>LAYANAN</p></th>
                <th><p>PENGIRIM</p></th>
                <th><p>PENERIMA</p></th>
                <th><p style="width: 120px; ">ALAMAT</p></th>
                <th><p>KOLI</p></th>
                <th><p>BA</p></th>
                <th><p>BV</p></th>
                <th><p>ISI</p></th>
                <th><p>TRANSIT</p></th>
                <th><p>KARANTINA</p></th>
                <th><p>PACKING</p></th>
                <th><p>TOTAL</p></th>
                <th><p>PEMBAYARAN</p></th>
                <th><p>ADMIN</p></th>
                <th><p>TANGGAL</p></th>
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
                    $total_ongkir += $data->ongkir->total_ongkir;      
                @endphp
                <tr>
                    <td><p>{{ $no++ }}</p></td>
                    <td><p>{{ $data->no_resi }}</p></td>
                    <td><p>{{ $data->outlet->kode_agen }}</p></td>
                    <td><p style="white-space: nowrap">{{ $data->pengirim->kecamatan->kota->kode_kota }} - {{ $data->penerima->kecamatan->kota->kode_kota }}</p></td>
                    <td><p>{{ $data->layanan->nama_layanan }}</p></td>
                    <td><p>{{ $data->pengirim->nama_pengirim }}</p></td>
                    <td><p>{{ $data->penerima->nama_penerima }}</p></td>
                    <td><p>{{ $data->penerima->alamat_penerima }} {{ $data->penerima->kecamatan->nama_kecamatan }}, {{ $data->penerima->kecamatan->kota->nama_kota }}</p></td>
                    <td><p>{{ $data->barang->koli }}</p></td>
                    <td><p>{{ $data->barang->berat_aktual }}</p></td>
                    <td><p>{{ $data->barang->berat_volumetrik }}</p></td>
                    <td><p>{{ $data->barang->isi }}</p></td>
                    <td><p>{{ $data->ongkir->harga_transit }}</p></td>
                    <td><p>{{ $data->ongkir->harga_karantina }}</p></td>
                    <td><p>{{ $data->ongkir->harga_packing }}</p></td>
                    <td><p>{{ $data->ongkir->total_ongkir }}</p></td>
                    <td><p>{{ $data->ongkir->pembayaran }}</p></td>
                    <td><p>{{ $data->admin }}</p></td>
                    <td><p>{{ $data->created_at }}</p></td>
                </tr>
            @empty
                <tr>
                    <td colspan="18"><p style="text-align: center">Data Not Found</p></td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <td colspan="8"><p>TOTAL</p></td>
                <td><p style="text-align: center;">{{ $total_koli }} Q</p></td>
                <td><p style="text-align: center;"> {{ $total_kilo }} KG</p></td>
                <td><p style="text-align: center;"> {{ $total_volume }} V</p></td>
                <td colspan="4"></td>
                <td><p style="text-align: center;">Rp. {{ $total_ongkir }}</p></td>
                <td colspan="3"></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>