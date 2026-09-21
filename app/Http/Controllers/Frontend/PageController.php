<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\MembershipPlan;
use App\Models\Package;
use App\Models\Setting;
use App\Models\Test;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

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
     * Display the LIS laboratory login page.
     */
    public function lisLogin(): View
    {
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
