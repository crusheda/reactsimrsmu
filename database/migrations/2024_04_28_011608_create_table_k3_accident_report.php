<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableK3AccidentReport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mfk_accident_report', function (Blueprint $table) {
            $table->id();
            $table->dateTime('tgl')->nullable();
            $table->string('lokasi')->nullable();
            $table->string('jenis')->nullable();
            $table->string('lain1')->nullable();
            $table->string('kronologi')->nullable();

            $table->string('kerugian')->nullable();
            $table->integer('korban')->nullable();
            $table->string('korban_luar')->nullable();
            $table->longText('role')->nullable();
            $table->string('role_luar')->nullable();
            $table->date('lahir')->nullable();
            $table->string('usia')->nullable();
            $table->string('jk')->nullable();
            $table->string('cedera')->nullable();
            $table->string('penanganan')->nullable();
            $table->string('k_aset')->nullable();
            $table->string('k_lingkungan')->nullable();

            $table->string('tta')->nullable();
            $table->string('kta')->nullable();
            $table->string('f_personal')->nullable();
            $table->string('f_pekerjaan')->nullable();
            $table->string('p_kerja')->nullable();
            $table->string('mesin')->nullable();
            $table->string('material')->nullable();
            $table->string('alat_berat')->nullable();
            $table->string('kendaraan')->nullable();

            $table->string('benda_bergerak')->nullable();
            $table->string('bejana_tekan')->nullable();
            $table->string('alat_listrik')->nullable();
            $table->string('radiasi')->nullable();
            $table->string('binatang')->nullable();
            $table->string('lain2')->nullable();

            $table->string('r_tindakan')->nullable();
            $table->string('t_waktu')->nullable();
            $table->string('wewenang')->nullable();

                $table->string('title', 200)->nullable();
                $table->string('filename', 200)->nullable();

            $table->dateTime('verifikasi')->nullable();
            $table->integer('user')->nullable();
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
        Schema::dropIfExists('mfk_accident_report');
    }
}
