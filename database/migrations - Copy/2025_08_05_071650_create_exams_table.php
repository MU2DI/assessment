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
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('exam_id');
            $table->string('exam_name', 100);
            $table->string('exam_code', 20)->unique();
            $table->unsignedBigInteger('level_id');
            $table->integer('total_marks');
            $table->integer('passing_marks')->nullable();
            $table->date('exam_date')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('level_id')->references('level_id')->on('levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};
