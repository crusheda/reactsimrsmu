<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAsetRuangan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_ruangan', function (Blueprint $table) {
            $table->id();
            $table->integer('id_user')->nullable();
            $table->string('kode')->nullable();
            $table->string('ruangan')->nullable();
            $table->string('lokasi')->nullable();
            $table->longText('unit')->nullable();

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
        Schema::dropIfExists('aset_ruangan');
    }
}
