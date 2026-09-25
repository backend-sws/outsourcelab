<?php

namespace App\Services;

use App\Models\Setting;
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
        if (! config('pathology.enabled', true)) {
            return false;
        }

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
     * Authenticate patient and obtain signed Single Sign-On (SSO) redirect URL.
     */
    public function patientLogin(string $patientIdOrBill, string $phone): ?array
    {
        if (! $this->isConfigured()) {
            return null;
        }

        try {
            $response = $this->client()->post('/patient/login', [
                'patient_id' => $patientIdOrBill,
                'phone' => $phone,
            ]);

            if ($response->successful()) {
                return (array) $response->json('data', []);
            }
            Log::warning('Pathology API patientLogin rejected: '.$response->body());
        } catch (\Throwable $e) {
            Log::error('Pathology API patientLogin error: '.$e->getMessage());
        }

        return null;
    }
}
