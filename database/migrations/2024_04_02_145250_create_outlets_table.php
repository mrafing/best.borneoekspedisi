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
            $table->foreignUuid('id_mitra');
            $table->string('nama_agen')->unique();
            $table->enum('tipe', ['mitra gw', 'mitra j', 'mitra a', 'mitra b', 'mitra c']);
            $table->string('id_kecamatan');
            $table->text('alamat')->nullable()->default(null);
            $table->string('nama_cs')->nullable()->default(null);
            $table->string('nomor_kontak')->nullable()->default(null);
            $table->text('link_alamat')->nullable()->default(null);
            $table->string('lokasi')->nullable()->default(null);
            $table->string('status_bangunan')->nullable()->default(null);
            $table->string('jenis_bangunan')->nullable()->default(null);
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
