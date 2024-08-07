
@if ($listongkir->isEmpty())
    <div class="row justify-content-center mt-5">
        <div class="col-auto text-center">
            <img src="{{ asset('img/no_data.png') }}" alt="" width="200">
            <p><small>Belum ada data cek ongkir yang di tampilkan</small></p>
        </div>
    </div>
@else
    <div class="row" style="max-width: 1000px">
        @foreach ($listongkir as $ongkir)
            <div class="col-sm card" style="max-width: 300px">
                <div class="card-body">
                    <h5 class="card-title text-primary"><b>{{ $ongkir->layanan->nama_layanan }}</b></h5>
                    <small><b>{{ $ongkir->layanan->nama_komoditi }}</b></small>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">{{ "Rp. " . $ongkir->harga_ongkir . "/Kg" }}</li>
                    <li class="list-group-item">{{ "Rp. " . $ongkir->harga_transit . " Transit" }}</li>
                    <li class="list-group-item">{{ "Total Rp. " . ($kg * $ongkir->harga_ongkir) + $ongkir->harga_transit }}</li>
                    <li class="list-group-item text-danger">{{ "Estimasi " . $ongkir->estimasi }}</li>
                </ul>
            </div>
        @endforeach
    </div>
@endif