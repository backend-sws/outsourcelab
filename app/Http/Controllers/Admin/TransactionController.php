<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentTransaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    /**
     * Display a paginated listing of all payment transactions and gateway audit logs.
     */
    public function index(Request $request): View
    {
        $query = PaymentTransaction::with(['patient', 'booking', 'membership']);

        // Search Filter
        if ($request->filled('search')) {
            $search = trim($request->input('search'));
            $query->where(function ($q) use ($search) {
                $q->where('transaction_reference', 'like', "%{$search}%")
                    ->orWhere('razorpay_order_id', 'like', "%{$search}%")
                    ->orWhere('razorpay_payment_id', 'like', "%{$search}%")
                    ->orWhere('vpa', 'like', "%{$search}%")
                    ->orWhereHas('patient', function ($pq) use ($search) {
                        $pq->where('name', 'like', "%{$search}%")
                            ->orWhere('mobile', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    })
                    ->orWhereHas('booking', function ($bq) use ($search) {
                        $bq->where('booking_reference', 'like', "%{$search}%");
                    });
            });
        }

        // Status Filter
        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            if ($status === 'pending') {
                $query->whereIn('status', ['created', 'authorized']);
            } else {
                $query->where('status', $status);
            }
        }

        // Payment Method Filter
        if ($request->filled('method') && $request->input('method') !== 'all') {
            $query->where('payment_method', $request->input('method'));
        }

        // Type Filter (Booking vs Membership)
        if ($request->filled('type') && $request->input('type') !== 'all') {
            $query->where('type', $request->input('type'));
        }

        // Date Range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        // KPIs
        $totalVolume = (float) PaymentTransaction::where('status', 'captured')->sum('amount');
        $successfulCount = PaymentTransaction::where('status', 'captured')->count();
        $todayCollection = (float) PaymentTransaction::where('status', 'captured')->whereDate('paid_at', today())->sum('amount');
        $failedCount = PaymentTransaction::where('status', 'failed')->count();

        $transactions = $query->latest('id')->paginate(15)->withQueryString();

        return view('admin.pages.transactions.index', compact(
            'transactions',
            'totalVolume',
            'successfulCount',
            'todayCollection',
            'failedCount'
        ));
    }

    /**
     * Fetch full transaction JSON payload for audit modal inspection.
     */
    public function show(int $id): JsonResponse
    {
        $transaction = PaymentTransaction::with(['patient', 'booking', 'membership'])->findOrFail($id);

        return response()->json([
            'success' => true,
            'transaction' => $transaction,
        ]);
    }
}
