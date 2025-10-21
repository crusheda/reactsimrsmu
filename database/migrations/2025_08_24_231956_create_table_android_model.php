<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableAndroidModel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('android_model', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->comment('retail_brand')->nullable();
            $table->string('nama')->comment('marketing_name')->nullable();
            $table->string('device')->nullable();
            $table->string('model')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('android_model');
    }
}
