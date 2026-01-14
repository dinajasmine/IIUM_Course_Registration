<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample courses
        $courses = [
            [
                'code' => 'BICS2301',
                'name' => 'Enterprise Network',
                'credit_hours' => 3,
            ],
            [
                'code' => 'BICS2302',
                'name' => 'Data Structures and Algorithm',
                'credit_hours' => 3,
            ],
            [
                'code' => 'BICS2303',
                'name' => 'Intelligent Systems',
                'credit_hours' => 3,
            ],
            [
                'code' => 'BICS2306',
                'name' => 'Software Engineering',
                'credit_hours' => 3,
            ],
        ];

        $this->call([
            UserSeeder::class,
            //SubjectSeeder::class,
        ]);
    }
}