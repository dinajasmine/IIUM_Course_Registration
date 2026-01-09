<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // DON'T create subjects table - it already exists from teammates
        // Instead, add any missing columns to the existing table
        
        Schema::table('subjects', function (Blueprint $table) {
            // Check and add columns that your design needs but might be missing
            
            // 1. Check if 'code' column exists (it should from teammates)
            if (!Schema::hasColumn('subjects', 'code')) {
                $table->string('code')->unique()->after('id');
            }
            
            // 2. Check if 'name' column exists
            if (!Schema::hasColumn('subjects', 'name')) {
                $table->string('name')->after('code');
            }
            
            // 3. Add credit_hours if missing
            if (!Schema::hasColumn('subjects', 'credit_hours')) {
                $table->integer('credit_hours')->default(3)->after('name');
            }
            
            // 4. Add faculty if missing
            if (!Schema::hasColumn('subjects', 'faculty')) {
                $table->string('faculty')->nullable()->after('credit_hours');
            }
            
            // 5. Add kulliyyah if missing
            if (!Schema::hasColumn('subjects', 'kulliyyah')) {
                $table->string('kulliyyah')->nullable()->after('faculty');
            }
            
            // 6. Add description if missing
            if (!Schema::hasColumn('subjects', 'description')) {
                $table->text('description')->nullable()->after('kulliyyah');
            }
            
            // 7. Add prerequisites if missing
            if (!Schema::hasColumn('subjects', 'prerequisites')) {
                $table->text('prerequisites')->nullable()->after('description');
            }
            
            // 8. Add is_active if missing
            if (!Schema::hasColumn('subjects', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('prerequisites');
            }
        });
    }

    public function down()
    {
        // Only remove columns that this migration added
        // Don't drop the entire table!
        
        Schema::table('subjects', function (Blueprint $table) {
            $columnsToRemove = ['faculty', 'kulliyyah', 'prerequisites', 'is_active'];
            
            foreach ($columnsToRemove as $column) {
                if (Schema::hasColumn('subjects', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};