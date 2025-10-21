<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianAbsensi2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_absensi', function (Blueprint $table) {
            $table->boolean('lewat_hari')->after('terlambat')->comment('Waktu absensi melewati jam 12 Malam / lewat hari (0:false; 1:true)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepegawaian_absensi', function (Blueprint $table) {
            $table->dropColumn('lewat_hari');
        });
    }
}
