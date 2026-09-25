<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\NotificationService;
use App\Services\PathologyApiService;
use App\Services\PathologyCatalogSyncService;
use Illuminate\Http\JsonResponse;
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
        $activeTab = $request->input('active_tab', 'general');
        $inputs = $request->except(['_token', 'settings_group', 'active_tab']);

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
            $keyGroup = match (true) {
                str_starts_with($key, 'razorpay_') => 'payment',
                str_starts_with($key, 'mail_') || $key === 'email_notifications_enabled' || $key === 'patient_email_otp_enabled' => 'mail',
                str_starts_with($key, 'sms_') || str_starts_with($key, 'msg91_') || str_starts_with($key, 'twilio_') => 'sms',
                str_starts_with($key, 'whatsapp_') || str_starts_with($key, 'interakt_') || str_starts_with($key, 'aisensy_') => 'whatsapp',
                str_starts_with($key, 'pathology_') => 'pathology',
                default => $group,
            };

            Setting::set($key, is_string($value) ? trim($value) : $value, $keyGroup);
        }

        Setting::clearSettingCache();
        NotificationService::applyMailConfig();

        return back()
            ->with('success', 'Credentials and site settings successfully saved.')
            ->with('active_tab', $activeTab);
    }

    /**
     * Test connection handshake to Pathology LIS.
     */
    public function testPathologyConnection(Request $request, PathologyApiService $api): JsonResponse
    {
        if (! config('pathology.admin_sync_enabled', false)) {
            return response()->json([
                'success' => false,
                'message' => 'Pathology LIS sync is currently hidden/disabled.',
            ], 403);
        }

        $overrideUrl = $request->input('base_url');
        $overrideKey = $request->input('api_key');

        if (! empty($overrideUrl) || ! empty($overrideKey)) {
            $api->setCredentials($overrideUrl, $overrideKey);
        }

        $result = $api->checkHandshake();

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    /**
     * Trigger manual catalog synchronization from Pathology LIS.
     */
    public function syncPathologyCatalog(Request $request, PathologyCatalogSyncService $syncService): JsonResponse
    {
        if (! config('pathology.admin_sync_enabled', false)) {
            return response()->json([
                'success' => false,
                'message' => 'Pathology LIS sync is currently hidden/disabled.',
            ], 403);
        }

        $overwritePricing = $request->boolean('overwrite_pricing');
        $result = $syncService->syncAll($overwritePricing);

        return response()->json($result, $result['success'] ? 200 : 422);
    }
}
