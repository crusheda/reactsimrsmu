<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianAbsensi3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_absensi', function (Blueprint $table) {
            $table->longText('user_agent')->after('jenis')->nullable()->comment('AgentUser');
            $table->string('ip_out')->after('jenis')->nullable()->comment('IP Berangkat');
            $table->string('ip_in')->after('jenis')->nullable()->comment('IP Pulang');
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
            $table->dropColumn('ip_out');
            $table->dropColumn('ip_in');
            $table->dropColumn('user_agent');
        });
    }
}
