<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * SMS notification service.
 * Prioritizes credentials set in Admin Settings, falling back to config/services.php.
 */
class SmsService
{
    public function isEnabled(): bool
    {
        $settingVal = Setting::get('sms_enabled');
        if ($settingVal !== null) {
            return (bool) $settingVal;
        }

        return (bool) config('services.sms.enabled', false);
    }

    public function getProvider(): string
    {
        return Setting::get('sms_provider', config('services.sms.provider', 'msg91'));
    }

    /**
     * Send an SMS message to the given phone number.
     * Returns 'sent' | 'failed' | 'skipped'.
     *
     * @param  string  $to  Recipient phone (with country code e.g. +919876543210)
     * @param  string  $message  Plain-text message body
     */
    public function send(string $to, string $message): string
    {
        if (! $this->isEnabled()) {
            return 'skipped';
        }

        $provider = $this->getProvider();

        try {
            return match ($provider) {
                'msg91' => $this->sendViaMsg91($to, $message),
                'twilio' => $this->sendViaTwilio($to, $message),
                default => 'skipped',
            };
        } catch (\Throwable $e) {
            Log::error("SmsService send exception [{$provider}]: ".$e->getMessage(), ['to' => $to]);

            return 'failed';
        }
    }

    /**
     * Send via MSG91 API.
     * Docs: https://docs.msg91.com/reference/send-sms
     */
    protected function sendViaMsg91(string $to, string $message): string
    {
        $authKey = Setting::get('msg91_auth_key', config('services.sms.msg91.auth_key'));
        $senderId = Setting::get('msg91_sender_id', config('services.sms.msg91.sender_id', 'OUTSLAB'));
        $templateId = Setting::get('msg91_template_id', config('services.sms.msg91.template_id'));

        if (empty($authKey)) {
            Log::warning('SmsService: MSG91_AUTH_KEY not set in Settings or config — SMS skipped.');

            return 'skipped';
        }

        $response = Http::withHeaders([
            'authkey' => $authKey,
            'content-type' => 'application/json',
        ])->post('https://api.msg91.com/api/v5/otp', [
            'sender' => $senderId,
            'template_id' => $templateId,
            'mobile' => $to,
            'message' => $message,
        ]);

        if ($response->successful()) {
            return 'sent';
        }

        Log::error('SmsService MSG91 error: '.$response->body(), ['to' => $to]);

        return 'failed';
    }

    /**
     * Send via Twilio REST API.
     */
    protected function sendViaTwilio(string $to, string $message): string
    {
        $sid = Setting::get('twilio_sid', config('services.sms.twilio.sid'));
        $token = Setting::get('twilio_token', config('services.sms.twilio.token'));
        $from = Setting::get('twilio_from', config('services.sms.twilio.from'));

        if (empty($sid) || empty($token) || empty($from)) {
            Log::warning('SmsService: Twilio credentials not set in Settings or config — SMS skipped.');

            return 'skipped';
        }

        $response = Http::withBasicAuth($sid, $token)
            ->asForm()
            ->post("https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json", [
                'From' => $from,
                'To' => $to,
                'Body' => $message,
            ]);

        if ($response->successful()) {
            return 'sent';
        }

        Log::error('SmsService Twilio error: '.$response->body(), ['to' => $to]);

        return 'failed';
    }
}
