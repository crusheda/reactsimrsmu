<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableFcmToken2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('fcm_tokens', function (Blueprint $table) {
            $table->string('ip_address')->after('device_id')->nullable();
            $table->boolean('accepted')->after('is_rooted')->nullable()->default(false)->comment('Login pada Device Disetujui/Tidak');
            $table->datetime('accepted_date')->after('is_rooted')->nullable()->comment('Tanggal Device Disetujui');
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
            $table->dropColumn('ip_address');
            $table->dropColumn('accepted');
            $table->dropColumn('accepted_date');
        });
    }
}
