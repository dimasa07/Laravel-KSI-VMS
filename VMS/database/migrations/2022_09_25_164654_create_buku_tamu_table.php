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
        Schema::create('buku_tamu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_front_office')->unsigned();
            $table->integer('id_permintaan')->unsigned()->unique();
            $table->foreign('id_front_office')->references('id')->on('pegawai');
            $table->foreign('id_permintaan')->references('id')->on('permintaan_bertamu');
            $table->dateTime('check_in')->nullable();
            $table->dateTime('check_out')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku_tamu');
    }
};
