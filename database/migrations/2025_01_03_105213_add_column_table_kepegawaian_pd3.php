<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianPd3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_pd', function (Blueprint $table) {
            $table->datetime('tgl_paid')->after('deskripsi')->nullable();
            $table->integer('user_paid')->after('deskripsi')->nullable();
            $table->boolean('paid')->after('deskripsi')->comment('0:unpaid; 1:paid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('kepegawaian_pd', function (Blueprint $table) {
            $table->dropColumn('tgl_paid');
            $table->dropColumn('user_paid');
            $table->dropColumn('paid');
        });
    }
}
