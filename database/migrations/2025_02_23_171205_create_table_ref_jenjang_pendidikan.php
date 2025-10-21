<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableRefJenjangPendidikan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referensi_jenjang_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->comment('Nama Jenjang Pendidikan');
            $table->string('kategori')->comment('Kategori : SD/SMP/SMA/D1/etc');
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
        Schema::dropIfExists('referensi_jenjang_pendidikan');
    }
}
