<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        $topics = [
            // L001
            ['title' => 'Sistem Pengesanan Penyakit Tanaman Menggunakan CNN', 'description' => 'Membangunkan model deep learning untuk mengesan penyakit tanaman melalui imej daun.', 'status' => 'Active', 'lecturerID' => 'L001'],
            ['title' => 'Aplikasi Mobile Pengurusan Jadual Peperiksaan', 'description' => 'Sistem pengurusan jadual peperiksaan berbasis mobile untuk pelajar UMPSA.', 'status' => 'Active', 'lecturerID' => 'L001'],
            ['title' => 'Analisis Sentimen Media Sosial Menggunakan NLP', 'description' => 'Kajian analisis sentimen pengguna media sosial tempatan menggunakan teknik NLP.', 'status' => 'Pending', 'lecturerID' => 'L001'],

            // L002
            ['title' => 'Sistem Pengesyoran Kursus Berdasarkan Profil Pelajar', 'description' => 'Platform cadangan kursus elektif menggunakan collaborative filtering.', 'status' => 'Active', 'lecturerID' => 'L002'],
            ['title' => 'Pembangunan Chatbot Sokongan Pelajar Menggunakan AI', 'description' => 'Chatbot berasaskan NLP untuk menjawab soalan pelajar berkaitan akademik.', 'status' => 'Active', 'lecturerID' => 'L002'],

            // L003
            ['title' => 'Sistem Pemantauan Kualiti Air Sungai IoT', 'description' => 'Rangkaian sensor IoT untuk pemantauan kualiti air sungai secara masa nyata.', 'status' => 'Active', 'lecturerID' => 'L003'],
            ['title' => 'Keselamatan Rangkaian Menggunakan Machine Learning', 'description' => 'Pengesanan pencerobohan rangkaian menggunakan algoritma machine learning.', 'status' => 'Closed', 'lecturerID' => 'L003'],
        ];

        foreach ($topics as $topic) {
            DB::table('topic_records')->insert([
                'title'       => $topic['title'],
                'description' => $topic['description'],
                'status'      => $topic['status'],
                'lecturerID'  => $topic['lecturerID'],
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }
    }
}
