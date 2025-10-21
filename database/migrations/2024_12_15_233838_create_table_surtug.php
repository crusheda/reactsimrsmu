<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSurtug extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_surtug', function (Blueprint $table) {
            $table->id();
            $table->longText('pegawai_id')->comment('Pegawai Shared');
            $table->date('tgl')->comment('Tanggal Tugas')->nullable();
            $table->longText('keterangan')->nullable();
            $table->integer('user')->comment('User Uploaded')->nullable();
            $table->string('title', 200)->nullable();
            $table->string('filename', 200)->nullable();
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
        Schema::dropIfExists('kepegawaian_surtug');
    }
}
