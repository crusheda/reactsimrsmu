<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAsetBarang extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset', function (Blueprint $table) {
            $table->id();
            $table->longText('token');
            $table->integer('urutan')->nullable();
            $table->integer('id_user')->nullable();
            $table->integer('id_ruangan')->nullable();
            $table->integer('jenis')->nullable();
            $table->string('no_kalibrasi')->nullable();
            //$table->integer('kalibrasi')->nullable();
            $table->date('tgl_berlaku')->nullable();
            $table->date('tgl_perolehan')->nullable();
            $table->longText('no_inventaris')->nullable();
            $table->string('sarana')->nullable();
            $table->string('merk')->nullable();
            $table->string('tipe')->nullable();
            $table->string('no_seri')->nullable();
            $table->date('tgl_operasi')->nullable();
            $table->integer('asal_perolehan')->nullable();
            $table->bigInteger('nilai_perolehan')->nullable();
            $table->integer('kondisi')->nullable();
            $table->longText('keterangan')->nullable();

                $table->string('title')->nullable();
                $table->string('filename')->nullable();

            $table->integer('golongan')->nullable();
            $table->integer('umur')->nullable();
            $table->bigInteger('tarif')->nullable();
            $table->integer('penyusutan')->nullable();
            $table->date('tgl_input')->nullable();

            $table->integer('status')->nullable()->comment('Null: Aset Ready; 1: Aset dalam Peminjaman; 2: Aset Ditarik ke Gudang; 3: Aset Dimusnahkan');

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
        Schema::dropIfExists('aset');
    }
}
