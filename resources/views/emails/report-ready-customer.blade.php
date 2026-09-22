@extends('emails.layouts.base')

@section('content')
    <div style="text-align: center; margin-bottom: 24px;">
        <span class="badge badge-success">Report Ready</span>
        <h2 style="margin: 12px 0 6px; color: #0f172a; font-size: 20px;">Your Test Report is Available!</h2>
        <p style="margin: 0; color: #64748b; font-size: 14px;">
            Hello <strong>{{ $booking->patient?->name ?? 'Valued Customer' }}</strong>, your diagnostic test report for booking <strong>#{{ $booking->booking_reference }}</strong> has been verified and published.
        </p>
    </div>

    <div class="info-card">
        <table style="width: 100%; border-collapse: collapse;">
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Booking Reference</td>
                <td style="padding: 8px 0; color: #0d9488; font-weight: 700; font-size: 14px; text-align: right;">#{{ $booking->booking_reference }}</td>
            </tr>
            <tr style="border-bottom: 1px dashed #e2e8f0;">
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Report Date</td>
                <td style="padding: 8px 0; color: #0f172a; font-weight: 600; font-size: 14px; text-align: right;">{{ now()->format('d M, Y') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px 0; color: #64748b; font-size: 14px;">Status</td>
                <td style="padding: 8px 0; color: #15803d; font-weight: 700; font-size: 14px; text-align: right;">Verified & Published</td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        @if($booking->report_url)
            <a href="{{ $booking->report_url }}" target="_blank" class="btn">View / Download Report</a>
        @elseif($booking->report_file)
            <a href="{{ asset('storage/' . $booking->report_file) }}" target="_blank" class="btn">Download Report PDF</a>
        @else
            <a href="{{ url('/patient/bookings') }}" class="btn">View Report in Portal</a>
        @endif
    </div>

    <p style="margin-top: 24px; font-size: 13px; color: #64748b; text-align: center;">
        You can also log in to your patient dashboard at any time to access your past reports and medical history.
    </p>
@endsection
