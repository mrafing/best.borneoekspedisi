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
        Schema::create('tb_pengirim', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nama_pengirim');
            $table->string('nama_perusahaan_pengirim')->nullable();
            $table->string('alamat_pengirim');
            $table->string('id_kecamatan_pengirim');
            $table->string('no_pengirim');
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
        Schema::dropIfExists('tb_pengirim');
    }
};
