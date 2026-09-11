<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Booking;
use App\Models\Agent;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['patient', 'agent'])->latest()->paginate(15);
        $agents = Agent::where('status', 'active')->get();
        return view('admin.bookings.index', compact('bookings', 'agents'));
    }

    public function show(int $id)
    {
        $booking = Booking::with(['patient', 'familyMember', 'address', 'agent'])->findOrFail($id);
        $agents = Agent::where('status', 'active')->get();
        return view('admin.bookings.show', compact('booking', 'agents'));
    }

    public function assignAgent(Request $request, int $id)
    {
        $request->validate([
            'agent_id' => 'nullable|exists:agents,id',
        ]);

        $booking = Booking::findOrFail($id);
        $booking->agent_id = $request->agent_id;
        if ($request->filled('agent_id')) {
            if ($booking->sample_status === 'Pending') {
                $booking->sample_status = 'Assigned';
            }
            if ($booking->status === 'Pending') {
                $booking->status = 'Confirmed';
            }
        }
        $booking->save();

        $agentName = $booking->agent ? $booking->agent->name : 'Unassigned';
        return back()->with('success', "Agent assigned successfully: {$agentName}");
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
