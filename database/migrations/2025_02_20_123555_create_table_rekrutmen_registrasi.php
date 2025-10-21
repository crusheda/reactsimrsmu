<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRekrutmenRegistrasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rekrutmen_registrasi', function (Blueprint $table) {
            $table->id();

                $table->unsignedBigInteger('id_pengumuman')->comment('ID from Table Rekrutmen Pengumuman');
                $table->foreign('id_pengumuman')->references('id')->on('rekrutmen_pengumuman')->onDelete('cascade');

            $table->string('email')->nullable();
            $table->string('nama')->comment('Nama Lengkap Sesuai KTP');
            $table->integer('tempat_lahir');
            $table->date('tgl_lahir');
            $table->string('pendidikan')->comment('Pendidikan Terakhir');
            $table->integer('hp');
            $table->longText('sosmed')->nullable();
            $table->longText('alamat_lengkap');

            // TITLE
            $table->string('t_ijazah', 200)->nullable();
            $table->string('t_transkip', 200)->nullable();
            $table->string('t_lamaran', 200)->nullable();
            $table->string('t_sertifikat', 200)->nullable();
            $table->string('t_cv', 200)->nullable();
            $table->string('t_foto', 200)->nullable();

            // PATH - FILENAME
            $table->string('p_ijazah', 200)->nullable();
            $table->string('p_transkip', 200)->nullable();
            $table->string('p_lamaran', 200)->nullable();
            $table->string('p_sertifikat', 200)->nullable();
            $table->string('p_cv', 200)->nullable();
            $table->string('p_foto', 200)->nullable();

            $table->integer('status');
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
        Schema::dropIfExists('rekrutmen_registrasi');
    }
}
