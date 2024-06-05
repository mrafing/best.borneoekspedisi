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
        Schema::create('tb_outlet', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_mitra');
            $table->string('kode_agen')->unique();
            $table->enum('tipe', ['gw', 'mitra a', 'mitra b', 'mitra c']);
            $table->string('id_kecamatan');
            $table->string('alamat')->nullable();
            $table->string('nama_cs')->nullable();
            $table->string('nomor_kontak')->nullable();
            $table->text('link_alamat')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('status_bangunan')->nullable();
            $table->string('jenis_bangunan')->nullable();
            $table->enum('status', ['active', 'nonactive']);
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
        Schema::dropIfExists('tb_outlet');
    }
};
