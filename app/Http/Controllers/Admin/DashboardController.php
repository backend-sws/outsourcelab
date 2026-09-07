<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Test;
use App\Models\Package;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBookings = Booking::count();
        $activeTests = Test::where('is_active', true)->count();
        $activePackages = Package::where('is_active', true)->count();
        $totalRevenue = Booking::whereIn('status', ['Completed', 'Report Ready', 'Sample Collected'])->sum('amount');
        
        $pendingBookings = Booking::where('status', 'Pending')->count();
        $completedBookings = Booking::where('status', 'Completed')->count();
        $featuredPackages = Package::where('is_active', true)->take(2)->get();
        $recentTests = Test::where('is_active', true)->take(4)->get();
        $completionRate = $totalBookings > 0 ? round(($completedBookings / $totalBookings) * 100) : 67;
        
        $recentBookings = Booking::with('patient')->latest()->take(6)->get();
        
        return view('admin.dashboard', compact(
            'totalBookings', 
            'pendingBookings', 
            'completedBookings', 
            'activeTests', 
            'activePackages', 
            'totalRevenue', 
            'recentBookings', 
            'featuredPackages', 
            'recentTests', 
            'completionRate'
        ));
    }
}
