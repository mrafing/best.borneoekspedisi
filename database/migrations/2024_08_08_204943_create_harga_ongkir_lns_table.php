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
        Schema::create('tb_harga_ongkir_ln', function (Blueprint $table) {
            $table->string('id_kota_ln');
            $table->string('id_layanan');
            $table->integer('harga_transit');
            $table->integer('harga_ongkir');
            $table->string('estimasi');
            $table->timestamps();
            $table->primary(['id_kota_ln', 'id_layanan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_harga_ongkir_ln');
    }
};
