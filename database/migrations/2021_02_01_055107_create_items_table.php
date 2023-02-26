<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('kode',12);
            $table->string('nama',30);
            $table->unsignedBigInteger('id_bengkel');
            $table->unsignedBigInteger('id_fund');
            $table->integer('total');
            $table->text('gambar');
            $table->timestamps();

            $table->foreign('id_bengkel')->references('id')->on('bengkels');
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
        Schema::dropIfExists('items');
    }
}
