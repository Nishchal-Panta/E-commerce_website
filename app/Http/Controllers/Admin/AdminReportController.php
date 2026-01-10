<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BugReport;
use Illuminate\Http\Request;

class AdminReportController extends Controller
{
    public function index(Request $request)
    {
        $query = BugReport::with('user');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->orderBy('created_at', 'desc')->paginate(20);

        $totalReports = BugReport::count();
        $pendingReports = BugReport::where('status', 'pending')->count();
        $inProgressReports = BugReport::where('status', 'in_progress')->count();
        $resolvedReports = BugReport::where('status', 'resolved')->count();

        return view('admin.reports', compact('reports', 'totalReports', 'pendingReports', 'inProgressReports', 'resolvedReports'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved',
        ]);

        $report = BugReport::findOrFail($id);

        $data = ['status' => $request->status];
        if ($request->status === 'resolved') {
            $data['resolved_at'] = now();
        }

        $report->update($data);

        return back()->with('success', 'Report status updated successfully!');
    }

    public function destroy($id)
    {
        $report = BugReport::findOrFail($id);
        $report->delete();

        return back()->with('success', 'Report deleted successfully!');
    }
}
