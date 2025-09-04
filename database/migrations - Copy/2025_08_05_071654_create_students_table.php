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
        Schema::create('students', function (Blueprint $table) {
    $table->bigIncrements('student_id');
    $table->string('first_name', 50);
    $table->string('last_name', 50);
    $table->char('gender', 1);
    $table->date('dob');
    $table->string('center_code', 10);
    $table->unsignedBigInteger('level_id');
    $table->integer('year_of_study')->nullable();
    $table->date('registration_date')->default(DB::raw('CURRENT_DATE'));

    $table->unique(['first_name', 'last_name', 'dob', 'level_id']);

    $table->foreign('center_code')->references('center_code')->on('schools')->onDelete('cascade');
    $table->foreign('level_id')->references('level_id')->on('levels')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
