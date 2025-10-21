<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKepegawaianIdCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_idcard', function (Blueprint $table) {
            $table->id();

                $table->unsignedInteger('pegawai_id')->comment('ID from Table Users'); // unsignedBigInteger
                $table->foreign('pegawai_id')->references('id')->on('users');

            $table->string('pegawai_nip');
            $table->string('pegawai_nama');
            $table->string('pegawai_panggilan');
            $table->string('pegawai_jabatan');

            $table->integer('progress')->comment('0=pengajuan;1=dalam_proses;2=selesai;3=ditolak');
            $table->date('estimasi')->comment('Estimasi Pengerjaan')->nullable();
            $table->integer('pengajuan')->comment('0=baru;1=ganti');
            $table->longText('alasan')->nullable();
            $table->string('title', 200);
            $table->string('filename', 200);
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
        Schema::dropIfExists('kepegawaian_idcard');
    }
}
