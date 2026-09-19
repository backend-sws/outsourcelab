<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactEnquiry;
use App\Models\Review;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FeedbackController extends Controller
{
    /**
     * Store a newly created public patient review.
     */
    public function storeReview(Request $request): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'author_name' => 'required|string|max:100',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'required|string|min:5|max:1000',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $review = Review::create([
            'author_name' => $validated['author_name'],
            'rating' => (int) $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'Pending', // Requires admin approval before display
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you for your feedback! Your review has been submitted and will be visible on the homepage once verified by our team.',
                'review' => [
                    'id' => $review->id,
                    'author_name' => $review->author_name,
                    'rating' => $review->rating,
                    'comment' => $review->comment,
                    'time_ago' => 'Just now',
                ],
            ]);
        }

        return back()->with('review_success', 'Thank you for your feedback! Your review has been submitted and will be visible once verified by our team.');
    }

    /**
     * Store a newly created contact / enquiry message.
     */
    public function storeEnquiry(Request $request): JsonResponse|RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'subject' => 'required|string|max:200',
            'message' => 'required|string|min:5|max:2000',
        ]);

        if ($validator->fails()) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            return back()->withErrors($validator)->withInput();
        }

        $validated = $validator->validated();

        $enquiry = ContactEnquiry::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'status' => 'Unread',
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thank you! Your enquiry has been received. Our diagnostic team will contact you shortly.',
                'enquiry' => $enquiry,
            ]);
        }

        return back()->with('enquiry_success', 'Thank you! Your enquiry has been received. Our diagnostic team will contact you shortly.');
    }
}
