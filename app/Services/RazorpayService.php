<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class RazorpayService
{
    protected const API_BASE = 'https://api.razorpay.com/v1';

    /**
     * Retrieve the active Razorpay Key ID (prioritizes DB setting, then config).
     */
    public function getKeyId(): string
    {
        $dbKey = trim((string) Setting::get('razorpay_key_id', ''));
        if (! empty($dbKey)) {
            return $dbKey;
        }

        return trim((string) config('services.razorpay.key', ''));
    }

    /**
     * Retrieve the active Razorpay Key Secret (prioritizes DB setting, then config).
     */
    public function getKeySecret(): string
    {
        $dbSecret = trim((string) Setting::get('razorpay_key_secret', ''));
        if (! empty($dbSecret)) {
            return $dbSecret;
        }

        return trim((string) config('services.razorpay.secret', ''));
    }

    /**
     * Retrieve the active Razorpay Webhook Secret (prioritizes DB setting, then config).
     */
    public function getWebhookSecret(): string
    {
        $dbWebhookSecret = trim((string) Setting::get('razorpay_webhook_secret', ''));
        if (! empty($dbWebhookSecret)) {
            return $dbWebhookSecret;
        }

        return trim((string) config('services.razorpay.webhook_secret', ''));
    }

    /**
     * Check if Razorpay credentials are fully configured.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->getKeyId()) && ! empty($this->getKeySecret());
    }

    /**
     * Build an authenticated HTTP request to the Razorpay API.
     */
    protected function client(int $timeout = 15): PendingRequest
    {
        $client = Http::withBasicAuth($this->getKeyId(), $this->getKeySecret())
            ->timeout($timeout);

        // Disable SSL certificate verification on local dev or if configured false
        $verifySsl = (bool) config('services.razorpay.verify_ssl', false);
        if (! $verifySsl) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    /**
     * Create an order on Razorpay.
     *
     * @param  float  $amountInRupees  Amount in INR (e.g. 1499.00)
     * @param  string  $receipt  Internal booking/txn reference
     * @param  array  $notes  Arbitrary metadata key-values
     */
    public function createOrder(float $amountInRupees, string $receipt, array $notes = []): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay credentials (Key ID and Secret) are not configured. Please set them in Admin Settings.',
            ];
        }

        $amountInPaise = (int) round($amountInRupees * 100);

        try {
            $response = $this->client(15)->post(self::API_BASE.'/orders', [
                'amount' => $amountInPaise,
                'currency' => 'INR',
                'receipt' => substr($receipt, 0, 40),
                'payment_capture' => 1, // Auto-capture payment
                'notes' => $notes,
            ]);

            if ($response->successful()) {
                $data = $response->json();

                return [
                    'success' => true,
                    'order_id' => $data['id'] ?? null,
                    'amount' => $amountInPaise,
                    'amount_in_rupees' => $amountInRupees,
                    'currency' => $data['currency'] ?? 'INR',
                    'receipt' => $data['receipt'] ?? $receipt,
                    'raw' => $data,
                ];
            }

            $errBody = $response->json();
            $errMsg = $errBody['error']['description'] ?? 'Failed to communicate with Razorpay API';
            Log::error('Razorpay createOrder error: '.$response->body(), ['receipt' => $receipt]);

            return [
                'success' => false,
                'message' => $errMsg,
                'raw' => $errBody,
            ];
        } catch (\Throwable $e) {
            Log::error('Razorpay createOrder exception: '.$e->getMessage(), ['receipt' => $receipt]);

            return [
                'success' => false,
                'message' => 'Network error connecting to payment gateway: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Verify the HMAC-SHA256 signature returned by the Razorpay Checkout popup.
     */
    public function verifyPaymentSignature(string $orderId, string $paymentId, string $signature): bool
    {
        $secret = $this->getKeySecret();
        if (empty($secret) || empty($orderId) || empty($paymentId) || empty($signature)) {
            return false;
        }

        $expected = hash_hmac('sha256', $orderId.'|'.$paymentId, $secret);

        return hash_equals($expected, $signature);
    }

    /**
     * Verify the Razorpay webhook signature header against the raw body.
     */
    public function verifyWebhookSignature(string $rawPayload, ?string $signatureHeader): bool
    {
        $webhookSecret = $this->getWebhookSecret();
        if (empty($webhookSecret) || empty($signatureHeader)) {
            return false;
        }

        $expected = hash_hmac('sha256', $rawPayload, $webhookSecret);

        return hash_equals($expected, $signatureHeader);
    }

    /**
     * Fetch payment details directly from Razorpay to extract payment method, VPA, bank, etc.
     */
    public function fetchPayment(string $paymentId): ?array
    {
        if (! $this->isConfigured() || empty($paymentId)) {
            return null;
        }

        try {
            $response = $this->client(10)->get(self::API_BASE.'/payments/'.$paymentId);

            if ($response->successful()) {
                return $response->json();
            }
        } catch (\Throwable $e) {
            Log::warning('Razorpay fetchPayment exception: '.$e->getMessage());
        }

        return null;
    }

    /**
     * Process a full or partial refund for a Razorpay payment.
     *
     * @param  string  $paymentId  Razorpay Payment ID (e.g. 'pay_xxxxxxxxx')
     * @param  float|null  $amountInRupees  Amount to refund in INR (null for full refund)
     * @param  array  $notes  Arbitrary metadata key-values for the refund
     * @return array ['success' => bool, 'refund_id' => string|null, 'amount' => float, 'message' => string, 'raw' => array]
     */
    public function refundPayment(string $paymentId, ?float $amountInRupees = null, array $notes = []): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Razorpay credentials (Key ID and Secret) are not configured. Cannot process refund automatically.',
            ];
        }

        if (empty($paymentId)) {
            return [
                'success' => false,
                'message' => 'No Razorpay Payment ID found for this booking.',
            ];
        }

        $payload = [
            'speed' => 'optimum',
            'notes' => $notes,
        ];

        if ($amountInRupees !== null && $amountInRupees > 0) {
            $payload['amount'] = (int) round($amountInRupees * 100);
        }

        try {
            $response = $this->client(20)->post(self::API_BASE.'/payments/'.$paymentId.'/refund', $payload);

            if ($response->successful()) {
                $data = $response->json();
                $refundId = $data['id'] ?? null;
                $refundAmountPaise = $data['amount'] ?? 0;
                $refundAmountRupees = round($refundAmountPaise / 100, 2);

                Log::info("Razorpay refund processed successfully for payment {$paymentId}", [
                    'refund_id' => $refundId,
                    'amount' => $refundAmountRupees,
                    'status' => $data['status'] ?? 'processed',
                ]);

                return [
                    'success' => true,
                    'refund_id' => $refundId,
                    'amount' => $refundAmountRupees,
                    'currency' => $data['currency'] ?? 'INR',
                    'status' => $data['status'] ?? 'processed',
                    'message' => 'Refund processed successfully via Razorpay.',
                    'raw' => $data,
                ];
            }

            $errBody = $response->json();
            $errMsg = $errBody['error']['description'] ?? 'Failed to process refund on Razorpay.';

            Log::error("Razorpay refund error for payment {$paymentId}: ".$response->body(), ['payload' => $payload]);

            return [
                'success' => false,
                'message' => $errMsg,
                'raw' => $errBody,
            ];
        } catch (\Throwable $e) {
            Log::error("Razorpay refund exception for payment {$paymentId}: ".$e->getMessage());

            return [
                'success' => false,
                'message' => 'Network error connecting to Razorpay refund gateway: '.$e->getMessage(),
            ];
        }
    }
}
