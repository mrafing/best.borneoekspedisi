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
        Schema::create('tb_tracking', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('id_manifest');
            $table->string('no_resi');
            $table->uuid('id_outlet_asal')->nullable();
            $table->uuid('id_outlet_tujuan')->nullable();
            $table->string('keterangan');
            $table->string('status_tracking');
            $table->string('nama_kurir')->nullable();
            $table->string('armada')->nullable();
            $table->string('plat_armada')->nullable();
            $table->string('pemindai');
            $table->string('status')->nullable();
            $table->string('gambar')->nullable();
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
        Schema::dropIfExists('tb_tracking');
    }
};
