<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::latest()->paginate(15);
        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(int $id)
    {
        $review = Review::findOrFail($id);
        $review->status = 'Approved';
        $review->save();

        return back()->with('success', 'Review approved successfully.');
    }

    public function reject(int $id)
    {
        $review = Review::findOrFail($id);
        $review->status = 'Rejected';
        $review->save();

        return back()->with('success', 'Review rejected successfully.');
    }
}
