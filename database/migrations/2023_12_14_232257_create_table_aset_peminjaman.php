<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAsetPeminjaman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_peminjaman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aset');
            $table->foreign('id_aset')->references('id')->on('aset');
            $table->integer('id_user')->nullable();
            $table->integer('id_ruangan')->nullable();
            $table->dateTime('tgl_peminjaman')->nullable();
            $table->date('tgl_pengembalian')->nullable();
            $table->integer('penanggungjawab')->nullable();
            $table->longText('kelengkapan')->nullable();
            $table->longText('ket')->nullable();

                $table->string('title')->nullable();
                $table->string('filename')->nullable();

            $table->tinyInteger('status')->nullable()->comment('0: Aset Ready/telah dikembalikan; 1: Aset dalam Peminjaman;');
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
        Schema::dropIfExists('aset_peminjaman');
    }
}
