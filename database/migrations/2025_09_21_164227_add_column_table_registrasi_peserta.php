<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableRegistrasiPeserta extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekrutmen_registrasi', function (Blueprint $table) {
            $table->longText('keterangan_tidak_lolos')->after('keterangan_lolos')->comment("Keterangan apabila tidak lolos")->nullable();
            $table->string('ruang_seleksi',255)->after('hasil')->comment("Ruang Seleksi")->nullable();
            $table->dateTime('tgl_seleksi')->after('hasil')->comment("Tanggal Seleksi")->nullable();
            $table->longText('keterangan_seleksi')->after('keterangan_lolos')->comment("Keterangan apabila lanjut seleksi")->nullable();
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
            $table->dropColumn('keterangan_seleksi');
            $table->dropColumn('tgl_seleksi');
            $table->dropColumn('Ruang_seleksi');
            $table->dropColumn('keterangan_tidak_lolos');
        });
    }
}
