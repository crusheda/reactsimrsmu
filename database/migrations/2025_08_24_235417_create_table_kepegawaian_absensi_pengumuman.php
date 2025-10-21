<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKepegawaianAbsensiPengumuman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_absensi_pengumuman', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->dateTime('tgl')->comment('Tanggal Terbit')->nullable();
            $table->string('judul')->comment('Subject Pengumuman')->nullable();
            $table->longText('deskripsi')->comment('Isi Pengumuman')->nullable();
            $table->string('title', 200)->comment('Nama File Lampiran')->nullable();
            $table->string('filename', 200)->comment('Path Lampiran')->nullable();
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
        Schema::dropIfExists('kepegawaian_absensi_pengumuman');
    }
}
