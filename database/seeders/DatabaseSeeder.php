<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\StudentRecord;
use App\Models\LecturerRecord;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // FYP Coordinator
        User::create([
            'email'    => 'coordinator@fyp.com',
            'password' => Hash::make('password'),
            'role'     => 'fypcoordinator',
        ]);

        // Lecturers
        $lecturers = [
            ['id' => 'L001', 'name' => 'Dr. Ahmad Fauzi',    'email' => 'ahmad.fauzi@fyp.com',    'quota' => 5],
            ['id' => 'L002', 'name' => 'Dr. Siti Aminah',    'email' => 'siti.aminah@fyp.com',    'quota' => 4],
            ['id' => 'L003', 'name' => 'Prof. Rahul Kumar',  'email' => 'rahul.kumar@fyp.com',    'quota' => 6],
        ];

        foreach ($lecturers as $l) {
            $user = User::create([
                'email'    => $l['email'],
                'password' => Hash::make('password'),
                'role'     => 'lecturer',
            ]);

            LecturerRecord::create([
                'lecturerID'    => $l['id'],
                'user_id'       => $user->id,
                'name'          => $l['name'],
                'numberQuota'   => $l['quota'],
                'profilePicture'=> null,
                'timetable'     => null,
            ]);
        }

        // Students
        $students = [
            ['id' => 'S001', 'name' => 'Ali bin Abu',         'email' => 'ali.abu@fyp.com',         'course' => 'CS'],
            ['id' => 'S002', 'name' => 'Nurul Ain',           'email' => 'nurul.ain@fyp.com',       'course' => 'SE'],
            ['id' => 'S003', 'name' => 'Chong Wei Liang',     'email' => 'chong.wei@fyp.com',       'course' => 'IT'],
            ['id' => 'S004', 'name' => 'Priya Ramasamy',      'email' => 'priya.rama@fyp.com',      'course' => 'CS'],
            ['id' => 'S005', 'name' => 'Muhammad Haziq',      'email' => 'haziq@fyp.com',           'course' => 'SE'],
        ];

        foreach ($students as $s) {
            $user = User::create([
                'email'    => $s['email'],
                'password' => Hash::make('password'),
                'role'     => 'student',
            ]);

            StudentRecord::create([
                'studentID' => $s['id'],
                'user_id'   => $user->id,
                'name'      => $s['name'],
                'course'    => $s['course'],
            ]);
        }
    }
}
