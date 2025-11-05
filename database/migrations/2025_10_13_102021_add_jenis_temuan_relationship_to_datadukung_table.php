<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddJenisTemuanRelationshipToDatadukungTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datadukung', function (Blueprint $table) {
            $table->unsignedBigInteger('id_jenis_temuan')->nullable()->after('id_pengawasan');
            $table->string('keterangan_file')->nullable()->after('nama_file');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datadukung', function (Blueprint $table) {
            $table->dropColumn(['id_jenis_temuan', 'keterangan_file']);
        });
    }
}
