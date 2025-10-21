<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableEruang3 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('eruang', function (Blueprint $table) {
            $table->longText('alasan_penolakan')->after('ket')->nullable();
            $table->boolean('status_penolakan')->after('ket')->nullable();
            $table->boolean('gizi_verif')->after('gizi')->nullable();
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
