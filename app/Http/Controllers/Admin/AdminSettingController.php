<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    public function edit()
    {
        $settings = Setting::getSiteSettings();
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'phone_number' => 'nullable|string|max:20',
            'admin_email' => 'nullable|email|max:255',
            'location' => 'nullable|string|max:500',
            'about_us' => 'nullable|string',
        ]);

        $settings = Setting::getSiteSettings();
        $settings->update($request->only(['phone_number', 'admin_email', 'location', 'about_us']));

        return back()->with('success', 'Settings updated successfully!');
    }
}
