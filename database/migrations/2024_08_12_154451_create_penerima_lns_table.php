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
        Schema::create('tb_penerima_ln', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_penerima');
            $table->string('nama_perusahaan_penerima')->nullable();
            $table->string('alamat_penerima');
            $table->string('id_kota_ln_penerima');
            $table->string('no_penerima');
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
        Schema::dropIfExists('tb_penerima_ln');
    }
};
