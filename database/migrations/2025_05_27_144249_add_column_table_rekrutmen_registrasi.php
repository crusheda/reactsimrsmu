<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableRekrutmenRegistrasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekrutmen_registrasi', function (Blueprint $table) {
            $table->integer('hasil')->default(1)->after('status')->comment('1=sudah daftar; 2=lanjut seleksi; 3=lolos; 0=tidak lolos;');
            $table->longText('keterangan_lolos')->after('hasil')->nullable()->comment('keterangan apabila lanjut seleksi');
            $table->boolean('kehadiran')->after('keterangan_lolos')->nullable()->comment('0=tidak hadir; 1=hadir;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekrutmen_registrasi', function (Blueprint $table) {
            $table->dropColumn('hasil');
            $table->dropColumn('keterangan_lolos');
            $table->dropColumn('kehadiran');
        });
    }
}
