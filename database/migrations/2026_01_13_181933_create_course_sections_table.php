<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('course_sections', function (Blueprint $table) {
        $table->id();
        $table->string('course_code');
        $table->string('section_code'); // e.g., "A", "B", "C"
        $table->string('instructor');
        $table->integer('available_seats');
        $table->integer('total_seats');
        $table->string('schedule'); // e.g., "MWF 9:00-10:15"
        $table->string('room');
        $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sections');
    }
};
