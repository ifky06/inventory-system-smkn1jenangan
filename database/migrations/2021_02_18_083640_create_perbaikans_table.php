<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePerbaikansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbaikans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_perbaikan',7);
            $table->unsignedBigInteger('id_barang');
            $table->string('kode_barang',12);
            $table->unsignedBigInteger('id_fund');
            $table->date('tanggal_pengajuan');
            $table->date('tanggal_persetujuan');
            $table->timestamps();

            $table->foreign('id_barang')->references('id')->on('items');
            $table->foreign('id_fund')->references('id')->on('funds');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('perbaikans');
    }
}
