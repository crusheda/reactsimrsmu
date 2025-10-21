<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePerbaikanIpsrs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('perbaikan_ipsrs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('unit')->nullable();

                $table->string('title_pengaduan', 200)->nullable();
                $table->string('filename_pengaduan', 200)->nullable();

            $table->dateTime('tgl_pengaduan')->nullable();
            $table->string('ket_pengaduan')->nullable();
            $table->dateTime('tgl_diterima')->nullable();
            $table->string('ket_diterima')->nullable();
            $table->dateTime('tgl_dikerjakan')->nullable();
            $table->string('ket_dikerjakan')->nullable();
            $table->dateTime('tgl_selesai')->nullable();
            $table->string('ket_selesai')->nullable();
            $table->string('ket_penolakan')->nullable();

                $table->string('title_selesai', 200)->nullable();
                $table->string('filename_selesai', 200)->nullable();

            $table->dateTime('estimasi')->nullable();
            $table->integer('verifikator_id')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('perbaikan_ipsrs');
    }
}
