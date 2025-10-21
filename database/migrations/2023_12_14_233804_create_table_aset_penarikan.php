<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAsetPenarikan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aset_penarikan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aset');
            $table->foreign('id_aset')->references('id')->on('aset');
            $table->integer('id_user')->nullable();
            $table->integer('kondisi')->nullable();
            $table->integer('kondisi_awal')->nullable();
            $table->integer('lokasi_awal')->nullable();
            $table->longText('ket')->nullable();

                $table->string('title', 200)->nullable();
                $table->string('filename', 200)->nullable();

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
        Schema::dropIfExists('aset_penarikan');
    }
}
