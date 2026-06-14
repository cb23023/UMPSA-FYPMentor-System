<?php

namespace App\Http\Controllers;

use App\Models\TimeFrameRecord;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class TimeFrameController extends Controller
{
    // COORDINATOR: Show manage time frame page (with existing records)
    public function manageTimeFrame()
    {
        $timeFrames  = TimeFrameRecord::orderBy('created_at', 'desc')->get();
        $activeFrame = TimeFrameRecord::where('is_active', true)->first();

        return view('fypcoordinator.manageTimeFrame', compact('timeFrames', 'activeFrame'));
    }

    // COORDINATOR: Save a new time frame and notify all users
    public function saveTimeFrame(Request $request)
    {
        $request->validate([
            'description'   => 'required|string',
            'semester'      => 'nullable|string|max:50',
            'academic_year' => 'nullable|string|max:20',
            'startDate'     => 'required|date',
            'endDate'       => 'required|date|after_or_equal:startDate',
        ]);

        // Deactivate any currently active time frame
        TimeFrameRecord::where('is_active', true)->update(['is_active' => false, 'status' => 'inactive']);

        $timeFrame = TimeFrameRecord::create([
            'description'   => $request->description,
            'semester'      => $request->semester,
            'academic_year' => $request->academic_year,
            'startDate'     => $request->startDate,
            'endDate'       => $request->endDate,
            'status'        => 'active',
            'is_active'     => true,
        ]);

        // Notify all users
        $users = User::all();
        foreach ($users as $user) {
            Notification::create([
                'user_id'          => $user->id,
                'type'             => 'timeframe',
                'message'          => "New time frame: {$timeFrame->description}. From {$timeFrame->startDate} to {$timeFrame->endDate}.",
                'notifiable_type'  => TimeFrameRecord::class,
                'notifiable_id'    => $timeFrame->timeFrameID,
            ]);
        }

        return redirect()->route('manageTimeFrame')->with('success', 'Time frame saved and all users notified.');
    }

    // COORDINATOR: Show edit form for an existing time frame
    public function edit($id)
    {
        $timeFrame = TimeFrameRecord::findOrFail($id);

        return view('fypcoordinator.editTimeFrame', compact('timeFrame'));
    }

    // COORDINATOR: Update an existing time frame and notify students and lecturers
    public function update(Request $request, $id)
    {
        $request->validate([
            'description'   => 'required|string|max:255',
            'semester'      => 'nullable|string|max:50',
            'academic_year' => 'nullable|string|max:20',
            'startDate'     => 'required|date',
            'endDate'       => 'required|date|after_or_equal:startDate',
            'status'        => 'nullable|in:active,inactive',
        ]);

        $timeFrame = TimeFrameRecord::findOrFail($id);
        $status = $request->input('status', $timeFrame->status ?? 'inactive');

        if ($status === 'active') {
            TimeFrameRecord::where('timeFrameID', '!=', $timeFrame->timeFrameID)
                ->where('is_active', true)
                ->update(['is_active' => false, 'status' => 'inactive']);
        }

        $timeFrame->update([
            'description'   => $request->description,
            'semester'      => $request->semester,
            'academic_year' => $request->academic_year,
            'startDate'     => $request->startDate,
            'endDate'       => $request->endDate,
            'status'        => $status,
            'is_active'     => $status === 'active',
        ]);

        $users = User::whereIn('role', ['student', 'lecturer'])->get();
        foreach ($users as $user) {
            Notification::create([
                'user_id'          => $user->id,
                'type'             => 'timeframe',
                'message'          => "Supervisor hunting timeframe has been updated: {$timeFrame->description}. Semester: {$timeFrame->semester}. Academic Year: {$timeFrame->academic_year}. From {$timeFrame->startDate} to {$timeFrame->endDate}.",
                'notifiable_type'  => TimeFrameRecord::class,
                'notifiable_id'    => $timeFrame->timeFrameID,
            ]);
        }

        return redirect()->route('manageTimeFrame')->with('success', 'Time frame updated and all users notified.');
    }

    // COORDINATOR: Set a specific time frame as the active one
    public function setActive($id)
    {
        TimeFrameRecord::where('is_active', true)->update(['is_active' => false, 'status' => 'inactive']);

        $timeFrame = TimeFrameRecord::findOrFail($id);
        $timeFrame->update(['is_active' => true, 'status' => 'active']);

        return redirect()->route('manageTimeFrame')->with('success', 'Time frame set as active.');
    }

    // COORDINATOR: Delete a time frame
    public function deleteTimeFrame($id)
    {
        $timeFrame = TimeFrameRecord::findOrFail($id);
        $timeFrame->delete();

        return redirect()->route('manageTimeFrame')->with('success', 'Time frame deleted.');
    }
}
