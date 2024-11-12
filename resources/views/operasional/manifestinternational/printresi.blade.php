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
                                $logoPath = public_path('img/logoborneo.png');
                                $imageData = base64_encode(file_get_contents($logoPath));
                                $imageBase64 = 'data:image/png;base64,' . $imageData;
                                $logo = $imageBase64;
                            @endphp
                            <td style="text-align: center; width: 120px;">
                                <img src="{{ $logo }}" style="width: 104px;">
                            </td>
                            <td style="width: 430px;">
                                <p style="font-size: 32px; font-weight: bolder; text-align: center;">
                                    {{ $data->outlet->kode_agen }} - GW/OVP
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
                                <td rowspan="2" style="background-color: yellow; color: black;">
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
                                        <td><p style="font-size: 12px;">: {{ $data->penerimaLn->nama_penerima }}</p></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 2px;"><p style="font-size: 14px; height: 80px;">Alamat</p></td>
                                        <td><p style="font-size: 12px; height: 80px;">: {{ $data->penerimaLn->alamat_penerima }}</p></td>
                                    </tr>
                                    <tr>
                                        <td style="padding-left: 2px;"><p style="font-size: 14px;">No. Hp</p></td>
                                        <td><p style="font-size: 12px;">: {{ $data->penerimaLn->no_penerima }}</p></td>
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
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkirLn->harga_ongkir }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; margin: 0;">Transit</p>
                                        </td>
                                        <td colspan="2">
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkirLn->harga_transit }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; margin: 0;">Packing</p>
                                        </td>
                                        <td colspan="2">
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkirLn->harga_packing }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p style="font-size: 14px; margin: 0;">Karantina</p>
                                        </td>
                                        <td colspan="2">
                                            <p style="font-size: 14px; margin: 0;">Rp. {{ $data->ongkirLn->harga_karantina }}</p>
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
                            <p style="width: 280px; font-size: 14px; text-align: center;">CS PNK001A : 0812-5695-5705</p>
                        </td>
                        <td><p style="width: 266px; text-align: center; font-size: 14px; color:red;" ><b>Rp. {{ $data->ongkirLn->total_ongkir }}</b></p></td>
                    </tr>
                </table>
                <table border="1" style="width: 100%">
                    <tr>
                        <td style="width: 250px">
                            <div style="border-bottom: 1px solid black ">
                                <p style="font-size: 11px; line-height: 16px;">Jl. Dr. Sutomo No.24</p>
                                <p style="font-size: 11px; margin-bottom: 7px;">0812-5695-5705</p>
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
                                    <td colspan="2"><p style="font-size: 14px; text-align: center;"><b>{{ $data->ongkirLn->pembayaran }}</b></p></td>
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
</body>
</html>
