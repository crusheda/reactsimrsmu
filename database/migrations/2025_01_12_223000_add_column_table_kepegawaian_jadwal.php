<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianJadwal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_jadwal', function (Blueprint $table) {
            $table->dateTime('tgl_verif')->after('progress')->nullable();
            $table->integer('verif')->after('progress')->comment('Verify from Atasan Langsung')->nullable();
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
            $table->dropColumn('verif');
            $table->dropColumn('tgl_verif');
        });
    }
}
