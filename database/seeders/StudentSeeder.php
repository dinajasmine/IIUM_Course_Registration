<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            [
                'matric_no' => 'ITUM001',
                'name' => 'Ali Ahmad',
                'email' => 'ali@itum.edu.my',
                'password' => Hash::make('password123'),
                'phone' => '012-3456789',
                'program' => 'Computer Science',
                'semester' => 3,
                'year' => 2024,
                'faculty' => 'Computing',
                'kulliyyah' => 'Kulliyyah of ICT',
                'current_credit' => 12,
                'max_credit' => 18,
                'is_active' => true,
            ],
            [
                'matric_no' => 'ITUM002',
                'name' => 'Siti Rahman',
                'email' => 'siti@itum.edu.my',
                'password' => Hash::make('password123'),
                'phone' => '013-4567890',
                'program' => 'Information Technology',
                'semester' => 2,
                'year' => 2024,
                'faculty' => 'Computing',
                'kulliyyah' => 'Kulliyyah of ICT',
                'current_credit' => 15,
                'max_credit' => 18,
                'is_active' => true,
            ],
            [
                'matric_no' => 'ITUM003',
                'name' => 'Mohd Hafiz',
                'email' => 'hafiz@itum.edu.my',
                'password' => Hash::make('password123'),
                'phone' => '014-5678901',
                'program' => 'Software Engineering',
                'semester' => 4,
                'year' => 2023,
                'faculty' => 'Computing',
                'kulliyyah' => 'Kulliyyah of ICT',
                'current_credit' => 9,
                'max_credit' => 18,
                'is_active' => true,
            ],
            [
                'matric_no' => 'ITUM004',
                'name' => 'Nurul Aina',
                'email' => 'aina@itum.edu.my',
                'password' => Hash::make('password123'),
                'phone' => '015-6789012',
                'program' => 'Data Science',
                'semester' => 1,
                'year' => 2024,
                'faculty' => 'Computing',
                'kulliyyah' => 'Kulliyyah of ICT',
                'current_credit' => 0,
                'max_credit' => 18,
                'is_active' => true,
            ],
            [
                'matric_no' => 'ITUM005',
                'name' => 'Ahmad Faris',
                'email' => 'faris@itum.edu.my',
                'password' => Hash::make('password123'),
                'phone' => '016-7890123',
                'program' => 'Cybersecurity',
                'semester' => 5,
                'year' => 2023,
                'faculty' => 'Computing',
                'kulliyyah' => 'Kulliyyah of ICT',
                'current_credit' => 18,
                'max_credit' => 18,
                'is_active' => true,
            ],
        ];

        foreach ($students as $student) {
            Student::create($student);
        }

        $this->command->info('✅ 5 students created successfully!');
        $this->command->info('📝 Login with:');
        $this->command->info('   Matric No: ITUM001 to ITUM005');
        $this->command->info('   Password: password123');
    
        $this->call([
            StudentSeeder::class,
        ]);
    }
}