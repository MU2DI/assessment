<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Optional, for DB::statement

return new class extends Migration
{
    public function up(): void
    {
        // Ensure the tables use InnoDB (this is usually the default)
        // This step is often unnecessary but can solve the problem
        DB::statement('ALTER TABLE subjects ENGINE = InnoDB');
        DB::statement('ALTER TABLE levels ENGINE = InnoDB');

        Schema::create('level_subject', function (Blueprint $table) {
            $table->id();

            // Use the same data type as the referenced primary key
            $table->unsignedBigInteger('level_id');
            $table->unsignedBigInteger('subject_id');

            $table->timestamps();

            // Create the foreign key constraints EXPLICITLY
            // Reference the correct column name ('level_id') on the 'levels' table
            $table->foreign('level_id')
                  ->references('level_id') // This is the crucial part
                  ->on('levels')
                  ->onDelete('cascade');

            $table->foreign('subject_id')
                  ->references('subject_id') // This is the crucial part
                  ->on('subjects')
                  ->onDelete('cascade');

            // Ensure we don't get duplicate assignments
            $table->unique(['level_id', 'subject_id']);
        });

        // Remove the old level_id column from the subjects table
        Schema::table('subjects', function (Blueprint $table) {
            // Check if the foreign key exists before trying to drop it
            // The name is generated automatically like 'subjects_level_id_foreign'
            $table->dropForeign(['level_id']); 
            $table->dropColumn('level_id');
        });
    }

    public function down(): void
    {
        // Reverse the changes if rolling back
        Schema::table('subjects', function (Blueprint $table) {
            // Add the column back
            $table->unsignedBigInteger('level_id')->nullable()->after('subject_code');
            // You might need to re-add the foreign key constraint here in the down() method
            // $table->foreign('level_id')->references('level_id')->on('levels');
        });

        Schema::dropIfExists('level_subject');
    }
};