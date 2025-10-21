<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianIdCard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_idcard', function (Blueprint $table) {
            $table->boolean('status')->after('filename')->nullable();
            $table->string('kwitansi_filename')->comment('Path Kwitansi')->after('filename')->nullable();
            $table->string('kwitansi_title')->comment('Judul Kwitansi')->after('filename')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepegawaian_idcard', function (Blueprint $table) {
            $table->dropColumn('kwitansi_title');
            $table->dropColumn('kwitansi_filename');
            $table->dropColumn('status');
        });
    }
}
