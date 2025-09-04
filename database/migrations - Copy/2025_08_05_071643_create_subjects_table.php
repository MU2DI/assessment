<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
       Schema::create('subjects', function (Blueprint $table) {
            $table->id('subject_id');
            $table->string('subject_name', 100);
            $table->string('short_name', 20)->nullable();
            $table->string('subject_code', 20)->unique();
            $table->unsignedBigInteger('level_id');
            $table->timestamp('created_at')->useCurrent();

            // Foreign key constraint
            $table->foreign('level_id')->references('level_id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
