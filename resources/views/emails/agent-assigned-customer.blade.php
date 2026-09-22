@extends('emails.layouts.base')

@section('content')
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-primary">Phlebotomist Assigned</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Phlebotomist Assigned</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong>{{ $booking->patient?->name ?? 'Valued Customer' }}</strong>, our phlebotomist has been assigned for your test sample collection.
        </p>
    </div>

    <div class="info-card">
        <h4 style="margin: 0 0 12px; font-size: 13px; color: #64748b; text-transform: uppercase;">Phlebotomist Details</h4>
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Name</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 700; font-size: 14px; text-align: right;">{{ $booking->agent?->name ?? 'Assigned Agent' }}</td>
            </tr>
            @if($booking->agent?->phone)
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Phone Number</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 600; font-size: 14px; text-align: right;">
                    <a href="tel:{{ $booking->agent->phone }}" style="color: #0d9488; text-decoration: none;">{{ $booking->agent->phone }}</a>
                </td>
            </tr>
            @endif
            @if($booking->agent?->vehicle_number)
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Vehicle Number</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">{{ $booking->agent->vehicle_number }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">#{{ $booking->booking_reference }}</td>
            </tr>
        </table>
    </div>

    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 14px 18px; margin-bottom: 20px;">
        <p style="margin: 0; font-size: 13px; color: #166534;">
            💡 <strong>Pre-collection tip:</strong> Please ensure you follow any required fasting guidelines before the phlebotomist arrives.
        </p>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ url('/patient/bookings') }}" class="btn">Track Booking Status</a>
    </div>
@endsection
