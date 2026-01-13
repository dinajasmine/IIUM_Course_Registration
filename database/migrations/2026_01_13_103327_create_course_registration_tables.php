<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Courses table
        Schema::create('courses', function (Blueprint $table) {
            $table->string('code')->unique();
            $table->string('name');
            $table->integer('credit_hours')->default(3);
            $table->timestamps();
        });

        // Course sections table
        Schema::create('course_sections', function (Blueprint $table) {
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('section_number');
            $table->time('start_time');
            $table->time('end_time');
            $table->integer('capacity')->default(30);
            $table->integer('enrolled')->default(0);
            $table->timestamps();
        });

        // Student registrations table
        Schema::create('student_registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('matric_no')->constrained()->onDelete('cascade');
            $table->foreignId('course_section_id')->constrained()->onDelete('cascade');
            $table->timestamp('registered_at');
            $table->timestamps();
            
            $table->unique(['matric_no', 'course_section_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_registrations');
        Schema::dropIfExists('course_sections');
        Schema::dropIfExists('courses');
    }
};