<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('status', 'active');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('username', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'blocked') {
                $query->where('is_blocked', true);
            } elseif ($request->status === 'active') {
                $query->where('is_blocked', false);
            }
        }

        $users = $query->withCount('orders')->paginate(20);

        $totalUsers = User::where('status', 'active')->count();
        $buyersCount = User::where('role', 'buyer')->where('status', 'active')->count();
        $activeUsers = User::where('is_blocked', false)->where('status', 'active')->count();
        $blockedUsers = User::where('is_blocked', true)->where('status', 'active')->count();

        return view('admin.users', compact('users', 'totalUsers', 'buyersCount', 'activeUsers', 'blockedUsers'));
    }

    public function toggleBlock($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot block admin users.');
        }

        $user->update(['is_blocked' => !$user->is_blocked]);

        $status = $user->is_blocked ? 'blocked' : 'unblocked';
        return back()->with('success', "User {$status} successfully!");
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->isAdmin()) {
            return back()->with('error', 'Cannot delete admin users.');
        }

        // Delete profile photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        // Revoke all sessions for this user
        \Illuminate\Support\Facades\DB::table('sessions')
            ->where('user_id', $user->id)
            ->delete();

        // Mark user as deleted and anonymize their data
        $user->update([
            'status' => 'deleted',
            'username' => null,
            'email' => null,
            'password' => null,
            'profile_photo' => null,
            'is_blocked' => false,
        ]);

        // Delete profile photo if exists
        if ($user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
        }

        return back()->with('success', 'User deleted successfully!');
    }
}
