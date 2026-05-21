<?php

namespace App\Http\Controllers;

use App\Models\TimeFrameRecord;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
