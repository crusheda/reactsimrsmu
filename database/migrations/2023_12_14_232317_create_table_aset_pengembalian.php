<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAsetPengembalian extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_pengembalian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aset');
            $table->foreign('id_aset')->references('id')->on('aset');
            $table->integer('id_user')->nullable();
            $table->dateTime('tgl_pengembalian')->nullable();
            $table->integer('pengantar')->nullable();
            $table->integer('penerima')->nullable();
            $table->integer('kondisi')->nullable();
            $table->longText('ket')->nullable();

                $table->string('title')->nullable();
                $table->string('filename')->nullable();

            $table->boolean('status')->comment('0: Aset telah dikembalikan; 1: Aset sedang dipinjam;');
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
        Schema::dropIfExists('aset_pengembalian');
    }
}
