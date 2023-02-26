<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListPinjamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_pinjams', function (Blueprint $table) {
            $table->id();
            $table->string('nama',20);
            $table->unsignedBigInteger('id_barang');
            $table->string('kode_barang',12);
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
        Schema::dropIfExists('list_pinjams');
    }
}
