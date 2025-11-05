<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRekomendasiRelationshipToDatadukungsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('datadukungs', function (Blueprint $table) {
            $table->unsignedBigInteger('id_pengawasan')->nullable()->after('nama_file');
            $table->unsignedBigInteger('id_jenis_temuan')->nullable()->after('id_pengawasan');
            $table->string('keterangan_file')->nullable()->after('id_jenis_temuan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('datadukungs', function (Blueprint $table) {
            $table->dropColumn(['id_pengawasan', 'id_jenis_temuan', 'keterangan_file']);
        });
    }
}
