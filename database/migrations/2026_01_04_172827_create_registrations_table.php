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
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();

            //Student 
            $table->foreignId('matric_no')->constrained()->cascadeOnDelete();

            //Course Reference (auto registration)
            $table->foreignId('subject_id')->nullable()->constrained()->cascadeOnDelete(); 
            $table->foreignId('section_id')->nullable()->constrained()->cascadeOnDelete(); 

            //manual registration fields
            $table->string('subject_name')->nullable(); 
            $table->string('course_code')->nullable();
            $table->float('current_credit_hours', 3, 2)->nullable();
            $table->float('completed_credit_hours', 3, 2)->nullable();
            $table->float('cgpa', 3, 2)->nullable();
            $table->integer('semester')->nullable();
            $table->string('requested_section')->nullable();
            $table->text('reason')->nullable();

            //common fields
            $table->enum('registration_type', ['AUTO', 'MANUAL']);

            //approval workflow
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING');
            $table->foreignId('approved_by')->nullable()->references('id')->on('users');
            $table->timestamp('approved_at')->nullable();

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
