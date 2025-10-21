<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableDataLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datalogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id', 20)->nullable();
            $table->string('ip', 20);
            $table->longText('event')->nullable();
            $table->longText('extra')->nullable();
            $table->longText('before')->nullable();
            $table->longText('after')->nullable();
            $table->string('role_target')->nullable();
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
        Schema::dropIfExists('datalogs');
    }
}
