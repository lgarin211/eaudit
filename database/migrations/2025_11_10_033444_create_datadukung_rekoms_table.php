<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatadukungRekomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('datadukung_rekoms', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_jenis_temuan');
            $table->string('nama_file');
            $table->string('original_name');
            $table->unsignedBigInteger('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->unsignedBigInteger('uploaded_by');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_jenis_temuan')->references('id')->on('jenis_temuans')->onDelete('cascade');
            $table->foreign('uploaded_by')->references('id')->on('users')->onDelete('cascade');

            // Indexes for performance
            $table->index(['id_jenis_temuan']);
            $table->index(['uploaded_by']);
            $table->index(['created_at']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('datadukung_rekoms');
    }
}
