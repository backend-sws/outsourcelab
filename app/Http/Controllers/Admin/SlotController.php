<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CollectionSlot;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SlotController extends Controller
{
    /**
     * Display the list of collection time slots.
     */
    public function index(Request $request): View
    {
        $query = CollectionSlot::query();

        // Filter by Period
        if ($request->filled('period') && in_array($request->period, ['morning', 'afternoon', 'evening'])) {
            $query->where('period', $request->period);
        }

        // Filter by Status
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        // Search by title or time
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where('title', 'like', "%{$search}%");
        }

        $slots = $query->ordered()->paginate(25)->withQueryString();

        // Calculate statistics for header cards
        $totalSlots = CollectionSlot::count();
        $activeSlots = CollectionSlot::where('is_active', true)->count();
        $inactiveSlots = CollectionSlot::where('is_active', false)->count();
        $morningCount = CollectionSlot::where('period', 'morning')->count();
        $afternoonCount = CollectionSlot::where('period', 'afternoon')->count();
        $eveningCount = CollectionSlot::where('period', 'evening')->count();

        // Today's slot booking counts
        $today = now()->format('Y-m-d');
        $todayBookingStats = Booking::whereDate('booking_date', $today)
            ->whereNotNull('collection_slot')
            ->selectRaw('collection_slot, count(*) as count')
            ->groupBy('collection_slot')
            ->pluck('count', 'collection_slot')
            ->toArray();

        return view('admin.pages.slots.index', compact(
            'slots',
            'totalSlots',
            'activeSlots',
            'inactiveSlots',
            'morningCount',
            'afternoonCount',
            'eveningCount',
            'todayBookingStats'
        ));
    }

    /**
     * Store a newly created collection time slot.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:100',
            'period' => 'required|in:morning,afternoon,evening',
            'start_time' => 'required',
            'end_time' => 'required',
            'max_bookings' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        // Auto-generate title if not explicitly provided or format nicely
        $title = trim($request->input('title', ''));
        if (empty($title)) {
            $startTimeFormatted = date('h:i A', strtotime($request->start_time));
            $endTimeFormatted = date('h:i A', strtotime($request->end_time));
            $title = "{$startTimeFormatted} - {$endTimeFormatted}";
        }

        // If sort_order not provided, set to max + 1
        $sortOrder = $request->filled('sort_order')
            ? (int) $request->sort_order
            : (CollectionSlot::max('sort_order') ?? 0) + 1;

        CollectionSlot::create([
            'title' => $title,
            'period' => $request->period,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'max_bookings' => (int) ($request->max_bookings ?? 0),
            'sort_order' => $sortOrder,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', "Collection slot '{$title}' created successfully.");
    }

    /**
     * Update an existing collection time slot.
     */
    public function update(Request $request, int|string $id): RedirectResponse
    {
        $slot = CollectionSlot::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'period' => 'required|in:morning,afternoon,evening',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'max_bookings' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
        ]);

        $slot->title = $request->title;
        $slot->period = $request->period;
        if ($request->filled('start_time')) {
            $slot->start_time = $request->start_time;
        }
        if ($request->filled('end_time')) {
            $slot->end_time = $request->end_time;
        }
        $slot->max_bookings = (int) ($request->max_bookings ?? 0);
        if ($request->filled('sort_order')) {
            $slot->sort_order = (int) $request->sort_order;
        }
        $slot->is_active = $request->boolean('is_active', true);
        $slot->save();

        return back()->with('success', "Slot '{$slot->title}' updated successfully.");
    }

    /**
     * Toggle active/inactive status of a slot.
     */
    public function toggle(Request $request, int|string $id): RedirectResponse|JsonResponse
    {
        $slot = CollectionSlot::findOrFail($id);
        $slot->is_active = ! $slot->is_active;
        $slot->save();

        $statusStr = $slot->is_active ? 'Activated' : 'Deactivated';

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'is_active' => $slot->is_active,
                'message' => "Slot '{$slot->title}' is now {$statusStr}.",
            ]);
        }

        return back()->with('success', "Slot '{$slot->title}' is now {$statusStr}.");
    }

    /**
     * Delete a collection slot.
     */
    public function destroy(int|string $id): RedirectResponse
    {
        $slot = CollectionSlot::findOrFail($id);
        $title = $slot->title;
        $slot->delete();

        return back()->with('success', "Slot '{$title}' removed successfully.");
    }
}
