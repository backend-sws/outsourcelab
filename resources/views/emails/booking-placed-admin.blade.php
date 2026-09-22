@extends('emails.layouts.base')

@section('content')
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-primary">New Booking Alert</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">New Booking Placed</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            A new booking #{{ $booking->booking_reference }} has been submitted and awaits review.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#{{ $booking->booking_reference }}</td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Customer Name</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">{{ $booking->patient?->name ?? 'N/A' }}</td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Contact Number</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">{{ $booking->patient?->mobile ?? 'N/A' }}</td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Date & Time</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">
                    {{ $booking->booking_date ? \Carbon\Carbon::parse($booking->booking_date)->format('d M, Y') : 'N/A' }}
                    @if($booking->booking_time) ({{ $booking->booking_time }}) @endif
                </td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Payment Status</td>
                <td style="padding: 8px 0; text-align: right;">
                    <span class="badge {{ $booking->payment_status === 'Paid' ? 'badge-success' : 'badge-warning' }}">
                        {{ $booking->payment_status ?? 'Pending' }}
                    </span>
                </td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Amount</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 700; font-size: 16px; text-align: right;">
                    ₹{{ number_format((float) $booking->amount, 2) }}
                </td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ url('/admin/bookings/' . $booking->id) }}" class="btn">View & Assign Phlebotomist</a>
    </div>
@endsection
