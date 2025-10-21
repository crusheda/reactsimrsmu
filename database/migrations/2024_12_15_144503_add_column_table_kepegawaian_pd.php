<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianPd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_pd', function (Blueprint $table) {
            $table->integer('lama2')->comment('Lama Jam Dinas')->after('jenis')->nullable();
            $table->integer('lama1')->comment('1:<4jam; 2:>4jam;')->after('jenis')->nullable();
            $table->integer('kendaraan')->comment('1:[Pribadi] Motor; 2:[Pribadi] Mobil; 3:[Rumah Sakit] Mobil;')->after('jenis')->nullable();
            $table->longText('deskripsi')->comment('Deskripsi Perjalanan')->after('lokasi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepegawaian_pd', function (Blueprint $table) {
            $table->dropColumn('kendaraan');
            $table->dropColumn('lama1');
            $table->dropColumn('lama2');
            $table->dropColumn('deskripsi');
        });
    }
}
