<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Subject;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subject::create([
            'code'=>'BICS 2306',
            'name'=>'Software Engineering',
            'credit'=>3
        ]);

        Subject::create([
            'code'=>'BICS 2301',
            'name'=>'Enterprise Networks',
            'credit'=>3
        ]);
    }
}
