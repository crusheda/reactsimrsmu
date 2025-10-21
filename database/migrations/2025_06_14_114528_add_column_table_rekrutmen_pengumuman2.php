<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableRekrutmenPengumuman2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('rekrutmen_pengumuman', function (Blueprint $table) {
            $table->boolean('status')->default(1)->after('user_id')->comment('0:TidakAktif; 1:Aktif');
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
            $table->dropColumn('status');
        });
    }
}
