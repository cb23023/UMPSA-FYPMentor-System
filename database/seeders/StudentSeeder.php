<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $studentUsers = DB::table('users')->where('role', 'student')->get();

        $studentData = [
            ['studentID' => 'CB21023', 'name' => 'Ali bin Hassan',         'course' => 'CS'],
            ['studentID' => 'CB21024', 'name' => 'Siti Nora binti Ahmad',  'course' => 'SE'],
            ['studentID' => 'CB21025', 'name' => 'Rahman bin Aziz',        'course' => 'CS'],
            ['studentID' => 'CB21026', 'name' => 'Farah Diana binti Malik','course' => 'IT'],
            ['studentID' => 'CB21027', 'name' => 'Khairul Anwar bin Daud', 'course' => 'SE'],
        ];

        foreach ($studentUsers as $index => $user) {
            DB::table('student_records')->insert([
                'studentID'  => $studentData[$index]['studentID'],
                'user_id'    => $user->id,
                'name'       => $studentData[$index]['name'],
                'course'     => $studentData[$index]['course'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
