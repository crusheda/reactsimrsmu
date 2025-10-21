<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableUsers3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('tt')->after('ig')->nullable();
            $table->date('tmt')->comment('Tanggal Mulai Tugas')->after('masuk_kerja')->nullable();
            $table->date('tat')->comment('Tanggal Akhir Tugas')->after('masuk_kerja')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tt');
            $table->dropColumn('tmt');
            $table->dropColumn('tat');
        });
    }
}
