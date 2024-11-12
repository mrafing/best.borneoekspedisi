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
        Schema::create('tb_karung', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('no_karung');
            $table->string('no_smu')->nullable();
            $table->string('nama_karung');
            $table->string('id_outlet_asal');
            $table->string('id_outlet_tujuan')->nullable();
            $table->string('kode_karung');
            $table->integer('total_kilo');
            $table->string('status_tracking')->nullable();
            $table->string('pemindai');
            $table->string('status');
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
        Schema::dropIfExists('tb_karung');
    }
};
