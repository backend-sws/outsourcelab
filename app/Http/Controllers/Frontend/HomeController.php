<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Package;
use App\Models\Review;
use App\Models\Test;
use Illuminate\Contracts\View\View;

class HomeController extends Controller
{
    /**
     * Display the main landing page with packages, tests, categories and reviews.
     */
    public function index(): View
    {
        $approvedReviews = Review::where('status', 'Approved')->latest()->take(15)->get();
        $singleTests = Test::where('is_active', true)->with('category')->latest()->take(30)->get();

        $packages = Package::where('is_active', true)
            ->where(function ($q) {
                $q->whereJsonContains('display_sections', 'top_booked')
                    ->orWhere('type', 'general')
                    ->orWhereNull('type');
            })->latest()->take(12)->get();

        $habitPackages = Package::where('is_active', true)
            ->where(function ($q) {
                $q->whereJsonContains('display_sections', 'habit')
                    ->orWhere('type', 'habit');
            })->latest()->get();

        $femcliffePackages = Package::where('is_active', true)
            ->where(function ($q) {
                $q->whereJsonContains('display_sections', 'femcliffe')
                    ->orWhere('type', 'femcliffe');
            })->latest()->get();

        $categories = Category::where('is_active', true)->get();

        return view('frontend.pages.home', compact(
            'approvedReviews',
            'singleTests',
            'packages',
            'habitPackages',
            'femcliffePackages',
            'categories'
        ));
    }
}
