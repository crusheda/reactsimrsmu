<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePengadaanDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengadaan_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('id_pengadaan')->nullable();
            $table->integer('id_barang')->nullable();
            $table->integer('jumlah')->nullable();
            $table->bigInteger('harga')->nullable();
            $table->string('satuan')->nullable();
            $table->bigInteger('total')->nullable();
            $table->longText('ket')->nullable();

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
        Schema::dropIfExists('pengadaan_detail');
    }
}
