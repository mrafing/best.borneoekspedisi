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
        Schema::create('trackings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_resi')->unique();
            $table->uuid('id_outlet_asal');
            $table->uuid('id_outlet_tujuan');
            $table->string('keterangan');
            $table->string('status_tracking');
            $table->string('nama_kurir')->nullable();
            $table->string('armada')->nullable();
            $table->string('plat_armada')->nullable();
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
        Schema::dropIfExists('trackings');
    }
};
