<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTableKepegawaianJadwalDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_jadwal_detail', function (Blueprint $table) {
            $table->string('tgl1')->nullable()->change();
            $table->string('tgl2')->nullable()->change();
            $table->string('tgl3')->nullable()->change();
            $table->string('tgl4')->nullable()->change();
            $table->string('tgl5')->nullable()->change();
            $table->string('tgl6')->nullable()->change();
            $table->string('tgl7')->nullable()->change();
            $table->string('tgl8')->nullable()->change();
            $table->string('tgl9')->nullable()->change();
            $table->string('tgl10')->nullable()->change();
            $table->string('tgl11')->nullable()->change();
            $table->string('tgl12')->nullable()->change();
            $table->string('tgl13')->nullable()->change();
            $table->string('tgl14')->nullable()->change();
            $table->string('tgl15')->nullable()->change();
            $table->string('tgl16')->nullable()->change();
            $table->string('tgl17')->nullable()->change();
            $table->string('tgl18')->nullable()->change();
            $table->string('tgl19')->nullable()->change();
            $table->string('tgl20')->nullable()->change();
            $table->string('tgl21')->nullable()->change();
            $table->string('tgl22')->nullable()->change();
            $table->string('tgl23')->nullable()->change();
            $table->string('tgl24')->nullable()->change();
            $table->string('tgl25')->nullable()->change();
            $table->string('tgl26')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepegawaian_jadwal_detail', function (Blueprint $table) {
            $table->string('tgl1')->nullable(false)->change();
            $table->string('tgl2')->nullable(false)->change();
            $table->string('tgl3')->nullable(false)->change();
            $table->string('tgl4')->nullable(false)->change();
            $table->string('tgl5')->nullable(false)->change();
            $table->string('tgl6')->nullable(false)->change();
            $table->string('tgl7')->nullable(false)->change();
            $table->string('tgl8')->nullable(false)->change();
            $table->string('tgl9')->nullable(false)->change();
            $table->string('tgl10')->nullable(false)->change();
            $table->string('tgl11')->nullable(false)->change();
            $table->string('tgl12')->nullable(false)->change();
            $table->string('tgl13')->nullable(false)->change();
            $table->string('tgl14')->nullable(false)->change();
            $table->string('tgl15')->nullable(false)->change();
            $table->string('tgl16')->nullable(false)->change();
            $table->string('tgl17')->nullable(false)->change();
            $table->string('tgl18')->nullable(false)->change();
            $table->string('tgl19')->nullable(false)->change();
            $table->string('tgl20')->nullable(false)->change();
            $table->string('tgl21')->nullable(false)->change();
            $table->string('tgl22')->nullable(false)->change();
            $table->string('tgl23')->nullable(false)->change();
            $table->string('tgl24')->nullable(false)->change();
            $table->string('tgl25')->nullable(false)->change();
            $table->string('tgl26')->nullable(false)->change();
        });
    }
}
