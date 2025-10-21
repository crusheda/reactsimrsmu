<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('id_gaji')->nullable();
            $table->integer('id_gol')->nullable();
            $table->integer('id_finger')->nullable();
            $table->string('nick')->nullable();
            $table->string('nik')->nullable();
            $table->string('nip')->nullable();
            $table->string('jns_kelamin')->nullable();
            $table->string('temp_lahir')->nullable();
            $table->date('tgl_lahir')->nullable();
            $table->string('status_kawin')->nullable();
            $table->string('jabatan')->nullable();
            $table->date('masuk_kerja')->nullable();
            $table->string('nama_rek', 200)->nullable();
            $table->boolean('status')->nullable();
            $table->integer('nomor_rek')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('ig')->nullable();
            $table->string('fb')->nullable();
            $table->string('no_hp')->nullable();
            $table->longText('alamat_ktp')->nullable();
            $table->longText('alamat_dom')->nullable();
            $table->string('jln_ktp')->nullable();
            $table->string('jln_dom')->nullable();

                $table->string('ktp_provinsi')->nullable();
                $table->string('ktp_kabupaten')->nullable();
                $table->string('ktp_kecamatan')->nullable();
                $table->string('ktp_kelurahan')->nullable();

                $table->string('dom_provinsi')->nullable();
                $table->string('dom_kabupaten')->nullable();
                $table->string('dom_kecamatan')->nullable();
                $table->string('dom_kelurahan')->nullable();

                $table->string('sd')->nullable();
                $table->string('smp')->nullable();
                $table->string('sma')->nullable();
                $table->string('d1')->nullable();
                $table->string('d2')->nullable();
                $table->string('d3')->nullable();
                $table->string('d4')->nullable();
                $table->string('s1')->nullable();
                $table->string('s2')->nullable();
                $table->string('s3')->nullable();

                $table->integer('th_sd')->nullable();
                $table->integer('th_smp')->nullable();
                $table->integer('th_sma')->nullable();
                $table->integer('th_d1')->nullable();
                $table->integer('th_d2')->nullable();
                $table->integer('th_d3')->nullable();
                $table->integer('th_d4')->nullable();
                $table->integer('th_s1')->nullable();
                $table->integer('th_s2')->nullable();
                $table->integer('th_s3')->nullable();

            $table->longText('no_str')->nullable();
            $table->date('masa_str')->nullable();
            $table->date('masa_sip')->nullable();
            $table->longText('pengalaman_kerja')->nullable();
            $table->longText('riwayat_penyakit')->nullable();
            $table->longText('riwayat_penyakit_keluarga')->nullable();
            $table->longText('riwayat_operasi')->nullable();
            $table->longText('riwayat_penggunaan_obat')->nullable();
            $table->string('name');
            $table->string('nama')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
