<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('level_subject', function (Blueprint $table) {
            // This is a pivot table for the many-to-many relationship
            $table->id();
            $table->foreignId('level_id')->constrained('levels')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->timestamps();

            // Ensure we don't get duplicate assignments
            $table->unique(['level_id', 'subject_id']);
        });

        // Remove the old level_id column from the subjects table
        Schema::table('subjects', function (Blueprint $table) {
            $table->dropForeign(['level_id']);
            $table->dropColumn('level_id');
        });
    }

    public function down(): void
    {
        // Reverse the changes if rolling back
        Schema::table('subjects', function (Blueprint $table) {
            $table->foreignId('level_id')->constrained()->nullable()->after('subject_code');
        });

        Schema::dropIfExists('level_subject');
    }
};