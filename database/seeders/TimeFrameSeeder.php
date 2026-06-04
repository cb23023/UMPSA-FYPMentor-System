<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeFrameSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('time_frame_records')->insert([
            [
                'description'   => 'FYP Registration Semester 1 2024/2025',
                'semester'      => 'Semester 1',
                'academic_year' => '2024/2025',
                'startDate'     => '2024-09-01',
                'endDate'       => '2025-01-31',
                'status'        => 'inactive',
                'is_active'     => false,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
            [
                'description'   => 'FYP Registration Semester 2 2024/2025',
                'semester'      => 'Semester 2',
                'academic_year' => '2024/2025',
                'startDate'     => '2025-02-01',
                'endDate'       => '2025-07-31',
                'status'        => 'active',
                'is_active'     => true,
                'created_at'    => now(),
                'updated_at'    => now(),
            ],
        ]);
    }
}
