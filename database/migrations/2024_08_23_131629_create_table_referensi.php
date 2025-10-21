<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReferensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referensi', function (Blueprint $table) {
            $table->id();
            $table->integer('ref_jenis');
            $table->integer('queue')->comment('Urutan Referensi berdasarkan Jenis');
            $table->string('deskripsi');
            $table->string('color')->nullable();
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
        Schema::dropIfExists('referensi');
    }
}
