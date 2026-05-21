<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRecord;
use App\Models\LecturerRecord;
use App\Models\Notification;
use App\Models\StudentRecord;
use App\Models\TimeFrameRecord;
use App\Models\TopicApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $role = Auth::user()->role;

        if ($role === 'fypcoordinator') {
            return $this->coordinatorDashboard();
        } elseif ($role === 'lecturer') {
            return $this->lecturerDashboard();
        } elseif ($role === 'student') {
            return $this->studentDashboard();
        }

        return redirect('/login');
    }

    private function coordinatorDashboard()
    {
        $totalLecturers  = LecturerRecord::count();
        $totalStudents   = StudentRecord::count();
        $activeTimeFrame = TimeFrameRecord::where('is_active', true)->first();

        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')->count();

        return view('fypcoordinator.dashboard', compact(
            'totalLecturers',
            'totalStudents',
            'activeTimeFrame',
            'unreadNotifications'
        ));
    }

    private function lecturerDashboard()
    {
        $lecturer = LecturerRecord::where('user_id', Auth::id())->first();

        $appointments = [];
        $quotaLeft    = 0;
        $currentStudents = 0;

        if ($lecturer) {
            $appointments = AppointmentRecord::where('lecturerID', $lecturer->lecturerID)
                ->with('student')
                ->orderBy('date', 'desc')
                ->limit(5)
                ->get();

            $quotaLeft       = (int) $lecturer->numberQuota;
            $currentStudents = (int) $lecturer->current_students;
        }

        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')->count();

        return view('lecturer.dashboard', compact(
            'lecturer',
            'appointments',
            'quotaLeft',
            'currentStudents',
            'unreadNotifications'
        ));
    }

    private function studentDashboard()
    {
        $student = StudentRecord::where('user_id', Auth::id())->first();

        $approvedTopics       = [];
        $approvedAppointments = [];

        if ($student) {
            $approvedTopics = TopicApplication::where('studentID', $student->studentID)
                ->where('status', 'Approved')
                ->with('topic.lecturer')
                ->get();

            $approvedAppointments = AppointmentRecord::where('studentID', $student->studentID)
                ->where('status', 'Approved')
                ->with('lecturer')
                ->orderBy('date', 'desc')
                ->get();
        }

        $unreadNotifications = Notification::where('user_id', Auth::id())
            ->whereNull('read_at')->count();

        return view('student.dashboard', compact(
            'student',
            'approvedTopics',
            'approvedAppointments',
            'unreadNotifications'
        ));
    }

    public function changePassword()
    {
        $user = Auth::user();

        if ($user->role === 'student') {
            return view('student.changePassword');
        } elseif ($user->role === 'lecturer') {
            return view('lecturer.changePassword');
        }

        return redirect('/home');
    }

    public function newPassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update(['password' => Hash::make($request->new_password)]);

        return redirect('/home')->with('success', 'Password changed successfully.');
    }
}
