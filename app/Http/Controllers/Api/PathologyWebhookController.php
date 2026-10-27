<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PathologyWebhookController extends Controller
{
    /**
     * Handle incoming real-time status webhooks from Ojaselab / Pathology LIS.
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->all();
        Log::info('Pathology Webhook received: '.json_encode($payload));

        $ref = trim((string) (
            $payload['external_booking_reference']
            ?? $payload['booking_reference']
            ?? $payload['reference']
            ?? $payload['bill_number']
            ?? $payload['invoice_number']
            ?? ''
        ));

        $cleanRef = ltrim($ref, '#');

        if (empty($cleanRef)) {
            return response()->json([
                'success' => false,
                'message' => 'Missing booking reference in webhook payload.',
            ], 422);
        }

        $booking = Booking::where('booking_reference', $cleanRef)
            ->orWhere('lis_booking_reference', $cleanRef)
            ->orWhere('lis_bill_number', $cleanRef)
            ->first();

        if (! $booking) {
            // Try partial match if prefix was attached
            $booking = Booking::where('booking_reference', 'like', "%{$cleanRef}%")
                ->orWhere('lis_booking_reference', 'like', "%{$cleanRef}%")
                ->first();
        }

        if (! $booking) {
            Log::warning("Pathology Webhook: No booking found for reference '{$cleanRef}'.");

            return response()->json([
                'success' => false,
                'message' => "Booking with reference '{$cleanRef}' not found.",
            ], 404);
        }

        $event = strtolower(trim((string) ($payload['event'] ?? '')));
        $stage = trim((string) ($payload['stage'] ?? $payload['status'] ?? $payload['sample_status'] ?? ''));
        $homeCollectionStatus = trim((string) ($payload['home_collection_status'] ?? ''));

        $isDispatched = $event === 'sample.dispatched'
            || strcasecmp($stage, 'Dispatched') === 0
            || strcasecmp($stage, 'Delivered to Lab') === 0
            || strcasecmp($homeCollectionStatus, 'Dispatched') === 0
            || strcasecmp($homeCollectionStatus, 'Received') === 0
            || ! empty($payload['dispatched_at']);

        $isCollected = $event === 'sample.collected'
            || strcasecmp($stage, 'Sample Collected') === 0
            || strcasecmp($stage, 'Collected') === 0
            || strcasecmp($homeCollectionStatus, 'Collected') === 0
            || ! empty($payload['collected_at']);

        $isReportReady = $event === 'report.ready'
            || strcasecmp($stage, 'Report Ready') === 0
            || strcasecmp($stage, 'Ready') === 0
            || strcasecmp($stage, 'Completed') === 0
            || ! empty($payload['report_download_url'])
            || ! empty($payload['report_file_path']);

        $previousStatus = $booking->status;

        if ($isReportReady) {
            $booking->status = 'Report Ready';
            if (! empty($payload['report_download_url'])) {
                $booking->report_file_path = $payload['report_download_url'];
            } elseif (! empty($payload['report_file_path'])) {
                $booking->report_file_path = $payload['report_file_path'];
            }
            $booking->lis_status = 'Report Ready for Download';
        } elseif ($isDispatched) {
            // Dispatched: transition status to "In Process" and sample_status to "Delivered to Lab"
            $booking->status = 'In Process';
            $booking->sample_status = 'Delivered to Lab';
            $booking->lis_status = 'Dispatched to Lab - Processing Underway';
        } elseif ($isCollected) {
            if ($booking->status !== 'In Process' && $booking->status !== 'Report Ready' && $booking->status !== 'Completed') {
                $booking->status = 'Sample Collected';
                $booking->sample_status = 'Sample Collected';
                $booking->lis_status = 'Sample Collected by Phlebotomist';
                if (! $booking->sample_collected_at) {
                    $booking->sample_collected_at = now();
                }
            }
        }

        if (! empty($payload['invoice_number']) && empty($booking->lis_bill_number)) {
            $booking->lis_bill_number = $payload['invoice_number'];
        }

        if (! empty($payload['collector_name'])) {
            $collectorInfo = 'Phlebotomist: '.$payload['collector_name'].(! empty($payload['collector_phone']) ? " ({$payload['collector_phone']})" : '');
            if (empty($booking->sample_notes)) {
                $booking->sample_notes = $collectorInfo;
            }
        }

        $booking->lis_synced_at = now();
        $booking->save();

        Log::info("Pathology Webhook updated booking #{$booking->booking_reference}: status transitioned from '{$previousStatus}' to '{$booking->status}', sample_status: '{$booking->sample_status}'.");

        return response()->json([
            'success' => true,
            'message' => "Booking status transitioned to {$booking->status}.",
            'booking_reference' => $booking->booking_reference,
            'status' => $booking->status,
            'sample_status' => $booking->sample_status,
        ]);
    }
}
