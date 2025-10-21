<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableKepegawaianAbsensi7 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('kepegawaian_absensi', function (Blueprint $table) {
            $table->dateTime('trashed_date')->after('deleted_at')->comment("Tanggal Penghapusan Foto")->nullable();
            $table->boolean('trashed_status')->after('deleted_at')->default(false)->comment("Status Penghapusan Foto (IF TRUE = DELETED)");
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
            $table->dropColumn('trashed_date');
            $table->dropColumn('trashed_status');
        });
    }
}
