@if ($result == 'perusahaan')
    <div class="form-group">
        <label for="nama_perusahaan">Nama Perusahaan</label>
        <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" required placeholder="Cth: PT. Borneo Citra Express">
    </div>
    <div class="form-group">
        <label for="nama_pemimpin_perusahaan">Nama Pemimpin Perusahaan</label>
        <input type="text" class="form-control" id="nama_pemimpin_perusahaan" name="nama_pemimpin_perusahaan" required placeholder="Cth: Arya Bagus">
    </div>
    <div class="form-group">
        <label for="alamat_perusahaan">Alamat Perusahaan</label>
        <input type="text" class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" required placeholder="Cth: Jl. Ahmad Yani Ruko No.124">
    </div>
    <div class="form-group">
        <label for="kategori_perusahaan">Kategori Perusahaan</label>
        <select class="form-control" id="kategori_perusahaan" name="kategori_perusahaan" required>
            <option value="">Pilih</option>
        </select>
    </div>
@elseif ($result == 'customer priority')
    <div class="form-group">
        <label for="nama_toko">Nama Toko</label>
        <input type="text" class="form-control" id="nama_toko" name="nama_toko" required placeholder="Cth: Toko Jaya Abadi">
    </div>
@else
@endif