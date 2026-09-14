<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Agent;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['patient', 'agent'])->latest();

        if ($request->filled('agent_id')) {
            if ($request->agent_id === 'unassigned') {
                $query->whereNull('agent_id');
            } else {
                $query->where('agent_id', $request->agent_id);
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $bookings = $query->paginate(15)->withQueryString();
        $agents = Agent::where('status', 'active')->orderBy('name')->get();
        return view('admin.bookings.index', compact('bookings', 'agents'));
    }

    public function show(int $id)
    {
        $booking = Booking::with(['patient', 'familyMember', 'address', 'agent'])->findOrFail($id);
        $agents = Agent::where('status', 'active')->orderBy('name')->get();
        return view('admin.bookings.show', compact('booking', 'agents'));
    }

    public function assignAgent(Request $request, int $id)
    {
        $request->validate([
            'agent_id' => 'nullable|exists:agents,id',
        ]);

        $booking = Booking::findOrFail($id);
        $agentId = $request->filled('agent_id') ? (int)$request->agent_id : null;
        $booking->agent_id = $agentId;

        if ($agentId) {
            // When agent is assigned, advance sample and order status
            if (empty($booking->sample_status) || in_array($booking->sample_status, ['Pending', 'Booked'])) {
                $booking->sample_status = 'Assigned';
            }
            if (in_array($booking->status, ['Pending', 'Booked'])) {
                $booking->status = 'Confirmed';
            }
        } else {
            // Unassigning agent
            if ($booking->sample_status === 'Assigned') {
                $booking->sample_status = 'Pending';
            }
        }
        $booking->save();
        $booking->load('agent');

        $agentName = $booking->agent ? $booking->agent->name : 'Unassigned';
        return back()->with('success', $agentId 
            ? "Field Agent '{$agentName}' successfully assigned to booking #{$booking->booking_reference}." 
            : "Booking #{$booking->booking_reference} is now unassigned.");
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate([
            'status' => 'required|string'
        ]);

        $booking = Booking::findOrFail($id);
        $booking->status = $request->status;
        $booking->save();

        return back()->with('success', 'Booking status updated successfully.');
    }

    public function print(int $id)
    {
        $booking = Booking::with(['patient', 'familyMember', 'address', 'agent'])->findOrFail($id);
        return view('admin.bookings.print', compact('booking'));
    }
}
