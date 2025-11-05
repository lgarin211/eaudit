<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIdPengawasanTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jenis_temuans', function (Blueprint $table) {
             $table->foreignId('id_pengawasan')->after('id')->nullable();
            $table->integer('id_parent')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jenis_temuans', function (Blueprint $table) {
            //
        });
    }
}
