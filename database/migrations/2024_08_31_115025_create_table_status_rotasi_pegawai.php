<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStatusRotasiPegawai extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_rotasi', function (Blueprint $table) {
            $table->id();

                $table->unsignedBigInteger('ref_id')->comment('ID from Table Referensi');
                $table->foreign('ref_id')->references('id')->on('referensi');

            $table->integer('user_id');
            $table->integer('pegawai_id');
            $table->string('before')->nullable();
            $table->string('after')->nullable();
            $table->date('tgl_berlaku')->nullable();
            $table->longText('keterangan')->nullable();
            $table->string('title', 200)->nullable();
            $table->string('filename', 200)->nullable();
            $table->integer('valid')->comment('Verify from User Kepegawaian')->nullable();
            $table->dateTime('tgl_valid')->nullable();
            $table->boolean('status')->comment('1=aktif;0=nonaktif');
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
        Schema::dropIfExists('users_rotasi');
    }
}
