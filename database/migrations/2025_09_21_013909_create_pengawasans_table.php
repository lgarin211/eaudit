<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengawasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengawasans', function (Blueprint $table) {
            $table->id();
            $table->string('tipe');
            $table->string('jenis');
            $table->string('wilayah');
            $table->string('pemeriksa');
            $table->string('status_LHP');
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
        Schema::dropIfExists('pengawasans');
    }
}
