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
        Schema::create('tb_void_manifest', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('id_outlet_terima');
            $table->string('id_pengirim');
            $table->string('id_penerima');
            $table->string('id_barang');
            $table->string('id_ongkir');
            $table->string('id_layanan');
            $table->string('keterangan_hapus');
            $table->string('admin');
            $table->string('deleted_by');
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
        Schema::dropIfExists('tb_void_manifest');
    }
};
