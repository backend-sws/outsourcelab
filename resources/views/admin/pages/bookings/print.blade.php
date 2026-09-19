<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Booking #{{ $booking->booking_reference }}</title>
    @include('partials.favicon')
    <style>
        body { font-family: Arial, sans-serif; margin: 0; padding: 20px; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #333; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; margin-bottom: 10px; }
        .title { font-size: 18px; text-transform: uppercase; letter-spacing: 2px; }
        .details-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px; }
        .box { border: 1px solid #ddd; padding: 15px; border-radius: 5px; }
        .box-title { font-weight: bold; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin-bottom: 10px; margin-top: 0; }
        table { border-collapse: collapse; margin-bottom: 30px; width: 100%; }
        th, td { padding: 10px; border-bottom: 1px solid #ddd; text-align: left; }
        th { background-color: #f5f5f5; }
        .total-row td { font-weight: bold; font-size: 16px; border-top: 2px solid #333; }
        .footer { margin-top: 50px; text-align: center; font-size: 12px; color: #777; border-top: 1px solid #ddd; padding-top: 20px; }
        @media print {
            body { padding: 0; }
            .no-print { display: none; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print" style="margin-bottom: 20px;">
        <button onclick="window.print()" style="padding: 10px 20px; background: #333; color: white; border: none; cursor: pointer;">Print</button>
        <button onclick="window.close()" style="padding: 10px 20px; background: #ddd; color: #333; border: none; cursor: pointer;">Close</button>
    </div>

    <div class="header">
        <div class="logo">LAB SYSTEM</div>
        <div class="title">Booking Receipt</div>
    </div>

    <div class="details-grid">
        <div class="box">
            <h3 class="box-title">Booking Information</h3>
            <p><strong>Reference #:</strong> {{ $booking->booking_reference }}</p>
            <p><strong>Date:</strong> {{ $booking->booking_date->format('d M, Y') }}</p>
            <p><strong>Time Slot:</strong> {{ $booking->display_slot }}</p>
            <p><strong>Status:</strong> {{ $booking->status }}</p>
            <p><strong>Collection Type:</strong> {{ $booking->collection_type }}</p>
            @if($booking->agent)
            <p><strong>Field Agent:</strong> {{ $booking->agent->name }} ({{ $booking->agent->phone }})</p>
            @endif
        </div>
        <div class="box">
            <h3 class="box-title">Patient Information</h3>
            <p><strong>Name:</strong> {{ $booking->patient->name ?? 'N/A' }}</p>
            @if($booking->familyMember)
            <p><strong>Family Member:</strong> {{ $booking->familyMember->name }} ({{ $booking->familyMember->relation }})</p>
            @endif
            @if($booking->address)
            <p><strong>Address:</strong><br>
            {{ $booking->address->full_address }}, {{ $booking->address->city }}</p>
            @endif
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Item / Test Name</th>
                <th style="text-align: right;">Amount</th>
            </tr>
        </thead>
        <tbody>
            @foreach($booking->test_details as $test)
            <tr>
                <td>{{ $test['name'] ?? 'Test' }}</td>
                <td style="text-align: right;">₹{{ isset($test['price']) ? number_format($test['price'], 2) : '0.00' }}</td>
            </tr>
            @endforeach
            @if($booking->coins_discount > 0)
            <tr>
                <td style="text-align: right; color: #b45309;">Health Coins Redeemed ({{ $booking->coins_redeemed }} 🪙)</td>
                <td style="text-align: right; color: #b45309;">-₹{{ number_format($booking->coins_discount, 2) }}</td>
            </tr>
            @endif
            @if($booking->discount_amount > ($booking->coins_discount ?? 0))
            <tr>
                <td style="text-align: right; color: #15803d;">Promo / VIP Discount</td>
                <td style="text-align: right; color: #15803d;">-₹{{ number_format($booking->discount_amount - ($booking->coins_discount ?? 0), 2) }}</td>
            </tr>
            @endif
            <tr class="total-row">
                <td style="text-align: right;">Final Paid / Payable ({{ $booking->payment_status }})</td>
                <td style="text-align: right;">₹{{ number_format($booking->amount, 2) }}</td>
            </tr>
        </tbody>
    </table>
    
    <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
        <p><strong>Payment Method:</strong> {{ $booking->payment_method }}</p>
        @if($booking->coins_earned > 0)
        <p style="color: #b45309; font-weight: bold;">🪙 Health Coins Earned on this order: +{{ $booking->coins_earned }} Coins</p>
        @endif
    </div>

    <div class="footer">
        <p>Thank you for choosing our lab services.</p>
        <p>This is a computer generated document and does not require signature.</p>
    </div>
</body>
</html>
