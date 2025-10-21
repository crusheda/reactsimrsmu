<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableRekrutmenPengumuman extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekrutmen_pengumuman', function (Blueprint $table) {
            $table->integer('user_id')->after('keterangan')->comment('ID from Table Users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('rekrutmen_pengumuman', function (Blueprint $table) {
            $table->dropColumn('user_id');
        });
    }
}
