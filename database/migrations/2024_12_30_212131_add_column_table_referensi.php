<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableReferensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('referensi', function (Blueprint $table) {
            $table->longText('keterangan')->after('deskripsi')->nullable();
            $table->string('filename',200)->after('status')->nullable();
            $table->string('title',200)->after('status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('referensi', function (Blueprint $table) {
            $table->dropColumn('keterangan');
            $table->dropColumn('title');
            $table->dropColumn('filename');
        });
    }
}
