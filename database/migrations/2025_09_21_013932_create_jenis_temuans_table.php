<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJenisTemuansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jenis_temuans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_temuan');
            $table->string('kode_temuan')->nullable();
            $table->string('rekomendasi')->nullable();
            $table->string('pengembalian')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('kode_rekomendasi')->nullable();
            $table->longText('Rawdata')->nullable();
            $table->string('password');

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
        Schema::dropIfExists('jenis_temuans');
    }
}
