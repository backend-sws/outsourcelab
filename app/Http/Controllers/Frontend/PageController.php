<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

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
}
