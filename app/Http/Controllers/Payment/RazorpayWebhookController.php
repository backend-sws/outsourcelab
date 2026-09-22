<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\MembershipPlan;
use App\Models\PatientMembership;
use App\Models\PaymentTransaction;
use App\Services\RazorpayService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RazorpayWebhookController extends Controller
{
    /**
     * Handle incoming server-to-server webhook notifications from Razorpay.
     */
    public function handle(Request $request, RazorpayService $razorpay): JsonResponse
    {
        $rawPayload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');

        Log::info('Razorpay Webhook Received', [
            'event' => $request->input('event'),
            'has_signature' => ! empty($signature),
        ]);

        // Signature Verification
        if (! empty($razorpay->getWebhookSecret())) {
            $isValid = $razorpay->verifyWebhookSignature($rawPayload, $signature);
            if (! $isValid) {
                Log::warning('Razorpay Webhook signature verification failed');

                return response()->json(['success' => false, 'message' => 'Invalid signature.'], 400);
            }
        }

        $payload = json_decode($rawPayload, true);
        if (! is_array($payload)) {
            return response()->json(['success' => false, 'message' => 'Invalid JSON payload.'], 400);
        }

        $event = $payload['event'] ?? '';
        $paymentEntity = $payload['payload']['payment']['entity'] ?? null;
        $orderEntity = $payload['payload']['order']['entity'] ?? null;

        $orderId = $paymentEntity['order_id'] ?? ($orderEntity['id'] ?? null);
        $paymentId = $paymentEntity['id'] ?? null;

        switch ($event) {
            case 'payment.captured':
            case 'order.paid':
                $this->handlePaymentCaptured($orderId, $paymentId, $paymentEntity, $payload);
                break;

            case 'payment.failed':
                $this->handlePaymentFailed($orderId, $paymentId, $paymentEntity, $payload);
                break;

            default:
                Log::info("Unhandled Razorpay Webhook event: {$event}");
                break;
        }

        return response()->json(['status' => 'ok', 'event' => $event]);
    }

    /**
     * Handle payment.captured or order.paid webhook.
     */
    protected function handlePaymentCaptured(?string $orderId, ?string $paymentId, ?array $paymentEntity, array $payload): void
    {
        if (! $orderId && ! $paymentId) {
            return;
        }

        $query = PaymentTransaction::query();
        if ($orderId) {
            $query->where('razorpay_order_id', $orderId);
        } elseif ($paymentId) {
            $query->where('razorpay_payment_id', $paymentId);
        }

        $txn = $query->latest()->first();
        if (! $txn && $orderId) {
            // Find booking by razorpay_order_id if transaction missing
            $booking = Booking::where('razorpay_order_id', $orderId)->first();
            if ($booking) {
                $txn = PaymentTransaction::create([
                    'transaction_reference' => PaymentTransaction::generateReference(),
                    'patient_id' => $booking->patient_id,
                    'booking_id' => $booking->id,
                    'type' => 'booking',
                    'amount' => $booking->amount,
                    'currency' => 'INR',
                    'gateway' => 'razorpay',
                    'razorpay_order_id' => $orderId,
                    'status' => 'created',
                ]);
            }
        }

        if (! $txn) {
            Log::warning("Razorpay Webhook: No transaction or booking found for Order [{$orderId}] / Payment [{$paymentId}]");

            return;
        }

        // Idempotency: Skip if already captured
        if ($txn->status === 'captured') {
            Log::info("Razorpay Webhook: Transaction #{$txn->id} already marked as captured. Skipping redundant update.");

            return;
        }

        $method = $paymentEntity['method'] ?? 'online';
        $vpa = $paymentEntity['vpa'] ?? null;
        $bank = $paymentEntity['bank'] ?? null;
        $wallet = $paymentEntity['wallet'] ?? null;

        DB::transaction(function () use ($txn, $paymentId, $method, $vpa, $bank, $wallet, $payload, $paymentEntity) {
            $txn->update([
                'status' => 'captured',
                'razorpay_payment_id' => $paymentId ?: $txn->razorpay_payment_id,
                'payment_method' => $method,
                'vpa' => $vpa,
                'bank' => $bank,
                'wallet' => $wallet,
                'paid_at' => now(),
                'webhook_payload' => $payload,
                'response_payload' => $paymentEntity ?: $txn->response_payload,
            ]);

            // If associated with a booking
            if ($txn->booking_id) {
                $booking = Booking::find($txn->booking_id);
                if ($booking && $booking->payment_status !== 'Paid') {
                    $booking->update([
                        'payment_status' => 'Paid',
                        'payment_method' => 'Online',
                        'razorpay_payment_id' => $paymentId ?: $booking->razorpay_payment_id,
                    ]);
                }
            }

            // If associated with a membership purchase
            if ($txn->type === 'membership' && ! $txn->patient_membership_id) {
                $planId = $txn->request_payload['plan_id'] ?? null;
                if ($planId && $txn->patient_id) {
                    $plan = MembershipPlan::find($planId);
                    if ($plan) {
                        $membership = PatientMembership::create([
                            'patient_id' => $txn->patient_id,
                            'membership_plan_id' => $plan->id,
                            'plan_name_snapshot' => $plan->name,
                            'discount_percentage' => $plan->discount_percentage,
                            'price_paid' => $plan->price,
                            'started_at' => now(),
                            'expires_at' => now()->addMonths($plan->duration_in_months),
                            'status' => 'active',
                        ]);
                        $txn->update(['patient_membership_id' => $membership->id]);
                    }
                }
            }
        });

        Log::info("Razorpay Webhook: Successfully processed payment capture for Transaction #{$txn->id}");
    }

    /**
     * Handle payment.failed webhook.
     */
    protected function handlePaymentFailed(?string $orderId, ?string $paymentId, ?array $paymentEntity, array $payload): void
    {
        $query = PaymentTransaction::query();
        if ($orderId) {
            $query->where('razorpay_order_id', $orderId);
        } elseif ($paymentId) {
            $query->where('razorpay_payment_id', $paymentId);
        }

        $txn = $query->latest()->first();
        if (! $txn) {
            return;
        }

        $errCode = $paymentEntity['error_code'] ?? ($payload['error']['code'] ?? 'PAYMENT_FAILED');
        $errDesc = $paymentEntity['error_description'] ?? ($payload['error']['description'] ?? 'Payment authorization failed');

        $txn->update([
            'status' => 'failed',
            'razorpay_payment_id' => $paymentId ?: $txn->razorpay_payment_id,
            'error_code' => $errCode,
            'error_description' => $errDesc,
            'webhook_payload' => $payload,
        ]);

        Log::notice("Razorpay Webhook: Payment failed for Transaction #{$txn->id}. Reason: {$errDesc}");
    }
}
