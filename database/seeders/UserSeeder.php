<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // FYP Coordinator
        DB::table('users')->insert([
            'email'      => 'coordinator@umpsa.edu.my',
            'password'   => Hash::make('password'),
            'role'       => 'fypcoordinator',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Lecturers
        $lecturers = [
            ['email' => 'ahmad.zaki@umpsa.edu.my',   'name' => 'Dr. Ahmad Zaki bin Ismail'],
            ['email' => 'nurul.ain@umpsa.edu.my',    'name' => 'Dr. Nurul Ain binti Razak'],
            ['email' => 'hafiz.rahman@umpsa.edu.my', 'name' => 'Prof. Hafiz bin Rahman'],
        ];

        foreach ($lecturers as $l) {
            DB::table('users')->insert([
                'email'      => $l['email'],
                'password'   => Hash::make('password'),
                'role'       => 'lecturer',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Students
        $students = [
            'ali.hassan@student.umpsa.edu.my',
            'siti.nora@student.umpsa.edu.my',
            'rahman.aziz@student.umpsa.edu.my',
            'farah.diana@student.umpsa.edu.my',
            'khairul.anwar@student.umpsa.edu.my',
        ];

        foreach ($students as $email) {
            DB::table('users')->insert([
                'email'      => $email,
                'password'   => Hash::make('password'),
                'role'       => 'student',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
