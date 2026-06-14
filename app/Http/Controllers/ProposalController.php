<?php

namespace App\Http\Controllers;

use App\Models\TopicRecord;
use App\Models\TopicApplication;
use App\Models\LecturerRecord;
use App\Models\StudentRecord;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProposalController extends Controller
{
    // LECTURER: Post a new topic/proposal
    public function postTopic(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $lecturer = LecturerRecord::where('user_id', Auth::id())->first();

        TopicRecord::create([
            'title'       => $request->title,
            'description' => $request->description,
            'lecturerID'  => $lecturer->lecturerID,
            'is_custom'   => false,
            'status'      => 'Actived',
        ]);

        return redirect()->back()->with('success', 'Topic posted successfully.');
    }

    // LECTURER: Show edit topic form
    public function editTopic($topicID)
    {
        $topic = TopicRecord::findOrFail($topicID);
        return view('lecturer.editTopic', compact('topic'));
    }

    // LECTURER: Update a topic
    public function updateTopic(Request $request, $topicID)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $topic = TopicRecord::findOrFail($topicID);
        $topic->update([
            'title'       => $request->title,
            'description' => $request->description,
        ]);

        return redirect()->route('viewProfile')->with('success', 'Topic updated successfully.');
    }

    // LECTURER: Delete a topic
    public function deleteTopic($topicID)
    {
        $topic = TopicRecord::findOrFail($topicID);
        $topic->delete();

        return redirect()->back()->with('success', 'Topic deleted successfully.');
    }

    // LECTURER: View pending topic applications
    public function topicApproval()
    {
        $lecturer = LecturerRecord::where('user_id', Auth::id())->first();

        $applications = TopicApplication::with(['student', 'topic'])
            ->whereHas('topic', function ($q) use ($lecturer) {
                $q->where('lecturerID', $lecturer->lecturerID);
            })
            ->where('status', 'Pending')
            ->get();

        $topic = $applications; // view uses $topic
        return view('lecturer.topicApproval', compact('topic'));
    }

    // LECTURER: Show review page for a single application
    public function review($id)
    {
        $topic = TopicApplication::with(['student', 'topic'])->findOrFail($id);
        return view('lecturer.reviewApproval', compact('topic'));
    }

    // LECTURER: Approve or reject a topic application
    public function updateApplication(Request $request, $id)
    {
        $topicApplication = TopicApplication::findOrFail($id);
        $topic            = $topicApplication->topic;
        $lecturer         = $topic->lecturer;

        if ($request->input('status') === 'Approved' && $lecturer && $lecturer->numberQuota <= 0) {
            $topicApplication->update([
                'status'  => 'Rejected',
                'remarks' => 'Rejected: lecturer has no available quota.',
            ]);

            return redirect()->back()->withErrors('The lecturer has no available quota.');
        }

        $topicApplication->update([
            'status'  => $request->input('status'),
            'remarks' => $request->input('remarks'),
        ]);

        if ($topicApplication->status === 'Approved') {
            $topic->update([
                'studentID' => $topicApplication->studentID,
                'status'    => 'Closed',
            ]);

            $lecturer->decrement('numberQuota');
            $lecturer->increment('current_students');

            // Reject all other pending applications for the same topic
            TopicApplication::where('topicID', $topic->topicID)
                ->where('id', '!=', $topicApplication->id)
                ->where('status', 'Pending')
                ->update([
                    'status'  => 'Rejected',
                    'remarks' => 'Topic has been assigned to another student.',
                ]);
        }

        // Notify the student
        $student = $topicApplication->student;
        if ($student) {
            $statusText = strtolower($topicApplication->status);
            Notification::create([
                'user_id'          => $student->user_id,
                'type'             => 'topic',
                'message'          => "Your topic application for \"{$topic->title}\" has been {$statusText}.",
                'notifiable_type'  => TopicApplication::class,
                'notifiable_id'    => $topicApplication->id,
            ]);
        }

        return redirect()->route('topicApproval')->with('success', 'Application status updated.');
    }

    // STUDENT: View lecturers to choose from
    public function listOfLecturer(Request $request)
    {
        $query   = $request->input('query');
        $builder = LecturerRecord::with('user');

        if ($query) {
            $builder->where('name', 'LIKE', "%{$query}%");
        }

        $lecturer = $builder->get();

        return view('student.listOfLecturer', compact('lecturer'));
    }

    // STUDENT: View a lecturer's profile and available topics
    public function lecturerProfile($lecturerID)
    {
        $lecturer = LecturerRecord::findOrFail($lecturerID);

        $topic = TopicRecord::where('lecturerID', $lecturerID)
            ->where('is_custom', false)
            ->where('status', 'Actived')
            ->get();

        return view('student.lecturerProfile', compact('lecturer', 'topic'));
    }

    // STUDENT: Show apply topic form
    public function applyTopic($lecturerID)
    {
        $lecturer = LecturerRecord::findOrFail($lecturerID);

        $topic = TopicRecord::where('lecturerID', $lecturerID)
            ->where('is_custom', false)
            ->where('status', 'Actived')
            ->get();

        $student = StudentRecord::where('user_id', Auth::id())->first();

        $hasPendingRequest = TopicApplication::where('studentID', $student->studentID)
            ->whereIn('status', ['Pending', 'Approved'])
            ->exists();

        return view('student.applyTopic', compact('lecturer', 'topic', 'hasPendingRequest'));
    }

    // STUDENT: Submit a topic application
    public function apply(Request $request)
    {
        $student = StudentRecord::where('user_id', Auth::id())->first();

        $existing = TopicApplication::where('studentID', $student->studentID)
            ->whereIn('status', ['Pending', 'Approved'])
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors('You already have a pending or approved topic request.');
        }

        if ($request->topic === 'others') {
            $request->validate([
                'title'       => 'required|string|max:255',
                'description' => 'required|string',
            ]);

            $newTopic = TopicRecord::create([
                'title'       => $request->title,
                'description' => $request->description,
                'lecturerID'  => $request->lecturerID,
                'studentID'   => $student->studentID,
                'is_custom'   => true,
                'status'      => 'Actived',
            ]);

            $application = TopicApplication::create([
                'topicID'   => $newTopic->topicID,
                'studentID' => $student->studentID,
                'status'    => 'Pending',
                'remarks'   => null,
            ]);
        } else {
            $application = TopicApplication::create([
                'topicID'   => $request->topic,
                'studentID' => $student->studentID,
                'status'    => 'Pending',
                'remarks'   => null,
            ]);
        }

        // Notify the lecturer
        $lecturer = LecturerRecord::find($request->lecturerID);
        if ($lecturer) {
            Notification::create([
                'user_id'          => $lecturer->user_id,
                'type'             => 'topic',
                'message'          => "New topic application from {$student->name}.",
                'notifiable_type'  => TopicApplication::class,
                'notifiable_id'    => $application->id,
            ]);
        }

        return redirect()->back()->with('success', 'Topic application submitted successfully.');
    }

    // STUDENT: View own topic requests
    public function topicRequest()
    {
        $student = StudentRecord::where('user_id', Auth::id())->first();

        $topic = TopicApplication::where('studentID', $student->studentID)
            ->with('topic.lecturer')
            ->get();

        return view('student.topicRequest', compact('topic'));
    }

    // STUDENT: Cancel a pending topic request
    public function cancelRequest($id)
    {
        $application = TopicApplication::findOrFail($id);

        if ($application->status !== 'Pending') {
            return back()->withErrors('Only pending requests can be cancelled.');
        }

        if ($application->topic && $application->topic->is_custom) {
            $application->topic->delete();
        }

        $application->delete();

        return redirect()->back()->with('success', 'Topic request cancelled successfully.');
    }
}
