<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('filename_s3')->after('sd')->nullable();
            $table->string('filename_s2')->after('sd')->nullable();
            $table->string('filename_s1_profesi')->after('sd')->nullable();
            $table->string('filename_s1')->after('sd')->nullable();
            $table->string('filename_d4')->after('sd')->nullable();
            $table->string('filename_d3')->after('sd')->nullable();
            $table->string('filename_d2')->after('sd')->nullable();
            $table->string('filename_d1')->after('sd')->nullable();
            $table->string('filename_sma')->after('sd')->nullable();
            $table->string('filename_smp')->after('sd')->nullable();
            $table->string('filename_sd')->after('sd')->nullable();
            // S1 PROFESI
            $table->string('th_s1_profesi')->after('th_s2')->nullable();
            $table->string('s1_profesi')->after('s2')->nullable();
            $table->integer('ref_profesi')->after('jabatan')->comment('ID from Table Referensi')->nullable();
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
            $table->dropColumn('filename_s3');
            $table->dropColumn('filename_s2');
            $table->dropColumn('filename_s1');
            $table->dropColumn('filename_d4');
            $table->dropColumn('filename_d3');
            $table->dropColumn('filename_d2');
            $table->dropColumn('filename_d1');
            $table->dropColumn('filename_sma');
            $table->dropColumn('filename_smp');
            $table->dropColumn('filename_sd');
            // S1 PROFESI
            $table->dropColumn('filename_s1_profesi');
            $table->dropColumn('th_s1_profesi');
            $table->dropColumn('s1_profesi');
            $table->dropColumn('ref_profesi');
        });
    }
}
