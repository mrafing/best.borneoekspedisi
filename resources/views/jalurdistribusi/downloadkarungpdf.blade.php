<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title }}</title>
</head>
<body>
    <h3 style="text-align: center">Grub scan masuk karung</h3>
    <p>{{ \Carbon\Carbon::parse($tanggal)->locale('id')->translatedFormat('l, d F Y') }}</p>
    <table border="1" cellpadding="6" cellspacing="0">
        @foreach ($listkarung as $karung)
        <thead>
            <tr style="background-color: blue; color: white;">
                <th>No</th>
                <th>K{{ $karung->nama_karung }}</th>
                <th>{{ $karung->kode_karung }}</th>
                <th>{{ $karung->no_karung }}</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($karung->DetailKarung as $detail_karung )
                <tr>
                    <td>{{ $no++ }}</td>
                    <td colspan="3">{{ $detail_karung->no_resi }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: center">Total Kg : {{ $karung->total_kilo }} || Total Q : {{ $no-1 }}</td>
            </tr>
        </tfoot>
        @endforeach
    </table>
</body>
</html>

