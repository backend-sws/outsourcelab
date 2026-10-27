<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PathologyApiService
{
    protected string $baseUrl;

    protected string $apiKey;

    protected int $timeout;

    public function __construct()
    {
        $configuredBaseUrl = Setting::get('pathology_api_base_url', config('pathology.base_url'));
        $this->baseUrl = rtrim((string) $configuredBaseUrl, '/');
        $this->apiKey = (string) Setting::get('pathology_api_key', config('pathology.api_key'));
        $this->timeout = (int) Setting::get('pathology_api_timeout', config('pathology.timeout', 20));
    }

    /**
     * Override credentials on the fly (e.g. for connection testing).
     */
    public function setCredentials(?string $baseUrl = null, ?string $apiKey = null): self
    {
        if (! empty($baseUrl)) {
            $this->baseUrl = rtrim(trim($baseUrl), '/');
        }
        if (! empty($apiKey)) {
            $this->apiKey = trim($apiKey);
        }

        return $this;
    }

    /**
     * Get pre-configured HTTP client instance.
     */
    protected function client(): PendingRequest
    {
        $client = Http::baseUrl($this->baseUrl)
            ->withHeaders([
                'X-Lab-Api-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])
            ->timeout($this->timeout);

        if (! config('pathology.ssl_verify', true)) {
            $client = $client->withoutVerifying();
        }

        return $client;
    }

    /**
     * Check if the API is configured with a key and URL.
     */
    public function isConfigured(): bool
    {
        return ! empty($this->baseUrl) && ! empty($this->apiKey);
    }

    /**
     * Perform detailed handshake connection to Pathology LIS.
     * Returns structured status and exact error message from remote server if any.
     *
     * @return array{success: bool, message: string, departments_count?: int}
     */
    public function checkHandshake(): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Pathology API Base URL or Secret API Key is missing in settings or .env.',
            ];
        }

        try {
            $response = $this->client()->get('/departments');

            if ($response->successful()) {
                $departments = (array) $response->json('data', []);
                $deptCount = count($departments);

                return [
                    'success' => true,
                    'message' => "Successfully connected to Pathology LIS! Handshake verified ({$deptCount} departments detected).",
                    'departments_count' => $deptCount,
                ];
            }

            $remoteMessage = $response->json('message') ?? $response->json('error');
            $status = $response->status();

            if ($remoteMessage) {
                return [
                    'success' => false,
                    'message' => "Pathology Server responded (HTTP {$status}): {$remoteMessage}",
                ];
            }

            return [
                'success' => false,
                'message' => "Pathology LIS returned HTTP {$status}. Please verify your credentials and server status.",
            ];
        } catch (\Throwable $e) {
            Log::warning('Pathology API Ping failed: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Network error connecting to Pathology LIS: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Test handshake connection to Pathology LIS.
     */
    public function ping(): bool
    {
        $result = $this->checkHandshake();

        return $result['success'];
    }

    /**
     * Fetch active laboratory branches and collection centers.
     */
    public function getBranches(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        try {
            $response = $this->client()->get('/branches');
            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning('Pathology API getBranches failed: '.$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API getBranches error: '.$e->getMessage());
        }

        return [];
    }

    /**
     * Fetch active test departments.
     */
    public function getDepartments(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        try {
            $response = $this->client()->get('/departments');
            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning('Pathology API getDepartments failed: '.$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API getDepartments error: '.$e->getMessage());
        }

        return [];
    }

    /**
     * Fetch tests catalog with optional search, department filter and pagination.
     */
    public function getTests(array $params = []): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        try {
            $response = $this->client()->get('/tests', $params);
            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning('Pathology API getTests failed: '.$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API getTests error: '.$e->getMessage());
        }

        return [];
    }

    /**
     * Fetch health packages catalog.
     */
    public function getPackages(): array
    {
        if (! $this->isConfigured()) {
            return [];
        }

        try {
            $response = $this->client()->get('/packages');
            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning('Pathology API getPackages failed: '.$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API getPackages error: '.$e->getMessage());
        }

        return [];
    }

    /**
     * Fetch package details with included tests and sub-parameters.
     */
    public function getPackageDetails(int $id): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            $response = $this->client()->get("/packages/{$id}");
            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning("Pathology API getPackageDetails failed for #{$id}: ".$response->body());
        } catch (\Throwable $e) {
            Log::error("Pathology API getPackageDetails error for #{$id}: ".$e->getMessage());
        }

        return null;
    }

    /**
     * Submit an online appointment / booking into Pathology SaaS.
     */
    public function createBooking(array $bookingData): ?array
    {
        if (! $this->isConfigured()) {
            Log::notice('Pathology API is not configured. Skipping remote booking creation.');

            return null;
        }

        try {
            $response = $this->client()->post('/bookings', $bookingData);
            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning('Pathology API createBooking rejected: '.$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API createBooking error: '.$e->getMessage());
        }

        return null;
    }

    /**
     * Track patient report status and fetch signed PDF URL.
     */
    public function trackReport(string $billNumberOrRef, string $phone): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            $response = $this->client()->post('/reports/track', [
                'bill_number' => $billNumberOrRef,
                'phone' => $phone,
            ]);

            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning("Pathology API trackReport returned status {$response->status()}: ".$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API trackReport error: '.$e->getMessage());
        }

        return null;
    }

    /**
     * Fetch real-time booking status and invoice/report details from Pathology SaaS.
     */
    public function getBookingStatus(string $bookingReference): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            $cleanRef = urlencode(trim(ltrim($bookingReference, '#')));
            $response = $this->client()->get("/bookings/{$cleanRef}/status");
            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning("Pathology API getBookingStatus returned {$response->status()}: ".$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API getBookingStatus error: '.$e->getMessage());
        }

        return null;
    }

    /**
     * Poll and synchronize the live state of a local booking against Pathology LIS.
     * Transitions status from Sample Collection to Processing when dispatched by phlebotomist.
     */
    public function syncBookingState(Booking $booking): bool
    {
        if (! $this->isConfigured()) {
            return false;
        }

        $lookupRef = $booking->lis_booking_reference ?: $booking->booking_reference;
        if (empty($lookupRef)) {
            return false;
        }

        $remote = $this->getBookingStatus($lookupRef);
        if (! $remote || ! is_array($remote)) {
            return false;
        }

        $changed = false;
        $sampleStatus = trim((string) ($remote['sample_status'] ?? ''));
        $homeCollectionStatus = trim((string) ($remote['home_collection_status'] ?? ''));
        $isDispatched = ! empty($remote['is_dispatched'])
            || strcasecmp($sampleStatus, 'Dispatched') === 0
            || strcasecmp($sampleStatus, 'Delivered to Lab') === 0
            || strcasecmp($homeCollectionStatus, 'Dispatched') === 0
            || strcasecmp($homeCollectionStatus, 'Received') === 0
            || ! empty($remote['dispatched_at']);

        $isCollected = ! empty($remote['collected_at'])
            || strcasecmp($sampleStatus, 'Sample Collected') === 0
            || strcasecmp($homeCollectionStatus, 'Collected') === 0;

        $isReportReady = ! empty($remote['is_report_ready'])
            || in_array(strtolower((string) ($remote['report_status'] ?? '')), ['approved', 'finalized', 'completed'])
            || ! empty($remote['report_download_url']);

        if ($isReportReady) {
            if ($booking->status !== 'Report Ready' && $booking->status !== 'Completed') {
                $booking->status = 'Report Ready';
                $booking->lis_status = 'Report Ready for Download';
                $changed = true;
            }
            if (! empty($remote['report_download_url']) && $booking->report_file_path !== $remote['report_download_url']) {
                $booking->report_file_path = $remote['report_download_url'];
                $changed = true;
            }
        } elseif ($isDispatched) {
            if ($booking->status !== 'In Process' && $booking->status !== 'Report Ready' && $booking->status !== 'Completed') {
                $booking->status = 'In Process';
                $booking->sample_status = 'Delivered to Lab';
                $booking->lis_status = 'Dispatched to Lab - Processing Underway';
                $changed = true;
            } elseif ($booking->sample_status !== 'Delivered to Lab') {
                $booking->sample_status = 'Delivered to Lab';
                $changed = true;
            }
        } elseif ($isCollected) {
            if ($booking->status !== 'In Process' && $booking->status !== 'Report Ready' && $booking->status !== 'Completed') {
                if ($booking->status !== 'Sample Collected' || $booking->sample_status !== 'Sample Collected') {
                    $booking->status = 'Sample Collected';
                    $booking->sample_status = 'Sample Collected';
                    $booking->lis_status = 'Sample Collected by Phlebotomist';
                    if (! $booking->sample_collected_at) {
                        $booking->sample_collected_at = ! empty($remote['collected_at']) ? Carbon::parse($remote['collected_at']) : now();
                    }
                    $changed = true;
                }
            }
        }

        if (! empty($remote['invoice_number']) && empty($booking->lis_bill_number)) {
            $booking->lis_bill_number = $remote['invoice_number'];
            $changed = true;
        }

        if (! empty($remote['payment_status']) && strtolower((string) $remote['payment_status']) === 'paid' && $booking->payment_status !== 'Paid') {
            $booking->payment_status = 'Paid';
            $changed = true;
        }

        if (! empty($remote['assigned_collector_name']) && empty($booking->sample_notes)) {
            $collector = 'Phlebotomist: '.$remote['assigned_collector_name'].(! empty($remote['assigned_collector_phone']) ? " ({$remote['assigned_collector_phone']})" : '');
            $booking->sample_notes = $collector;
            $changed = true;
        }

        if ($changed) {
            $booking->lis_synced_at = now();
            $booking->save();
        }

        return $changed;
    }

    /**
     * Authenticate patient and obtain signed Single Sign-On (SSO) redirect URL.
     *
     * @return array{success: bool, message: string, data: array<string, mixed>}
     */
    public function patientLogin(string $patientIdOrBill, string $phone): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Pathology Laboratory API is not configured.',
                'data' => [],
            ];
        }

        try {
            $response = $this->client()->post('/patient/login', [
                'patient_id' => $patientIdOrBill,
                'phone' => $phone,
            ]);

            $json = (array) $response->json();

            if ($response->successful() && ! empty($json['success'])) {
                return [
                    'success' => true,
                    'message' => $json['message'] ?? 'Login verified successfully. Redirecting to patient dashboard...',
                    'data' => (array) ($json['data'] ?? []),
                ];
            }

            return [
                'success' => false,
                'message' => $json['message'] ?? 'Patient record not found. Please verify your Bill / Patient ID and mobile number.',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Pathology API patientLogin error: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Unable to connect to laboratory server: '.$e->getMessage(),
                'data' => [],
            ];
        }
    }

    /**
     * Authenticate staff / doctor / partner and obtain signed Single Sign-On (SSO) redirect URL.
     *
     * @return array{success: bool, message: string, data: array<string, mixed>}
     */
    public function staffLogin(string $login, string $password): array
    {
        if (! $this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'Pathology Laboratory API is not configured.',
                'data' => [],
            ];
        }

        try {
            $response = $this->client()->post('/staff/login', [
                'login' => $login,
                'password' => $password,
            ]);

            $json = (array) $response->json();

            if ($response->successful() && ! empty($json['success'])) {
                return [
                    'success' => true,
                    'message' => $json['message'] ?? 'Login verified successfully. Redirecting to LIS dashboard...',
                    'data' => (array) ($json['data'] ?? []),
                ];
            }

            return [
                'success' => false,
                'message' => $json['message'] ?? 'Invalid login credentials. Please verify your email/mobile and password.',
                'data' => [],
            ];
        } catch (\Throwable $e) {
            Log::error('Pathology API staffLogin error: '.$e->getMessage());

            return [
                'success' => false,
                'message' => 'Unable to connect to laboratory server: '.$e->getMessage(),
                'data' => [],
            ];
        }
    }

    /**
     * Get base domain of the remote software (without /api/v1).
     */
    public function getSoftwareDomain(): string
    {
        if (empty($this->baseUrl)) {
            return '';
        }

        $clean = preg_replace('#/api/v1/?$#i', '', $this->baseUrl);

        return rtrim((string) $clean, '/');
    }

    /**
     * Get the configured Lab API key.
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get direct HTML POST action URL for Staff login.
     */
    public function getStaffDirectLoginUrl(): string
    {
        $domain = $this->getSoftwareDomain();

        return $domain ? "{$domain}/auth/direct-login" : '#';
    }

    /**
     * Get direct HTML POST action URL for Patient login.
     */
    public function getPatientDirectLoginUrl(): string
    {
        $domain = $this->getSoftwareDomain();

        return $domain ? "{$domain}/portal/auth/direct-login" : '#';
    }
}
