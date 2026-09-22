<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * WhatsApp notification service.
 * Prioritizes credentials set in Admin Settings, falling back to config/services.php.
 * Supported providers: interakt, aisensy
 */
class WhatsAppService
{
    public function isEnabled(): bool
    {
        $settingVal = Setting::get('whatsapp_enabled');
        if ($settingVal !== null) {
            return (bool) $settingVal;
        }

        return (bool) config('services.whatsapp.enabled', false);
    }

    public function getProvider(): string
    {
        return Setting::get('whatsapp_provider', config('services.whatsapp.provider', 'interakt'));
    }

    /**
     * Send a WhatsApp template message.
     * Returns 'sent' | 'failed' | 'skipped'.
     *
     * @param  string  $to  Recipient phone with country code (e.g. +919876543210)
     * @param  string  $templateName  Template name registered on provider
     * @param  array  $params  Template body variables in order
     */
    public function send(string $to, string $templateName, array $params = []): string
    {
        if (! $this->isEnabled()) {
            return 'skipped';
        }

        $provider = $this->getProvider();

        try {
            return match ($provider) {
                'interakt' => $this->sendViaInterakt($to, $templateName, $params),
                'aisensy' => $this->sendViaAiSensy($to, $templateName, $params),
                default => 'skipped',
            };
        } catch (\Throwable $e) {
            Log::error("WhatsAppService exception [{$provider}]: ".$e->getMessage(), ['to' => $to]);

            return 'failed';
        }
    }

    /**
     * Send via Interakt API.
     * Docs: https://dev.interakt.ai/reference/post_api-v1-message
     */
    protected function sendViaInterakt(string $to, string $templateName, array $params): string
    {
        $apiKey = Setting::get('interakt_api_key', config('services.whatsapp.interakt.api_key'));

        if (empty($apiKey)) {
            Log::warning('WhatsAppService: INTERAKT_API_KEY not set in Settings or config — WhatsApp skipped.');

            return 'skipped';
        }

        // Strip leading + for Interakt
        $phoneNumber = ltrim($to, '+');

        $response = Http::withHeaders([
            'Authorization' => 'Basic '.$apiKey,
            'Content-Type' => 'application/json',
        ])->post('https://api.interakt.ai/v1/public/message/', [
            'countryCode' => '+91',
            'phoneNumber' => $phoneNumber,
            'callbackData' => 'notification',
            'type' => 'Template',
            'template' => [
                'name' => $templateName,
                'languageCode' => 'en',
                'bodyValues' => $params,
            ],
        ]);

        if ($response->successful()) {
            return 'sent';
        }

        Log::error('WhatsAppService Interakt error: '.$response->body(), ['to' => $to]);

        return 'failed';
    }

    /**
     * Send via AiSensy API.
     * Docs: https://documenter.getpostman.com/view/18309175/UzBnrmod
     */
    protected function sendViaAiSensy(string $to, string $templateName, array $params): string
    {
        $apiKey = Setting::get('aisensy_api_key', config('services.whatsapp.aisensy.api_key'));

        if (empty($apiKey)) {
            Log::warning('WhatsAppService: AISENSY_API_KEY not set in Settings or config — WhatsApp skipped.');

            return 'skipped';
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post('https://backend.aisensy.com/campaign/t1/api/v2', [
            'apiKey' => $apiKey,
            'campaignName' => $templateName,
            'destination' => $to,
            'userName' => Setting::get('site_name', 'AV Wellcare Diagnostics'),
            'templateParams' => $params,
        ]);

        if ($response->successful()) {
            return 'sent';
        }

        Log::error('WhatsAppService AiSensy error: '.$response->body(), ['to' => $to]);

        return 'failed';
    }
}
