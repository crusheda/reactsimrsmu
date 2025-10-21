<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableJd extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_jadwal', function (Blueprint $table) {
            $table->string('unit')->after('staf')->nullable()->comment('Unit Jadwal Dinas');
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
            $table->dropColumn('unit');
        });
    }
}
