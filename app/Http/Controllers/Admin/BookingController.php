<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Test;
use App\Services\NotificationService;
use App\Services\PathologyApiService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'agent'])->latest();

        if ($request->filled('agent_id')) {
            if ($request->agent_id === 'unassigned') {
                $query->whereNull('agent_id');
            } else {
                $query->where('agent_id', $request->agent_id);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15)->withQueryString();
        $agents = Agent::where('status', 'active')->orderBy('name')->get();

        return view('admin.pages.bookings.index', compact('bookings', 'agents'));
    }

    public function show(int $id)
    {
        $booking = Booking::with(['patient', 'familyMember', 'address', 'agent'])->findOrFail($id);
        $agents = Agent::where('status', 'active')->orderBy('name')->get();

        return view('admin.pages.bookings.show', compact('booking', 'agents'));
    }

    public function assignAgent(Request $request, int $id)
    {
        $request->validate([
            'agent_id' => 'nullable|exists:agents,id',
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
        $booking = Booking::with(['patient', 'familyMember', 'address', 'agent'])->findOrFail($id);

        return view('admin.pages.bookings.print', compact('booking'));
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

        if (! config('pathology.admin_sync_enabled', false) || ! $api->isConfigured()) {
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
        if ($request->filled('payment_status')) {
            $booking->payment_status = $request->payment_status;
        }
        if ($request->filled('payment_method')) {
            $booking->payment_method = $request->payment_method;
        }

        $booking->save();

        return back()->with('success', "Booking #{$booking->booking_reference} details updated successfully.");
    }
}
