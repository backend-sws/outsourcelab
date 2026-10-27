<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\PatientCoupon;
use App\Models\PaymentTransaction;
use App\Models\Setting;
use App\Models\Test;
use App\Services\NotificationService;
use App\Services\PathologyApiService;
use App\Services\RazorpayService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'familyMember', 'agent'])->latest();

        if ($request->filled('agent_id')) {
            if ($request->agent_id === 'unassigned') {
                $query->whereNull('agent_id');
            } elseif ($request->agent_id === 'deactivated') {
                $query->whereHas('agent', function ($q) {
                    $q->where('status', '!=', 'active');
                });
            } else {
                $query->where('agent_id', $request->agent_id);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cancellation_requests') || $request->filter === 'cancellation_requests') {
            $query->where('cancellation_request_status', 'requested');
        }

        $cancellationRequestsCount = Booking::where('cancellation_request_status', 'requested')->count();
        $bookings = $query->paginate(15)->withQueryString();
        $agents = Agent::where('status', 'active')->orderBy('name')->get();

        return view('admin.pages.bookings.index', compact('bookings', 'agents', 'cancellationRequestsCount'));
    }

    public function show(int $id)
    {
        $booking = Booking::with(['patient', 'familyMember', 'address', 'agent'])->findOrFail($id);
        $agents = Agent::where('status', 'active')->orderBy('name')->get();
        $allTests = Test::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'original_price', 'sample_type']);
        $allPackages = Package::where('is_active', true)
            ->orderBy('name')
            ->get(['id', 'name', 'price', 'original_price', 'sample_type']);

        return view('admin.pages.bookings.show', compact('booking', 'agents', 'allTests', 'allPackages'));
    }

    public function assignAgent(Request $request, int $id)
    {
        $request->validate([
            'agent_id' => [
                'nullable',
                Rule::exists('agents', 'id')->where(function ($query) {
                    $query->where('status', 'active');
                }),
            ],
        ], [
            'agent_id.exists' => 'The selected phlebotomist is deactivated or does not exist. Only active phlebotomists can be assigned.',
        ]);

        $booking = Booking::findOrFail($id);
        $agentId = $request->filled('agent_id') ? (int) $request->agent_id : null;
        $booking->agent_id = $agentId;

        if ($agentId) {
            // When agent is assigned, advance sample and order status
            if (empty($booking->sample_status) || in_array($booking->sample_status, ['Pending', 'Booked'])) {
                $booking->sample_status = 'Assigned';
            }
            if (in_array($booking->status, ['Pending', 'Booked'])) {
                $booking->status = 'Confirmed';
            }
        } else {
            // Unassigning agent
            if ($booking->sample_status === 'Assigned') {
                $booking->sample_status = 'Pending';
            }
        }
        $booking->save();
        $booking->load('agent');

        if ($agentId) {
            try {
                $booking->load(['patient', 'agent']);
                app(NotificationService::class)->bookingConfirmed($booking);
            } catch (\Throwable $e) {
                Log::warning('Booking confirmed notification failed: '.$e->getMessage());
            }
        }

        $agentName = $booking->agent ? $booking->agent->name : 'Unassigned';

        return back()->with('success', $agentId
            ? "Field Agent '{$agentName}' successfully assigned to booking #{$booking->booking_reference}."
            : "Booking #{$booking->booking_reference} is now unassigned.");
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $booking = Booking::findOrFail($id);
        $oldStatus = $booking->status;
        $booking->status = $request->status;
        $booking->save();

        try {
            if ($request->status === 'Cancelled' && $oldStatus !== 'Cancelled') {
                app(NotificationService::class)->bookingCancelled($booking);
            } elseif ($request->status === 'Report Ready' && $oldStatus !== 'Report Ready') {
                app(NotificationService::class)->reportReady($booking);
            }
        } catch (\Throwable $e) {
            Log::warning('Booking status change notification failed: '.$e->getMessage());
        }

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function print(int $id)
    {
        $booking = Booking::with(['patient', 'familyMember', 'address', 'agent', 'latestPaymentTransaction'])->findOrFail($id);

        return view('patient.pages.invoice', compact('booking'));
    }

    /**
     * Upload or link a report for a booking.
     * Accepts either a PDF file upload OR an external URL/link.
     */
    public function uploadReport(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'report_type' => 'required|in:file,link',
            'report_file' => 'required_if:report_type,file|nullable|file|mimes:pdf,jpg,jpeg,png|max:20480',
            'report_link' => 'required_if:report_type,link|nullable|url|max:2000',
        ]);

        $booking = Booking::findOrFail($id);

        // Delete old file from storage if it was a stored file (not a URL)
        if ($booking->report_file_path && ! str_starts_with($booking->report_file_path, 'http')) {
            Storage::disk('public')->delete($booking->report_file_path);
        }

        if ($request->report_type === 'file' && $request->hasFile('report_file')) {
            $path = $request->file('report_file')->store(
                "reports/booking-{$booking->id}",
                'public'
            );
            $booking->report_file_path = $path;
        } else {
            // Store external URL/link directly
            $booking->report_file_path = $request->report_link;
        }

        // Auto-advance status when report is uploaded
        if (in_array($booking->status, ['Pending', 'Booked', 'Confirmed', 'Sample Collected'])) {
            $booking->status = 'Report Ready';
        }

        $booking->save();

        try {
            app(NotificationService::class)->reportReady($booking);
        } catch (\Throwable $e) {
            Log::warning('Report ready notification failed: '.$e->getMessage());
        }

        return back()->with('success', "Report uploaded successfully for booking #{$booking->booking_reference}.");
    }

    /**
     * Delete/remove the report from a booking.
     */
    public function deleteReport(int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        if ($booking->report_file_path && ! str_starts_with($booking->report_file_path, 'http')) {
            Storage::disk('public')->delete($booking->report_file_path);
        }

        $booking->report_file_path = null;
        $booking->save();

        return back()->with('success', "Report removed from booking #{$booking->booking_reference}.");
    }

    /**
     * Manually push or re-sync booking order to Pathology LIS.
     */
    public function pushToLis(int $id, PathologyApiService $api): RedirectResponse
    {
        $booking = Booking::with(['patient', 'familyMember', 'address'])->findOrFail($id);

        if (! config('pathology.enabled', false) || ! $api->isConfigured()) {
            return back()->with('error', 'Pathology LIS API sync is currently disabled.');
        }

        $lisItems = [];
        if (is_array($booking->test_details)) {
            foreach ($booking->test_details as $cartItem) {
                $itemType = $cartItem['type'] ?? 'test';
                $localId = $cartItem['id'] ?? null;

                if ($itemType === 'test') {
                    $testModel = Test::find($localId);
                    $targetId = $testModel?->lis_test_id ?: $localId;
                    $lisItems[] = ['type' => 'test', 'id' => (int) $targetId];
                } elseif ($itemType === 'package') {
                    $pkgModel = Package::find($localId);
                    $targetId = $pkgModel?->lis_package_id ?: $localId;
                    $lisItems[] = ['type' => 'package', 'id' => (int) $targetId];
                }
            }
        }

        if (empty($lisItems)) {
            return back()->with('error', 'No valid tests or packages found in this booking to push.');
        }

        $patient = $booking->patient;
        $targetMember = $booking->familyMember;
        $targetAddress = $booking->address;

        $lisPayload = [
            'patient_name' => $targetMember?->name ?: ($patient?->name ?? 'Patient'),
            'patient_phone' => $patient?->mobile ?? '',
            'patient_email' => $patient?->email,
            'patient_gender' => strtolower($targetMember?->gender ?: ($patient?->gender ?: 'other')),
            'patient_age' => (int) ($targetMember?->age ?: ($patient?->age ?: 30)),
            'patient_age_unit' => 'years',
            'collection_type' => str_contains(strtolower($booking->collection_type), 'home') ? 'home_collection' : 'lab_visit',
            'collection_address' => $targetAddress?->full_address ?? 'Not provided',
            'preferred_date' => $booking->booking_date ? $booking->booking_date->toDateString() : now()->toDateString(),
            'preferred_time_slot' => $booking->collection_slot ?: '08:00 AM - 10:00 AM',
            'branch_id' => (int) config('pathology.default_branch_id', 1),
            'external_booking_reference' => $booking->booking_reference,
            'webhook_url' => url('/api/v1/pathology/webhook'),
            'payment_method' => $booking->payment_method,
            'payment_status' => strtolower($booking->payment_status ?? 'pending'),
            'paid_amount' => (float) ($booking->payment_status === 'Paid' ? $booking->amount : ($booking->paid_amount ?? 0)),
            'notes' => "Admin Push: #{$booking->booking_reference}",
            'items' => $lisItems,
        ];

        $lisResult = $api->createBooking($lisPayload);

        if ($lisResult && ! empty($lisResult['booking_reference'])) {
            $booking->lis_booking_reference = $lisResult['booking_reference'];
            $booking->lis_status = $lisResult['status'] ?? 'pending';
            $booking->lis_synced_at = now();
            $booking->save();

            return back()->with('success', "Booking successfully pushed to Pathology LIS! Ref: {$lisResult['booking_reference']}");
        }

        return back()->with('error', 'Failed to push booking to Pathology LIS. Please check API credentials and logs.');
    }

    /**
     * Admin modification of booking details and tests.
     */
    public function modifyBooking(Request $request, int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'booking_date' => 'nullable|date',
            'collection_slot' => 'nullable|string',
            'collection_type' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|in:Pending,Paid,Partial Online / Cash on Collection',
            'payment_method' => 'nullable|string',
        ]);

        if ($request->filled('booking_date')) {
            $booking->booking_date = $request->booking_date;
        }
        if ($request->filled('collection_slot')) {
            $booking->collection_slot = $request->collection_slot;
        }
        if ($request->filled('collection_type')) {
            $booking->collection_type = $request->collection_type;
        }
        if ($request->filled('amount')) {
            $booking->amount = (float) $request->amount;
        }
        if ($request->filled('paid_amount')) {
            $booking->paid_amount = (float) $request->paid_amount;
        }
        if ($request->filled('payment_status')) {
            $booking->payment_status = $request->payment_status;
            if ($booking->payment_status === 'Paid' && ! $request->filled('paid_amount')) {
                $booking->paid_amount = $booking->amount;
            }
        }
        if ($request->filled('payment_method')) {
            $booking->payment_method = $request->payment_method;
        }

        $booking->save();

        return back()->with('success', "Booking #{$booking->booking_reference} details updated successfully.");
    }

    /**
     * Update tests, packages, and pricing for a booking by Admin.
     */
    public function updateTests(Request $request, int $id): RedirectResponse
    {
        $booking = Booking::findOrFail($id);

        $request->validate([
            'tests' => 'required',
            'collection_fee' => 'nullable|numeric|min:0',
            'amount' => 'nullable|numeric|min:0',
            'paid_amount' => 'nullable|numeric|min:0',
            'payment_status' => 'nullable|string',
            'payment_method' => 'nullable|string',
        ]);

        $rawTests = is_array($request->input('tests'))
            ? $request->input('tests')
            : json_decode($request->input('tests'), true);

        if (empty($rawTests) || ! is_array($rawTests)) {
            return back()->with('error', 'At least one diagnostic test or package is required.');
        }

        $sanitizedItems = [];
        $calculatedSubtotal = 0.0;

        foreach ($rawTests as $item) {
            $type = $item['type'] ?? 'test';
            $itemId = $item['id'] ?? null;
            if (! $itemId) {
                continue;
            }

            if ($type === 'package') {
                $pkg = Package::find($itemId);
                if ($pkg) {
                    $itemPrice = isset($item['price']) && is_numeric($item['price'])
                        ? (float) $item['price']
                        : (float) $pkg->price;
                    $sanitizedItems[] = [
                        'id' => $pkg->id,
                        'name' => $pkg->name,
                        'title' => $pkg->name,
                        'type' => 'package',
                        'price' => $itemPrice,
                        'parameters_count' => is_array($pkg->parameters) ? count($pkg->parameters) : 0,
                    ];
                    $calculatedSubtotal += $itemPrice;
                }
            } else {
                $test = Test::find($itemId);
                if ($test) {
                    $itemPrice = isset($item['price']) && is_numeric($item['price'])
                        ? (float) $item['price']
                        : (float) $test->price;
                    $sanitizedItems[] = [
                        'id' => $test->id,
                        'name' => $test->name,
                        'title' => $test->name,
                        'type' => 'test',
                        'price' => $itemPrice,
                        'sample_type' => $test->sample_type ?? 'Blood',
                    ];
                    $calculatedSubtotal += $itemPrice;
                }
            }
        }

        if (empty($sanitizedItems)) {
            return back()->with('error', 'No valid diagnostic tests or packages were selected.');
        }

        // Collection fee calculation
        $isHomeCollection = str_contains(strtolower((string) $booking->collection_type), 'home');
        if ($request->has('collection_fee') && $request->collection_fee !== null && $request->collection_fee !== '') {
            $collectionFee = (float) $request->collection_fee;
        } else {
            $collectionFee = 0;
            if ($isHomeCollection) {
                $collectionFeeEnabled = Setting::get('collection_fee_enabled', '1') == '1';
                $standardCollectionFee = (float) Setting::get('home_collection_fee', '100');
                $freeThreshold = (float) Setting::get('free_collection_threshold', '500');
                if ($collectionFeeEnabled && $calculatedSubtotal < $freeThreshold) {
                    $collectionFee = $standardCollectionFee;
                }
            }
        }

        $existingDiscount = (float) ($booking->discount_amount ?? 0);
        $coinsDiscount = (float) ($booking->coins_discount ?? 0);

        if ($request->filled('amount')) {
            $finalAmount = (float) $request->amount;
        } else {
            $finalAmount = max(0, $calculatedSubtotal - $existingDiscount - $coinsDiscount + $collectionFee);
        }

        $previousAmount = (float) $booking->amount;
        $previousPaidAmount = (float) ($booking->paid_amount ?? 0);
        $wasPaid = ($booking->payment_status === 'Paid');

        // If the booking was previously marked as Paid, then the customer had paid the previous amount
        if ($wasPaid && $previousPaidAmount <= 0) {
            $previousPaidAmount = $previousAmount;
        }

        $booking->test_details = $sanitizedItems;
        $booking->collection_fee = $collectionFee;
        $booking->amount = $finalAmount;

        $requestedPaymentStatus = $request->input('payment_status');

        if ($request->filled('paid_amount')) {
            $booking->paid_amount = (float) $request->paid_amount;
        }

        if ($requestedPaymentStatus === 'Paid') {
            $booking->payment_status = 'Paid';
            if (! $request->filled('paid_amount')) {
                $booking->paid_amount = $finalAmount;
            }
        } elseif ($requestedPaymentStatus === 'Partial Online / Cash on Collection') {
            $booking->payment_status = 'Partial Online / Cash on Collection';
            if (! $request->filled('paid_amount')) {
                $booking->paid_amount = $previousPaidAmount;
            }
            if (empty($booking->payment_method) || in_array($booking->payment_method, ['Online', 'Cash'])) {
                $booking->payment_method = 'Partial Online / Cash on Collection';
            }
        } elseif ($requestedPaymentStatus === 'Pending') {
            $booking->payment_status = 'Pending';
            if (! $request->filled('paid_amount')) {
                $booking->paid_amount = $previousPaidAmount;
            }
        } else {
            // No payment_status explicitly requested
            if (! $request->filled('paid_amount')) {
                if ($previousPaidAmount > 0 && $finalAmount > $previousPaidAmount) {
                    // Additional tests added to an already paid booking: customer only owes the difference
                    $booking->payment_status = 'Partial Online / Cash on Collection';
                    $booking->paid_amount = $previousPaidAmount;
                    $booking->payment_method = 'Partial Online / Cash on Collection';
                } elseif ($previousPaidAmount >= $finalAmount && $previousPaidAmount > 0) {
                    $booking->payment_status = 'Paid';
                    $booking->paid_amount = $finalAmount;
                }
            }
        }

        if ($request->filled('payment_method')) {
            $booking->payment_method = $request->payment_method;
        }

        $booking->save();

        return back()->with('success', "Tests and pricing for booking #{$booking->booking_reference} have been updated successfully.");
    }

    /**
     * Approve customer cancellation request and process auto-refund via Razorpay if eligible.
     */
    public function approveCancellation(Request $request, int $id, RazorpayService $razorpay): RedirectResponse
    {
        $booking = Booking::with(['patient', 'agent', 'paymentTransactions'])->findOrFail($id);

        if ($booking->status === 'Cancelled') {
            return back()->with('error', 'This booking is already cancelled.');
        }

        $adminNotes = $request->input('admin_notes');
        $autoRefund = $request->boolean('auto_refund', true);

        $booking->status = 'Cancelled';
        $booking->cancellation_request_status = 'approved';
        $booking->cancellation_admin_notes = $adminNotes;
        $booking->cancellation_processed_at = now();

        $refundAmount = $booking->refundable_amount;
        $refundId = null;
        $refundSuccess = false;
        $refundErrorMsg = null;

        // Auto-refund via Razorpay if customer paid online and autoRefund is enabled
        if ($autoRefund && $booking->hasOnlinePayment() && $refundAmount > 0) {
            $paymentId = $booking->razorpay_payment_id
                ?: $booking->paymentTransactions()->whereNotNull('razorpay_payment_id')->latest()->value('razorpay_payment_id');

            if ($paymentId) {
                $razorpayResult = $razorpay->refundPayment($paymentId, $refundAmount, [
                    'booking_reference' => $booking->booking_reference,
                    'cancelled_by' => 'admin',
                    'reason' => $booking->cancellation_reason ?: 'Customer cancellation approved by admin',
                ]);

                if ($razorpayResult['success']) {
                    $refundSuccess = true;
                    $refundId = $razorpayResult['refund_id'];
                    $booking->refund_status = 'refunded';
                    $booking->refund_id = $refundId;
                    $booking->refund_amount = $refundAmount;
                    $booking->refunded_at = now();

                    // Update payment transaction record if available
                    PaymentTransaction::where('booking_id', $booking->id)
                        ->where('razorpay_payment_id', $paymentId)
                        ->update(['status' => 'refunded']);
                } else {
                    $booking->refund_status = 'failed';
                    $refundErrorMsg = $razorpayResult['message'] ?? 'Failed to process refund on Razorpay.';
                    Log::warning("Razorpay auto-refund failed for booking #{$booking->booking_reference}: {$refundErrorMsg}");
                }
            } else {
                $booking->refund_status = 'failed';
                $refundErrorMsg = 'Online payment detected but no valid Razorpay Payment ID was found.';
            }
        } else {
            $booking->refund_status = 'not_applicable';
            $booking->refund_amount = 0.00;
        }

        // Restore redeemed loyalty coins if any
        if ((int) $booking->coins_redeemed > 0 && $booking->patient) {
            $coinVal = (float) Setting::get('reward_coin_value', '1.00');
            $refundedValue = round($booking->coins_redeemed * $coinVal, 2);
            $booking->patient->creditCoins(
                $booking->coins_redeemed,
                "Coins refunded for cancelled booking #{$booking->booking_reference}",
                $booking->id,
                $refundedValue
            );
            Log::info("Restored {$booking->coins_redeemed} redeemed coins to patient #{$booking->patient->id} for cancelled booking #{$booking->booking_reference}.");
        }

        // Restore coupon usage if coupon was applied
        if (! empty($booking->coupon_code)) {
            $coupon = Coupon::where('code', $booking->coupon_code)->first();
            if ($coupon && $coupon->usage_count > 0) {
                $coupon->decrement('usage_count');
            }
            if ($coupon && $booking->patient_id) {
                PatientCoupon::where('patient_id', $booking->patient_id)
                    ->where('coupon_id', $coupon->id)
                    ->delete();
            }
        }

        $booking->save();

        try {
            app(NotificationService::class)->cancellationApproved($booking, $refundSuccess ? $refundAmount : null, $refundId);
        } catch (\Throwable $e) {
            Log::warning('Cancellation approval notification failed: '.$e->getMessage());
        }

        if ($refundErrorMsg) {
            return back()->with('warning', "Booking #{$booking->booking_reference} has been marked as Cancelled, but Razorpay refund returned an alert: {$refundErrorMsg}. Please check your Razorpay dashboard.");
        }

        $msg = "Booking #{$booking->booking_reference} successfully cancelled.";
        if ($refundSuccess) {
            $msg .= ' Full refund of ₹'.number_format($refundAmount, 2)." has been issued to the customer via Razorpay (Refund ID: {$refundId}).";
        }

        return back()->with('success', $msg);
    }

    /**
     * Reject customer cancellation request with reason note.
     */
    public function rejectCancellation(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $booking = Booking::with('patient')->findOrFail($id);

        $booking->cancellation_request_status = 'rejected';
        $booking->cancellation_admin_notes = $request->rejection_reason;
        $booking->cancellation_processed_at = now();
        $booking->save();

        try {
            app(NotificationService::class)->cancellationRejected($booking, $request->rejection_reason);
        } catch (\Throwable $e) {
            Log::warning('Cancellation rejection notification failed: '.$e->getMessage());
        }

        return back()->with('success', "Cancellation request for booking #{$booking->booking_reference} has been declined. The patient has been notified.");
    }
}
