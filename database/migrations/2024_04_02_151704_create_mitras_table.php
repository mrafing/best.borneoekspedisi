<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_mitra', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->enum('tipe', ['perusahaan', 'perorangan', 'customer priority']);
            $table->enum('status', ['accepted', 'rejected', 'waiting']);
            $table->string('nama_pendaftar')->nullable()->default(null);
            $table->string('nomor_kontak')->nullable()->default(null);
            $table->string('alamat_pendaftar')->nullable()->default(null);
            $table->string('nama_perusahaan')->nullable()->default(null);
            $table->string('nama_pemimpin_perusahaan')->nullable()->default(null);
            $table->string('alamat_perusahaan')->nullable()->default(null);
            $table->string('kategori_perusahaan')->nullable()->default(null);
            $table->string('nama_toko')->nullable()->default(null);
            $table->string('jenis_produk_toko')->nullable()->default(null);
            $table->string('alamat_toko')->nullable()->default(null);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_mitra');
    }
};
