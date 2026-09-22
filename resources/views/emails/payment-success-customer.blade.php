@extends('emails.layouts.base')

@section('content')
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-success">Payment Received</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Payment Successful</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong>{{ $booking->patient?->name ?? 'Valued Customer' }}</strong>, thank you for your payment.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#{{ $booking->booking_reference }}</td>
            </tr>
            @if($booking->razorpay_payment_id)
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Transaction ID</td>
                <td style="padding: 8px 0; color: #0f172a; font-family: monospace; font-size: 13px; text-align: right;">{{ $booking->razorpay_payment_id }}</td>
            </tr>
            @endif
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Payment Method</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">{{ $booking->payment_method ?? 'Online / Razorpay' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Amount Paid</td>
                <td style="padding: 8px 0; color: #15803d; font-weight: 700; font-size: 18px; text-align: right;">
                    ₹{{ number_format((float) $booking->amount, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ url('/patient/bookings') }}" class="btn">View Booking & Receipt</a>
    </div>
@endsection
