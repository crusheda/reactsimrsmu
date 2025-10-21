<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableKepegawaianSurket extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kepegawaian_surket', function (Blueprint $table) {
            $table->id();

                $table->unsignedBigInteger('ref_id')->comment('ID from Table Referensi');
                $table->foreign('ref_id')->references('id')->on('referensi');

                $table->unsignedInteger('pegawai_id')->comment('ID from Table Users');
                $table->foreign('pegawai_id')->references('id')->on('users');

            $table->integer('no_surat')->comment('Optional')->nullable();
            $table->integer('th_surat')->comment('Optional')->nullable();
            $table->date('tgl_surat');
            $table->string('pegawai_nama');
            $table->string('pegawai_ttl');
            $table->string('pegawai_pendidikan')->comment('Pendidikan Terakhir');
            $table->string('pegawai_alamat');
            $table->date('pegawai_tmt');
            $table->date('pegawai_tat')->comment('Keperluan Pemenuhan SKP & Paklaring')->nullable();
            $table->integer('profesi')->comment('ID dari tabel referensi 14')->nullable();
            $table->longText('deskripsi')->nullable();

            $table->boolean('progress')->comment('0=pengajuan;1=diverifikasi;2=diproses;3=selesai;4=ditolak');
            $table->integer('valid')->comment('Verify from User Kepegawaian')->nullable();
            $table->dateTime('tgl_valid')->nullable();
            $table->dateTime('tgl_proses')->nullable();
            $table->dateTime('tgl_selesai')->nullable();

            $table->string('title', 200)->comment('Upload File Jadi')->nullable();
            $table->string('filename', 200)->comment('Upload File Jadi')->nullable();
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
        Schema::dropIfExists('kepegawaian_surket');
    }
}
