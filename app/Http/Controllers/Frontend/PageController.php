<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Category;
use App\Models\MembershipPlan;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Test;
use App\Services\PathologyApiService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    /**
     * Display the download report page.
     */
    public function downloadReport(): View
    {
        return view('frontend.pages.download-report');
    }

    /**
     * Track and fetch verified report status with PDF download link.
     */
    public function fetchReportTrack(Request $request, PathologyApiService $api): JsonResponse
    {
        $validated = $request->validate([
            'ref' => 'required|string|max:100',
            'mobile' => 'required|string|min:10|max:15',
        ]);

        $ref = trim($validated['ref']);
        $mobile = preg_replace('/[^0-9]/', '', $validated['mobile']);

        // 1. Search local bookings
        $booking = Booking::with('patient')
            ->where(function ($q) use ($ref) {
                $q->where('booking_reference', $ref)
                    ->orWhere('lis_booking_reference', $ref)
                    ->orWhere('lis_bill_number', $ref);
            })
            ->whereHas('patient', function ($q) use ($mobile) {
                $q->where('mobile', 'like', "%{$mobile}%");
            })
            ->first();

        // If local booking already has ready report file
        if ($booking && $booking->report_file_path) {
            $isUrl = str_starts_with($booking->report_file_path, 'http');
            $downloadUrl = $isUrl ? $booking->report_file_path : Storage::url($booking->report_file_path);

            return response()->json([
                'success' => true,
                'message' => 'Report is ready for download.',
                'data' => [
                    'bill_number' => $booking->lis_booking_reference ?: $booking->booking_reference,
                    'patient_name' => $booking->patient?->name ?? 'Patient',
                    'current_stage' => 'Report Ready',
                    'is_ready' => true,
                    'download_url' => $downloadUrl,
                    'tests' => is_array($booking->test_details) ? array_map(fn ($t) => [
                        'name' => $t['name'] ?? 'Diagnostic Test',
                        'status' => 'approved',
                    ], $booking->test_details) : [],
                ],
            ]);
        }

        // 2. Query Pathology SaaS LIS API
        if ($api->isConfigured()) {
            $targetRef = $booking?->lis_booking_reference ?: $ref;
            $reportData = $api->trackReport($targetRef, $mobile);

            if ($reportData) {
                // Auto-link report to booking if ready
                if ($booking && ! empty($reportData['is_ready']) && ! empty($reportData['download_url'])) {
                    $booking->report_file_path = $reportData['download_url'];
                    $booking->status = 'Report Ready';
                    $booking->lis_status = 'Report Ready';
                    $booking->lis_synced_at = now();
                    $booking->save();
                }

                return response()->json([
                    'success' => true,
                    'message' => ! empty($reportData['is_ready']) ? 'Report is ready for download.' : 'Report is currently in progress.',
                    'data' => $reportData,
                ]);
            }
        }

        // 3. Fallback: If local booking found but still processing
        if ($booking) {
            return response()->json([
                'success' => true,
                'message' => 'Your sample is currently being processed by the laboratory.',
                'data' => [
                    'bill_number' => $booking->booking_reference,
                    'patient_name' => $booking->patient?->name ?? 'Patient',
                    'current_stage' => $booking->status ?: 'Sample Processing',
                    'is_ready' => false,
                    'download_url' => null,
                    'tests' => is_array($booking->test_details) ? array_map(fn ($t) => [
                        'name' => $t['name'] ?? 'Diagnostic Test',
                        'status' => 'pending',
                    ], $booking->test_details) : [],
                ],
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'No booking or report found matching the provided Reference ID / Bill Number and Registered Mobile.',
        ], 404);
    }

    /**
     * Authenticate patient via Single Sign-On (SSO) to Pathology LIS Dashboard.
     */
    public function authenticateLisSso(Request $request, PathologyApiService $api): JsonResponse
    {
        if (! config('pathology.enabled', true) || ! config('pathology.sso_enabled', true)) {
            return response()->json([
                'success' => false,
                'message' => 'SSO login is currently disabled.',
            ], 403);
        }

        $validated = $request->validate([
            'patient_id' => 'required|string|max:100',
            'phone' => 'required|string|min:10|max:15',
        ]);

        $patientId = trim($validated['patient_id']);
        $phone = preg_replace('/[^0-9]/', '', $validated['phone']);

        $ssoResult = $api->patientLogin($patientId, $phone);

        if ($ssoResult && ! empty($ssoResult['redirect_url'])) {
            return response()->json([
                'success' => true,
                'message' => 'Login verified successfully. Redirecting to your patient dashboard...',
                'data' => $ssoResult,
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid Patient ID / Bill Number or Mobile Number. Please verify and try again.',
        ], 401);
    }

    /**
     * Display the LIS laboratory login page.
     */
    public function lisLogin(): View|RedirectResponse
    {
        if (! config('pathology.enabled', true) || ! config('pathology.sso_enabled', true)) {
            return redirect()->route('home');
        }

        return view('frontend.pages.lis-login');
    }

    /**
     * Redirect root /login to admin login.
     */
    public function loginRedirect(): RedirectResponse
    {
        return redirect()->route('admin.login');
    }

    /**
     * Display the About Us page.
     */
    public function about(): View
    {
        $featuredPackages = Package::take(3)->get();

        return view('frontend.pages.about', compact('featuredPackages'));
    }

    /**
     * Display Our Labs & Diagnostic Centers page.
     */
    public function labs(): View
    {
        $pincodesRaw = Setting::get('serviceable_pincodes', '800001, 800002, 110001, 201301, 201309, 400001, 560001');
        $serviceablePincodes = array_map('trim', explode(',', $pincodesRaw));

        return view('frontend.pages.labs', compact('serviceablePincodes'));
    }

    /**
     * Display Partner With Us page (Doctors, Corporates, Hospitals).
     */
    public function partner(): View
    {
        return view('frontend.pages.partner');
    }

    /**
     * Display Franchise Opportunity (Collection Centre) page.
     */
    public function franchise(): View
    {
        return view('frontend.pages.franchise');
    }

    /**
     * Display Frequently Asked Questions (FAQs) page.
     */
    public function faqs(): View
    {
        return view('frontend.pages.faqs');
    }

    /**
     * Display Careers at Av Wellcare page.
     */
    public function careers(): View
    {
        return view('frontend.pages.careers');
    }

    /**
     * Display Statutory Compliance page (Bio-medical waste, AERB, PCPNDT).
     */
    public function compliance(): View
    {
        return view('frontend.pages.compliance');
    }

    /**
     * Display public Membership Subscription showcase page.
     */
    public function membership(): View
    {
        $plans = MembershipPlan::where('is_active', true)->get();

        return view('frontend.pages.membership', compact('plans'));
    }

    /**
     * Display Pharmacy Coming Soon page.
     */
    public function pharmacy(): View
    {
        return view('frontend.pages.pharmacy');
    }

    /**
     * Display Privacy Policy page.
     */
    public function privacy(): View
    {
        return view('frontend.pages.privacy');
    }

    /**
     * Display Terms & Conditions page.
     */
    public function terms(): View
    {
        return view('frontend.pages.terms');
    }

    /**
     * Display HTML visual Sitemap page.
     */
    public function sitemap(): View
    {
        $categories = Category::all();
        $packages = Package::all();
        $tests = Test::all();

        return view('frontend.pages.sitemap', compact('categories', 'packages', 'tests'));
    }

    /**
     * Generate dynamic XML Sitemap for search engines.
     */
    public function sitemapXml(): Response
    {
        $packages = Package::select('id', 'updated_at')->get();
        $tests = Test::select('id', 'updated_at')->get();
        $categories = Category::select('id', 'updated_at')->get();

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        $staticRoutes = [
            ['url' => route('home'), 'priority' => '1.0', 'freq' => 'daily'],
            ['url' => route('about'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => route('labs'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('partner'), 'priority' => '0.7', 'freq' => 'monthly'],
            ['url' => route('franchise'), 'priority' => '0.8', 'freq' => 'monthly'],
            ['url' => route('faqs'), 'priority' => '0.7', 'freq' => 'weekly'],
            ['url' => route('careers'), 'priority' => '0.6', 'freq' => 'weekly'],
            ['url' => route('compliance'), 'priority' => '0.5', 'freq' => 'monthly'],
            ['url' => route('membership'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('calculators.index'), 'priority' => '0.9', 'freq' => 'weekly'],
            ['url' => route('calculators.bmi'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('calculators.cardiovascular'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('calculators.diabetes'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('calculators.vitamin'), 'priority' => '0.8', 'freq' => 'weekly'],
            ['url' => route('download.report'), 'priority' => '0.7', 'freq' => 'daily'],
            ['url' => route('privacy'), 'priority' => '0.4', 'freq' => 'monthly'],
            ['url' => route('terms'), 'priority' => '0.4', 'freq' => 'monthly'],
            ['url' => route('sitemap'), 'priority' => '0.5', 'freq' => 'weekly'],
        ];

        foreach ($staticRoutes as $r) {
            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars($r['url']).'</loc>';
            $xml .= '<changefreq>'.$r['freq'].'</changefreq>';
            $xml .= '<priority>'.$r['priority'].'</priority>';
            $xml .= '</url>';
        }

        foreach ($categories as $cat) {
            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars(route('category.show', $cat->id)).'</loc>';
            $xml .= '<lastmod>'.($cat->updated_at ? $cat->updated_at->toAtomString() : date('c')).'</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        foreach ($packages as $pkg) {
            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars(route('package.show', $pkg->id)).'</loc>';
            $xml .= '<lastmod>'.($pkg->updated_at ? $pkg->updated_at->toAtomString() : date('c')).'</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.9</priority>';
            $xml .= '</url>';
        }

        foreach ($tests as $t) {
            $xml .= '<url>';
            $xml .= '<loc>'.htmlspecialchars(route('test.show', $t->id)).'</loc>';
            $xml .= '<lastmod>'.($t->updated_at ? $t->updated_at->toAtomString() : date('c')).'</lastmod>';
            $xml .= '<changefreq>weekly</changefreq>';
            $xml .= '<priority>0.8</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
