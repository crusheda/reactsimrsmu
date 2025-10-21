<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableEruang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eruang', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->unsignedBigInteger('id_ruangan');
            $table->foreign('id_ruangan')->references('id')->on('eruang_ref');
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_selesai')->nullable();
            $table->time('jam_mulai');
            $table->time('jam_selesai')->nullable();
            $table->longText('gizi')->nullable();
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
        Schema::dropIfExists('eruang');
    }
}
