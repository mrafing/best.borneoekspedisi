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
            $table->uuid('id')->primary();
            $table->enum('tipe', ['perusahaan', 'perorangan', 'customer priority']);
            $table->string('nama_mitra');
            $table->string('nama_pendaftar')->nullable();
            $table->string('nomor_kontak')->nullable();
            $table->string('alamat_pendaftar')->nullable();
            $table->string('nama_perusahaan')->nullable();
            $table->string('nama_pemimpin_perusahaan')->nullable();
            $table->string('alamat_perusahaan')->nullable();
            $table->string('kategori_perusahaan')->nullable();
            $table->string('nama_toko')->nullable();
            $table->string('jenis_produk_toko')->nullable();
            $table->string('alamat_toko')->nullable();
            $table->enum('status', ['accepted', 'rejected', 'waiting']);
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
