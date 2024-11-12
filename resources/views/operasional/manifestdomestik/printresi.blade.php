@php
    use Milon\Barcode\Facades\DNS1DFacade;
    use Milon\Barcode\Facades\DNS2DFacade;
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Resi</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: sans-serif;
        }
        table {
            border-collapse: collapse;
        }
        .container {
            position: relative;
            margin: 10px auto;
            width: 600pt;
            height: 274pt;
            border: 1px solid black;
        }
    </style>
</head>
<body>
{{-- LEMBAR PENGIRIM --}}
    <div class="container">
        <div class="lembar-pengirim">
            <div class="header">
                <div>
                    <table border="1" style="width: 100%;">
                        <tr>
                            @php
                                if (in_array($data->id_layanan, ['LY1', 'LY2', 'LY3'])) {
                                    $logoPath = public_path('img/logobce.png');
                                } else {
                                    $logoPath = public_path('img/logoborneo.png');
                                }
                                $imageData = base64_encode(file_get_contents($logoPath));
                                $imageBase64 = 'data:image/png;base64,' . $imageData;
                                $logo = $imageBase64;
                            @endphp
                            <td style="text-align: center; width: 120px;">
                                @if (in_array($data->id_layanan, ['LY1', 'LY2', 'LY3']))
                                    <img src="{{ $logo }}" style="width: 104px;">
                                @else
                                    <img src="{{ $logo }}" style="width: 104px;">
                                @endif
                            </td>
                            <td style="width: 430px;">
                                <p style="font-size: 32px; font-weight: bolder; text-align: center;">
                                    {{ $data->outlet->kode_agen }} - 
                                    @if ($data->penerima->kecamatan->outletDelivery)
                                        {{ $data->penerima->kecamatan->outletDelivery->kode_agen }}
                                    @else
                                        {{ $data->penerima->kecamatan->kota->kode_kota}}
                                    @endif
                                </p>
                            </td>
                            <td>
                                <table border="1">
                                    <tr>
                                        <td>
                                            {!! DNS1DFacade::getBarcodeHTML($data->no_resi, 'C128', 2, 45) !!}
                                        </td>
                                    </tr>
                                    <tr>
                                        @php 
                                            $no_resi_utama = $data->no_resi;
                                            $depan_no_resi_utama = substr($no_resi_utama, 0, 6);
                                            $belakang_no_resi_utama = substr($no_resi_utama, -6);
                                        @endphp
                                        <td><p style="text-align: center;"><span>{{ $depan_no_resi_utama }}</span><span style="color: red;">{{ $belakang_no_resi_utama }}</span></p></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <div>
                        <table border=1 style="width: 100%;">
                            <tr>
                                <td style="width: 15%;"><p style="font-size: 7px; padding: 2px 2px;">PT. BORNEO CITRA EXPRESS</p></td>
                                <td style="width: 60%; background-color: blue;"><p style="font-size: 11px; padding: 2px 30px; color: white;">EKSPEDISI PENGIRIMAN BARANG SELURUH INDONESIA & LUAR NEGERI</p></td>
                                <td rowspan="2" 
                                    @if (in_array($data->id_layanan, ['LY1', 'LY2']))
                                        style="background-color: #00008b; color: #fff;"
                                    @elseif(in_array($data->id_layanan, ['LY3']))
                                        style="background-color: green; color: #fff;"
                                    @else
                                        style="background-color: red; color: #fff;"
                                    @endif 
                                >
                                    <p style="text-align: center;"><b>{{ $data->layanan->nama_layanan }}</b></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><p style="padding: 2px 0; text-align: center;"><b>SURAT TANDA TERIMA BARANG</b></p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="body">
                <div style="max-height: 120px; border-bottom: 1px solid black; overflow: hidden;">
                    <table style="width: 800px;">
                        <tr>
                            <td style="width: 250px; border-right: 1px solid black;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="padding-left: 2px; width: 60px;"><p style="font-size: 14px;">Pengirim</p></td>
                                        <td><p style="font-size: 12px;">: {{ $data->pengirim->nama_pengirim }}</p></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 2px;"><p style="font-size: 14px; height: 80px;">Alamat</p></td>
                                        <td><p style="font-size: 12px; height: 80px;">: {{ $data->pengirim->alamat_pengirim }}</p></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 2px;"><p style="font-size: 14px;">No. Hp</p></td>
                                        <td><p style="font-size: 12px;">: {{ $data->pengirim->no_pengirim }}</p></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 280px; border-right: 1px solid black;">
                                <table style="width: 100%;">
                                    <tr>
                                        <td style="padding-left: 2px; width: 64px;"><p style="font-size: 14px;">Penerima</p></td>
                                        <td><p style="font-size: 12px;">: {{ $data->penerima->nama_penerima }}</p></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 2px;"><p style="font-size: 14px; height: 80px;">Alamat</p></td>
                                        <td><p style="font-size: 12px; height: 80px;">: {{ $data->penerima->alamat_penerima }}, KEC {{ $data->penerima->kecamatan->nama_kecamatan }}, {{ $data->penerima->kecamatan->kota->nama_kota }}</p></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 2px;"><p style="font-size: 14px;">No. Hp</p></td>
                                        <td><p style="font-size: 12px;">: {{ $data->penerima->no_penerima }}</p></td>
                                    </tr>
                                </table>
                            </td>
                            <td style="width: 270px;">
                                <table border="1" style="width: 100%; height: 114px;">
                                    <tr>
                                        <td style="width: 135px; height: 24px; background-color: blue; color: white;">
                                            <p style="text-align: center; font-size: 14px; margin: 0;">Koli</p>
                                        </td>
                                        <td colspan="2" style="background-color: blue; color: white;">
                                            <p style="text-align: center; font-size: 14px; margin: 0;">Kilo</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; text-align: center; margin: 0;">{{ $data->barang->koli }} Q</p>
                                        </td>
                                        <td>
                                            <p style="font-size: 14px; text-align: center; margin: 0;">BA : {{ $data->barang->berat_aktual }}</p>
                                        </td>
                                        <td>
                                            <p style="font-size: 14px; text-align: center; margin: 0;">BV : {{ $data->barang->berat_volumetrik }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; margin: 0;">Ongkir / kg</p>
                                        </td>
                                        <td colspan="2">
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkir->harga_ongkir }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; margin: 0;">Transit</p>
                                        </td>
                                        <td colspan="2">
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkir->harga_transit }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; margin: 0;">Packing</p>
                                        </td>
                                        <td colspan="2">
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkir->harga_packing }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; margin: 0;">Karantina</p>
                                        </td>
                                        <td colspan="2">
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkir->harga_karantina }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </td>                            
                        </tr>
                    </table>
                </div>
                <table border="1" style="width: 100%;">
                    <tr>
                        <td><p style="font-size: 12px;"><b>ISI PAKET MENURUT PENGAKUAN : </b> {{ $data->barang->isi }} - {{ $data->layanan->nama_komoditi }}</p></td>
                    </tr>
                </table>
            </div>
            <div class="footer">
                <table border="1">
                    <tr>
                        <td><p style="width: 250px; font-size: 14px; background: blue; color: #fff;"><b>OUTLET PONTIANAK</b></p></td>
                        <td>
                            <p style="width: 280px; font-size: 14px; text-align: center;"> 
                                @if ($data->penerima->kecamatan->outletDelivery)
                                    CS {{ $data->penerima->kecamatan->outletDelivery->kode_agen }} : {{ $data->penerima->kecamatan->outletDelivery->nomor_kontak }}
                                @else
                                    CS PNK001A : 0812-5695-5705
                                @endif
                            </p>
                        </td>
                        <td><p style="width: 266px; text-align: center; font-size: 14px; color:red;" ><b>Rp. {{ $data->ongkir->total_ongkir }}</b></p></td>
                    </tr>
                </table>
                <table border="1" style="width: 100%">
                    <tr>
                        <td style="width: 250px">
                            <div style="border-bottom: 1px solid black ">
                                <p style="font-size: 11px; line-height: 16px;">Jl. Dr. Sutomo No.24</p>
                                <p style="font-size: 11px; margin-bottom: 7px;">0812-5695-5705 / 0813-4783-2877</p>
                            </div>
                            <div>
                                <p style="font-size: 11px; line-height: 16px;">Jl. Veteran No. 06B (Seberang Resto Fajar)</p>
                                <p style="font-size: 11px; margin-bottom: 7px;">0812-8795-7777</p>
                            </div>
                        </td>
                        <td style="width: 280px;">
                            <div style="border-bottom: 1px solid black;">
                                <p style="font-size: 11px; line-height: 16px;">Jl. Bukit Barisan No.22 B (Kantor J&T Cargo)</p>
                                <p style="font-size: 11px; margin-bottom: 7px;">0852-5073-9275</p>
                            </div>
                            <div>
                                <p style="font-size: 11px; line-height: 16px;">Jl.PH Muksin 2, Gg.Kalisari No.5</p>
                                <p style="font-size: 11px; margin-bottom: 7px;">0821-5445-8707</p>
                            </div>
                        </td>
                        <td>
                            <table style="width: 268px; padding-left: 4px;" border="0">
                                <tr>
                                    <td colspan="2"><p style="font-size: 14px; text-align: center;"><b>{{ $data->ongkir->pembayaran }}</b></p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-size: 14px">Admin</p></td>
                                    <td><p style="font-size: 14px">: {{ $data->admin }}</p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-size: 14px">Tanggal</p></td>
                                    <td><p style="font-size: 14px">: {{ date('d M Y', strtotime($data->created_at)) }}</p></td>
                                </tr>
                                <tr>
                                    <td><p style="font-size: 14px">Time</p></td>
                                    <td><p style="font-size: 14px">: {{ date('H:i', strtotime($data->created_at)) }} WIB</p></td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
                <table style="width: 100%;" border="1">
                    <tr>
                        <td><h4 style="background: blue; color:#fff; text-align: center;">ISI BARANG TIDAK DIPERIKSA</h4></td>
                        <td><p style="font-size: 14px; text-align: center;">CEK ONGKIR & POSISI PAKET : WWW.BORNEOEKSPEDISI.COM</p></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <div style=page-break-before:always align="center"><span style="visibility: hidden;">-</span></div>

{{-- LEMBAR PENERIMA --}}
    <div class="container">
        <div class="header">
            <div class="header">
                <div>
                    <table border="1" style="width: 100%;">
                        <tr>
                            @php
                                if (in_array($data->id_layanan, ['LY1', 'LY2', 'LY3'])) {
                                    $logoPath = public_path('img/logobce.png');
                                } else {
                                    $logoPath = public_path('img/logoborneo.png');
                                }
                                $imageData = base64_encode(file_get_contents($logoPath));
                                $imageBase64 = 'data:image/png;base64,' . $imageData;
                                $logo = $imageBase64;
                            @endphp
                            <td style="text-align: center; width: 120px;">
                                @if (in_array($data->id_layanan, ['LY1', 'LY2', 'LY3']))
                                    <img src="{{ $logo }}" style="width: 104px;">
                                @else
                                    <img src="{{ $logo }}" style="width: 104px;">
                                @endif
                            </td>
                            <td style="width: 409px;">
                                <p style="font-size: 32px; font-weight: bolder; text-align: center;">
                                    {{ $data->outlet->kode_agen }} - 
                                    @if ($data->penerima->kecamatan->outletDelivery)
                                        {{ $data->penerima->kecamatan->outletDelivery->kode_agen }}
                                    @else
                                        {{ $data->penerima->kecamatan->kota->kode_kota}}
                                    @endif
                                </p>
                            </td>
                            <td>
                                <table border="1">
                                    <tr>
                                        <td>
                                            <p style="margin-bottom: 5px; margin-top: 2px; padding-left: 2px;"><b>OUTLET DELIVERY</b></p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            @if ($data->penerima->kecamatan->outletDelivery)
                                                <p style="font-size: 13px; margin-bottom: 5px; padding-left: 2px;">{{ $data->penerima->kecamatan->outletDelivery->alamat }} {{ $data->penerima->kecamatan->outletDelivery->kecamatan->kota->nama_kota }}, {{ $data->penerima->kecamatan->outletDelivery->kecamatan->kota->provinsi->nama_provinsi }} </p>
                                            @else
                                                <p style="font-size: 13px; margin-bottom: 5px; padding-left: 2px;">JL. P Natakusuma (Seberang Indomaret pnk) KOTA PONTIANAK, KALIMANTAN BARAT</p>
                                            @endif
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </div>
                <div>
                    <div>
                        <table border=1 style="width: 100%;">
                            <tr>
                                <td style="width: 15%;"><p style="font-size: 7px; padding: 2px 2px;">PT. BORNEO CITRA EXPRESS</p></td>
                                <td style="width: 60%; background-color: blue;"><p style="font-size: 11px; padding: 2px 30px; color: white;">EKSPEDISI PENGIRIMAN BARANG SELURUH INDONESIA & LUAR NEGERI</p></td>
                                <td rowspan="2" 
                                    @if (in_array($data->id_layanan, ['LY1', 'LY2']))
                                        style="background-color: #00008b; color: #fff;"
                                    @elseif(in_array($data->id_layanan, ['LY3']))
                                        style="background-color: green; color: #fff;"
                                    @else
                                        style="background-color: red; color: #fff;"
                                    @endif 
                                >
                                    <p style="text-align: center;"><b>{{ $data->layanan->nama_layanan }}</b></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><p style="padding: 2px 0; text-align: center;"><b>SURAT TANDA TERIMA BARANG</b></p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="body">
            <div style="max-height: 120px; border-bottom: 1px solid black; overflow: hidden;">
                <table style="width: 800px;">
                    <tr>
                        <td style="width: 250px; border-right: 1px solid black;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="padding-left: 2px; width: 60px;"><p style="font-size: 14px;">Pengirim</p></td>
                                    <td><p style="font-size: 12px;">: {{ $data->pengirim->nama_pengirim }}</p></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 2px;"><p style="font-size: 14px; height: 80px;">Alamat</p></td>
                                    <td><p style="font-size: 12px; height: 80px;">: {{ $data->pengirim->alamat_pengirim }}</p></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 2px;"><p style="font-size: 14px;">No. Hp</p></td>
                                    <td><p style="font-size: 12px;">: {{ $data->pengirim->no_pengirim }}</p></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 280px; border-right: 1px solid black;">
                            <table style="width: 100%;">
                                <tr>
                                    <td style="padding-left: 2px; width: 64px;"><p style="font-size: 14px;">Penerima</p></td>
                                    <td><p style="font-size: 12px;">: {{ $data->penerima->nama_penerima }}</p></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 2px;"><p style="font-size: 14px; height: 80px;">Alamat</p></td>
                                    <td><p style="font-size: 12px; height: 80px;">: {{ $data->penerima->alamat_penerima }}, KEC {{ $data->penerima->kecamatan->nama_kecamatan }}, {{ $data->penerima->kecamatan->kota->nama_kota }}</p></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 2px;"><p style="font-size: 14px;">No. Hp</p></td>
                                    <td><p style="font-size: 12px;">: {{ $data->penerima->no_penerima }}</p></td>
                                </tr>
                            </table>
                        </td>
                        <td style="width: 270px;">
                            <table border="1" style="width: 100%; height: 114px;">
                                <tr>
                                    <td style="width: 135px; height: 24px; background-color: blue; color: white;">
                                        <p style="text-align: center; font-size: 14px; margin: 0;">Koli</p>
                                    </td>
                                    <td colspan="2" style="background-color: blue; color: white;">
                                        <p style="text-align: center; font-size: 14px; margin: 0;">Kilo</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height: 88px;">
                                        <p style="font-size: 18px; font-weight: bold; text-align: center; margin: 0;">{{ $data->barang->koli }} Q</p>
                                    </td>
                                    <td>
                                        <p style="font-size: 18px; font-weight: bold; text-align: center; margin: 0;">BA : {{ $data->barang->berat_aktual }}</p>
                                    </td>
                                    <td>
                                        <p style="font-size: 18px; font-weight: bold; text-align: center; margin: 0;">BV : {{ $data->barang->berat_volumetrik }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>                            
                    </tr>
                </table>
            </div>
            <table border="1" style="width: 100%;">
                <tr>
                    <td style="width: 530px"><p style="font-size: 12px;"><b>ISI PAKET MENURUT PENGAKUAN : </b> {{ $data->barang->isi }} - {{ $data->layanan->nama_komoditi }}</p></td>
                    <td><p style="font-size: 14px; text-align: center;"><b>{{ $data->ongkir->pembayaran }}</b></p></td>
                </tr>
            </table>
        </div>
        <div class="footer">
            <table border="1" style="width: 100%">
                <tr>
                    <td colspan="4" style="width: 258px"><p style="font-size: 14px; height: 64px;">Keterangan Tambahan : {{ $data->barang->informasi_tambahan }}</p></td>
                    <td colspan="2" tyle="width: 270px">{!! DNS1DFacade::getBarcodeHTML($data->no_resi, 'C128', 2, 54) !!}</td>
                    <td>
                        <table style="width: 268px; padding-left: 4px;" border="0">
                            <tr>
                                <td><p style="font-size: 14px">Admin</p></td>
                                <td><p style="font-size: 14px">: {{ $data->admin }}</p></td>
                            </tr>
                            <tr>
                                <td><p style="font-size: 14px">Tanggal</p></td>
                                <td><p style="font-size: 14px">: {{ date('d M Y', strtotime($data->created_at)) }}</p></td>
                            </tr>
                            <tr>
                                <td><p style="font-size: 14px">Time</p></td>
                                <td><p style="font-size: 14px">: {{ date('H:i', strtotime($data->created_at)) }} WIB</p></td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td style="width: 60px; height: 30px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                    <td style="width: 60px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                    <td style="width: 70px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                    <td style="width: 60px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                    <td style="width: 96px">
                        <p style="font-size: 10px; text-align:center; color:darkgrey;">TTD + NAMA +</p>
                        <p style="font-size: 10px; text-align:center; color:darkgrey;">CAP PENERIMA</p>
                    </td>
                    <td style="width: 178px">
                        <p style="font-size: 14px; text-align:center;"><span>{{ $depan_no_resi_utama }}</span><span style="color: red;"><b>{{ $belakang_no_resi_utama }}</b></span></p>
                    </td>
                    <td>
                        <p style="font-size: 14px; text-align:center;">
                            CS 
                            @if ($data->penerima->kecamatan->outletDelivery)
                                {{ $data->penerima->kecamatan->outletDelivery->kode_agen }} : {{ $data->penerima->kecamatan->outletDelivery->nomor_kontak }}
                            @else
                                PNK001A : 0812-5695-5705
                            @endif
                        </p>
                    </td>
                </tr>
            </table>
            <table style="width: 100%;" border="1">
                <tr>
                    <td><h4 style="background: blue; color:#fff; text-align: center;">ISI BARANG TIDAK DIPERIKSA</h4></td>
                    <td><p style="font-size: 14px; text-align: center;">CEK ONGKIR & POSISI PAKET : WWW.BORNEOEKSPEDISI.COM</p></td>
                </tr>
            </table>
        </div>
    </div>

{{-- SUB MANIFEST --}}
    @if ($submanifest)
        @foreach ( $submanifest->skip(1) as $sub )
            <div style=page-break-before:always align="center"><span style="visibility: hidden;">-</span></div>
            {{-- LEMBAR PENERIMA --}}
                <div class="container">
                    <div class="header">
                        <div class="header">
                            <div>
                                <table border="1" style="width: 100%;">
                                    <tr>
                                        @php
                                            if (in_array($data->id_layanan, ['LY1', 'LY2', 'LY3'])) {
                                                $logoPath = public_path('img/logobce.png');
                                            } else {
                                                $logoPath = public_path('img/logoborneo.png');
                                            }
                                            $imageData = base64_encode(file_get_contents($logoPath));
                                            $imageBase64 = 'data:image/png;base64,' . $imageData;
                                            $logo = $imageBase64;
                                        @endphp
                                        <td style="text-align: center; width: 120px;">
                                            @if (in_array($data->id_layanan, ['LY1', 'LY2', 'LY3']))
                                                <img src="{{ $logo }}" style="width: 104px;">
                                            @else
                                                <img src="{{ $logo }}" style="width: 104px;">
                                            @endif
                                        </td>
                                        <td style="width: 409px;">
                                            <p style="font-size: 32px; font-weight: bolder; text-align: center;">
                                                {{ $data->outlet->kode_agen }} - 
                                                @if ($data->penerima->kecamatan->outletDelivery)
                                                    {{ $data->penerima->kecamatan->outletDelivery->kode_agen }}
                                                @else
                                                    {{ $data->penerima->kecamatan->kota->kode_kota}}
                                                @endif
                                            </p>
                                        </td>
                                        <td>
                                            <table border="1">
                                                <tr>
                                                    <td>
                                                        <p style="margin-bottom: 5px; margin-top: 2px; padding-left: 2px;"><b>OUTLET DELIVERY</b></p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        @if ($data->penerima->kecamatan->outletDelivery)
                                                            <p style="font-size: 13px; margin-bottom: 5px; padding-left: 2px;">{{ $data->penerima->kecamatan->outletDelivery->alamat }} {{ $data->penerima->kecamatan->outletDelivery->kecamatan->kota->nama_kota }}, {{ $data->penerima->kecamatan->outletDelivery->kecamatan->kota->provinsi->nama_provinsi }} </p>
                                                        @else
                                                            <p style="font-size: 13px; margin-bottom: 5px; padding-left: 2px;">JL. P Natakusuma (Seberang Indomaret pnk) KOTA PONTIANAK, KALIMANTAN BARAT</p>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div>
                                <div>
                                    <table border=1 style="width: 100%;">
                                        <tr>
                                            <td style="width: 15%;"><p style="font-size: 7px; padding: 2px 2px;">PT. BORNEO CITRA EXPRESS</p></td>
                                            <td style="width: 60%; background-color: blue;"><p style="font-size: 11px; padding: 2px 30px; color: white;">EKSPEDISI PENGIRIMAN BARANG SELURUH INDONESIA & LUAR NEGERI</p></td>
                                            <td rowspan="2" 
                                                @if (in_array($data->id_layanan, ['LY1', 'LY2']))
                                                    style="background-color: #00008b; color: #fff;"
                                                @elseif(in_array($data->id_layanan, ['LY3']))
                                                    style="background-color: green; color: #fff;"
                                                @else
                                                    style="background-color: red; color: #fff;"
                                                @endif 
                                            >
                                                <p style="text-align: center;"><b>{{ $data->layanan->nama_layanan }}</b></p>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2"><p style="padding: 2px 0; text-align: center;"><b>SURAT TANDA TERIMA BARANG</b></p></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="body">
                        <div style="max-height: 120px; border-bottom: 1px solid black; overflow: hidden;">
                            <table style="width: 800px;">
                                <tr>
                                    <td style="width: 250px; border-right: 1px solid black;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="padding-left: 2px; width: 60px;"><p style="font-size: 14px;">Pengirim</p></td>
                                                <td><p style="font-size: 12px;">: {{ $data->pengirim->nama_pengirim }}</p></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 2px;"><p style="font-size: 14px; height: 80px;">Alamat</p></td>
                                                <td><p style="font-size: 12px; height: 80px;">: {{ $data->pengirim->alamat_pengirim }}</p></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 2px;"><p style="font-size: 14px;">No. Hp</p></td>
                                                <td><p style="font-size: 12px;">: {{ $data->pengirim->no_pengirim }}</p></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 280px; border-right: 1px solid black;">
                                        <table style="width: 100%;">
                                            <tr>
                                                <td style="padding-left: 2px; width: 64px;"><p style="font-size: 14px;">Penerima</p></td>
                                                <td><p style="font-size: 12px;">: {{ $data->penerima->nama_penerima }}</p></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 2px;"><p style="font-size: 14px; height: 80px;">Alamat</p></td>
                                                <td><p style="font-size: 12px; height: 80px;">: {{ $data->penerima->alamat_penerima }}, KEC {{ $data->penerima->kecamatan->nama_kecamatan }}, {{ $data->penerima->kecamatan->kota->nama_kota }}</p></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-left: 2px;"><p style="font-size: 14px;">No. Hp</p></td>
                                                <td><p style="font-size: 12px;">: {{ $data->penerima->no_penerima }}</p></td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td style="width: 270px;">
                                        <table border="1" style="width: 100%; height: 114px;">
                                            <tr>
                                                <td style="width: 135px; height: 24px; background-color: blue; color: white;">
                                                    <p style="text-align: center; font-size: 14px; margin: 0;">Koli</p>
                                                </td>
                                                <td colspan="2" style="background-color: blue; color: white;">
                                                    <p style="text-align: center; font-size: 14px; margin: 0;">Kilo</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="height: 88px;">
                                                    <p style="font-size: 18px; font-weight: bold; text-align: center; margin: 0;">{{ $data->barang->koli }} Q</p>
                                                </td>
                                                <td>
                                                    <p style="font-size: 18px; font-weight: bold; text-align: center; margin: 0;">BA : {{ $data->barang->berat_aktual }}</p>
                                                </td>
                                                <td>
                                                    <p style="font-size: 18px; font-weight: bold; text-align: center; margin: 0;">BV : {{ $data->barang->berat_volumetrik }}</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>                            
                                </tr>
                            </table>
                        </div>
                        <table border="1" style="width: 100%;">
                            <tr>
                                <td style="width: 530px"><p style="font-size: 12px;"><b>ISI PAKET MENURUT PENGAKUAN : </b> {{ $data->barang->isi }} - {{ $data->layanan->nama_komoditi }}</p></td>
                                <td><p style="font-size: 14px; text-align: center;"><b>{{ $data->ongkir->pembayaran }}</b></p></td>
                            </tr>
                        </table>
                    </div>
                    <div class="footer">
                        <table border="1" style="width: 100%">
                            <tr>
                                <td colspan="3" style="width: 258px"><p style="font-size: 14px; height: 64px;">Keterangan Tambahan : {{ $data->barang->informasi_tambahan }}</p></td>
                                <td colspan="3" tyle="width: 270px">{!! DNS1DFacade::getBarcodeHTML($sub->sub_resi, 'C128', 2, 54) !!}</td>
                                <td>
                                    <table style="width: 268px; padding-left: 4px;" border="0">
                                        <tr>
                                            <td><p style="font-size: 14px">Admin</p></td>
                                            <td><p style="font-size: 14px">: {{ $data->admin }}</p></td>
                                        </tr>
                                        <tr>
                                            <td><p style="font-size: 14px">Tanggal</p></td>
                                            <td><p style="font-size: 14px">: {{ date('d M Y', strtotime($data->created_at)) }}</p></td>
                                        </tr>
                                        <tr>
                                            <td><p style="font-size: 14px">Time</p></td>
                                            <td><p style="font-size: 14px">: {{ date('H:i', strtotime($data->created_at)) }} WIB</p></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 60px; height: 30px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                                <td style="width: 60px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                                <td style="width: 70px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                                <td style="width: 60px;"><p style="font-size: 12px; text-align: center;"> </p></td>
                                <td style="width: 96px">
                                    <p style="font-size: 10px; text-align:center; color:darkgrey;">TTD + NAMA +</p>
                                    <p style="font-size: 10px; text-align:center; color:darkgrey;">CAP PENERIMA</p>
                                </td>
                                <td style="width: 178px">
                                    @php 
                                        $no_resi_sub = $sub->sub_resi; 
                                        $depan_no_resi_sub = substr($no_resi_sub, 0, 6);
                                        $tengah_no_resi_sub = substr($no_resi_sub, 6, 6);
                                        $belakang_no_resi_sub = substr($no_resi_sub, -3);
                                    @endphp
                                    <p style="font-size: 14px; text-align:center;"><span>{{ $depan_no_resi_sub }}</span><span style="color: red"><b>{{ $tengah_no_resi_sub }}</b></span><span>{{ $belakang_no_resi_sub }}</span></p>
                                </td>
                                <td>
                                    <p style="font-size: 14px; text-align:center;">
                                        CS 
                                        @if ($data->penerima->kecamatan->outletDelivery)
                                            {{ $data->penerima->kecamatan->outletDelivery->kode_agen }} : {{ $data->penerima->kecamatan->outletDelivery->nomor_kontak }}
                                        @else
                                            PNK001A : 0812-5695-5705
                                        @endif
                                    </p>
                                </td>
                            </tr>
                        </table>
                        <table style="width: 100%;" border="1">
                            <tr>
                                <td><h4 style="background: blue; color:#fff; text-align: center;">ISI BARANG TIDAK DIPERIKSA</h4></td>
                                <td><p style="font-size: 14px; text-align: center;">CEK ONGKIR & POSISI PAKET : WWW.BORNEOEKSPEDISI.COM</p></td>
                            </tr>
                        </table>
                    </div>
                </div>
        @endforeach
    @endif
</body>
</html>
