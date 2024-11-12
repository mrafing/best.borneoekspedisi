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
        Schema::create('tb_manifest_ln', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_resi')->unique();
            $table->uuid('id_outlet_terima');
            $table->string('id_pengirim');
            $table->string('id_penerima_ln');
            $table->string('id_barang');
            $table->string('id_ongkir_ln');
            $table->string('id_layanan');
            $table->string('admin');
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
        Schema::dropIfExists('tb_manifest_ln');
    }
};
