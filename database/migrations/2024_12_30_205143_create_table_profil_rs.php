<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableProfilRs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profil_rs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_bpjs',8)->comment('Kode RS dari BPJS');
            $table->integer('kode_kemenkes')->comment('Kode RS dari Kemenkes');
            $table->string('nama_rs');
            $table->string('alamat_rs');
            $table->string('nama_direktur');
            $table->string('jabatan_direktur')->comment('Dirut / Direktur / Kepala Instansi Rumah Sakit');
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
        Schema::dropIfExists('profil_rs');
    }
}
