<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableReferensiJadwalUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referensi_jadwal_users', function (Blueprint $table) {
            $table->string('unit')->after('staf')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referensi_jadwal_users', function (Blueprint $table) {
            $table->dropColumn('unit');
        });
    }
}
