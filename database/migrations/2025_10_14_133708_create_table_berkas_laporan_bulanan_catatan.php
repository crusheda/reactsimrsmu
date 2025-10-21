<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBerkasLaporanBulananCatatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_laporan_bulanan_catatan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_laporan');
            $table->integer('user');
            $table->dateTime('tgl');
            $table->longText('deskripsi');
            $table->longText('extra')->comment('Tambahan')->nullable();
            $table->boolean('solved')->default(0);
            $table->dateTime('tgl_solved')->nullable();
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
        Schema::dropIfExists('berkas_laporan_bulanan_catatan');
    }
}
