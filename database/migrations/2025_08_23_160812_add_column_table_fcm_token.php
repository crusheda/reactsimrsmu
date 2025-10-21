<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableFcmToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->string('device_id')->after('os_version')->nullable()->comment('ID Device per User');
            $table->boolean('is_active')->after('model')->nullable()->comment('Device ID = Aktif/Tidak Aktif');
            $table->datetime('last_login_at')->after('is_rooted')->nullable()->comment('Waktu Login Terakhir');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->dropColumn('device_id');
            $table->dropColumn('is_active');
            $table->dropColumn('last_login_at');
        });
    }
}
