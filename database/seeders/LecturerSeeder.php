<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LecturerSeeder extends Seeder
{
    public function run(): void
    {
        $lecturerUsers = DB::table('users')->where('role', 'lecturer')->get();

        $lecturerData = [
            ['lecturerID' => 'L001', 'name' => 'Dr. Ahmad Zaki bin Ismail',   'numberQuota' => 5],
            ['lecturerID' => 'L002', 'name' => 'Dr. Nurul Ain binti Razak',   'numberQuota' => 4],
            ['lecturerID' => 'L003', 'name' => 'Prof. Hafiz bin Rahman',      'numberQuota' => 6],
        ];

        foreach ($lecturerUsers as $index => $user) {
            DB::table('lecturer_records')->insert([
                'lecturerID'         => $lecturerData[$index]['lecturerID'],
                'user_id'            => $user->id,
                'name'               => $lecturerData[$index]['name'],
                'numberQuota'        => $lecturerData[$index]['numberQuota'],
                'current_students'   => 0,
                'accepting_students' => true,
                'created_at'         => now(),
                'updated_at'         => now(),
            ]);
        }
    }
}
