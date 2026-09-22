<?php

namespace App\Services;

use App\Mail\Notifications\AgentAssignedToAgent;
use App\Mail\Notifications\AgentAssignedToCustomer;
use App\Mail\Notifications\AgentRegisteredAdmin;
use App\Mail\Notifications\BookingCancelledCustomer;
use App\Mail\Notifications\BookingPlacedAdmin;
use App\Mail\Notifications\BookingPlacedCustomer;
use App\Mail\Notifications\PaymentFailedCustomer;
use App\Mail\Notifications\PaymentSuccessCustomer;
use App\Mail\Notifications\ReportReadyCustomer;
use App\Mail\Notifications\SampleCollectedAdmin;
use App\Mail\Notifications\SampleCollectedCustomer;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\NotificationLog;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Central dispatcher for all notification channels (Email, SMS, WhatsApp).
 * Each public send* method accepts a Booking and dispatches to all configured channels.
 */
class NotificationService
{
    public function __construct(
        protected SmsService $sms,
        protected WhatsAppService $whatsapp,
    ) {}

    // ─────────────────────────────────────────────────────────────────────────
    // Public event methods
    // ─────────────────────────────────────────────────────────────────────────

    /** Booking placed — notify customer + admin */
    public function bookingPlaced(Booking $booking): void
    {
        $booking->load(['patient', 'address', 'familyMember']);
        $patient = $booking->patient;

        if ($patient) {
            $this->sendEmail(
                event: 'booking_placed',
                notifiable: $patient,
                recipientName: $patient->name,
                recipientContact: $patient->email,
                mailable: new BookingPlacedCustomer($booking),
            );
            $this->sendSms($patient->mobile, $this->smsText('booking_placed', $booking), 'booking_placed', $patient);
            $this->sendWhatsApp($patient->mobile, 'booking_placed', [$booking->booking_reference, $patient->name], 'booking_placed', $patient);
            $this->sendInApp(
                notifiable: $patient,
                event: 'booking_placed',
                recipientName: $patient->name,
                title: "Booking #{$booking->booking_reference} Placed",
                message: 'Your diagnostic test booking has been received. Our team will assign a phlebotomist shortly.',
                actionUrl: route('patient.bookings'),
            );
        }

        // Admin email & In-App alert
        $this->sendAdminEmail('booking_placed', new BookingPlacedAdmin($booking));
        $this->sendInApp(
            notifiable: null,
            event: 'booking_placed',
            recipientName: 'Admin',
            title: "New Booking #{$booking->booking_reference}",
            message: "Patient {$patient?->name} placed a booking for ₹".number_format((float) $booking->amount).'.',
            actionUrl: route('admin.bookings.index'),
        );
    }

    /** Agent assigned — notify customer + agent */
    public function bookingConfirmed(Booking $booking): void
    {
        $booking->load(['patient', 'agent']);
        $patient = $booking->patient;
        $agent = $booking->agent;

        if ($patient) {
            $this->sendEmail(
                event: 'booking_confirmed',
                notifiable: $patient,
                recipientName: $patient->name,
                recipientContact: $patient->email,
                mailable: new AgentAssignedToCustomer($booking),
            );
            $this->sendSms($patient->mobile, $this->smsText('booking_confirmed', $booking), 'booking_confirmed', $patient);
            $this->sendWhatsApp($patient->mobile, 'booking_confirmed', [$booking->booking_reference, $agent?->name ?? 'our team'], 'booking_confirmed', $patient);
            $this->sendInApp(
                notifiable: $patient,
                event: 'agent_assigned',
                recipientName: $patient->name,
                title: "Phlebotomist Assigned (#{$booking->booking_reference})",
                message: "Phlebotomist {$agent?->name} has been assigned for your home sample collection.",
                actionUrl: route('patient.bookings'),
            );
        }

        if ($agent) {
            $this->sendEmail(
                event: 'agent_assigned',
                notifiable: $agent,
                recipientName: $agent->name,
                recipientContact: $agent->email,
                mailable: new AgentAssignedToAgent($booking),
            );
            $this->sendSms($agent->phone, $this->smsText('agent_assigned', $booking), 'agent_assigned', $agent);
            $this->sendWhatsApp($agent->phone, 'agent_assigned', [$booking->booking_reference, $patient?->name ?? ''], 'agent_assigned', $agent);
        }

        // Admin In-App
        $this->sendInApp(
            notifiable: null,
            event: 'agent_assigned',
            recipientName: 'Admin',
            title: "Phlebotomist Assigned (#{$booking->booking_reference})",
            message: "Booking #{$booking->booking_reference} assigned to {$agent?->name}.",
            actionUrl: route('admin.bookings.index'),
        );
    }

    /** Sample collected — notify customer + admin */
    public function sampleCollected(Booking $booking): void
    {
        $booking->load(['patient', 'agent']);
        $patient = $booking->patient;

        if ($patient) {
            $this->sendEmail(
                event: 'sample_collected',
                notifiable: $patient,
                recipientName: $patient->name,
                recipientContact: $patient->email,
                mailable: new SampleCollectedCustomer($booking),
            );
            $this->sendSms($patient->mobile, $this->smsText('sample_collected', $booking), 'sample_collected', $patient);
            $this->sendWhatsApp($patient->mobile, 'sample_collected', [$booking->booking_reference], 'sample_collected', $patient);
            $this->sendInApp(
                notifiable: $patient,
                event: 'sample_collected',
                recipientName: $patient->name,
                title: "Sample Collected (#{$booking->booking_reference})",
                message: 'Your lab sample has been successfully collected and safely transported to our reference lab.',
                actionUrl: route('patient.bookings'),
            );
        }

        $this->sendAdminEmail('sample_collected', new SampleCollectedAdmin($booking));
        $this->sendInApp(
            notifiable: null,
            event: 'sample_collected',
            recipientName: 'Admin',
            title: "Sample Collected (#{$booking->booking_reference})",
            message: "Sample for booking #{$booking->booking_reference} was collected.",
            actionUrl: route('admin.bookings.index'),
        );
    }

    /** Report ready — notify customer */
    public function reportReady(Booking $booking): void
    {
        $booking->load('patient');
        $patient = $booking->patient;

        if (! $patient) {
            return;
        }

        $this->sendEmail(
            event: 'report_ready',
            notifiable: $patient,
            recipientName: $patient->name,
            recipientContact: $patient->email,
            mailable: new ReportReadyCustomer($booking),
        );
        $this->sendSms($patient->mobile, $this->smsText('report_ready', $booking), 'report_ready', $patient);
        $this->sendWhatsApp($patient->mobile, 'report_ready', [$booking->booking_reference], 'report_ready', $patient);
        $this->sendInApp(
            notifiable: $patient,
            event: 'report_ready',
            recipientName: $patient->name,
            title: "Test Report Ready! (#{$booking->booking_reference})",
            message: 'Your diagnostic test report is now ready. Click here to view and download your report.',
            actionUrl: route('patient.reports'),
        );

        // Admin In-App
        $this->sendInApp(
            notifiable: null,
            event: 'report_ready',
            recipientName: 'Admin',
            title: "Report Finalized (#{$booking->booking_reference})",
            message: "Test report generated for patient {$patient->name}.",
            actionUrl: route('admin.bookings.index'),
        );
    }

    /** Booking cancelled — notify customer (+ admin if needed) */
    public function bookingCancelled(Booking $booking): void
    {
        $booking->load(['patient', 'agent']);
        $patient = $booking->patient;

        if ($patient) {
            $this->sendEmail(
                event: 'booking_cancelled',
                notifiable: $patient,
                recipientName: $patient->name,
                recipientContact: $patient->email,
                mailable: new BookingCancelledCustomer($booking),
            );
            $this->sendSms($patient->mobile, $this->smsText('booking_cancelled', $booking), 'booking_cancelled', $patient);
            $this->sendWhatsApp($patient->mobile, 'booking_cancelled', [$booking->booking_reference], 'booking_cancelled', $patient);
            $this->sendInApp(
                notifiable: $patient,
                event: 'booking_cancelled',
                recipientName: $patient->name,
                title: "Booking #{$booking->booking_reference} Cancelled",
                message: "Your booking #{$booking->booking_reference} has been cancelled.",
                actionUrl: route('patient.bookings'),
            );
        }

        $this->sendInApp(
            notifiable: null,
            event: 'booking_cancelled',
            recipientName: 'Admin',
            title: "Booking Cancelled (#{$booking->booking_reference})",
            message: "Booking #{$booking->booking_reference} was cancelled.",
            actionUrl: route('admin.bookings.index'),
        );
    }

    /** Payment successful — notify customer + admin */
    public function paymentSuccess(Booking $booking): void
    {
        $booking->load('patient');
        $patient = $booking->patient;

        if ($patient) {
            $this->sendEmail(
                event: 'payment_success',
                notifiable: $patient,
                recipientName: $patient->name,
                recipientContact: $patient->email,
                mailable: new PaymentSuccessCustomer($booking),
            );
            $this->sendSms($patient->mobile, $this->smsText('payment_success', $booking), 'payment_success', $patient);
            $this->sendWhatsApp($patient->mobile, 'payment_success', [$booking->booking_reference, number_format((float) $booking->amount, 2)], 'payment_success', $patient);
            $this->sendInApp(
                notifiable: $patient,
                event: 'payment_success',
                recipientName: $patient->name,
                title: "Payment Received (#{$booking->booking_reference})",
                message: 'Payment of ₹'.number_format((float) $booking->amount, 2).' confirmed successfully.',
                actionUrl: route('patient.transactions'),
            );
        }

        $this->sendInApp(
            notifiable: null,
            event: 'payment_success',
            recipientName: 'Admin',
            title: "Payment Captured (#{$booking->booking_reference})",
            message: 'Received ₹'.number_format((float) $booking->amount, 2)." for booking #{$booking->booking_reference}.",
            actionUrl: route('admin.bookings.index'),
        );
    }

    /** Payment failed — notify customer */
    public function paymentFailed(Booking $booking): void
    {
        $booking->load('patient');
        $patient = $booking->patient;

        if (! $patient) {
            return;
        }

        $this->sendEmail(
            event: 'payment_failed',
            notifiable: $patient,
            recipientName: $patient->name,
            recipientContact: $patient->email,
            mailable: new PaymentFailedCustomer($booking),
        );
        $this->sendSms($patient->mobile, $this->smsText('payment_failed', $booking), 'payment_failed', $patient);
        $this->sendWhatsApp($patient->mobile, 'payment_failed', [$booking->booking_reference], 'payment_failed', $patient);
        $this->sendInApp(
            notifiable: $patient,
            event: 'payment_failed',
            recipientName: $patient->name,
            title: "Payment Incomplete (#{$booking->booking_reference})",
            message: "Your payment attempt for booking #{$booking->booking_reference} could not be completed. You can pay on sample collection.",
            actionUrl: route('patient.bookings'),
        );
    }

    /** New agent registration — notify admin */
    public function agentRegistered(Agent $agent): void
    {
        $this->sendAdminEmail('agent_registration', new AgentRegisteredAdmin($agent));
        $this->sendInApp(
            notifiable: null,
            event: 'agent_registration',
            recipientName: 'Admin',
            title: 'New Phlebotomist Registered',
            message: "Field agent {$agent->name} submitted their registration for review.",
            actionUrl: route('admin.agents.index'),
        );
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Internal channel helpers
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Apply runtime mail configuration from DB Setting table if set by Admin.
     */
    public static function applyMailConfig(): void
    {
        try {
            $mailer = Setting::get('mail_mailer', config('mail.default', 'smtp'));
            $host = Setting::get('mail_host', config('mail.mailers.smtp.host'));
            $port = Setting::get('mail_port', config('mail.mailers.smtp.port', 587));
            $username = Setting::get('mail_username', config('mail.mailers.smtp.username'));
            $password = Setting::get('mail_password', config('mail.mailers.smtp.password'));
            $encryption = Setting::get('mail_encryption', config('mail.mailers.smtp.encryption', 'tls'));
            $fromAddress = Setting::get('mail_from_address', config('mail.from.address'));
            $fromName = Setting::get('mail_from_name', config('mail.from.name', 'AV Wellcare Diagnostics'));

            $newConfig = [
                'mail.default' => $mailer,
                'mail.mailers.smtp.transport' => 'smtp',
            ];

            if (! empty($fromAddress)) {
                $newConfig['mail.from.address'] = $fromAddress;
            }
            if (! empty($fromName)) {
                $newConfig['mail.from.name'] = $fromName;
            }
            if (! empty($host)) {
                $newConfig['mail.mailers.smtp.host'] = $host;
            }
            if (! empty($port)) {
                $newConfig['mail.mailers.smtp.port'] = (int) $port;
            }
            if (! empty($username)) {
                $newConfig['mail.mailers.smtp.username'] = $username;
            }
            if (! empty($password)) {
                $newConfig['mail.mailers.smtp.password'] = $password;
            }
            if ($encryption !== null && $encryption !== '') {
                $newConfig['mail.mailers.smtp.encryption'] = $encryption === 'null' ? null : $encryption;
            }

            config($newConfig);
        } catch (\Throwable $e) {
            // Ignore if settings table is unavailable
        }
    }

    private function sendEmail(
        string $event,
        Patient|Agent|User $notifiable,
        string $recipientName,
        ?string $recipientContact,
        mixed $mailable,
    ): void {
        if (Setting::get('email_notifications_enabled', '1') == '0') {
            $this->log('email', $event, $notifiable, $recipientName, $recipientContact, 'skipped', 'Email notifications disabled in Admin Settings');

            return;
        }

        if (empty($recipientContact)) {
            $this->log('email', $event, $notifiable, $recipientName, null, 'skipped', 'No email address');

            return;
        }

        self::applyMailConfig();

        try {
            Mail::to($recipientContact)->queue($mailable);
            $this->log('email', $event, $notifiable, $recipientName, $recipientContact, 'sent');
        } catch (\Throwable $e) {
            Log::error("NotificationService email failed [{$event}]: ".$e->getMessage());
            $this->log('email', $event, $notifiable, $recipientName, $recipientContact, 'failed', $e->getMessage());
        }
    }

    /** Send admin email to the configured admin address */
    private function sendAdminEmail(string $event, mixed $mailable): void
    {
        if (Setting::get('email_notifications_enabled', '1') == '0') {
            return;
        }

        self::applyMailConfig();

        $adminEmail = Setting::get('mail_admin_address', config('mail.admin_address', config('mail.from.address')));
        if (empty($adminEmail)) {
            return;
        }

        try {
            Mail::to($adminEmail)->queue($mailable);
            $this->log('email', $event, null, 'Admin', $adminEmail, 'sent');
        } catch (\Throwable $e) {
            Log::error("NotificationService admin email failed [{$event}]: ".$e->getMessage());
            $this->log('email', $event, null, 'Admin', $adminEmail, 'failed', $e->getMessage());
        }
    }

    private function sendSms(
        ?string $phone,
        string $message,
        string $event,
        Patient|Agent $notifiable,
    ): void {
        if (empty($phone)) {
            $this->log('sms', $event, $notifiable, '', null, 'skipped', 'No phone number');

            return;
        }

        $status = $this->sms->send($phone, $message);
        $this->log('sms', $event, $notifiable, '', $phone, $status);
    }

    private function sendWhatsApp(
        ?string $phone,
        string $templateName,
        array $params,
        string $event,
        Patient|Agent $notifiable,
    ): void {
        if (empty($phone)) {
            $this->log('whatsapp', $event, $notifiable, '', null, 'skipped', 'No phone number');

            return;
        }

        $status = $this->whatsapp->send($phone, $templateName, $params);
        $this->log('whatsapp', $event, $notifiable, '', $phone, $status);
    }

    /**
     * Emit an in-app notification record.
     */
    public function sendInApp(
        Patient|Agent|User|null $notifiable,
        string $event,
        string $recipientName,
        string $title,
        string $message,
        ?string $actionUrl = null,
    ): ?NotificationLog {
        try {
            return NotificationLog::create([
                'notifiable_type' => $notifiable ? get_class($notifiable) : null,
                'notifiable_id' => $notifiable?->id,
                'channel' => 'in_app',
                'event' => $event,
                'recipient_name' => $recipientName,
                'recipient_contact' => $notifiable?->email ?? $notifiable?->mobile ?? null,
                'subject' => $title,
                'body' => $message,
                'status' => 'sent',
                'read_at' => null,
                'action_url' => $actionUrl,
                'sent_at' => now(),
            ]);
        } catch (\Throwable $e) {
            Log::warning('NotificationService: Failed to write in-app notification — '.$e->getMessage());

            return null;
        }
    }

    /**
     * Write a notification_log record.
     */
    private function log(
        string $channel,
        string $event,
        Patient|Agent|User|null $notifiable,
        string $recipientName,
        ?string $recipientContact,
        string $status,
        ?string $errorMessage = null,
    ): void {
        try {
            NotificationLog::create([
                'notifiable_type' => $notifiable ? get_class($notifiable) : null,
                'notifiable_id' => $notifiable?->id,
                'channel' => $channel,
                'event' => $event,
                'recipient_name' => $recipientName,
                'recipient_contact' => $recipientContact,
                'status' => $status,
                'error_message' => $errorMessage,
                'sent_at' => in_array($status, ['sent']) ? now() : null,
            ]);
        } catch (\Throwable $e) {
            Log::warning('NotificationService: Failed to write notification log — '.$e->getMessage());
        }
    }

    /**
     * Build a plain-text SMS message for a given event.
     */
    private function smsText(string $event, Booking $booking): string
    {
        $ref = $booking->booking_reference;

        return match ($event) {
            'booking_placed' => "AV Wellcare: Booking #{$ref} confirmed. We will assign a phlebotomist shortly. For help call us.",
            'booking_confirmed' => "AV Wellcare: Your booking #{$ref} is confirmed. Our phlebotomist {$booking->agent?->name} will visit you soon.",
            'agent_assigned' => "AV Wellcare: You have a new booking #{$ref} assigned. Please check the app for details.",
            'sample_collected' => "AV Wellcare: Sample for booking #{$ref} has been collected. Your report will be ready soon.",
            'report_ready' => "AV Wellcare: Your test report for booking #{$ref} is ready. Login to view/download.",
            'booking_cancelled' => "AV Wellcare: Booking #{$ref} has been cancelled. Contact us if you need help.",
            'payment_success' => 'AV Wellcare: Payment of Rs.'.number_format((float) $booking->amount, 2)." for booking #{$ref} received. Thank you!",
            'payment_failed' => "AV Wellcare: Payment for booking #{$ref} failed. Please retry or contact support.",
            default => "AV Wellcare: Update on booking #{$ref}.",
        };
    }
}
