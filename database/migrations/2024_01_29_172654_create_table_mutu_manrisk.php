<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableMutuManrisk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mutu_manrisk', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_user')->nullable();
            $table->string('unit')->nullable();
            $table->string('judul')->nullable();
            $table->integer('bln')->nullable();
            $table->integer('thn')->nullable();
            $table->string('title', 200)->nullable();
            $table->string('filename', 200)->nullable();
            $table->string('keterangan',500)->nullable();
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
        Schema::dropIfExists('mutu_manrisk');
    }
}
