<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAntigen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelayanan_antigen', function (Blueprint $table) {
            $table->id();
            $table->string('dr_pengirim')->nullable();
            $table->string('pemeriksa')->nullable();
            $table->string('rm')->nullable();
            $table->string('nama')->nullable();
            $table->string('jns_kelamin')->nullable();
            $table->string('umur')->nullable();
            $table->longText('alamat')->nullable();
            $table->dateTime('tgl')->nullable();
            $table->string('hasil')->nullable();
            $table->string('pj')->nullable();
            $table->integer('user_id')->nullable();
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
        Schema::dropIfExists('pelayanan_antigen');
    }
}
