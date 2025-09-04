<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolLevelsTable extends Migration
{
    public function up()
    {
        Schema::create('school_levels', function (Blueprint $table) {
            $table->string('school_code', 10);
            $table->unsignedBigInteger('level_id');

            // Composite primary key
            $table->primary(['school_code', 'level_id']);

            // Foreign key constraints
            $table->foreign('school_code')
                  ->references('center_code')
                  ->on('schools')
                  ->onDelete('cascade');

            $table->foreign('level_id')
                  ->references('level_id')
                  ->on('levels')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_levels');
    }
}
