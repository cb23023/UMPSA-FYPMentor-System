<?php

namespace App\Http\Controllers;

use App\Models\AppointmentRecord;
use App\Models\StudentRecord;
use App\Models\LecturerRecord;
use App\Models\TopicApplication;
use App\Models\TopicRecord;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MainMenuController extends Controller
{

    //MIKA SECTION
    //DISPLAY STUDENT LIST
    public function fypstudentList(Request $request)
    {
        $entryYear = $request->input('entry_year');
        $course = $request->input('course');

        $query = StudentRecord::query();

        if ($entryYear) {
            // Assuming studentID format: XXYY... where YY is the last two digits of the year
            $query->whereRaw('SUBSTRING(studentID, 3, 2) = ?', [substr($entryYear, -2)]);
        }
        if ($course) {
            $query->where('course', $course);
        }

        $data = $query->get();

        // For filter dropdowns
        $courses =StudentRecord::select('course')->distinct()->pluck('course');
        $years = StudentRecord::selectRaw('DISTINCT CONCAT("20", SUBSTRING(studentID, 3, 2)) as year')
            ->pluck('year');

        return view('fypcoordinator.studentList', compact('data', 'courses', 'years', 'entryYear', 'course'));
    }

    //DISPLAY LECTURER LIST
    public function fyplecturerList(Request $request)
    {
        $lecturerID = $request->input('lecturerID');
        $name = $request->input('name');

        $query = LecturerRecord::query();

        if ($lecturerID) {
            $query->where('lecturerID', 'LIKE', "%$lecturerID%");
        }
        if ($name) {
            $query->where('name', 'LIKE', "%$name%");
        }

        $data = $query->get();

        // For filter dropdowns (optional, if you want to list all IDs/names)
        $lecturerIDs = LecturerRecord::select('lecturerID')->distinct()->pluck('lecturerID');
        $names = LecturerRecord::select('name')->distinct()->pluck('name');

        return view('fypcoordinator.lecturerList', compact('data', 'lecturerID', 'name', 'lecturerIDs', 'names'));
    }

    //DISPLAY UPLOAD INTERFACE
    public function uploadUser()
    {
        return view('fypcoordinator.uploadUser');
    }

    //DISPLAY REPORT INTERFACE
    public function fypReport()
    {
        return view('fypcoordinator.report');
    }

    //GENERATE REPORT USER
    public function generateReport(Request $request)
    {

        if ($request->type === 'student') {
            $data = StudentRecord::get();
            $pdf = Pdf::loadView('fypcoordinator.userList', [
                'data' => $data
            ]);
            return $pdf->download('userList.pdf');
        } else {
            $data = LecturerRecord::get();
            $pdf = Pdf::loadView('fypcoordinator.userList', [
                'data' => $data
            ]);
            return $pdf->download('userList.pdf');
        }
    }

    //NURUL INSYIRAH SECTION

    //DISPLAY QUOTA PAGE
    public function manageQuota()
    {

        $lecturer = LecturerRecord::all();

        return view('fypcoordinator.manageQuota', compact('lecturer'));
    }

    //DISPLAY TIMEFRAME PAGE
    public function manageTimeFrame()
    {
        return view('fypcoordinator.manageTimeFrame');
    }

    //DISPLAY USER LIST PAGE
    public function userList()
    {
        $lecturers = LecturerRecord::with('user')->get();
        $students = StudentRecord::with('user')->get();
        return view('fypcoordinator.userList', compact('lecturers', 'students'));
    }

    //DISPLAY TOPIC APPROVAL PAGE
    public function topicApproval()
    {
        $user = auth()->user()->id;
        $lecturer = LecturerRecord::where('user_id', $user)->first();
        $lecturerID = $lecturer->lecturerID;

        // Fetch topics where lecturerID matches the logged-in lecturer's ID
        $topic = TopicApplication::with(['student', 'topic']) // Eager load student and topic relationships
            ->whereHas('topic', function ($query) use ($lecturerID) {
                $query->where('lecturerID', $lecturerID);
            })->where('status', 'Pending')->get();

        // Pass the data to the view
        return view('lecturer.topicApproval', compact('topic'));
    }

    //DISPLAY VIEW PROFILE LECTURER
    public function viewProfile()
    {
        $lecturer = LecturerRecord::where('user_id', Auth::id())->first();

        $topic = TopicRecord::where('lecturerID', $lecturer->lecturerID)
            ->where('is_custom', 0)
            ->get();

        $closedCustomTopics = TopicRecord::where('lecturerID', $lecturer->lecturerID)
            ->where('is_custom', 1)
            ->where('status', 'Closed')
            ->get();

        return view('lecturer.viewProfile', compact('lecturer', 'topic', 'closedCustomTopics'));
    }

    //UPDATE PICTURE LECTURER
    public function uploadPicture(Request $request, $lecturerID)
    {


        $data = LecturerRecord::find($lecturerID);

        $image = $request->profilePicture;

        $filename = time() . '.' . $image->getClientOriginalExtension();

        $request->profilePicture->move('lecturerProfile', $filename);

        $data->profilePicture = $filename;

        $data->save();

        return redirect()->back();
    }

    //UPDATE TIMETABLE LECTURER
    public function uploadTimetable(Request $request, $lecturerID)
    {


        $data = LecturerRecord::find($lecturerID);

        $image = $request->timetable;

        $filename = time() . '.' . $image->getClientOriginalExtension();

        $request->timetable->move('timetable', $filename);

        $data->timetable = $filename;

        $data->save();

        return redirect()->back();
    }

    //DISPLAY LIST OF LECTURER
    public function listOfLecturer()
    {
        $lecturer = LecturerRecord::all();
        return view('student.listOfLecturer', compact('lecturer'));
    }

    //DISPLAY TOPIC REQUEST PAGE
    public function topicRequest()
    {
        $user = auth()->user()->id; // Get the authenticated user's ID
        $student = StudentRecord::where('user_id', $user)->first(); // Fetch the student's record

        // Fetch the topic applications for the student
        $topic = TopicApplication::where('studentID', $student->studentID)
            ->with('topic.lecturer') // Load related topic and lecturer data
            ->get();

        // Pass the topics to the view
        return view('student.topicRequest', compact('topic'));
    }


    public function lecturerProfile($lecturerID)
    {

        $lecturer = LecturerRecord::find($lecturerID);

        $topic = TopicRecord::where('lecturerID', '=', $lecturerID)
            ->where('is_custom', 0)
            ->where('status', 'Actived')
            ->get();

        return view('student.lecturerProfile', compact('lecturer', 'topic'));
    }

    //APPOINTMENT SECTION
    //DISPLAY APPLY APPOINTMENT
    public function applyAppointment($lecturerID)
    {
        $lecturer = LecturerRecord::find($lecturerID);

        return view('student.applyAppointment', compact('lecturer'));
    }
    //Apply Appointment
    public function applyForm(Request $request)
    {
        $request->validate([
            'lecturerID' => 'required|exists:lecturer_records,lecturerID',
            'date' => 'required|date',
            'time' => 'required|date_format:H:i',
        ]);

        $user = Auth()->user()->id;
        $student = StudentRecord::where('user_id', $user)->first();

        $appointment = new AppointmentRecord;
        $appointment->date = $request->date;
        $appointment->time = $request->time;
        $appointment->status = 'Pending';
        $appointment->lecturerID = $request->lecturerID;
        $appointment->studentID = $student->studentID;

        $appointment->save();

        $lecturer = LecturerRecord::where('lecturerID', $request->lecturerID)
            ->with('user') // Assuming there's a relation 'user' in LecturerRecord model
            ->first();

        if ($lecturer && $lecturer->user && $lecturer->user->email) {
            // Send an email notification to the lecturer
            Mail::send('emails.appointment_notification', [
                'studentName' => $student->name,
                'appointmentDate' => $appointment->date,
                'appointmentTime' => $appointment->time,
            ], function ($message) use ($lecturer) {
                $message->to($lecturer->user->email)->subject('New Appointment Booking Notification');
            });
        }

        return redirect('appointmentRequest');
    }

    //DISPLAY APPOINTMENT REQUEST
    public function appointmentRequest()
    {
        $user = Auth::user(); // Get logged-in user
        $student = StudentRecord::where('user_id', $user->id)->first(); // Find the student record

        if (!$student) {
            return back()->withErrors('Student record not found.');
        }

        // Fetch appointments for this student
        $appointments = AppointmentRecord::where('studentID', $student->studentID)
            ->join('lecturer_records', 'appointment_records.lecturerID', '=', 'lecturer_records.lecturerID') // Join to get lecturer name
            ->select('appointment_records.*', 'lecturer_records.name as lecturer_name')
            ->orderBy('date', 'asc')
            ->get();

        return view('student.appointmentRequest', compact('appointments'));
    }

    //STUDENT CANCEL APPOINTMENT
    public function cancelAppointment($id)
    {
        $appointment = AppointmentRecord::find($id);

        if (!$appointment || $appointment->status != 'Pending') {
            return back()->withErrors('Cannot cancel this appointment.');
        }

        $appointment->delete();
        return redirect()->back()->with('success', 'Appointment cancelled successfully.');
    }

    //LECTURER RESPONSE APPOINTMENT DISPLAY
    public function responseAppointment()
    {
        $appointments = AppointmentRecord::all();

        return view('lecturer.responseAppointment', compact('appointments'));
    }

    //LECTURER APPROVAL
    public function approval(Request $request, $id)
    {

        $appointment = AppointmentRecord::find($id);

        if ($request->action == 'approve') {
            $appointment->status = 'Approved';
        } elseif ($request->action == 'reject') {
            $appointment->status = 'Rejected';
        }

        $appointment->save();

        return redirect('responseAppointment');
    }

    //DISPLAY APPLYTOPIC
    public function applyTopic($lecturerID)
    {
        $lecturer = LecturerRecord::find($lecturerID);

        $topic = TopicRecord::where('lecturerID', $lecturerID)
            ->where('is_custom', 0)
            ->where('status', 'Actived')
            ->get();


        $user = Auth()->user()->id;
        $student = StudentRecord::where('user_id', $user)->first();

        $hasPendingRequest = TopicApplication::where('studentID', operator: $student->studentID)
            ->where('status', 'Pending')
            ->exists();


        return view('student.applyTopic', compact('lecturer', 'topic', 'hasPendingRequest'));
    }

    //REVIEW APPLY TOPIC PAGE
    public function review($id)
    {

        $topic = TopicApplication::findOrFail($id);  // Adjust the model name as needed

        return view('lecturer.reviewApproval', compact('topic'));
    }

    //UPDATE APPLY TOPIC REQUEST
    public function update(Request $request, $id)
    {
        // Find the topic application by ID
        $topicApplication = TopicApplication::findOrFail($id);

        // Get the topic and lecturer associated with the application
        $topic = $topicApplication->topic;
        $lecturer = $topic->lecturer; // Assuming the topic has a 'lecturer' relation

        // Check if the lecturer has available quota
        if ($request->input('status') === 'Approved' && $lecturer && $lecturer->numberQuota <= 0) {
            // Automatically reject the application if the quota is 0
            $topicApplication->status = 'Rejected';
            $topicApplication->remarks = 'Application rejected due to no available quota for the lecturer.';
            $topicApplication->save();

            // Send an email to the student about the rejection
            $student = $topicApplication->student;
            Mail::send('emails.topic_approval', [
                'studentName' => $student->name,
                'topicTitle' => $topic->title,
                'status' => 'Rejected',
                'remarks' => $topicApplication->remarks,
            ], function ($message) use ($student) {
                $message->to($student->user->email)->subject('Your Topic Application has been Rejected');
            });

            // Redirect back with an error message
            return redirect()->back()->withErrors(['error' => 'The lecturer has no available quota to accept new students.']);
        }

        // Update the topic application status and remarks
        $topicApplication->status = $request->input('status');
        $topicApplication->remarks = $request->input('remarks');
        $topicApplication->save();

        // Handle the logic when the application is approved
        if ($topicApplication->status === 'Approved') {
            // Assign the topic to the student and close it
            $topic->studentID = $topicApplication->studentID;
            $topic->status = 'Closed'; // Mark the topic as closed
            $topic->save();

            // Decrement the lecturer's quota
            $lecturer->numberQuota -= 1;
            $lecturer->save();

            // Automatically reject other applications for the same topic
            $otherApplications = TopicApplication::where('topicID', $topic->topicID)
                ->where('id', '!=', $topicApplication->id)
                ->where('status', 'Pending')
                ->get();

            foreach ($otherApplications as $otherApplication) {
                $otherApplication->status = 'Rejected';
                $otherApplication->remarks = 'Application rejected as the topic has been assigned to another student.';
                $otherApplication->save();

                // Send an email to the other students about the rejection
                $otherStudent = $otherApplication->student;
                Mail::send('emails.topic_approval', [
                    'studentName' => $otherStudent->name,
                    'topicTitle' => $topic->title,
                    'status' => 'Rejected',
                    'remarks' => $otherApplication->remarks,
                ], function ($message) use ($otherStudent) {
                    $message->to($otherStudent->user->email)->subject('Your Topic Application has been Rejected');
                });
            }
            // Send an email to the student about the acceptance
            $student = $topicApplication->student;
            Mail::send('emails.topic_approval', [
                'studentName' => $student->name,
                'topicTitle' => $topic->title,
                'status' => 'Accepted',
                'remarks' => $topicApplication->remarks,
            ], function ($message) use ($student) {
                $message->to($student->user->email)->subject('Your Topic Application has been Accepted');
            });
        }

        // Handle the logic when the application is rejected
        if ($topicApplication->status === 'Rejected') {
            // Send an email to the student about the rejection
            $student = $topicApplication->student;
            Mail::send('emails.topic_approval', [
                'studentName' => $student->name,
                'topicTitle' => $topic->title,
                'status' => 'Rejected',
                'remarks' => $topicApplication->remarks,
            ], function ($message) use ($student) {
                $message->to($student->user->email)->subject('Your Topic Application has been Rejected');
            });
        }

        // Redirect back to the topic approval page
        return redirect('topicApproval');
    }





    //FUNCTION TO SEARCH LECTURERS
    public function searchLecturers(Request $request)
    {
        // Get the search query from the input field
        $query = $request->input('query');

        // Fetch lecturers whose names match the query
        $lecturer = LecturerRecord::where('name', 'LIKE', "%$query%")
            ->with('user') // Eager load the related user for email
            ->get();

        // Return the view with the filtered list of lecturers
        return view('student.listOfLecturer', compact('lecturer'));
    }
}
