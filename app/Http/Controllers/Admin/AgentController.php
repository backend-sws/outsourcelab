<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent;
use App\Models\Booking;

class AgentController extends Controller
{
    public function index()
    {
        $agents = Agent::withCount([
            'bookings',
            'bookings as active_bookings_count' => function ($query) {
                $query->whereNotIn('sample_status', ['Delivered to Lab', 'Cancelled']);
            },
            'bookings as completed_samples_count' => function ($query) {
                $query->whereIn('sample_status', ['Sample Collected', 'Delivered to Lab']);
            }
        ])->latest()->paginate(15);

        return view('admin.agents.index', compact('agents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|unique:agents,email',
            'phone'          => 'required|string|max:20',
            'password'       => 'required|string|min:4',
            'city'           => 'nullable|string|max:100',
            'address'        => 'nullable|string|max:255',
            'vehicle_number' => 'nullable|string|max:50',
        ]);

        Agent::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'password'       => Hash::make($request->password),
            'city'           => $request->city,
            'address'        => $request->address,
            'vehicle_number' => $request->vehicle_number,
            'status'         => 'active',
        ]);

        return back()->with('success', 'Agent added successfully.');
    }

    public function toggleStatus($id)
    {
        $agent = Agent::findOrFail($id);
        $agent->status = $agent->status === 'active' ? 'inactive' : 'active';
        $agent->save();

        return back()->with('success', 'Agent status updated to ' . ucfirst($agent->status) . '.');
    }

    public function destroy($id)
    {
        $agent = Agent::findOrFail($id);
        // Nullify agent_id on bookings
        Booking::where('agent_id', $agent->id)->update(['agent_id' => null]);
        $agent->delete();

        return back()->with('success', 'Agent deleted successfully.');
    }
}
