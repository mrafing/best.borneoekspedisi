@if ($result == 'perusahaan')
    <h5># Tipe Perusahaan</h5>
    <hr>
    <div class="form-group">
        <label for="nama_perusahaan">Nama Perusahaan</label>
        <input type="text" class="form-control form-control-sm" id="nama_perusahaan" name="nama_perusahaan" required placeholder="Cth: PT. Borneo Citra Express">
    </div>
    <div class="form-group">
        <label for="nama_pemimpin_perusahaan">Nama Pemimpin Perusahaan</label>
        <input type="text" class="form-control form-control-sm" id="nama_pemimpin_perusahaan" name="nama_pemimpin_perusahaan" required placeholder="Cth: Arya Bagus">
    </div>
    <div class="form-group">
        <label for="alamat_perusahaan">Alamat Perusahaan</label>
        <input type="text" class="form-control form-control-sm" id="alamat_perusahaan" name="alamat_perusahaan" required placeholder="Cth: Jl. Ahmad Yani Ruko No.124">
    </div>
    <div class="form-group">
        <label for="kategori_perusahaan">Kategori Perusahaan</label>
        <input type="text" class="form-control form-control-sm" id="kategori_perusahaan" name="kategori_perusahaan" required placeholder="Cth: Jasa Pengiriman Barang">
    </div>
@elseif ($result == 'customer priority')
    <h5># Tipe Customer Priority</h5>
    <hr>
    <div class="form-group">
        <label for="nama_toko">Nama Toko</label>
        <input type="text" class="form-control form-control-sm" id="nama_toko" name="nama_toko" required placeholder="Cth: Toko Roti Jaya Abadi">
    </div>
    <div class="form-group">
        <label for="jenis_produk_toko">Jenis Produk Toko</label>
        <input type="text" class="form-control form-control-sm" id="jenis_produk_toko" name="jenis_produk_toko" required placeholder="Cth: Roti">
    </div>
    <div class="form-group">
        <label for="alamat_toko">Alamat Toko</label>
        <input type="text" class="form-control form-control-sm" id="alamat_toko" name="alamat_toko" required placeholder="Cth: Jl. Ahmad Yani Ruko No.124">
    </div>
@else
@endif