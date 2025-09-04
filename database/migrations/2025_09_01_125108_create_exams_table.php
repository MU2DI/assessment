<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id('exam_id');
            $table->string('exam_name'); // e.g. "Midterm"
            $table->string('academic_year'); // e.g. "2025"
            $table->string('term')->nullable(); // e.g. "Term 1"
            $table->unsignedBigInteger('level_id'); // which level is taking this exam
            $table->timestamps();

            $table->foreign('level_id')->references('level_id')->on('levels')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
