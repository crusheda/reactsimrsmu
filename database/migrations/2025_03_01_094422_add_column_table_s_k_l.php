<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableSKL extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pelayanan_skl', function (Blueprint $table) {
            $table->bigInteger('nik_ayah',16)->after('hari');
            $table->bigInteger('nik_ibu',16)->after('hari');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pelayanan_skl', function (Blueprint $table) {
            $table->dropColumn('nik_ibu');
            $table->dropColumn('nik_ayah');
        });
    }
}
