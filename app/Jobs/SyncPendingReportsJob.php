<?php

namespace App\Jobs;

use App\Models\Booking;
use App\Services\NotificationService;
use App\Services\PathologyApiService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class SyncPendingReportsJob implements ShouldQueue
{
    use Queueable;

    /**
     * Execute the job.
     */
    public function handle(PathologyApiService $api, NotificationService $notifications): void
    {
        if (! $api->isConfigured()) {
            return;
        }

        // Fetch bookings awaiting report that were pushed to LIS or have mobile number
        $pendingBookings = Booking::with('patient')
            ->whereNotNull('lis_booking_reference')
            ->whereNotIn('status', ['Report Ready', 'Cancelled'])
            ->where('created_at', '>=', now()->subDays(30))
            ->limit(50)
            ->get();

        foreach ($pendingBookings as $booking) {
            $phone = $booking->patient?->mobile;
            $ref = $booking->lis_booking_reference ?: $booking->booking_reference;

            if (empty($phone) || empty($ref)) {
                continue;
            }

            try {
                $reportData = $api->trackReport($ref, $phone);

                if (! $reportData) {
                    continue;
                }

                $isReady = ! empty($reportData['is_ready']);
                $downloadUrl = $reportData['download_url'] ?? null;
                $currentStage = $reportData['current_stage'] ?? null;

                $booking->lis_status = $currentStage;
                $booking->lis_synced_at = now();

                if ($isReady && $downloadUrl) {
                    $booking->report_file_path = $downloadUrl;
                    $booking->status = 'Report Ready';
                    $booking->save();

                    // Send automatic alert to patient
                    try {
                        $notifications->reportReady($booking);
                    } catch (\Throwable $notifErr) {
                        Log::warning("Notification failed for auto-linked report #{$booking->id}: ".$notifErr->getMessage());
                    }

                    Log::info("Successfully auto-linked LIS report for booking #{$booking->booking_reference} (LIS Ref: {$ref}).");
                } else {
                    $booking->save();
                }
            } catch (\Throwable $e) {
                Log::warning("Failed to auto-sync report for booking #{$booking->id}: ".$e->getMessage());
            }
        }
    }
}
