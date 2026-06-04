<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRecord;
use App\Models\LecturerRecord;
use App\Models\StudentRecord;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    // STUDENT: Show form to apply appointment with a specific lecturer
    public function applyAppointment($lecturerID)
    {
        $lecturer = LecturerRecord::find($lecturerID);

        if (!$lecturer) {
            return back()->withErrors('Lecturer not found.');
        }

        return view('student.applyAppointment', compact('lecturer'));
    }

    // STUDENT: Submit appointment application
    public function applyForm(Request $request)
    {
        $request->validate([
            'lecturerID'   => 'required|exists:lecturer_records,lecturerID',
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'date'         => 'required|date|after_or_equal:today',
            'time'         => 'required|date_format:H:i',
            'meeting_type' => 'required|in:physical,online',
            'meeting_link' => 'nullable|url',
        ]);

        $student = StudentRecord::where('user_id', Auth::id())->first();

        $appointment = AppointmentRecord::create([
            'title'        => $request->title,
            'description'  => $request->description,
            'date'         => $request->date,
            'time'         => $request->time,
            'status'       => 'Pending',
            'meeting_type' => $request->meeting_type,
            'meeting_link' => $request->meeting_link,
            'lecturerID'   => $request->lecturerID,
            'studentID'    => $student->studentID,
        ]);

        // Notify the lecturer
        $lecturer = LecturerRecord::find($request->lecturerID);
        if ($lecturer) {
            Notification::create([
                'user_id'          => $lecturer->user_id,
                'type'             => 'appointment',
                'message'          => "New appointment request from {$student->name} on {$appointment->date} at {$appointment->time}.",
                'notifiable_type'  => AppointmentRecord::class,
                'notifiable_id'    => $appointment->id,
            ]);
        }

        return redirect()->route('appointmentRequest')->with('success', 'Appointment request submitted successfully.');
    }

    // STUDENT: View own appointment requests
    public function appointmentRequest()
    {
        $student = StudentRecord::where('user_id', Auth::id())->first();

        if (!$student) {
            return back()->withErrors('Student record not found.');
        }

        $appointments = AppointmentRecord::where('studentID', $student->studentID)
            ->with('lecturer')
            ->orderBy('date', 'asc')
            ->get();

        return view('student.appointmentRequest', compact('appointments'));
    }

    // STUDENT: Show edit form for a pending appointment
    public function edit($id)
    {
        $appointment = AppointmentRecord::findOrFail($id);

        if ($appointment->status !== 'Pending') {
            return back()->withErrors('Only pending appointments can be edited.');
        }

        $lecturer = LecturerRecord::find($appointment->lecturerID);

        return view('student.editAppointment', compact('appointment', 'lecturer'));
    }

    // STUDENT: Update a pending appointment
    public function update(Request $request, $id)
    {
        $appointment = AppointmentRecord::findOrFail($id);

        if ($appointment->status !== 'Pending') {
            return back()->withErrors('Only pending appointments can be updated.');
        }

        $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string',
            'date'         => 'required|date|after_or_equal:today',
            'time'         => 'required|date_format:H:i',
            'meeting_type' => 'required|in:physical,online',
            'meeting_link' => 'nullable|url',
        ]);

        $appointment->update([
            'title'        => $request->title,
            'description'  => $request->description,
            'date'         => $request->date,
            'time'         => $request->time,
            'meeting_type' => $request->meeting_type,
            'meeting_link' => $request->meeting_link,
        ]);

        return redirect()->route('appointmentRequest')->with('success', 'Appointment details updated successfully.');
    }

    // STUDENT: Cancel a pending appointment
    public function cancelAppointment($id)
    {
        $appointment = AppointmentRecord::findOrFail($id);

        if ($appointment->status !== 'Pending') {
            return back()->withErrors('Only pending appointments can be cancelled.');
        }

        $appointment->delete();

        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }

    // LECTURER: View all appointment requests for this lecturer
    public function responseAppointment()
    {
        $lecturer = LecturerRecord::where('user_id', Auth::id())->first();

        if (!$lecturer) {
            return back()->withErrors('Lecturer record not found.');
        }

        $appointments = AppointmentRecord::where('lecturerID', $lecturer->lecturerID)
            ->with('student')
            ->orderByRaw("FIELD(status, 'Pending', 'Approved', 'Rejected')")
            ->orderBy('date', 'asc')
            ->get();

        return view('lecturer.responseAppointment', compact('appointments'));
    }

    // LECTURER: Approve or reject an appointment
    public function approval(Request $request, $id)
    {
        $appointment = AppointmentRecord::findOrFail($id);

        if ($request->action === 'approve') {
            $appointment->status = 'Approved';
            $appointment->rejection_reason = null;
        } elseif ($request->action === 'reject') {
            $appointment->status = 'Rejected';
            $appointment->rejection_reason = $request->rejection_reason;
        }

        $appointment->save();

        // Notify the student
        $student = StudentRecord::where('studentID', $appointment->studentID)->first();
        if ($student) {
            $statusText = $appointment->status === 'Approved' ? 'approved' : 'rejected';
            Notification::create([
                'user_id'          => $student->user_id,
                'type'             => 'appointment',
                'message'          => "Your appointment on {$appointment->date} at {$appointment->time} has been {$statusText}.",
                'notifiable_type'  => AppointmentRecord::class,
                'notifiable_id'    => $appointment->id,
            ]);
        }

        return redirect()->route('responseAppointment')->with('success', 'Appointment status updated.');
    }
}
