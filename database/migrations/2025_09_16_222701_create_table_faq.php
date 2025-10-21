<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFaq extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faq', function (Blueprint $table) {
            $table->id();
            $table->integer('kategori');
            $table->integer('user')->nullable();
            $table->dateTime('tgl')->nullable();
            $table->string('question')->comment('Pertanyaan');
            $table->longText('answer')->comment('Jawaban');
            $table->longText('extra')->comment('Tambahan')->nullable();
            $table->string('title', 200)->comment('Nama File Lampiran')->nullable();
            $table->string('filename', 200)->comment('Path Lampiran')->nullable();
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
        Schema::dropIfExists('faq');
    }
}
