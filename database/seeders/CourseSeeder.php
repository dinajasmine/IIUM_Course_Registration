<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseSection;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample courses
        $courses = [
            [
                'code' => 'BICS1013',
                'title' => 'Programming Fundamentals',
                'name' => 'Programming Fundamentals',
                'credit_hours' => 3,
                'faculty' => 'ICT',
                'kulliyyah' => 'KICT',
                'description' => 'Introduction to programming concepts using Python',
                'prerequisites' => 'None',
                'is_active' => true,
            ],
            [
                'code' => 'BICS1023',
                'title' => 'Data Structures',
                'name' => 'Data Structures',
                'credit_hours' => 3,
                'faculty' => 'ICT',
                'kulliyyah' => 'KICT',
                'description' => 'Introduction to data structures and algorithms',
                'prerequisites' => 'BICS1013',
                'is_active' => true,
            ],
            [
                'code' => 'BICS2013',
                'title' => 'Database Systems',
                'name' => 'Database Systems',
                'credit_hours' => 3,
                'faculty' => 'ICT',
                'kulliyyah' => 'KICT',
                'description' => 'Introduction to database design and SQL',
                'prerequisites' => 'BICS1013',
                'is_active' => true,
            ],
            [
                'code' => 'UNGS2080',
                'title' => 'Ethics and Fiqh for Contemporary Issues',
                'name' => 'Ethics and Fiqh',
                'credit_hours' => 2,
                'faculty' => 'General Studies',
                'kulliyyah' => 'KIRKHS',
                'description' => 'Islamic ethics and jurisprudence for modern issues',
                'prerequisites' => 'None',
                'is_active' => true,
            ],
        ];

        foreach ($courses as $courseData) {
            $course = Course::create($courseData);

            // Create sections for each course
            $sections = [
                [
                    'section_code' => '1',
                    'section_name' => 'Group 1',
                    'time_slot' => '8:00 AM - 9:30 AM',
                    'days' => 'Monday/Wednesday',
                    'venue' => 'Lecture Hall 1',
                    'lecturer' => 'Dr. Ahmad Ali',
                    'capacity' => 30,
                    'registered_count' => 15,
                    'is_active' => true,
                ],
                [
                    'section_code' => '2',
                    'section_name' => 'Group 2',
                    'time_slot' => '10:00 AM - 11:30 AM',
                    'days' => 'Tuesday/Thursday',
                    'venue' => 'Lab 3',
                    'lecturer' => 'Dr. Siti Fatimah',
                    'capacity' => 25,
                    'registered_count' => 10,
                    'is_active' => true,
                ],
                [
                    'section_code' => '3',
                    'section_name' => 'Group 3',
                    'time_slot' => '2:00 PM - 3:30 PM',
                    'days' => 'Monday/Wednesday',
                    'venue' => 'Lecture Hall 2',
                    'lecturer' => 'Prof. John Smith',
                    'capacity' => 35,
                    'registered_count' => 30,
                    'is_active' => true,
                ],
            ];

            foreach ($sections as $sectionData) {
                CourseSection::create(array_merge($sectionData, ['course_id' => $course->id]));
            }
        }

        $this->command->info('Courses and sections created successfully!');
    }
}