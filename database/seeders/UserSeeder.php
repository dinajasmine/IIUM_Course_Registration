<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        

        //admin users
        \App\Models\User::firstOrCreate([
            'name'=>'Admin User',
            'username'=>'admin003',
            'email'=>'admin003@iium.edu.my',
            'password'=>bcrypt('Admin@003#'),
            'user_type'=>'ADMIN'
        ]);

        User::create([
            'name'=>'Admin User2',
            'username'=>'admin411',
            'email'=>'admin411@iium.edu.my',
            'password'=>bcrypt('411@admin'),
            'user_type'=>'ADMIN'
        ]);

        //student users
        $students = [
            [
                'name'=>'Dina Jasmine',
                'username'=>'2419290',
                'email'=>'dina@iium.edu.my',
                'password'=>bcrypt('Justmine@123'),
                'user_type'=>'STUDENT'
            ],

            [
                'name' => 'Siti binti Rahman',
                'username' => 'siti2024',
                'email' => 'siti@student.iium.edu.my',
                'password' => bcrypt('Siti@2024#'),
                'user_type' => 'STUDENT'
            ],

            [
                'name' => 'Muhammad bin Hassan',
                'username' => 'muhammad2024',
                'email' => 'muhammad@student.iium.edu.my',
                'password' => bcrypt('Muhammad@2024#'),
                'user_type' => 'STUDENT'
            ],

            [
                'name' => 'Aisyah binti Kamal',
                'username' => 'aisyah2024',
                'email' => 'aisyah@student.iium.edu.my',
                'password' => bcrypt('Aisyah@2024#'),
                'user_type' => 'STUDENT'
            ],

            [
                'name' => 'Ali bin Abu',
                'username' => 	'ali2024',
               	'email' =>'ali@student.iium.edu.my',
                'password'=>bcrypt('Ali@2024#'),
                'user_type'=>'STUDENT'
            ]
        ];

        foreach ($students as $student) {
            User::create($student);
        }

        $this->command->info('Users seeded successfully!');
    }
}
