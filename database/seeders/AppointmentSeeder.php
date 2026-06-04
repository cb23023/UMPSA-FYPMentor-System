<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppointmentSeeder extends Seeder
{
    public function run(): void
    {
        $appointments = [
            [
                'title'            => 'Perbincangan Cadangan Tajuk FYP',
                'description'      => 'Sesi berbincang mengenai cadangan tajuk FYP semester ini.',
                'time'             => '10:00 AM',
                'date'             => '2025-03-10',
                'status'           => 'Approved',
                'meeting_type'     => 'physical',
                'meeting_link'     => null,
                'rejection_reason' => null,
                'lecturerID'       => 'L001',
                'studentID'        => 'CB21023',
            ],
            [
                'title'            => 'Semakan Progress Bab 1',
                'description'      => 'Semak draf Bab 1 - Pengenalan.',
                'time'             => '02:00 PM',
                'date'             => '2025-03-15',
                'status'           => 'Approved',
                'meeting_type'     => 'online',
                'meeting_link'     => 'https://meet.google.com/abc-defg-hij',
                'rejection_reason' => null,
                'lecturerID'       => 'L001',
                'studentID'        => 'CB21024',
            ],
            [
                'title'            => 'Konsultasi Metodologi Kajian',
                'description'      => 'Berbincang mengenai metodologi yang sesuai untuk kajian.',
                'time'             => '11:00 AM',
                'date'             => '2025-03-20',
                'status'           => 'Pending',
                'meeting_type'     => 'physical',
                'meeting_link'     => null,
                'rejection_reason' => null,
                'lecturerID'       => 'L002',
                'studentID'        => 'CB21025',
            ],
            [
                'title'            => 'Perbincangan Rekabentuk Sistem',
                'description'      => 'Semakan rekabentuk sistem dan ERD.',
                'time'             => '09:00 AM',
                'date'             => '2025-03-22',
                'status'           => 'Rejected',
                'meeting_type'     => 'physical',
                'meeting_link'     => null,
                'rejection_reason' => 'Tarikh tidak sesuai, sila pilih tarikh lain.',
                'lecturerID'       => 'L002',
                'studentID'        => 'CB21026',
            ],
            [
                'title'            => 'Semakan Draf Laporan Akhir',
                'description'      => 'Semak draf laporan akhir sebelum penghantaran.',
                'time'             => '03:00 PM',
                'date'             => '2025-04-05',
                'status'           => 'Pending',
                'meeting_type'     => 'online',
                'meeting_link'     => null,
                'rejection_reason' => null,
                'lecturerID'       => 'L003',
                'studentID'        => 'CB21027',
            ],
        ];

        foreach ($appointments as $appt) {
            DB::table('appointment_records')->insert([
                'title'            => $appt['title'],
                'description'      => $appt['description'],
                'time'             => $appt['time'],
                'date'             => $appt['date'],
                'status'           => $appt['status'],
                'meeting_type'     => $appt['meeting_type'],
                'meeting_link'     => $appt['meeting_link'],
                'rejection_reason' => $appt['rejection_reason'],
                'lecturerID'       => $appt['lecturerID'],
                'studentID'        => $appt['studentID'],
                'created_at'       => now(),
                'updated_at'       => now(),
            ]);
        }
    }
}
