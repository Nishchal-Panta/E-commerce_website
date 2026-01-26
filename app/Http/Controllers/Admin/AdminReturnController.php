<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Return as ProductReturn;
use App\Models\ReturnReason;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminReturnController extends Controller
{
    /**
     * Display all return requests
     */
    public function index()
    {
        $returns = ProductReturn::with(['order', 'orderItem.product', 'user', 'returnReason'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Optimize stats query using single query
        $stats = ProductReturn::selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        
        $stats = [
            'pending' => $stats['pending'] ?? 0,
            'approved' => $stats['approved'] ?? 0,
            'rejected' => $stats['rejected'] ?? 0,
            'completed' => $stats['completed'] ?? 0,
        ];

        return view('admin.returns.index', compact('returns', 'stats'));
    }

    /**
     * Show a specific return request
     */
    public function show($returnId)
    {
        $return = ProductReturn::with(['order', 'orderItem.product', 'user', 'returnReason'])
            ->findOrFail($returnId);

        return view('admin.returns.show', compact('return'));
    }

    /**
     * Approve a return request
     */
    public function approve($returnId)
    {
        $return = ProductReturn::findOrFail($returnId);

        if ($return->status !== 'pending') {
            return back()->with('error', 'Only pending returns can be approved.');
        }

        DB::beginTransaction();

        try {
            $return->update([
                'status' => 'approved',
                'approved_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Return request approved successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to approve return request.');
        }
    }

    /**
     * Reject a return request
     */
    public function reject(Request $request, $returnId)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $return = ProductReturn::findOrFail($returnId);

        if ($return->status !== 'pending') {
            return back()->with('error', 'Only pending returns can be rejected.');
        }

        DB::beginTransaction();

        try {
            $return->update([
                'status' => 'rejected',
                'rejected_at' => now(),
            ]);

            DB::commit();

            return back()->with('success', 'Return request rejected.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to reject return request.');
        }
    }

    /**
     * Mark return as completed
     */
    public function complete($returnId)
    {
        $return = ProductReturn::findOrFail($returnId);

        if ($return->status !== 'approved') {
            return back()->with('error', 'Only approved returns can be marked as completed.');
        }

        DB::beginTransaction();

        try {
            $return->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Optionally: Process refund here if you have a refund system

            DB::commit();

            return back()->with('success', 'Return marked as completed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to mark return as completed.');
        }
    }

    /**
     * Manage return reasons
     */
    public function manageReasons()
    {
        $reasons = ReturnReason::paginate(10);
        return view('admin.returns.reasons', compact('reasons'));
    }

    /**
     * Create a new return reason
     */
    public function storeReason(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:return_reasons,name',
            'description' => 'nullable|string|max:500',
        ]);

        ReturnReason::create($request->validated());

        return back()->with('success', 'Return reason created successfully.');
    }

    /**
     * Update a return reason
     */
    public function updateReason(Request $request, $reasonId)
    {
        $request->validate([
            'name' => 'required|string|max:100|unique:return_reasons,name,' . $reasonId,
            'description' => 'nullable|string|max:500',
            'is_active' => 'boolean',
        ]);

        $reason = ReturnReason::findOrFail($reasonId);
        $reason->update($request->validated());

        return back()->with('success', 'Return reason updated successfully.');
    }

    /**
     * Delete a return reason
     */
    public function destroyReason($reasonId)
    {
        $reason = ReturnReason::findOrFail($reasonId);

        // Check if reason is in use
        $inUse = ProductReturn::where('return_reason_id', $reasonId)->exists();

        if ($inUse) {
            return back()->with('error', 'Cannot delete a reason that is in use.');
        }

        $reason->delete();

        return back()->with('success', 'Return reason deleted successfully.');
    }
}
