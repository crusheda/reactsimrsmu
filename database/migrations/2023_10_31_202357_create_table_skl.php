<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSkl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pelayanan_skl', function (Blueprint $table) {
            $table->id();
            $table->integer('no_surat')->nullable();
            $table->dateTime('tgl')->nullable();
            $table->string('hari')->nullable();
            $table->string('ibu')->nullable();
            $table->string('ayah')->nullable();
            $table->string('anak')->nullable();
            $table->string('alamat')->nullable();
            $table->string('kelamin')->nullable();
            $table->integer('bb')->nullable();
            $table->integer('tb')->nullable();
            $table->string('user')->nullable();
            $table->string('dr')->nullable();
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
        Schema::dropIfExists('pelayanan_skl');
    }
}
