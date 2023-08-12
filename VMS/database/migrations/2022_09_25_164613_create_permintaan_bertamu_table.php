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
        Schema::create('permintaan_bertamu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_tamu')->unsigned();
            $table->integer('id_admin')->unsigned()->nullable();
            $table->integer('id_front_office')->unsigned()->nullable();
            $table->integer('id_pegawai')->unsigned();
            $table->foreign('id_tamu')->references('id')->on('tamu');
            $table->foreign('id_admin')->references('id')->on('pegawai');
            $table->foreign('id_front_office')->references('id')->on('pegawai');
            $table->foreign('id_pegawai')->references('id')->on('pegawai');
            $table->string('keperluan')->nullable();
            $table->dateTime('waktu_bertamu')->nullable();
            $table->dateTime('waktu_pengiriman')->nullable();
            $table->dateTime('waktu_pemeriksaan')->nullable();
            $table->enum('status', ['BELUM DIPERIKSA','DISETUJUI', 'DITOLAK','KADALUARSA'])->default('BELUM DIPERIKSA');
            $table->integer('batas_waktu')->unsigned();
            $table->string('pesan_ditolak')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permintaan_bertamu');
    }
};
