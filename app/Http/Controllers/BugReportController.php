<?php

namespace App\Http\Controllers;

use App\Models\BugReport;
use Illuminate\Http\Request;

class BugReportController extends Controller
{
    public function create()
    {
        return view('buyer.report-issue');
    }

    public function store(Request $request)
    {
        $request->validate([
            'report_type' => 'required|in:bug,issue,feedback',
            'description' => 'required|string|max:2000',
        ]);

        BugReport::create([
            'user_id' => auth()->id(),
            'report_type' => $request->report_type,
            'description' => $request->description,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Report submitted successfully! We will review it soon.');
    }
}
