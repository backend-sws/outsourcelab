<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Setting;
use App\Models\User;
use App\Services\NotificationService;
use App\Services\SmsService;
use App\Services\WhatsAppService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class NotificationController extends Controller
{
    public function index(Request $request): View
    {
        $query = NotificationLog::with('notifiable')->latest();

        if ($request->filled('channel')) {
            $query->where('channel', $request->channel);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('event')) {
            $query->where('event', $request->event);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('recipient_name', 'like', "%{$search}%")
                    ->orWhere('recipient_contact', 'like', "%{$search}%")
                    ->orWhere('error_message', 'like', "%{$search}%")
                    ->orWhere('event', 'like', "%{$search}%");
            });
        }

        $logs = $query->paginate(20)->withQueryString();

        // Metrics
        $totalLogs = NotificationLog::count();
        $totalEmail = NotificationLog::where('channel', 'email')->count();
        $totalSms = NotificationLog::where('channel', 'sms')->count();
        $totalWhatsapp = NotificationLog::where('channel', 'whatsapp')->count();
        $totalSent = NotificationLog::where('status', 'sent')->count();
        $totalFailed = NotificationLog::where('status', 'failed')->count();
        $totalSkipped = NotificationLog::where('status', 'skipped')->count();

        // Channel Status (Reads from Settings, falling back to config)
        $channels = [
            'email' => [
                'enabled' => Setting::get('email_notifications_enabled', '1') == '1',
                'mailer' => Setting::get('mail_mailer', config('mail.default', 'smtp')),
                'from' => Setting::get('mail_from_address', config('mail.from.address', 'noreply@avwellcare.com')),
            ],
            'sms' => [
                'enabled' => (bool) Setting::get('sms_enabled', config('services.sms.enabled', false)),
                'provider' => Setting::get('sms_provider', config('services.sms.provider', 'msg91')),
                'ready' => ! empty(Setting::get('msg91_auth_key', config('services.sms.msg91.auth_key'))) || ! empty(Setting::get('twilio_sid', config('services.sms.twilio.sid'))),
            ],
            'whatsapp' => [
                'enabled' => (bool) Setting::get('whatsapp_enabled', config('services.whatsapp.enabled', false)),
                'provider' => Setting::get('whatsapp_provider', config('services.whatsapp.provider', 'interakt')),
                'ready' => ! empty(Setting::get('interakt_api_key', config('services.whatsapp.interakt.api_key'))) || ! empty(Setting::get('aisensy_api_key', config('services.whatsapp.aisensy.api_key'))),
            ],
        ];

        $uniqueEvents = NotificationLog::select('event')->distinct()->pluck('event');

        return view('admin.pages.notifications.index', compact(
            'logs',
            'totalLogs',
            'totalEmail',
            'totalSms',
            'totalWhatsapp',
            'totalSent',
            'totalFailed',
            'totalSkipped',
            'channels',
            'uniqueEvents'
        ));
    }

    /**
     * Send a test notification from the admin panel.
     */
    public function sendTest(Request $request, NotificationService $notifier, SmsService $sms, WhatsAppService $wa): RedirectResponse
    {
        $request->validate([
            'channel' => 'required|in:email,sms,whatsapp',
            'contact' => 'required|string',
        ]);

        $channel = $request->channel;
        $contact = trim($request->contact);

        try {
            if ($channel === 'email') {
                NotificationService::applyMailConfig();

                Mail::raw('This is a test email notification from AV Wellcare Diagnostics. Sent at: '.now()->toDayDateTimeString(), function ($message) use ($contact) {
                    $message->to($contact)->subject('Test Notification - AV Wellcare Diagnostics');
                });

                NotificationLog::create([
                    'channel' => 'email',
                    'event' => 'test_notification',
                    'recipient_name' => 'Admin Test',
                    'recipient_contact' => $contact,
                    'subject' => 'Test Notification',
                    'status' => 'sent',
                    'sent_at' => now(),
                ]);

                return back()->with('success', "Test email sent successfully to {$contact}!");
            }

            if ($channel === 'sms') {
                $status = $sms->send($contact, 'AV Wellcare Diagnostics: Test SMS alert sent at '.now()->format('H:i'));

                NotificationLog::create([
                    'channel' => 'sms',
                    'event' => 'test_notification',
                    'recipient_name' => 'Admin Test',
                    'recipient_contact' => $contact,
                    'status' => $status,
                    'sent_at' => $status === 'sent' ? now() : null,
                    'error_message' => $status === 'skipped' ? 'SMS Channel is disabled in config/services.php' : null,
                ]);

                $msg = $status === 'sent'
                    ? "Test SMS dispatched to {$contact}!"
                    : ($status === 'skipped' ? 'SMS channel is currently disabled (SMS_ENABLED=false). Logged as skipped.' : 'SMS dispatch failed. Check error log.');

                return back()->with($status === 'failed' ? 'error' : 'info', $msg);
            }

            if ($channel === 'whatsapp') {
                $status = $wa->send($contact, 'test_notification', ['Test Alert', now()->format('H:i')]);

                NotificationLog::create([
                    'channel' => 'whatsapp',
                    'event' => 'test_notification',
                    'recipient_name' => 'Admin Test',
                    'recipient_contact' => $contact,
                    'status' => $status,
                    'sent_at' => $status === 'sent' ? now() : null,
                    'error_message' => $status === 'skipped' ? 'WhatsApp Channel is disabled in config/services.php' : null,
                ]);

                $msg = $status === 'sent'
                    ? "Test WhatsApp message sent to {$contact}!"
                    : ($status === 'skipped' ? 'WhatsApp channel is disabled (WHATSAPP_ENABLED=false). Logged as skipped.' : 'WhatsApp dispatch failed. Check error log.');

                return back()->with($status === 'failed' ? 'error' : 'info', $msg);
            }
        } catch (\Throwable $e) {
            return back()->with('error', 'Failed to send test notification: '.$e->getMessage());
        }

        return back()->with('error', 'Invalid channel.');
    }

    /**
     * API feed for Admin Header Bell dropdown.
     */
    public function unreadFeed(): JsonResponse
    {
        $query = NotificationLog::where(function ($q) {
            $q->where('recipient_name', 'Admin')
                ->orWhere('notifiable_type', User::class)
                ->orWhere('channel', 'in_app');
        })->latest();

        $unreadCount = (clone $query)->whereNull('read_at')->count();
        $notifications = $query->take(8)->get()->map(function ($notif) {
            return [
                'id' => $notif->id,
                'event' => $notif->event,
                'title' => $notif->subject ?: NotificationLog::eventLabel($notif->event),
                'message' => $notif->body ?: "Notification for {$notif->recipient_name}",
                'icon' => NotificationLog::eventIcon($notif->event),
                'badge_class' => NotificationLog::eventBadgeClass($notif->event),
                'action_url' => $notif->action_url ?: route('admin.bookings.index'),
                'is_read' => $notif->isRead(),
                'time_ago' => $notif->created_at->diffForHumans(),
            ];
        });

        return response()->json([
            'unread_count' => $unreadCount,
            'notifications' => $notifications,
        ]);
    }

    /**
     * Mark a single notification or all notifications as read.
     */
    public function markAsRead(Request $request, ?int $id = null): JsonResponse|RedirectResponse
    {
        if ($id) {
            $notif = NotificationLog::find($id);
            if ($notif) {
                $notif->markAsRead();
            }
        } else {
            NotificationLog::where(function ($q) {
                $q->where('recipient_name', 'Admin')
                    ->orWhere('notifiable_type', User::class)
                    ->orWhere('channel', 'in_app');
            })->whereNull('read_at')->update(['read_at' => now()]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifications marked as read.');
    }
}
