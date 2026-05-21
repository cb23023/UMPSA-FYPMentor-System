<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopicRecord;
use App\Models\TopicApplication;
use App\Models\LecturerRecord;
use App\Models\StudentRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ManageTopicController extends Controller
{

    //DELETE TOPIC LECTURER
    public function deleteTopic($topicID)
    {

        $data = TopicRecord::find($topicID);

        $data->delete();

        return redirect()->back();
    }

    //POST TOPIC LECTURER
    public function postTopic(Request $request)
    {

        $userId = Auth::user()->id;
        $lecturer = LecturerRecord::where('user_id', $userId)->first();

        $data = new TopicRecord;

        $data->title = $request->title;
        $data->description = $request->description;
        $data->lecturerID = $lecturer->lecturerID;
        $data->is_custom = '0';
        $data->status = 'Actived';

        $data->save();

        return redirect()->back()->with('success', 'Topic successfully posted.');
    }

    // EDIT TOPIC LECTURER - GET request to show edit form
    public function editTopic($topicID)
    {
        $topic = TopicRecord::find($topicID);

        if (!$topic) {
            return redirect()->back()->withErrors('Topic not found.');
        }

        return view('lecturer.editTopic', compact('topic'));
    }

    // UPDATE TOPIC LECTURER - POST request to save changes
    public function updateTopic(Request $request, $topicID)
    {
        $topic = TopicRecord::find($topicID);

        if (!$topic) {
            return redirect()->back()->withErrors('Topic not found.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $topic->title = $request->title;
        $topic->description = $request->description;
        $topic->save();

        return redirect()->route('viewProfile')->with('success', 'Topic updated successfully.');
    }

    public function apply(Request $request)
    {

        $user = Auth()->user()->id;
        $student = StudentRecord::where('user_id', $user)->first();

        $existingRequest = TopicApplication::where('studentID', $student)
            ->where('status', 'Pending')
            ->first();

        if ($existingRequest) {
            return redirect()->back()->withErrors(['error' => 'You already have a pending topic request. Please wait for it to be accepted or rejected before applying for another topic.']);
        }

        if ($request->topic === 'others') {
            // Create a new topic in the topicRecord table
            $newTopic = new TopicRecord;
            $newTopic->title = $request->title;
            $newTopic->description = $request->description;
            $newTopic->lecturerID = $request->lecturerID; // Replace with the lecturer ID (you should pass this)
            $newTopic->studentID = $student->studentID; // Assign the student's ID
            $newTopic->is_custom = true; // Set is_custom to true
            $newTopic->status = 'Actived';
            $newTopic->save(); // Save the new topic

            // Create a new topic application for the newly created topic
            $application = new TopicApplication;
            $application->topicID = $newTopic->topicID; // Use the ID of the newly created topic
            $application->studentID = $student->studentID;
            $application->status = 'Pending'; // Default status
            $application->remarks = null; // Default remarks
            $application->save();

            $lecturer = LecturerRecord::where('lecturerID', $request->lecturerID)
                ->with('user') // Assuming there's a relation 'user' in LecturerRecord model
                ->first();

            if ($lecturer && $lecturer->user && $lecturer->user->email) {
                Mail::send('emails.topic_application_notification', [
                    'studentName' => $student->name,
                    'topicTitle' => $newTopic->title,
                    'applicationStatus' => $application->status,
                ], function ($message) use ($lecturer) {
                    $message->to($lecturer->user->email)->subject('New Topic Application Submitted');
                });
            }
        } else {
            // Create a new topic application for an existing topic
            $application = new TopicApplication;
            $application->topicID = $request->topic; // Use the selected topic ID
            $application->studentID = $student->studentID;
            $application->status = 'Pending'; // Default status
            $application->remarks = null; // Default remarks
            $application->save();

            $topic = TopicRecord::find($request->topic);
            $lecturer = LecturerRecord::where('lecturerID', $request->lecturerID)
                ->with('user') // Assuming there's a relation 'user' in LecturerRecord model
                ->first();

            if ($lecturer && $lecturer->user && $lecturer->user->email) {
                Mail::send('emails.topic_application_notification', [
                    'studentName' => $student->name,
                    'topicTitle' => $topic->title,
                    'applicationStatus' => $application->status,
                ], function ($message) use ($lecturer) {
                    $message->to($lecturer->user->email)->subject('New Topic Application Submitted');
                });
            }
        }

        // Redirect back with a success message
        return redirect()->back()->with('success', 'Your application has been submitted successfully.');
    }

    public function cancelRequest($id)
    {

        $topic = TopicApplication::find($id);

        if (!$topic || $topic->status != 'Pending') {
            return back()->withErrors('Cannot cancel this request.');
        }

        $topicRecord = $topic->topic;

        if ($topicRecord && $topicRecord->is_custom == 1) {
            $topicRecord->delete();
        }

        $topic->delete();


        return redirect()->back()->with('success', value: 'Topic requested cancelled successfully.');
    }
}
