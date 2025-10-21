<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableJadwalDinas3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_jadwal_detail', function (Blueprint $table) {
            $table->string('color')->after('pegawai_nama')->nullable();
            $table->string('jabatan')->after('pegawai_nama')->nullable();
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
            $table->dropColumn('jabatan');
            $table->dropColumn('color');
        });
    }
}
