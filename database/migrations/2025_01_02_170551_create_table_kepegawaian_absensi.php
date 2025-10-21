<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKepegawaianAbsensi extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_absensi', function (Blueprint $table) {
            $table->id();

                $table->unsignedInteger('pegawai_id')->comment('ID from Table Users');
                $table->foreign('pegawai_id')->references('id')->on('users');

            $table->string('kd_shift')->comment('Kode Shift');
            $table->string('nm_shift')->comment('Nama Shift');
            $table->time('ref_jam_masuk')->comment('Jam Masuk Seharusnya');
            $table->time('ref_jam_pulang')->comment('Jam Pulang Seharusnya');
            $table->datetime('tgl_in')->comment('Waktu Masuk Absen');
            $table->datetime('tgl_out')->comment('Waktu Pulang Absen')->nullable();
            $table->integer('selisih_jam')->comment('Selisih Jam Masuk Sampai Pulang')->nullable();
            $table->string('foto_in')->comment('Selfi Masuk')->nullable();
            $table->string('foto_out')->comment('Selfi Pulang')->nullable();
            $table->longText('lokasi_in')->comment('Latitude, Longitude');
            $table->longText('lokasi_out')->comment('Latitude, Longitude')->nullable();
            $table->boolean('terlambat')->comment('0:Disiplin; 1:Terlambat')->nullable();
            $table->string('keterangan')->comment('')->nullable();
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
        Schema::dropIfExists('kepegawaian_absensi');
    }
}
