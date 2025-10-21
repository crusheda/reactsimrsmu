<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableLaporanBulanan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_laporan_bulanan', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('id_user')->nullable();
            $table->string('judul')->nullable();
            $table->integer('bln')->nullable();
            $table->integer('thn')->nullable();
            $table->string('unit')->nullable();
            $table->string('ket')->nullable();

                $table->string('title', 200)->nullable();
                $table->string('filename', 200)->nullable();
                $table->integer('id_verif')->nullable();
                $table->dateTime('tgl_verif')->nullable();
                $table->longText('ket_verif')->nullable();
                $table->dateTime('tgl_ket_verif')->nullable();

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
        Schema::dropIfExists('berkas_laporan_bulanan');
    }
}
