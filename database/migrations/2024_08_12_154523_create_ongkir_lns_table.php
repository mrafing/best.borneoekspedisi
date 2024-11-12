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
        Schema::create('tb_ongkir_ln', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('pembayaran');
            $table->integer('harga_transit');
            $table->integer('harga_karantina');
            $table->integer('harga_packing');
            $table->integer('harga_modal');
            $table->bigInteger('total_modal');
            $table->integer('harga_ongkir');
            $table->bigInteger('total_ongkir');
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
        Schema::dropIfExists('tb_ongkir_ln');
    }
};
