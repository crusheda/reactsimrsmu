<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRekrutmenPengumuman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekrutmen_pengumuman', function (Blueprint $table) {
            $table->id();
            $table->longText('token');
            $table->string('unit')->comment('Nama Unit Kerja/Penempatan')->nullable();
            $table->string('nama')->comment('Nama Kebutuhan');
            $table->integer('jumlah')->comment('Jumlah Kebutuhan');
            $table->longText('kualifikasi')->comment('Kualifikasi Pendidikan');
            $table->longText('tugas')->comment('Uraian Tugas/Jabatan');
            $table->longText('keahlian')->comment('Keahlian Spesifik Yang Diharapkan');
            $table->longText('persyaratan')->comment('Nama Shift');
            $table->integer('umur_min')->comment('Batas Umur Minimal')->nullable();
            $table->integer('umur_max')->comment('Batas Umur Maksimal')->nullable();
            $table->integer('kuota')->comment('Kuota Peserta')->nullable();
            $table->datetime('mulai')->comment('Waktu Rekrutmen Dibuka');
            $table->datetime('selesai')->comment('Waktu Rekrutmen Ditutup');
            $table->string('keterangan')->comment('Optional')->nullable();
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
        Schema::dropIfExists('rekrutmen_pengumuman');
    }
}
