<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAsetMutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_mutasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aset');
            $table->foreign('id_aset')->references('id')->on('aset');
            $table->integer('id_user')->nullable();

            $table->unsignedBigInteger('lokasi_awal');
            $table->foreign('lokasi_awal')->references('id')->on('aset_ruangan');

            $table->unsignedBigInteger('lokasi_tujuan');
            $table->foreign('lokasi_tujuan')->references('id')->on('aset_ruangan');

            $table->integer('kondisi')->nullable();
            $table->integer('kondisi_awal');
            $table->longText('ket')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aset_mutasi');
    }
}
