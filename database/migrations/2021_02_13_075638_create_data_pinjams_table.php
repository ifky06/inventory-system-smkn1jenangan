<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataPinjamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_pinjams', function (Blueprint $table) {
            $table->id();
            $table->string('kode_peminjaman',13);
            $table->string('nama',12);
            $table->unsignedBigInteger('id_barang');
            $table->string('kode_barang',12);
            $table->date('tanggal_pinjam');
            $table->date('tenggat');
            $table->date('tanggal_kembali')->nullable();
            $table->timestamps();

            $table->foreign('id_barang')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('data_pinjams');
    }
}
