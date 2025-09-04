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
        Schema::create('grade_settings', function (Blueprint $table) {
            $table->id('grade_id');
            $table->string('grade_name', 10);
            $table->decimal('min_mark', 5, 2);
            $table->decimal('max_mark', 5, 2);
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('exam_id')->nullable();

            $table->unique(['grade_name', 'level_id', 'exam_id']);

            $table->foreign('level_id')->references('level_id')->on('levels')->onDelete('cascade');
            $table->foreign('exam_id')->references('exam_id')->on('exams')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grade_settings');
    }
};
