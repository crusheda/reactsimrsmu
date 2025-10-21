<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKepegawaianPerjalananDinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_pd', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('User Upload')->nullable();
            $table->longText('pegawai_id')->comment('Pegawai Pelaksana')->nullable();
            $table->integer('jenis')->comment('1:Offline;2:Online')->nullable();
            $table->datetime('tgl')->comment('Waktu Acara')->nullable();
            $table->string('acara')->comment('Nama Acara')->nullable();
            $table->longText('lokasi')->comment('Lokasi Tugas')->nullable();
            $table->string('title', 200)->nullable();
            $table->string('filename', 200)->nullable();
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
        Schema::dropIfExists('kepegawaian_pd');
    }
}
