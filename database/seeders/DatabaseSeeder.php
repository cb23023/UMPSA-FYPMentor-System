<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            LecturerSeeder::class,
            StudentSeeder::class,
            TimeFrameSeeder::class,
            TopicSeeder::class,
            AppointmentSeeder::class,
        ]);
    }
}
