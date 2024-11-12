@if(in_array($id_komoditi, ['KM1', 'KM2', 'KM3']))
    <label for="" class="form-label">Jumlah Item Komoditi</label>
    <select class="form-control form-control-sm" name="jumlah_item_komoditi" id="jumlah_item_komoditi">
        <option value="1">1 (Satu)</option>
        <option value="2">2 (Dua)</option>
        <option value="3">3 (Tiga)</option>
        <option value="4">4 (Empat)</option>
        <option value="5">5 (Lima)</option>
        <option value="6">6 (Enam)</option>
        <option value="7">7 (Tujuh)</option>
        <option value="8">8 (Delapan)</option>
        <option value="9">9 (Sembilan)</option>
        <option value="10">10 (Sepuluh)</option>
    </select>
@else
    <label for="" class="form-label">Jumlah Item Komoditi</label>
    <input type="text" class="form-control form-control-sm" name="jumlah_item_komoditi" id="jumlah_item_komoditi" placeholder="Tidak Ada" disabled>
@endif