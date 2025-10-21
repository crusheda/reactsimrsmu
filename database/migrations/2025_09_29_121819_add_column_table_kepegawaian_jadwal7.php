<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianJadwal7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_jadwal', function (Blueprint $table) {
            $table->integer('ref_id')->after('pegawai_id')->comment("ID dari referensi_jadwal_users")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepegawaian_jadwal', function (Blueprint $table) {
            $table->dropColumn('ref_id');
        });
    }
}
