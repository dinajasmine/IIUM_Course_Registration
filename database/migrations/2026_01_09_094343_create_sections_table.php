<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create sections table (this should be new)
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->string('section_code'); // e.g., 1, 2, 3
            $table->string('section_name')->nullable(); // e.g., (b), (c)
            $table->string('time_slot'); // e.g., 8:30-9:50
            $table->string('days'); // e.g., MW, TR
            $table->string('venue')->nullable();
            $table->string('lecturer')->nullable();
            $table->integer('capacity')->default(30);
            $table->integer('registered_count')->default(0);
            $table->boolean('is_available')->default(true);
            $table->timestamps();
            
            $table->unique(['subject_id', 'section_code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sections');
    }
};