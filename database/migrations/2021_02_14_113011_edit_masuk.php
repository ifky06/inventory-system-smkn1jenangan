<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class EditMasuk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('masuks', function (Blueprint $table) {
            // $table->string('keterangan',20)->nullable()
            //     ->after('tanggal');
            $table->dropColumn('jumlah');
        });
        Schema::table('keluars', function (Blueprint $table) {
            // $table->string('keterangan',20)->nullable()
            //     ->after('tanggal');
            $table->dropColumn('jumlah');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
