<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianAbsensi6 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_absensi', function (Blueprint $table) {
            $table->dateTime('edit_tgl')->after('manual_tgl')->comment("Tgl User Ubah Absensi")->nullable();
            $table->integer('edit_user')->after('manual_tgl')->comment("User yang Ubah Absensi")->nullable();
            $table->integer('user_deleted_at')->after('updated_at')->comment("User yang Hapus Absensi")->nullable();
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
            $table->dropColumn('edit_tgl');
            $table->dropColumn('edit_user');
            $table->dropColumn('user_deleted_at');
        });
    }
}
