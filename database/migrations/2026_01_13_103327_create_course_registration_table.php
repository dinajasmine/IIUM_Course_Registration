<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Create courses table FIRST
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // e.g., BICS1013
            $table->string('title'); // Course title
            $table->string('name')->nullable(); // Alternative name
            $table->integer('credit_hours')->default(3);
            $table->string('faculty')->nullable();
            $table->string('kulliyyah')->nullable();
            $table->text('description')->nullable();
            $table->text('prerequisites')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // 2. Create course_sections table SECOND (after courses exists)
        Schema::create('course_sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('section_code');
            $table->string('section_name')->nullable();
            $table->string('time_slot');
            $table->string('days')->nullable();
            $table->string('venue')->nullable();
            $table->string('lecturer')->nullable();
            $table->integer('capacity')->default(30);
            $table->integer('registered_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['course_id', 'section_code']);
        });

        // 3. Create registrations table LAST
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('course_id')->nullable()->constrained('courses')->onDelete('cascade');
            $table->foreignId('section_id')->nullable();
            $table->string('course_name');
            $table->string('course_code');
            $table->enum('registration_type', ['AUTO', 'MANUAL'])->default('AUTO');
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->string('requested_section');
            $table->string('semester');
            $table->integer('current_credit_hours')->default(0);
            $table->integer('completed_credit_hours')->default(0);
            $table->decimal('cgpa', 3, 2)->default(0.00);

            $table->text('reason')->nullable();

            // Approval tracking
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->timestamps();
            
            $table->index(['user_id', 'course_id', 'semester']);
            $table->index(['status', 'registration_type']); 
            $table->unique(['user_id', 'course_id', 'semester', 'section_id'], 'unique_registration');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registrations');
        Schema::dropIfExists('course_sections');
        Schema::dropIfExists('courses');
    }
};