@if ($id_item_khusus)
    @if($detail_ik)
        <div class="col table-responsive">
            <p class="mb-0"><small><b>*Note :</b></small></p>
            <ul class="mb-0">
                <li><p class="mb-0"><small>Ketik nol "0" jika tidak ada</small></p></li>
                <li><small>Ketik nol "0" pada berat & volume, jika harga dihitung per koli/Q</small></li>
            </ul>
            <table class="table table-bordered" style="min-width: 400px; overflow: auto;">
                <thead class="table-primary">
                    <tr>
                        <td>Q</td>
                        <td>Dimensi (PxLxT)</td>
                        <td>Berat Volume</td>
                        <td>Berat Barang (Kg)</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="align-bottom"><p>1</p></td>
                        <td class="pt-1 pb-1" style="min-width: 200px;">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Panjang</p></small>
                                    <input type="number" class="form-control form-control-sm panjang" min="0" id="panjang" value="0" readonly>
                                </div>
                                <div class="col-4">
                                    <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Lebar</p></small>
                                    <input type="number" class="form-control form-control-sm lebar" min="0" id="lebar" value="0" readonly>
                                </div>
                                <div class="col-4">
                                    <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Tinggi</p></small>
                                    <input type="number" class="form-control form-control-sm tinggi" min="0" id="tinggi" value="0" readonly>
                                </div>
                            </div>
                        </td>
                        <td class="pt-1 pb-1">
                            <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;"><b>Total PxLxT : 4000</b></p></small>
                            <input type="number" class="form-control form-control-sm" min="0" id="sum_volumetrik" value="0" readonly>
                        </td>
                        <td class="pt-1 pb-1">
                            <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;"><span class="text-danger">*</span>kg</p></small>
                            <input 
                                id="sum_aktual"
                                class="form-control form-control-sm sum_aktual" 
                                type="number" 
                                min="0"
                                value="{{ $detail_ik->berat_aktual }}"
                                required
                                readonly
                            >
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="pt-4 pb-4"></td>
                        <td class="pt-2 pb-2">
                            <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Total Berat Volumetrik</p></small>
                            <input type="number" class="form-control form-control-sm" min="0" name="berat_volumetrik" id="berat_volumetrik" value="0" readonly>
                        </td>
                        <td class="pt-2 pb-2">
                            <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Total Berat Aktual</p></small>
                            <input type="number" class="form-control form-control-sm" min="0" name="berat_aktual" id="berat_aktual" value="{{ $detail_ik->berat_aktual }}" readonly>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
@else
    <div class="table-responsive col">
        <p class="mb-0"><small><b>*Note :</b></small></p>
        <ul class="mb-0">
            <li><p class="mb-0"><small>Ketik nol "0" jika tidak ada</small></p></li>
            <li><small>Ketik nol "0" pada berat & volume, jika harga dihitung per koli/Q</small></li>
        </ul>
        <table class="table table-bordered" style="min-width: 400px; overflow: auto;">
            <thead class="table-primary">
                <tr>
                    <td>Q</td>
                    <td>Dimensi (PxLxT)</td>
                    <td>Berat Volume</td>
                    <td>Berat Barang (Kg)</td>
                </tr>
            </thead>
            <tbody>
                @for ($i = 1; $i <= $koli; $i++)
                    <tr>
                        <td class="align-bottom"><p><?= $i ?></p></td>
                        <td class="pt-1 pb-1" style="min-width: 200px;">
                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Panjang</p></small>
                                    <input type="number" class="form-control form-control-sm panjang" min="0" id="panjang{{ $i }}" value="0" onfocus="startPlt({{ $i }}),sumVol()" onblur="endPlt(),sumVol()">
                                </div>
                                <div class="col-4">
                                    <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Lebar</p></small>
                                    <input type="number" class="form-control form-control-sm lebar" min="0" id="lebar{{ $i }}" value="0" onfocus="startPlt({{ $i }}),sumVol()" onblur="endPlt(),sumVol()">
                                </div>
                                <div class="col-4">
                                    <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Tinggi</p></small>
                                    <input type="number" class="form-control form-control-sm tinggi" min="0" id="tinggi{{ $i }}" value="0" onfocus="startPlt({{ $i }}),sumVol()" onblur="endPlt(),sumVol()">
                                </div>
                            </div>
                        </td>
                        <td class="pt-1 pb-1">
                            <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;"><b>Total PxLxT: </b></p></small>
                            <input type="number" class="form-control form-control-sm" min="0" id="sum_volumetrik{{ $i }}" value="0" readonly>
                        </td>
                        <td class="pt-1 pb-1">
                            <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;"><span class="text-danger">*</span>kg</p></small>
                            <input 
                                id="sum_aktual<?=$i?>"
                                class="form-control form-control-sm sum_aktual" 
                                type="number" 
                                min="0" 
                                oninput="sumAktual()"
                                required
                            >
                        </td>
                    </tr>
                @endfor
                <tr>
                    <td colspan="2" class="pt-4 pb-4"></td>
                    <td class="pt-2 pb-2">
                        <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Total Berat Volumetrik</p></small>
                        <input type="number" class="form-control form-control-sm" min="0" name="berat_volumetrik" id="berat_volumetrik" value="0" readonly>
                    </td>
                    <td class="pt-2 pb-2">
                        <small><p class="m-0" style="font-size: 10px; color: #3d3d3d;">Total Berat Aktual</p></small>
                        <input type="number" class="form-control form-control-sm" min="0" name="berat_aktual" id="berat_aktual" value="0" readonly>
                    </td>
                </tr>
            </tbody>
        </table>
    </div> 
@endif

@if ($id_layanan === 'LY4')
    <script>
        // HITUNG PLT //
            function startPlt(data) {
                var koli = data;
                interval = setInterval(function(koli){
                    var panjang = parseInt(document.getElementById("panjang"+data).value);
                    var lebar = parseInt(document.getElementById("lebar"+data).value);
                    var tinggi = parseInt(document.getElementById("tinggi"+data).value);
                    sum_volume = panjang * lebar * tinggi / 4000;
                    document.getElementById("sum_volumetrik"+data).value = Math.round(sum_volume);
                }, 1);
            }
            function endPlt() {
                clearInterval(interval);
            }
        // END HITUNG PLT //
    </script>
@else
    <script>
        // HITUNG PLT //
            function startPlt(data) {
                var koli = data;
                interval = setInterval(function(koli){
                    var panjang = parseInt(document.getElementById("panjang"+data).value);
                    var lebar = parseInt(document.getElementById("lebar"+data).value);
                    var tinggi = parseInt(document.getElementById("tinggi"+data).value);
                    sum_volume = panjang * lebar * tinggi / 5000;
                    document.getElementById("sum_volumetrik"+data).value = Math.round(sum_volume);
                }, 1);
            }
            function endPlt() {
                clearInterval(interval);
            }
        // END HITUNG PLT
    </script>
@endif

<script>
    // START HITUNG SUM VOLUMETRIK //
    function sumVol() {
        var koli = <?= $koli ?>;
        var sumVolumetrik = 0;
        for (var i = 1; i <= koli; i++) {
                sumVolumetrik += parseInt(document.getElementById("sum_volumetrik"+i).value);
            }
        document.getElementById("berat_volumetrik").value = sumVolumetrik;
    }
    // END START HITUNG SUM VOLUMETRIK //

    // START HITUNG SUM AKTUAL //
    function sumAktual() {
        var koli = <?= $koli ?>;
        var sumAktual = 0;
        for (var i = 1; i <= koli; i++) {
            sumAktual += parseInt(document.getElementById("sum_aktual"+i).value);
        }
        document.getElementById("berat_aktual").value = sumAktual;
    }
    // END HITUNG SUM AKTUAL //

    // GET INFORMASI BIAYA //
        $('#refreshBiaya').click(function () {
            let id_kota_pengirim = $('#id_kota_pengirim').val();
            let id_kecamatan_penerima = $('#kecamatan_penerima').val();
            let id_layanan = $('input[name="id_layanan"]:checked').val();
            let id_komoditi = $('#komoditi').val();
            let jumlah_item_komoditi = $('#jumlah_item_komoditi').val();
            let id_item_khusus = $('input[name="item_khusus"]:checked').val();
            let bv = $('#berat_volumetrik').val();
            let ba = $('#berat_aktual').val();
            let refreshBiaya = $('#refreshBiaya').val();
            $.ajax({
                type: 'GET',
                url: '{{ route("resultinformasibiaya") }}',
                data: {
                    id_kota_pengirim : id_kota_pengirim,
                    id_kecamatan_penerima: id_kecamatan_penerima,
                    id_layanan: id_layanan,
                    id_komoditi: id_komoditi,
                    jumlah_item_komoditi: jumlah_item_komoditi,
                    id_item_khusus: id_item_khusus,
                    bv: bv,
                    ba: ba,
                    refreshBiaya : refreshBiaya,
                },
                success: function (response) {
                    $('#resultInformasiBiaya').html(response);
                },
                error: function (error) {
                    console.log(error);
                }
            });
        });
    // END GET INFORMASI BIAYA //
</script>
