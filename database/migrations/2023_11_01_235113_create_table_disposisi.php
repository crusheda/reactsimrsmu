<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDisposisi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disposisi', function (Blueprint $table) {
            $table->id();
            $table->integer('id_surat')->nullable();
            $table->longText('tujuan')->nullable();
            $table->longText('tindak_lanjut')->nullable();
            $table->longText('ket')->nullable();
            $table->string('title')->nullable();
            $table->string('filename')->nullable();
            $table->integer('user');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disposisi');
    }
}
