<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\Package;
use App\Models\Review;
use App\Models\Test;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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

    /**
     * Store selected city in user session.
     */
    public function setCity(Request $request): JsonResponse
    {
        $cityId = $request->input('city_id');
        $city = City::active()->find($cityId);

        if ($city) {
            session([
                'selected_city_id' => $city->id,
                'selected_city_name' => $city->name,
                'selected_city_state' => $city->state,
            ]);

            return response()->json([
                'success' => true,
                'city' => [
                    'id' => $city->id,
                    'name' => $city->name,
                    'state' => $city->state,
                    'pincodes' => $city->pincode_list,
                ],
                'message' => "City set to {$city->name}.",
            ]);
        }

        return response()->json(['success' => false, 'message' => 'City not found or inactive.'], 404);
    }
}
