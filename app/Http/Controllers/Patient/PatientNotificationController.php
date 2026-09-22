<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\NotificationLog;
use App\Models\Patient;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PatientNotificationController extends Controller
{
    /**
     * Display the full notifications page for patient.
     */
    public function index(Request $request): View|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return redirect('/');
        }

        $profile = Patient::find($patientId);
        if (! $profile) {
            return redirect('/');
        }

        $query = NotificationLog::where('notifiable_type', Patient::class)
            ->where('notifiable_id', $patientId)
            ->latest();

        if ($request->get('filter') === 'unread') {
            $query->whereNull('read_at');
        } elseif ($request->get('filter') === 'read') {
            $query->whereNotNull('read_at');
        }

        $notifications = $query->paginate(15)->withQueryString();
        $unreadCount = NotificationLog::where('notifiable_type', Patient::class)
            ->where('notifiable_id', $patientId)
            ->whereNull('read_at')
            ->count();

        return view('patient.pages.notifications', compact('profile', 'notifications', 'unreadCount'));
    }

    /**
     * API feed for Customer Header Bell dropdown.
     */
    public function unreadFeed(): JsonResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json([
                'unread_count' => 0,
                'notifications' => [],
            ]);
        }

        $query = NotificationLog::where('notifiable_type', Patient::class)
            ->where('notifiable_id', $patientId)
            ->latest();

        $unreadCount = (clone $query)->whereNull('read_at')->count();
        $notifications = $query->take(8)->get()->map(function ($notif) {
            return [
                'id' => $notif->id,
                'event' => $notif->event,
                'title' => $notif->subject ?: NotificationLog::eventLabel($notif->event),
                'message' => $notif->body ?: 'Your diagnostic test update',
                'icon' => NotificationLog::eventIcon($notif->event),
                'badge_class' => NotificationLog::eventBadgeClass($notif->event),
                'action_url' => $notif->action_url ?: route('patient.bookings'),
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
     * Mark a single notification or all patient notifications as read.
     */
    public function markAsRead(Request $request, ?int $id = null): JsonResponse|RedirectResponse
    {
        $patientId = session('patient_id');
        if (! $patientId) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        if ($id) {
            $notif = NotificationLog::where('notifiable_type', Patient::class)
                ->where('notifiable_id', $patientId)
                ->where('id', $id)
                ->first();

            if ($notif) {
                $notif->markAsRead();
            }
        } else {
            NotificationLog::where('notifiable_type', Patient::class)
                ->where('notifiable_id', $patientId)
                ->whereNull('read_at')
                ->update(['read_at' => now()]);
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Notifications marked as read.');
    }
}
