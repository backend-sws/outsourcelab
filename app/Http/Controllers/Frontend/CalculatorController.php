<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\Test;
use Illuminate\Contracts\View\View;

class CalculatorController extends Controller
{
    /**
     * Display the Health Calculators Hub directory.
     */
    public function index(): View
    {
        $featuredPackages = Package::take(4)->get();

        return view('frontend.pages.calculators.index', compact('featuredPackages'));
    }

    /**
     * Display the Body Mass Index (BMI) Calculator.
     */
    public function bmi(): View
    {
        $recommendedTests = Test::whereIn('id', [2, 3, 4, 7])->get();
        if ($recommendedTests->isEmpty()) {
            $recommendedTests = Test::take(4)->get();
        }

        $recommendedPackages = Package::whereIn('id', [1, 2, 3])->get();
        if ($recommendedPackages->isEmpty()) {
            $recommendedPackages = Package::take(3)->get();
        }

        return view('frontend.pages.calculators.bmi', compact('recommendedTests', 'recommendedPackages'));
    }

    /**
     * Display the Cardiovascular Heart Health Risk Calculator.
     */
    public function cardiovascularRisk(): View
    {
        $recommendedTests = Test::whereIn('id', [2, 3, 4, 6])->get();
        if ($recommendedTests->isEmpty()) {
            $recommendedTests = Test::take(4)->get();
        }

        $recommendedPackages = Package::whereIn('id', [1, 2, 8])->get();
        if ($recommendedPackages->isEmpty()) {
            $recommendedPackages = Package::take(3)->get();
        }

        return view('frontend.pages.calculators.cardiovascular', compact('recommendedTests', 'recommendedPackages'));
    }

    /**
     * Display the Diabetes Risk Profiler (IDRS & Pre-diabetes Assessment).
     */
    public function diabetesRisk(): View
    {
        $recommendedTests = Test::whereIn('id', [2, 3, 4, 10])->get();
        if ($recommendedTests->isEmpty()) {
            $recommendedTests = Test::take(4)->get();
        }

        $recommendedPackages = Package::whereIn('id', [1, 3, 10])->get();
        if ($recommendedPackages->isEmpty()) {
            $recommendedPackages = Package::take(3)->get();
        }

        return view('frontend.pages.calculators.diabetes', compact('recommendedTests', 'recommendedPackages'));
    }

    /**
     * Display the Vitamin D & B12 Deficiency Assessment.
     */
    public function vitaminDeficiency(): View
    {
        $recommendedTests = Test::whereIn('id', [8, 9, 1, 7])->get();
        if ($recommendedTests->isEmpty()) {
            $recommendedTests = Test::take(4)->get();
        }

        $recommendedPackages = Package::whereIn('id', [1, 2, 4])->get();
        if ($recommendedPackages->isEmpty()) {
            $recommendedPackages = Package::take(3)->get();
        }

        return view('frontend.pages.calculators.vitamin', compact('recommendedTests', 'recommendedPackages'));
    }
}
