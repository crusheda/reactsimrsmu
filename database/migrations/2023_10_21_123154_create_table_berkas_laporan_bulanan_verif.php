<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableBerkasLaporanBulananVerif extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berkas_laporan_bulanan_verif', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('queue');
            $table->integer('lap_id');
            $table->integer('user_id');
            $table->string('user_name');
            $table->string('role_name');
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
        Schema::dropIfExists('berkas_laporan_bulanan_verif');
    }
}
