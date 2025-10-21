<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegAbsen2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_absensi', function (Blueprint $table) {
            $table->string('path_in',200)->after('foto_in')->nullable();
            $table->string('path_out',200)->after('foto_out')->nullable();
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
            $table->dropColumn('path_in');
            $table->dropColumn('path_out');
        });
    }
}
