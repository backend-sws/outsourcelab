<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\AgentLeave;
use App\Models\Booking;
use App\Models\CollectionSlot;
use App\Services\AutoAssignPhlebotomistService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AgentController extends Controller
{
    public function index(): View
    {
        $agents = Agent::withCount([
            'bookings',
            'bookings as active_bookings_count' => function ($query) {
                $query->whereNotIn('sample_status', ['Delivered to Lab', 'Cancelled']);
            },
            'bookings as completed_samples_count' => function ($query) {
                $query->whereIn('sample_status', ['Sample Collected', 'Delivered to Lab']);
            },
            'leaves as upcoming_leaves_count' => function ($query) {
                $query->whereDate('leave_date', '>=', now()->toDateString())->where('status', 'approved');
            },
        ])->with(['leaves' => function ($query) {
            $query->whereDate('leave_date', '>=', now()->subDays(2))->orderBy('leave_date', 'asc');
        }])->latest()->paginate(15);

        $slots = CollectionSlot::active()->ordered()->get();

        return view('admin.pages.agents.index', compact('agents', 'slots'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:4',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
            'serviceable_pincodes' => 'nullable|string',
            'max_orders_per_slot' => 'nullable|integer|min:1|max:20',
            'weekly_offs' => 'nullable|array',
            'lis_collector_id' => 'nullable|string|max:50',
        ]);

        Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'city' => $request->city,
            'address' => $request->address,
            'vehicle_number' => $request->vehicle_number,
            'serviceable_pincodes' => $request->serviceable_pincodes ? trim($request->serviceable_pincodes) : null,
            'max_orders_per_slot' => $request->max_orders_per_slot ?: 2,
            'weekly_offs' => $request->weekly_offs ?: [],
            'lis_collector_id' => $request->lis_collector_id ? trim($request->lis_collector_id) : null,
            'status' => 'active',
        ]);

        return back()->with('success', 'Phlebotomist / Field Agent added successfully.');
    }

    public function update(Request $request, int|string $id): RedirectResponse
    {
        $agent = Agent::findOrFail($id);
        $wasActive = $agent->status === 'active';

        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:agents,email,'.$agent->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:4',
            'city' => 'nullable|string|max:100',
            'address' => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
            'serviceable_pincodes' => 'nullable|string',
            'max_orders_per_slot' => 'nullable|integer|min:1|max:20',
            'weekly_offs' => 'nullable|array',
            'lis_collector_id' => 'nullable|string|max:50',
            'status' => 'nullable|in:active,inactive',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'city' => $request->city,
            'address' => $request->address,
            'vehicle_number' => $request->vehicle_number,
            'serviceable_pincodes' => $request->serviceable_pincodes ? trim($request->serviceable_pincodes) : null,
            'max_orders_per_slot' => $request->max_orders_per_slot ?: 2,
            'weekly_offs' => $request->weekly_offs ?: [],
            'lis_collector_id' => $request->lis_collector_id ? trim($request->lis_collector_id) : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }
        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }

        $agent->update($data);
        $agent->refresh();

        if ($wasActive && $agent->status === 'inactive') {
            $deactivationMsg = $this->handleAgentDeactivation($agent);

            return back()->with('success', "Agent {$agent->name} updated. {$deactivationMsg}");
        }

        return back()->with('success', "Agent {$agent->name} updated successfully.");
    }

    public function toggleStatus(int|string $id): RedirectResponse
    {
        $agent = Agent::findOrFail($id);
        $newStatus = $agent->status === 'active' ? 'inactive' : 'active';
        $agent->status = $newStatus;
        $agent->save();

        if ($newStatus === 'inactive') {
            $msg = $this->handleAgentDeactivation($agent);

            return back()->with('success', $msg);
        }

        return back()->with('success', "Phlebotomist {$agent->name} has been activated successfully.");
    }

    /**
     * When an agent is deactivated, remove their active assignments and reassign to available active agents.
     */
    private function handleAgentDeactivation(Agent $agent): string
    {
        $activeBookings = Booking::where('agent_id', $agent->id)
            ->whereNotIn('sample_status', ['Delivered to Lab', 'Cancelled'])
            ->get();

        if ($activeBookings->isEmpty()) {
            return "Phlebotomist {$agent->name} is now Deactivated. (No pending bookings were assigned).";
        }

        $autoAssignService = app(AutoAssignPhlebotomistService::class);
        $reassignedCount = 0;
        $unassignedCount = 0;

        foreach ($activeBookings as $booking) {
            // Unassign from deactivated agent
            $booking->agent_id = null;
            $booking->sample_status = 'Pending';
            $booking->save();

            // Attempt auto-reassignment to an active phlebotomist covering this area
            $newAgent = null;
            try {
                $newAgent = $autoAssignService->assign($booking);
            } catch (\Throwable $e) {
                Log::warning("Auto-reassigning booking #{$booking->booking_reference} on agent deactivation failed: {$e->getMessage()}");
            }

            if ($newAgent && (int) $newAgent->id !== (int) $agent->id) {
                $reassignedCount++;
            } else {
                $unassignedCount++;
            }
        }

        $parts = [];
        if ($reassignedCount > 0) {
            $parts[] = "{$reassignedCount} active booking(s) reassigned to on-duty phlebotomists";
        }
        if ($unassignedCount > 0) {
            $parts[] = "{$unassignedCount} active booking(s) set to Unassigned for manual assignment";
        }

        return "Phlebotomist {$agent->name} is now Deactivated. ".implode(', and ', $parts).'.';
    }

    public function destroy(int|string $id): RedirectResponse
    {
        $agent = Agent::findOrFail($id);
        // Nullify agent_id on bookings
        Booking::where('agent_id', $agent->id)->update(['agent_id' => null]);
        $agent->leaves()->delete();
        $agent->delete();

        return back()->with('success', 'Agent deleted successfully.');
    }

    /**
     * Get leaves for a specific agent (JSON response for modal/ajax).
     */
    public function getLeaves(int|string $id): JsonResponse
    {
        $agent = Agent::with(['leaves' => function ($q) {
            $q->orderBy('leave_date', 'desc');
        }])->findOrFail($id);

        return response()->json([
            'success' => true,
            'agent' => [
                'id' => $agent->id,
                'name' => $agent->name,
                'weekly_offs' => $agent->weekly_offs ?? [],
                'serviceable_pincodes' => $agent->serviceable_pincodes,
            ],
            'leaves' => $agent->leaves,
        ]);
    }

    /**
     * Store a new leave for an agent.
     */
    public function storeLeave(Request $request, int|string $id): JsonResponse|RedirectResponse
    {
        $agent = Agent::findOrFail($id);

        $request->validate([
            'leave_date' => 'required|date',
            'slot_title' => 'nullable|string|max:100',
            'leave_type' => 'nullable|in:full_day,slot_specific,sick,emergency',
            'reason' => 'nullable|string|max:255',
        ]);

        $leaveType = $request->leave_type ?: (! empty($request->slot_title) ? 'slot_specific' : 'full_day');

        $leave = AgentLeave::create([
            'agent_id' => $agent->id,
            'leave_date' => date('Y-m-d', strtotime($request->leave_date)),
            'slot_title' => $leaveType === 'full_day' ? null : $request->slot_title,
            'leave_type' => $leaveType,
            'reason' => $request->reason ?: 'Scheduled off/leave',
            'status' => 'approved',
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'leave' => $leave,
                'message' => 'Leave marked successfully.',
            ]);
        }

        return back()->with('success', "Leave marked for {$agent->name} on {$request->leave_date}.");
    }

    /**
     * Delete/cancel an agent leave record.
     */
    public function destroyLeave(int|string $leaveId): JsonResponse|RedirectResponse
    {
        $leave = AgentLeave::findOrFail($leaveId);
        $leave->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Leave cancelled successfully.',
            ]);
        }

        return back()->with('success', 'Leave record removed.');
    }

    /**
     * Quick toggle off-duty for today or tomorrow.
     */
    public function quickToggleOff(Request $request, int|string $id): RedirectResponse
    {
        $agent = Agent::findOrFail($id);
        $targetDate = $request->input('date') ?: now()->format('Y-m-d');

        $existing = AgentLeave::where('agent_id', $agent->id)
            ->whereDate('leave_date', $targetDate)
            ->first();

        if ($existing) {
            $existing->delete();
            $msg = "Duty resumed for {$agent->name} on {$targetDate}.";
        } else {
            AgentLeave::create([
                'agent_id' => $agent->id,
                'leave_date' => $targetDate,
                'leave_type' => 'full_day',
                'reason' => 'Quick off marked by Admin',
                'status' => 'approved',
            ]);
            $msg = "Off-duty marked for {$agent->name} on {$targetDate}.";
        }

        return back()->with('success', $msg);
    }
}
