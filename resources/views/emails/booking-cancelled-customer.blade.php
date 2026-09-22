@extends('emails.layouts.base')

@section('content')
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-danger">Booking Cancelled</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Booking Has Been Cancelled</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong>{{ $booking->patient?->name ?? 'Valued Customer' }}</strong>, your booking <strong>#{{ $booking->booking_reference }}</strong> has been cancelled.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#{{ $booking->booking_reference }}</td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Scheduled Date</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">
                    {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M, Y') : 'N/A' }}
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Status</td>
                <td style="padding: 8px 0; color: #b91c1c; font-weight: 700; font-size: 14px; text-align: right;">Cancelled</td>
            </tr>
        </table>
    </div>

    <p style="margin-top: 20px; font-size: 14px; color: #334155; line-height: 1.6;">
        If you made an online payment for this booking, our team will initiate a refund as per our cancellation policy within 3-5 business days.
    </p>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ url('/') }}" class="btn">Book Another Test</a>
    </div>
@endsection
