@extends('emails.layouts.base')

@section('content')
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-danger">Payment Incomplete</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Payment Was Unsuccessful</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong>{{ $booking->patient?->name ?? 'Valued Customer' }}</strong>, we couldn't process the payment for booking <strong>#{{ $booking->booking_reference }}</strong>.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#{{ $booking->booking_reference }}</td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Amount Due</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 700; font-size: 16px; text-align: right;">₹{{ number_format((float) $booking->amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Payment Status</td>
                <td style="padding: 8px 0; color: #b91c1c; font-weight: 700; font-size: 14px; text-align: right;">Failed / Incomplete</td>
            </tr>
        </table>
    </div>

    <p style="margin-top: 16px; font-size: 14px; color: #334155; line-height: 1.6;">
        Don't worry! If money was debited from your account, banks usually reverse it automatically within 48-72 hours. You can retry paying online or choose Pay on Collection.
    </p>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ url('/patient/bookings') }}" class="btn">Retry Payment</a>
    </div>
@endsection
