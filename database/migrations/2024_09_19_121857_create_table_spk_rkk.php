<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableSpkRkk extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_spkrkk', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->comment('User Upload')->nullable();
            $table->integer('pegawai_id');
            $table->integer('pegawai_status')->comment('KHUSUS TGL BERAKHIR (Kontrak & THL)')->nullable();
            $table->date('tgl_berakhir')->nullable();
            $table->integer('jns_dokumen')->comment('1=RKK;0=SPK');
            $table->longText('deskripsi')->nullable();
            $table->string('title', 200);
            $table->string('filename', 200);
            $table->integer('valid')->comment('Verify from User Kepegawaian')->nullable();
            $table->dateTime('tgl_valid')->comment('')->nullable();
            $table->boolean('status')->comment('1=aktif;0=nonaktif');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_spkrkk');
    }
}
