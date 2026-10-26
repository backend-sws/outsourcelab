<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Services\NotificationService;
use App\Services\PathologyApiService;
use App\Services\PathologyCatalogSyncService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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

        // Explicitly remove file & banner keys from generic input array so they never overwrite existing values with null
        unset(
            $inputs['site_logo'],
            $inputs['site_favicon'],
            $inputs['banner_images'],
            $inputs['existing_banners'],
            $inputs['reset_banners'],
            $inputs['banner_section_submitted'],
            $inputs['floating_video_file'],
            $inputs['floating_video_thumbnail'],
            $inputs['delete_floating_video_file'],
            $inputs['delete_floating_video_thumb']
        );

        // Handle File Uploads (Logo & Favicon)
        if ($request->hasFile('site_logo')) {
            $file = $request->file('site_logo');
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'site_logo_'.time().'.'.$extension;

            // Store to public disk
            $file->storeAs('branding', $filename, 'public');

            // Guarantee direct physical copy in public/storage/branding for immediate HTTP serving
            $publicBrandingDir = public_path('storage/branding');
            if (! file_exists($publicBrandingDir)) {
                @mkdir($publicBrandingDir, 0755, true);
            }
            @copy($file->getRealPath(), $publicBrandingDir.DIRECTORY_SEPARATOR.$filename);

            Setting::set('site_logo', 'storage/branding/'.$filename, 'general', 'image');
        }

        if ($request->hasFile('site_favicon')) {
            $file = $request->file('site_favicon');
            $extension = $file->getClientOriginalExtension() ?: 'png';
            $filename = 'site_favicon_'.time().'.'.$extension;

            // Store to public disk
            $file->storeAs('branding', $filename, 'public');

            // Guarantee direct physical copy in public/storage/branding for immediate HTTP serving
            $publicBrandingDir = public_path('storage/branding');
            if (! file_exists($publicBrandingDir)) {
                @mkdir($publicBrandingDir, 0755, true);
            }
            @copy($file->getRealPath(), $publicBrandingDir.DIRECTORY_SEPARATOR.$filename);

            Setting::set('site_favicon', 'storage/branding/'.$filename, 'general', 'image');
        }

        // Handle Multiple Homepage Hero Banner Images
        $newBanners = [];
        if ($request->hasFile('banner_images')) {
            $publicBannerDir = public_path('storage/banners');
            if (! file_exists($publicBannerDir)) {
                @mkdir($publicBannerDir, 0755, true);
            }

            foreach ($request->file('banner_images') as $idx => $bannerFile) {
                if ($bannerFile && $bannerFile->isValid()) {
                    $ext = $bannerFile->getClientOriginalExtension() ?: 'jpg';
                    $filename = 'banner_'.time().'_'.$idx.'_'.uniqid().'.'.$ext;

                    // Store to public disk
                    $bannerFile->storeAs('banners', $filename, 'public');

                    // Direct copy for immediate web serving
                    @copy($bannerFile->getRealPath(), $publicBannerDir.DIRECTORY_SEPARATOR.$filename);

                    $newBanners[] = 'storage/banners/'.$filename;
                }
            }
        }

        if ($request->has('banner_section_submitted')) {
            if ($request->boolean('reset_banners')) {
                Setting::set('banner_images', json_encode(Setting::getDefaultBannerImages()), 'general', 'json');
            } else {
                $existingBanners = $request->input('existing_banners', []);
                if (! is_array($existingBanners)) {
                    $existingBanners = [];
                }
                $finalBanners = array_values(array_unique(array_merge($existingBanners, $newBanners)));
                Setting::set('banner_images', json_encode($finalBanners), 'general', 'json');
            }
        } elseif (count($newBanners) > 0) {
            $currentBanners = Setting::getRawBannerImages();
            $finalBanners = array_values(array_unique(array_merge($currentBanners, $newBanners)));
            Setting::set('banner_images', json_encode($finalBanners), 'general', 'json');
        }

        // Handle Direct Video Upload
        if ($request->hasFile('floating_video_file')) {
            $file = $request->file('floating_video_file');
            $extension = strtolower($file->getClientOriginalExtension() ?: 'mp4');
            $filename = 'floating_video_'.time().'_'.uniqid().'.'.$extension;

            $file->storeAs('videos', $filename, 'public');

            $publicVideosDir = public_path('storage/videos');
            if (! file_exists($publicVideosDir)) {
                @mkdir($publicVideosDir, 0755, true);
            }
            @copy($file->getRealPath(), $publicVideosDir.DIRECTORY_SEPARATOR.$filename);

            Setting::set('floating_video_file_path', 'storage/videos/'.$filename, 'video', 'video');
        } elseif ($request->boolean('delete_floating_video_file')) {
            $currentVideo = Setting::get('floating_video_file_path');
            if ($currentVideo) {
                $filePath = public_path($currentVideo);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            Setting::set('floating_video_file_path', '', 'video', 'video');
        }

        // Handle Floating Video Thumbnail Upload
        if ($request->hasFile('floating_video_thumbnail')) {
            $file = $request->file('floating_video_thumbnail');
            $extension = strtolower($file->getClientOriginalExtension() ?: 'jpg');
            $filename = 'video_thumb_'.time().'_'.uniqid().'.'.$extension;

            $file->storeAs('branding', $filename, 'public');

            $publicBrandingDir = public_path('storage/branding');
            if (! file_exists($publicBrandingDir)) {
                @mkdir($publicBrandingDir, 0755, true);
            }
            @copy($file->getRealPath(), $publicBrandingDir.DIRECTORY_SEPARATOR.$filename);

            Setting::set('floating_video_thumbnail', 'storage/branding/'.$filename, 'video', 'image');
        } elseif ($request->boolean('delete_floating_video_thumb')) {
            $currentThumb = Setting::get('floating_video_thumbnail');
            if ($currentThumb) {
                $filePath = public_path($currentThumb);
                if (file_exists($filePath)) {
                    @unlink($filePath);
                }
            }
            Setting::set('floating_video_thumbnail', '', 'video', 'image');
        }

        // Auto-sync alias keys so that changes to one immediately update the other
        if (array_key_exists('support_email', $inputs)) {
            $inputs['contact_email'] = $inputs['support_email'];
        } elseif (array_key_exists('contact_email', $inputs)) {
            $inputs['support_email'] = $inputs['contact_email'];
        }

        if (array_key_exists('collection_timing', $inputs)) {
            $inputs['working_hours'] = $inputs['collection_timing'];
        } elseif (array_key_exists('working_hours', $inputs)) {
            $inputs['collection_timing'] = $inputs['working_hours'];
        }

        foreach ($inputs as $key => $value) {
            $keyGroup = match (true) {
                str_starts_with($key, 'floating_video_') => 'video',
                str_starts_with($key, 'razorpay_') => 'payment',
                str_starts_with($key, 'mail_') || $key === 'email_notifications_enabled' || $key === 'patient_email_otp_enabled' => 'mail',
                str_starts_with($key, 'sms_') || str_starts_with($key, 'msg91_') || str_starts_with($key, 'twilio_') => 'sms',
                str_starts_with($key, 'whatsapp_') || str_starts_with($key, 'interakt_') || str_starts_with($key, 'aisensy_') => 'whatsapp',
                str_starts_with($key, 'pathology_') => 'pathology',
                str_starts_with($key, 'social_') => 'social',
                in_array($key, [
                    'helpline_primary',
                    'helpline_secondary',
                    'whatsapp_number',
                    'support_email',
                    'contact_email',
                    'collection_timing',
                    'working_hours',
                    'company_legal_name',
                    'registered_address',
                    'reference_lab_address',
                ]) => 'contact',
                in_array($key, [
                    'serviceable_pincodes',
                    'collection_fee_enabled',
                    'home_collection_fee',
                    'free_collection_threshold',
                ]) => 'service',
                default => 'general',
            };

            Setting::set($key, is_string($value) ? trim($value) : $value, $keyGroup);
        }

        Setting::clearSettingCache();
        Cache::flush();
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
        if (! config('pathology.enabled', false)) {
            return response()->json([
                'success' => false,
                'message' => 'Pathology LIS integration is disabled in system configuration.',
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
        if (! config('pathology.enabled', false)) {
            return response()->json([
                'success' => false,
                'message' => 'Pathology LIS integration is disabled in system configuration.',
            ], 403);
        }

        $overwritePricing = $request->boolean('overwrite_pricing');
        $result = $syncService->syncAll($overwritePricing);

        return response()->json($result, $result['success'] ? 200 : 422);
    }

    /**
     * Delete an individual banner image (works for both default system banners and custom uploaded banners).
     */
    public function deleteBannerImage(Request $request): JsonResponse
    {
        $pathToDelete = trim($request->input('banner_path', ''));
        if (empty($pathToDelete)) {
            return response()->json(['success' => false, 'message' => 'Banner path required.'], 400);
        }

        $cleanPathToDelete = ltrim($pathToDelete, '/');

        $currentBanners = Setting::getRawBannerImages();
        $updatedBanners = array_values(array_filter($currentBanners, function ($b) use ($cleanPathToDelete) {
            return ltrim($b, '/') !== $cleanPathToDelete;
        }));

        // Delete physical file if within storage/banners
        if (str_starts_with($cleanPathToDelete, 'storage/banners/')) {
            $physicalFile = public_path($cleanPathToDelete);
            if (file_exists($physicalFile)) {
                @unlink($physicalFile);
            }
            $storageDiskPath = str_replace('storage/', '', $cleanPathToDelete);
            Storage::disk('public')->delete($storageDiskPath);
        }

        Setting::set('banner_images', json_encode($updatedBanners), 'general', 'json');
        Setting::clearSettingCache();

        return response()->json([
            'success' => true,
            'message' => 'Banner removed successfully.',
            'remaining_count' => count($updatedBanners),
            'has_custom' => true,
            'banners' => $updatedBanners,
        ]);
    }
}
