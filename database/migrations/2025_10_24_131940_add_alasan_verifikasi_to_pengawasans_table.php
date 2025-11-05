<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAlasanVerifikasiToPengawasansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pengawasans', function (Blueprint $table) {
            $table->text('alasan_verifikasi')->nullable()->after('status_LHP');
            $table->timestamp('tgl_verifikasi')->nullable()->after('alasan_verifikasi');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pengawasans', function (Blueprint $table) {
            $table->dropColumn(['alasan_verifikasi', 'tgl_verifikasi']);
        });
    }
}
