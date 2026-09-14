<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent;
use App\Models\Booking;

class AgentPortalController extends Controller
{
    private function getLoggedInAgent()
    {
        $agentId = session('agent_id');
        if (!$agentId) return null;
        return Agent::find($agentId);
    }

    public function showLoginForm()
    {
        if (session()->has('agent_id') && Agent::find(session('agent_id'))) {
            return redirect()->route('agent.dashboard');
        }
        $agents = Agent::where('status', 'active')->orderBy('name')->get();
        return view('agent.login', compact('agents'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:100',
            'email'    => 'required|email|unique:agents,email',
            'phone'    => 'required|string|max:20',
            'password' => 'required|string|min:4',
            'city'     => 'nullable|string|max:100',
            'vehicle_number' => 'nullable|string|max:50',
        ]);

        $agent = Agent::create([
            'name'           => $request->name,
            'email'          => $request->email,
            'phone'          => $request->phone,
            'password'       => Hash::make($request->password),
            'city'           => $request->city,
            'vehicle_number' => $request->vehicle_number,
            'status'         => 'active',
            'last_login_at'  => now(),
        ]);

        session(['agent_id' => $agent->id]);

        if ($request->wantsJson()) {
            return response()->json([
                'success'  => true,
                'redirect' => route('agent.dashboard'),
                'message'  => 'Agent registered successfully!',
            ]);
        }

        return redirect()->route('agent.dashboard')->with('success', 'Agent registered successfully!');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $agent = Agent::where('email', $request->email)->first();

        if ($agent && Hash::check($request->password, $agent->password)) {
            if ($agent->status !== 'active') {
                if ($request->wantsJson()) {
                    return response()->json(['success' => false, 'message' => 'Your agent account is inactive. Please contact admin.']);
                }
                return back()->with('error', 'Your agent account is inactive. Please contact admin.')->withInput();
            }

            $agent->update(['last_login_at' => now()]);
            session(['agent_id' => $agent->id]);

            if ($request->wantsJson()) {
                return response()->json([
                    'success'  => true,
                    'redirect' => route('agent.dashboard'),
                ]);
            }

            return redirect()->route('agent.dashboard')->with('success', "Welcome back, {$agent->name}!");
        }

        if ($request->wantsJson()) {
            return response()->json(['success' => false, 'message' => 'Invalid email or password for agent.']);
        }

        return back()->with('error', 'Invalid email or password.')->withInput();
    }

    public function logout()
    {
        session()->forget('agent_id');
        return redirect()->route('home')->with('success', 'Logged out successfully.');
    }

    public function dashboard()
    {
        $agent = $this->getLoggedInAgent();
        if (!$agent) {
            return redirect()->route('agent.login')->with('error', 'Please login to access the Agent Portal.');
        }

        $bookings = Booking::with(['patient', 'address', 'familyMember'])
            ->where('agent_id', $agent->id)
            ->latest('booking_date')
            ->get();

        // Metrics
        $totalAssigned = $bookings->count();
        $pendingCollection = $bookings->whereNotIn('sample_status', ['Sample Collected', 'Delivered to Lab'])->count();
        $samplesCollected = $bookings->whereIn('sample_status', ['Sample Collected', 'Delivered to Lab'])->count();
        
        $cashToCollect = $bookings->where('payment_status', '!=', 'Paid')->sum('amount');
        $cashCollected = $bookings->where('money_collected_by', $agent->id)->where('payment_status', 'Paid')->sum('amount');

        return view('agent.dashboard', compact(
            'agent', 'bookings', 'totalAssigned', 'pendingCollection', 'samplesCollected', 'cashToCollect', 'cashCollected'
        ));
    }

    public function progress(Request $request)
    {
        $agent = $this->getLoggedInAgent();
        if (!$agent) {
            return redirect()->route('agent.login')->with('error', 'Please login to access the Agent Portal.');
        }

        $filter = $request->query('status', 'all');

        $query = Booking::with(['patient', 'address', 'familyMember'])
            ->where('agent_id', $agent->id);

        if ($filter === 'active') {
            $query->whereNotIn('sample_status', ['Delivered to Lab', 'Cancelled']);
        } elseif ($filter === 'collected') {
            $query->where('sample_status', 'Sample Collected');
        } elseif ($filter === 'delivered') {
            $query->where('sample_status', 'Delivered to Lab');
        }

        $bookings = $query->latest('booking_date')->get();

        return view('agent.progress', compact('agent', 'bookings', 'filter'));
    }

    public function updateSampleStatus(Request $request, $id)
    {
        $agent = $this->getLoggedInAgent();
        if (!$agent) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'sample_status' => 'required|in:Out for Collection,Sample Collected,Delivered to Lab',
            'notes'         => 'nullable|string|max:500',
        ]);

        $booking = Booking::where('agent_id', $agent->id)->findOrFail($id);
        $booking->sample_status = $request->sample_status;

        if ($request->sample_status === 'Sample Collected') {
            $booking->sample_collected_at = now();
            $booking->status = 'Sample Collected';
        } elseif ($request->sample_status === 'Delivered to Lab') {
            $booking->status = 'In Process';
        }

        if ($request->filled('notes')) {
            $booking->sample_notes = $request->notes;
        }

        $booking->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success'       => true,
                'sample_status' => $booking->sample_status,
                'message'       => 'Sample status updated to ' . $booking->sample_status,
            ]);
        }

        return back()->with('success', 'Status updated to ' . $booking->sample_status);
    }

    public function collections()
    {
        $agent = $this->getLoggedInAgent();
        if (!$agent) {
            return redirect('/')->with('error', 'Please login to access the Agent Portal.');
        }

        $bookings = Booking::with(['patient', 'address'])
            ->where('agent_id', $agent->id)
            ->latest('booking_date')
            ->get();

        $totalCashInHand = $bookings->where('money_collected_by', $agent->id)->where('payment_status', 'Paid')->sum('amount');
        $totalPendingCash = $bookings->where('payment_status', '!=', 'Paid')->sum('amount');
        $totalOnlinePaid = $bookings->where('payment_status', 'Paid')->where('money_collected_by', '!=', $agent->id)->count();

        return view('agent.collections', compact('agent', 'bookings', 'totalCashInHand', 'totalPendingCash', 'totalOnlinePaid'));
    }

    public function collectMoney(Request $request, $id)
    {
        $agent = $this->getLoggedInAgent();
        if (!$agent) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $booking = Booking::where('agent_id', $agent->id)->findOrFail($id);

        if ($booking->payment_status === 'Paid') {
            return back()->with('info', 'This booking has already been marked as Paid.');
        }

        $paymentMode = $request->input('payment_mode', 'Cash');

        $booking->payment_status = 'Paid';
        $booking->money_collected_at = now();
        $booking->money_collected_by = $agent->id;
        $booking->money_payment_mode = $paymentMode;
        $booking->save();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment of ₹' . $booking->amount . ' successfully collected via ' . $paymentMode . '!',
            ]);
        }

        return back()->with('success', 'Payment of ₹' . $booking->amount . ' collected successfully!');
    }
}
