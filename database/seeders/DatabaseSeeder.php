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

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);

            // Create sections for each course
            CourseSection::create([
                'course_id' => $course->id,
                'section_number' => 1,
                'start_time' => '08:30:00',
                'end_time' => '09:50:00',
                'capacity' => 30,
                'enrolled' => rand(0, 15),
            ]);

            CourseSection::create([
                'course_id' => $course->id,
                'section_number' => 2,
                'start_time' => '10:00:00',
                'end_time' => '11:30:00',
                'capacity' => 30,
                'enrolled' => 30, // Full section
            ]);

            // Add section 3 for BICS1304
            if ($course->code === 'BICS1304') {
                CourseSection::create([
                    'course_id' => $course->id,
                    'section_number' => 3,
                    'start_time' => '11:45:00',
                    'end_time' => '13:05:00',
                    'capacity' => 30,
                    'enrolled' => rand(0, 15),
                ]);

                CourseSection::create([
                    'course_id' => $course->id,
                    'section_number' => 3,
                    'start_time' => '14:00:00',
                    'end_time' => '15:20:00',
                    'capacity' => 30,
                    'enrolled' => 30, // Full section
                ]);
            }
        }
    }
}