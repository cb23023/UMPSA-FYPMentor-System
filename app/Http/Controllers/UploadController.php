<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LecturerRecord;
use App\Models\StudentRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UploadController extends Controller
{
    public function upload_user(Request $request)
    {

        // Validate the file input
        $request->validate(
            [
                'file' => 'required|mimes:csv,txt',
            ],
            [
                'file.mimes' => 'The uploaded file must be in CSV format.',
            ]
        );

        $file = fopen($request->file('file'), 'r');
        $isHeader = true;
        $successCount = 0;
        $duplicateCount = 0;
        $invalidRows = []; // To store details of invalid rows

        while (($data = fgetcsv($file)) !== false) {
            // Skip the header row
            if ($isHeader) {
                $isHeader = false;
                continue;
            }

            // Ensure row has at least 5 columns (ID, Name, SpecificField, Role, Email)
            if (count($data) < 5 || empty($data[0]) || empty($data[1]) || empty($data[3]) || empty($data[4])) {
                $invalidRows[] = $data; // Collect invalid rows
                continue; // Skip invalid rows
            }

            $userIdentifier = $data[0]; // StudentID or LecturerID
            $name = $data[1];
            $specificField = $data[2]; // Course for student, numberQuota for lecturer
            $role = strtolower($data[3]); // Role (student or lecturer)
            $email = $data[4];

            // Basic email validation
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $invalidRows[] = $data;
                continue;
            }

            // Generate a temporary password
            $temporaryPassword = uniqid();

            if ($role === 'student') {
                // Check for duplicate studentID
                if (StudentRecord::where('studentID', $userIdentifier)->exists()) {
                    $duplicateCount++;
                    continue;
                }

                // Insert into `users` table
                $user = User::create([
                    'email' => $email,
                    'password' => Hash::make($temporaryPassword),
                    'role' => $role,
                ]);

                // Insert into `student_records` table
                StudentRecord::create([
                    'studentID' => $userIdentifier,
                    'name' => $name,
                    'course' => $specificField,
                    'user_id' => $user->id,
                ]);

                Mail::send('emails.user_registered', [
                    'name' => $name,
                    'email' => $email,
                    'password' => $temporaryPassword,
                ], function ($message) use ($user) {
                    $message->to($user->email)->subject('Student Account Created');
                });

                $successCount++;
            } elseif ($role === 'lecturer') {
                // Check for duplicate lecturerID
                if (LecturerRecord::where('lecturerID', $userIdentifier)->exists()) {
                    $duplicateCount++;
                    continue;
                }

                // Insert into `users` table
                $user = User::create([
                    'email' => $email,
                    'password' => Hash::make($temporaryPassword),
                    'role' => $role,
                ]);

                // Insert into `lecturer_records` table
                LecturerRecord::create([
                    'lecturerID' => $userIdentifier,
                    'name' => $name,
                    'numberQuota' => $specificField,
                    'user_id' => $user->id,
                ]);

                Mail::send('emails.user_registered', [
                    'name' => $name,
                    'email' => $email,
                    'password' => $temporaryPassword,
                ], function ($message) use ($user) {
                    $message->to($user->email)->subject('Lecturer Account Created');
                });

                $successCount++;
            } else {
                $invalidRows[] = $data; // Invalid role
                continue;
            }
        }

        fclose($file);

        if (!empty($invalidRows)) {
            // Redirect back with an error message for invalid rows
            return redirect()->back()->withErrors(['csv_upload' => 'Some rows in the CSV were invalid or had missing data. Please check the CSV file and the template.']);
        }

        return redirect()->back()->with('success', "CSV uploaded successfully! {$successCount} records inserted, {$duplicateCount} duplicates skipped.");
    }

    public function downloadUserTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="user_upload_template.csv"',
        ];

        $output = fopen('php://temp', 'r+');
        fputcsv($output, ['ID', 'Name', 'Course_or_Quota', 'Role', 'Email']);
        fputcsv($output, ['S12345', 'John Doe', 'Software Engineering', 'student', 'john.doe@example.com']);
        fputcsv($output, ['L67890', 'Jane Smith', '5', 'lecturer', 'jane.smith@example.com']);

        rewind($output);
        $csvContent = stream_get_contents($output);
        fclose($output);

        return response($csvContent, 200, $headers);
    }
}
