<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // This is a SAFE migration that won't conflict with teammates
        
        // 1. Add columns to subjects table (safe - won't recreate table)
        if (Schema::hasTable('subjects')) {
            // Use raw SQL to avoid errors
            $columnsToAdd = [
                "ADD COLUMN IF NOT EXISTS faculty VARCHAR(255) NULL AFTER credit_hours",
                "ADD COLUMN IF NOT EXISTS kulliyyah VARCHAR(255) NULL AFTER faculty",
                "ADD COLUMN IF NOT EXISTS description TEXT NULL AFTER kulliyyah",
                "ADD COLUMN IF NOT EXISTS prerequisites TEXT NULL AFTER description",
                "ADD COLUMN IF NOT EXISTS is_active TINYINT(1) DEFAULT 1 AFTER prerequisites"
            ];
            
            foreach ($columnsToAdd as $columnSql) {
                try {
                    DB::statement("ALTER TABLE subjects {$columnSql}");
                } catch (\Exception $e) {
                    // Column might already exist with different definition
                    // Continue with next column
                    continue;
                }
            }
        }
        
        // 2. Create sections table only if it doesn't exist
        if (!Schema::hasTable('sections')) {
            Schema::create('sections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('subject_id')->constrained()->onDelete('cascade');
                $table->string('section_code');
                $table->string('section_name')->nullable();
                $table->string('time_slot');
                $table->string('days');
                $table->string('venue')->nullable();
                $table->string('lecturer')->nullable();
                $table->integer('capacity')->default(30);
                $table->integer('registered_count')->default(0);
                $table->boolean('is_available')->default(true);
                $table->timestamps();
                
                $table->unique(['subject_id', 'section_code']);
            });
        }
        
        // 3. Add section_id to registrations if missing
        if (Schema::hasTable('registrations') && !Schema::hasColumn('registrations', 'section_id')) {
            Schema::table('registrations', function (Blueprint $table) {
                $table->foreignId('section_id')->nullable()->after('subject_id');
            });
            
            // Add foreign key constraint
            DB::statement('ALTER TABLE registrations 
                ADD CONSTRAINT fk_registrations_sections 
                FOREIGN KEY (section_id) REFERENCES sections(id) 
                ON DELETE CASCADE');
        }
    }

    public function down()
    {
        // Safe down migration
        if (Schema::hasTable('registrations') && Schema::hasColumn('registrations', 'section_id')) {
            DB::statement('ALTER TABLE registrations DROP FOREIGN KEY fk_registrations_sections');
            Schema::table('registrations', function (Blueprint $table) {
                $table->dropColumn('section_id');
            });
        }
        
        // Don't drop sections table as it might have data
        // Just leave it - better safe in team environment
    }
};