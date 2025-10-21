<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableJadwalDinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_jadwal', function (Blueprint $table) {
            $table->id();

                $table->unsignedInteger('pegawai_id')->comment('ID from Table Users');
                $table->foreign('pegawai_id')->references('id')->on('users');

            $table->longText('staf')->comment('Daftar Anggota Jadwal')->nullable();
            $table->longText('bulan');
            $table->longText('tahun');
            $table->longText('keterangan')->nullable();
            $table->integer('progress')->comment('0=ditolak;1=pending;2=diverifikasi;3=divalidasi;');
            $table->integer('valid')->comment('Validation from User Kepegawaian')->nullable();
            $table->dateTime('tgl_valid')->nullable();
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
        Schema::dropIfExists('kepegawaian_jadwal');
    }
}
