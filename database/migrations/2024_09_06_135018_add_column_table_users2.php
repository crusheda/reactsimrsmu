<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableUsers2 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('id_gaji');
            $table->dropColumn('jabatan');
            $table->dropColumn('id_gol');

            $table->string('gelar_belakang')->after('id_finger')->nullable();
            $table->string('nama_lengkap')->after('id_finger')->nullable();
            $table->string('gelar_depan')->after('id_finger')->nullable();
            $table->integer('urutan_masuk')->after('masuk_kerja')->comment('Nomor Urut Karyawan Masuk')->nullable();
            $table->integer('user_hapus')->after('ig')->comment('User yang menghapus Pegawai')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('gelar_depan');
            $table->dropColumn('nama_lengkap');
            $table->dropColumn('gelar_belakang');
            $table->dropColumn('urutan_masuk');
            $table->dropColumn('user_hapus');
        });
    }
}
