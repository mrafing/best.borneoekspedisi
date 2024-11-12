@if ($item_khusus)
    <div class="row">
        <div class="col-md mb-3">
                                    
            <label for="" class="form-label">Biaya/Kg*</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-light">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="harga_ongkir" name="harga_ongkir" value="{{ $resulthargaongkir->harga_ongkir }}" onfocus="biaya()" onblur="endBiaya()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>
            
            <label for="" class="form-label">Harga Modal</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input type="text" min="0" class="form-control" id="harga_modal" name="harga_modal" value="0" onfocus="biaya()" onblur="endBiaya()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
            </div>

            <label for="harga_packing" class="form-label">Biaya Packing</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input type="text" min="0" class="form-control" id="harga_packing" name="harga_packing" value="{{ $resultitemkhusus->harga_packing }}" onfocus="biaya()" onblur="endBiaya()" required>
            </div>

            <label for="harga_karantina" class="form-label">Biaya Surat Jalan/Karantina</label>
            <div class="input-group" id="resultHargaKarantina">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input id="harga_karantina"
                    type="text"
                    min="0" 
                    class="form-control" 
                    name="harga_karantina" 
                    value="0" 
                    onfocus="biaya()" 
                    onblur="endBiaya()"
                    required
                >
            </div>
                                
            <label for="" class="form-label">Biaya Transit</label>
            <div class="input-group mb-3" id="resultHargaTransit">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input type="text" min="0" class="form-control" id="harga_transit" name="harga_transit" value="{{ $resulthargaongkir->harga_transit }}" onfocus="biaya()" onblur="endBiaya()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
            </div>
                
        </div>

        <div class="col-md mb-3">
            <label for="" class="form-label">Total Ongkos Kirim</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-danger text-light">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="total_ongkir" name="total_ongkir" value="{{ ($resulthargaongkir->harga_ongkir * $terberat) + $resulthargaongkir->harga_transit + $resultitemkhusus->harga_packing}}" onfocus="labaKotor()" onblur="endLabaKotor()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>

            <label for="" class="form-label">Total Modal</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-warning text-dark">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="total_modal" name="total_modal" value="0" onfocus="labaKotor()" onblur="endLabaKotor()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>

            <label for="" class="form-label">Laba Kotor</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-light">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="laba_kotor" name="laba_kotor" value="0" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button class="btn btn-warning w-100 text-dark" type="submit"><b>Submit</b></button>
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md mb-3">
                                    
            <label for="" class="form-label">Biaya/Kg*</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-light">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="harga_ongkir" name="harga_ongkir" value="{{ $resulthargaongkir->harga_ongkir }}" onfocus="biaya()" onblur="endBiaya()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>
            
            <label for="" class="form-label">Harga Modal</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input type="text" min="0" class="form-control" id="harga_modal" name="harga_modal" value="0" onfocus="biaya()" onblur="endBiaya()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
            </div>

            <label for="harga_packing" class="form-label">Biaya Packing</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input type="text" min="0" class="form-control" id="harga_packing" name="harga_packing" value="0" onfocus="biaya()" onblur="endBiaya()" required>
            </div>

            <label for="harga_karantina" class="form-label">Biaya Surat Jalan/Karantina</label>
            <div class="input-group" id="resultHargaKarantina">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input id="harga_karantina"
                    type="text" 
                    min="0" 
                    class="form-control" 
                    name="harga_karantina" 
                    value="{{ $resulthargakarantina->harga_karantina * $jumlahitemkomoditi }}" 
                    onfocus="biaya()" 
                    onblur="endBiaya()"
                    required
                >
            </div>
                                
            <label for="" class="form-label">Biaya Transit</label>
            <div class="input-group mb-3" id="resultHargaTransit">
                <div class="input-group-prepend">
                    <span class="input-group-text bg-primary text-light">Rp</span>
                </div>
                <input type="text" min="0" class="form-control" id="harga_transit" name="harga_transit" value="{{ $resulthargaongkir->harga_transit }}" onfocus="biaya()" onblur="endBiaya()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
            </div>
                
        </div>

        <div class="col-md mb-3">
            <label for="" class="form-label">Total Ongkos Kirim</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-danger text-light">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="total_ongkir" name="total_ongkir" value="{{ ($resulthargaongkir->harga_ongkir * $terberat) + ($resulthargakarantina->harga_karantina * $jumlahitemkomoditi) + $resulthargaongkir->harga_transit + $hargapacking}}" onfocus="labaKotor()" onblur="endLabaKotor()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>

            <label for="" class="form-label">Total Modal</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-warning text-dark">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="total_modal" name="total_modal" value="0" onfocus="labaKotor()" onblur="endLabaKotor()" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>

            <label for="" class="form-label">Laba Kotor</label>
            <div>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-light">Rp</span>
                    </div>
                    <input type="text" min="0" class="form-control" id="laba_kotor" name="laba_kotor" value="0" required {{ (Auth::user()->role == "gm") ? '' : 'readonly' }}>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <button class="btn btn-warning w-100 text-dark" type="submit"><b>Submit</b></button>
        </div>
    </div>
@endif

<script>
    // HITUNG INFORMASI BIAYA //
        function biaya() {
            interval = setInterval(function () {
                var strHargaOngkir = document.getElementById('harga_ongkir').value;
                var strHargaModal = document.getElementById('harga_modal').value;
                var strHargaPacking = document.getElementById('harga_packing').value;
                var strHargaKarantina = document.getElementById('harga_karantina').value;
                var strHargaTransit = document.getElementById('harga_transit').value;

                var hargaOngkir = parseInt(strHargaOngkir);
                var hargaModal = parseInt(strHargaModal);
                var hargaTransit = parseInt(strHargaTransit);
                var hargaPacking = parseInt(strHargaPacking);
                var hargaKarantina = parseInt(strHargaKarantina);
                var beratVolumetrik = parseInt(document.getElementById('berat_volumetrik').value);
                var beratAktual = parseInt(document.getElementById('berat_aktual').value);
                var resultBerat = 0;

                if (beratAktual >= beratVolumetrik) {
                    resultBerat = beratAktual;
                } else {
                    resultBerat = beratVolumetrik;
                }

                // TOTAL ONGKIR //
                    sumResultTotalOngkir = (hargaOngkir * resultBerat) + hargaPacking + hargaKarantina + hargaTransit;
                    document.getElementById('total_ongkir').value = sumResultTotalOngkir;
                // END TOTAL ONGKIR //

                // TOTAL MODAL //
                    sumResultTotalModal = (hargaModal * resultBerat) + hargaTransit + hargaKarantina;
                    document.getElementById('total_modal').value = sumResultTotalModal;
                // END TOTAL MODAL //

                // LABA KOTOR //
                    sumResultLabaKotor = sumResultTotalOngkir - sumResultTotalModal;
                    if (sumResultLabaKotor <= 0) {
                        sumResultLabaKotor = 0;
                    }
                    document.getElementById('laba_kotor').value = sumResultLabaKotor;
                // END LABA KOTOR //
            }, 1);
        }

        function endBiaya() {
            clearInterval(interval);
        }

    // END HITUNG INFORMASI BIAYA //
</script>