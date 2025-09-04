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
        Schema::create('school_levels', function (Blueprint $table) {
            $table->string('school_code', 10);
            $table->foreignId('level_id');

            $table->primary(['school_code', 'level_id']);

            $table->foreign('school_code')->references('center_code')->on('schools')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('levels')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('school_levels');
    }
};
