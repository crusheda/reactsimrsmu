<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnTableProfilRs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profil_rs', function (Blueprint $table) {
            $table->string('nbm')->after('alamat_rs')->nullable();
            $table->string('nip')->after('alamat_rs')->nullable();
            $table->string('coord_long')->after('jabatan_direktur')->nullable();
            $table->string('coord_lat')->after('jabatan_direktur')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profil_rs', function (Blueprint $table) {
            $table->dropColumn('nip');
            $table->dropColumn('nbm');
            $table->dropColumn('coord_lat');
            $table->dropColumn('coord_long');
        });
    }
}
