<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_absensi', function (Blueprint $table) {
            $table->integer('jenis')->after('id')->comment('1:Shift; 2:Cuti; 3:Ijin Sakit; 4:OnCall;');
            $table->time('lembur')->after('ref_jam_pulang')->nullable();
            $table->time('keterlambatan')->after('ref_jam_pulang')->nullable();
            $table->datetime('ref_jam_masuk')->change();
            $table->datetime('ref_jam_pulang')->change();
            $table->time('selisih_jam')->change();
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
            $table->dropColumn('jenis');
            $table->dropColumn('keterlambatan');
            $table->dropColumn('lembur');
        });
    }
}
