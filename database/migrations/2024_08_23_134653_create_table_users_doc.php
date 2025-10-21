<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUsersDoc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_doc', function (Blueprint $table) {
            $table->id();

                $table->unsignedBigInteger('ref_id')->comment('ID from Table Referensi');
                $table->foreign('ref_id')->references('id')->on('referensi');

            $table->integer('user_id');
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_akhir')->nullable();
            $table->string('no_surat')->nullable();
            $table->longText('deskripsi')->nullable();
            $table->string('title', 200)->nullable();
            $table->string('filename', 200)->nullable();
            $table->integer('valid')->comment('Verify from User Kepegawaian')->nullable();
            $table->dateTime('tgl_valid')->nullable();
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
        Schema::dropIfExists('users_doc');
    }
}
