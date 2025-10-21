<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableJadwalDinasDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_jadwal_detail', function (Blueprint $table) {
            $table->id();
            $table->integer('id_jadwal');

                $table->unsignedInteger('pegawai_id')->comment('ID from Table Users');
                $table->foreign('pegawai_id')->references('id')->on('users');

            $table->string('pegawai_nama');
            $table->string('tgl1');
            $table->string('tgl2');
            $table->string('tgl3');
            $table->string('tgl4');
            $table->string('tgl5');
            $table->string('tgl6');
            $table->string('tgl7');
            $table->string('tgl8');
            $table->string('tgl9');
            $table->string('tgl10');
            $table->string('tgl11');
            $table->string('tgl12');
            $table->string('tgl13');
            $table->string('tgl14');
            $table->string('tgl15');
            $table->string('tgl16');
            $table->string('tgl17');
            $table->string('tgl18');
            $table->string('tgl19');
            $table->string('tgl20');
            $table->string('tgl21');
            $table->string('tgl22');
            $table->string('tgl23');
            $table->string('tgl24');
            $table->string('tgl25');
            $table->string('tgl26');
            $table->string('tgl27')->nullable();
            $table->string('tgl28')->nullable();
            $table->string('tgl29')->nullable();
            $table->string('tgl30')->nullable();
            $table->string('tgl31')->nullable();
            $table->integer('jam_kerja')->comment('Satuan Detik')->nullable();
            $table->longText('jml_shift')->comment('Per Bulan')->nullable();
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
        Schema::dropIfExists('table_jadwal_dinas_detail');
    }
}
