<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableSurket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_surket', function (Blueprint $table) {
            $table->date('pegawai_tak')->comment('Tgl Akhir Kegiatan Pelayanan (SKP)')->after('pegawai_tat')->nullable();
            $table->date('pegawai_tmk')->comment('Tgl Mulai Kegiatan Pelayanan (SKP)')->after('pegawai_tat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepegawaian_surket', function (Blueprint $table) {
            $table->dropColumn('pegawai_tmk');
            $table->dropColumn('pegawai_tak');
        });
    }
}
