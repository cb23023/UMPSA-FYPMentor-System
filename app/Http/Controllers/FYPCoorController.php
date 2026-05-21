<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\LecturerRecord;
use App\Models\TimeFrameRecord;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class FYPCoorController extends Controller
{
    //Save Timeframe FYP COORDINATOR
    public function saveTimeFrame(Request $request)
    {

        $data = new TimeFrameRecord;

        $data->description = $request->description;
        $data->startDate = $request->startDate;
        $data->endDate = $request->endDate;

        $data->save();

        $users = User::all();

        foreach ($users as $user) {
            Mail::send('emails.timeframe_message', [
                'description' => $data->description,
                'startDate' => $data->startDate,
                'endDate' => $data->endDate,
            ], function ($message) use ($user) {
                $message->to($user->email)->subject('Announcement');
            });
        }


        return redirect()->back()->with('success', 'Time Frame saved successfully!');
    }

    //GENERETA REPORT QUOTA
    public function generateQuota()
    {
        $data = LecturerRecord::get();
        $pdf = Pdf::loadView('fypcoordinator.quotaReport', [
            'data' => $data
        ]);
        return $pdf->download('quotaReport.pdf');
    }

    //DISPLAY UPDATE QUOTA LECTURER
    public function updateQuota()
    {
        $lecturer = LecturerRecord::all();
        if (!$lecturer) {
            return redirect()->back()->withErrors('Lecturer not found!');
        }
        return view('fypcoordinator.updateQuota', compact('lecturer'));
    }

    public function updateQuotaList(Request $request)
    {

        $quotas = $request->input('numberQuota');

        // Iterate through each lecturer ID and update the corresponding record
        foreach ($quotas as $lecturerID => $quota) {
            $lecturer = LecturerRecord::find($lecturerID);

            if ($lecturer) { // Check if the lecturer exists
                $lecturer->numberQuota = $quota; // Update the quota
                $lecturer->save(); // Save the changes
            }
        }
        return redirect('manageQuota');
    }
}
