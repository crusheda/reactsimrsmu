<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePengadaanBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaan_barang', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->integer('ref_barang')->nullable();
            $table->string('nama')->nullable();
            $table->string('satuan')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->bigInteger('count')->nullable();
            $table->string('title')->nullable();
            $table->string('filename')->nullable();
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
        Schema::dropIfExists('pengadaan_barang');
    }
}
