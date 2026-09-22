<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\Booking;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AgentPortalController extends Controller
{
    private function getLoggedInAgent()
    {
        $agentId = session('agent_id');
        if (! $agentId) {
            return null;
        }

        return Agent::find($agentId);
    }

    public function showLoginForm()
    {
        if (session()->has('agent_id') && Agent::find(session('agent_id'))) {
            return redirect()->route('agent.dashboard');
        }
        $agents = Agent::where('status', 'active')->orderBy('name')->get();

        return view('agent.pages.login', compact('agents'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:agents,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:4',
            'city' => 'nullable|string|max:100',
            'vehicle_number' => 'nullable|string|max:50',
        ]);

        $agent = Agent::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'city' => $request->city,
            'vehicle_number' => $request->vehicle_number,
            'status' => 'pending_approval',
            'last_login_at' => null,
        ]);

        try {
            app(NotificationService::class)->agentRegistered($agent);
        } catch (\Throwable $e) {
            Log::warning('Agent registration notification failed: '.$e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'redirect' => route('agent.login'),
                'message' => 'Registration submitted successfully! Your account is pending admin approval before you can log in.',
            ]);
        }

        return redirect()->route('agent.login')->with('success', 'Registration submitted successfully! Your account is pending admin approval.');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
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
                    'success' => true,
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
        if (! $agent) {
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

        return view('agent.pages.dashboard', compact(
            'agent', 'bookings', 'totalAssigned', 'pendingCollection', 'samplesCollected', 'cashToCollect', 'cashCollected'
        ));
    }

    public function progress(Request $request)
    {
        $agent = $this->getLoggedInAgent();
        if (! $agent) {
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

        return view('agent.pages.progress', compact('agent', 'bookings', 'filter'));
    }

    public function updateSampleStatus(Request $request, $id)
    {
        $agent = $this->getLoggedInAgent();
        if (! $agent) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $request->validate([
            'sample_status' => 'required|in:Out for Collection,Sample Collected,Delivered to Lab',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking = Booking::where('agent_id', $agent->id)->findOrFail($id);

        if ($booking->status === 'Cancelled') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cannot update sample status on a cancelled booking.'], 422);
            }

            return back()->with('error', 'Cannot update sample status on a cancelled booking.');
        }

        if ($request->sample_status === 'Delivered to Lab' && $booking->sample_status !== 'Sample Collected') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Sample must be collected before it can be marked as Delivered to Lab.'], 422);
            }

            return back()->with('error', 'Sample must be collected before it can be marked as Delivered to Lab.');
        }

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

        if ($request->sample_status === 'Sample Collected') {
            try {
                $booking->load(['patient', 'agent']);
                app(NotificationService::class)->sampleCollected($booking);
            } catch (\Throwable $e) {
                Log::warning('Sample collected notification failed: '.$e->getMessage());
            }
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'sample_status' => $booking->sample_status,
                'message' => 'Sample status updated to '.$booking->sample_status,
            ]);
        }

        return back()->with('success', 'Status updated to '.$booking->sample_status);
    }

    public function collections()
    {
        $agent = $this->getLoggedInAgent();
        if (! $agent) {
            return redirect('/')->with('error', 'Please login to access the Agent Portal.');
        }

        $bookings = Booking::with(['patient', 'address'])
            ->where('agent_id', $agent->id)
            ->latest('booking_date')
            ->get();

        $totalCashInHand = $bookings->where('money_collected_by', $agent->id)->where('payment_status', 'Paid')->sum('amount');
        $totalPendingCash = $bookings->where('payment_status', '!=', 'Paid')->sum('amount');
        $totalOnlinePaid = $bookings->where('payment_status', 'Paid')->where('money_collected_by', '!=', $agent->id)->count();

        return view('agent.pages.collections', compact('agent', 'bookings', 'totalCashInHand', 'totalPendingCash', 'totalOnlinePaid'));
    }

    public function collectMoney(Request $request, $id)
    {
        $agent = $this->getLoggedInAgent();
        if (! $agent) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $booking = Booking::where('agent_id', $agent->id)->findOrFail($id);

        if ($booking->status === 'Cancelled') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'Cannot collect payment on a cancelled booking.'], 422);
            }

            return back()->with('error', 'Cannot collect payment on a cancelled booking.');
        }

        if ($booking->payment_status === 'Paid') {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'This booking has already been marked as Paid.']);
            }

            return back()->with('info', 'This booking has already been marked as Paid.');
        }

        $paymentMode = $request->input('payment_mode', 'Cash');

        $booking->payment_status = 'Paid';
        $booking->money_collected_at = now();
        $booking->money_collected_by = $agent->id;
        $booking->money_payment_mode = $paymentMode;
        $booking->save();

        try {
            $booking->load('patient');
            app(NotificationService::class)->paymentSuccess($booking);
        } catch (\Throwable $e) {
            Log::warning('Payment success notification failed: '.$e->getMessage());
        }

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Payment of ₹'.$booking->amount.' successfully collected via '.$paymentMode.'!',
            ]);
        }

        return back()->with('success', 'Payment of ₹'.$booking->amount.' collected successfully!');
    }
}
