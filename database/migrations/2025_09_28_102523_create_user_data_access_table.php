<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserDataAccessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_data_access', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('access_type', ['all', 'specific'])->default('all');
            $table->json('jenis_temuan_ids')->nullable(); // For specific access, store array of allowed jenis_temuan IDs
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable(); // Optional notes about access permissions
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // Indexes for performance
            $table->index(['user_id', 'is_active']);
            $table->index('access_type');

            // Unique constraint to prevent duplicate user entries
            $table->unique('user_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data_access');
    }
}
