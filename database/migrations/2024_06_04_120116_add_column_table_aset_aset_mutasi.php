<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableAsetAsetMutasi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aset_mutasi', function (Blueprint $table) {
            $table->integer('urutan_baru')->after('id_user')->nullable();
            $table->integer('urutan_lama')->after('id_user')->nullable();
            $table->longtext('no_inventaris_baru')->after('id_user')->nullable();
            $table->longtext('no_inventaris_lama')->after('id_user')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
