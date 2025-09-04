<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Schools Table
        Schema::create('schools', function (Blueprint $table) {
            $table->string('center_code', 10)->primary(); // DM001 format
            $table->string('school_name', 100);
            $table->text('address')->nullable();
            $table->string('contact_phone', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Levels Table (e.g., Primary 1, Secondary 3)
        Schema::create('levels', function (Blueprint $table) {
            $table->id('level_id');
            $table->string('level_name', 50);
            $table->text('description')->nullable();
        });

        // School Levels (Many-to-Many relationship)
        Schema::create('school_levels', function (Blueprint $table) {
            $table->string('school_code', 10);
            $table->foreignId('level_id');

            $table->primary(['school_code', 'level_id']);

            $table->foreign('school_code')->references('center_code')->on('schools')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
        });


        // Subjects Table
        Schema::create('subjects', function (Blueprint $table) {
            $table->id('subject_id');
            $table->string('subject_name', 100);
            $table->string('short_name', 20)->nullable();
            $table->string('subject_code', 20)->unique();
            $table->unsignedBigInteger('level_id');
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('level_id')->references('level_id')->on('levels');
        });

        // Exams Table
        Schema::create('exams', function (Blueprint $table) {
            $table->id('exam_id');
            $table->string('exam_name', 100);
            $table->string('exam_code', 20)->unique();
            $table->unsignedBigInteger('level_id');
            $table->integer('total_marks');
            $table->integer('passing_marks')->nullable();
            $table->date('exam_date')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->foreign('level_id')->references('level_id')->on('levels');
        });

        // Students Table
        Schema::create('students', function (Blueprint $table) {
            $table->id('student_id');
            $table->string('first_name', 50);
            $table->string('last_name', 50);
            $table->char('gender', 1);
            $table->date('dob');
            $table->string('center_code', 10);
            $table->unsignedBigInteger('level_id');
            $table->integer('year_of_study')->nullable();
            $table->date('registration_date')->useCurrent();

            $table->foreign('center_code')->references('center_code')->on('schools');
            $table->foreign('level_id')->references('level_id')->on('levels');
            $table->unique(['first_name', 'last_name', 'dob', 'level_id'], 'student_unique');
        });
        // Add the gender constraint
        DB::statement("ALTER TABLE students ADD CONSTRAINT chk_gender CHECK (gender IN ('M', 'F', 'O'))");

        // Student Subjects (Many-to-Many)
        Schema::create('student_subjects', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');
            $table->integer('year_of_study');

            $table->primary(['student_id', 'subject_id', 'year_of_study']);
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('subject_id')->references('subject_id')->on('subjects');
        });

        Schema::create('exam_marks', function (Blueprint $table) {
            $table->id('mark_id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('subject_id');
            $table->decimal('marks_obtained', 5, 2);
            $table->decimal('total_marks', 5, 2);
            $table->unsignedBigInteger('entered_by')->nullable();
            $table->timestamp('entered_at')->useCurrent();

            $table->foreign('exam_id')->references('exam_id')->on('exams');
            $table->foreign('student_id')->references('student_id')->on('students');
            $table->foreign('subject_id')->references('subject_id')->on('subjects');
        });

        // Add the marks constraint
        DB::statement('ALTER TABLE exam_marks ADD CONSTRAINT chk_marks CHECK (marks_obtained <= total_marks)');
        // Grading System
        Schema::create('grade_settings', function (Blueprint $table) {
            $table->id('grade_id');
            $table->string('grade_name', 10);
            $table->decimal('min_mark', 5, 2);
            $table->decimal('max_mark', 5, 2);
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('exam_id')->nullable();

            $table->foreign('level_id')->references('level_id')->on('levels');
            $table->foreign('exam_id')->references('exam_id')->on('exams');
            $table->unique(['grade_name', 'level_id', 'exam_id'], 'grade_unique');
        });

        // Users Table
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', 50)->unique();
            $table->string('password');
            $table->string('full_name', 100);
            $table->string('email', 100)->unique();
            $table->string('center_code', 10)->nullable();

            // Role fields
            $table->boolean('is_admin')->default(false);
            $table->boolean('is_school_admin')->default(false);
            $table->boolean('is_data_entry')->default(false);

            // Status fields
            $table->boolean('is_active')->default(true);
            $table->timestamp('last_login')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('center_code')
                ->references('center_code')
                ->on('schools')
                ->onDelete('set null');
        });

        // User Groups
        Schema::create('user_groups', function (Blueprint $table) {
            $table->id('group_id');
            $table->string('group_name', 50)->unique();
            $table->text('description')->nullable();
        });

        // Permissions
        Schema::create('permissions', function (Blueprint $table) {
            $table->id('permission_id');
            $table->string('permission_name', 50)->unique();
            $table->text('description')->nullable();
        });

        // Group Permissions
        Schema::create('group_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('permission_id');

            $table->primary(['group_id', 'permission_id']);
            $table->foreign('group_id')->references('group_id')->on('user_groups');
            $table->foreign('permission_id')->references('permission_id')->on('permissions');
        });

        // User Groups Assignment

    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        // Drop tables in reverse order to avoid foreign key constraints

        Schema::dropIfExists('group_permissions');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('user_groups');
        Schema::dropIfExists('users');
        Schema::dropIfExists('grade_settings');
        Schema::dropIfExists('exam_marks');
        Schema::dropIfExists('student_subjects');
        Schema::dropIfExists('students');
        Schema::dropIfExists('exams');
        Schema::dropIfExists('subjects');
        Schema::dropIfExists('school_levels');
        Schema::dropIfExists('levels');
        Schema::dropIfExists('schools');
    }
};
