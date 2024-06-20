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
        Schema::create('tb_harga_modal', function (Blueprint $table) {
            $table->string('id_kota_asal');
            $table->string('id_kecamatan_tujuan');
            $table->string('id_layanan');
            $table->integer('harga_modal');
            $table->timestamps();
            $table->primary(['id_kota_asal', 'id_kecamatan_tujuan', 'id_layanan']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tb_harga_modal');
    }
};
