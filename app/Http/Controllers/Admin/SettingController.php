<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->pluck('value', 'key')->toArray();

        return view('admin.pages.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $group = $request->input('settings_group', 'general');
        $inputs = $request->except(['_token', 'settings_group']);

        // Handle File Uploads (Logo & Favicon)
        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('branding', 'public');
            Setting::set('site_logo', Storage::url($path), 'general', 'image');
            unset($inputs['site_logo']);
        }

        if ($request->hasFile('site_favicon')) {
            $path = $request->file('site_favicon')->store('branding', 'public');
            Setting::set('site_favicon', Storage::url($path), 'general', 'image');
            unset($inputs['site_favicon']);
        }

        foreach ($inputs as $key => $value) {
            Setting::set($key, is_string($value) ? trim($value) : $value, $group);
        }

        Setting::clearSettingCache();

        return back()->with('success', 'Site settings successfully updated.');
    }
}
