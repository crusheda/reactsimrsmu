<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableReferensiJadwalDinas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referensi_jadwal_shift', function (Blueprint $table) {
            $table->id();

                $table->unsignedInteger('pegawai_id')->comment('ID from Table Users');
                $table->foreign('pegawai_id')->references('id')->on('users');

            $table->longText('unit')->nullable();
            $table->string('shift');
            $table->string('singkat');
            $table->time('berangkat');
            $table->time('pulang');
            $table->longText('ket')->nullable();
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
        Schema::dropIfExists('referensi_jadwal_shift');
    }
}
