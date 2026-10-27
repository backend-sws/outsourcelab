<?php

namespace Tests\Feature;

use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Patient;
use App\Models\PatientCoupon;
use App\Models\PaymentTransaction;
use App\Models\User;
use App\Services\RazorpayService;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery;
use Tests\TestCase;

class BookingCancellationAndRefundTest extends TestCase
{
    use DatabaseTransactions;

    protected User $adminUser;

    protected Patient $patient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::first() ?? User::factory()->create();

        $this->patient = Patient::create([
            'name' => 'Cancellation Test Patient',
            'mobile' => '91'.rand(10000000, 99999999),
            'email' => 'canceltest'.rand(100, 999).'@example.com',
            'gender' => 'female',
            'age' => 32,
            'reward_coins' => 100,
        ]);
    }

    public function test_patient_can_request_cancellation_with_valid_reason(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'TEST-CAN-01',
            'patient_id' => $this->patient->id,
            'booking_date' => now()->addDays(2),
            'collection_type' => 'Home Collection',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'amount' => 500.00,
            'paid_amount' => 500.00,
            'payment_method' => 'Online',
            'payment_status' => 'Paid',
            'status' => 'Booked',
            'sample_status' => 'Pending',
            'test_details' => [['id' => 1, 'name' => 'CBC', 'price' => 500]],
        ]);

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->post(route('patient.bookings.request_cancellation', $booking->id), [
                'reason' => 'Doctor modified or cancelled prescription',
                'notes' => 'Prescription was updated to a different scan.',
            ]);

        $response->assertSessionHas('success');

        $booking->refresh();
        $this->assertEquals('requested', $booking->cancellation_request_status);
        $this->assertStringContainsString('Doctor modified or cancelled prescription', $booking->cancellation_reason);
        $this->assertStringContainsString('Prescription was updated to a different scan', $booking->cancellation_reason);
        $this->assertNotNull($booking->cancellation_requested_at);
    }

    public function test_patient_cannot_request_cancellation_when_sample_collected_or_completed(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'TEST-CAN-02',
            'patient_id' => $this->patient->id,
            'booking_date' => now(),
            'collection_type' => 'Home Collection',
            'amount' => 500.00,
            'payment_method' => 'Cash',
            'status' => 'Processing',
            'sample_status' => 'Sample Collected',
            'test_details' => [['id' => 1, 'name' => 'CBC', 'price' => 500]],
        ]);

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->post(route('patient.bookings.request_cancellation', $booking->id), [
                'reason' => 'Want to cancel',
            ]);

        $response->assertSessionHas('error');

        $booking->refresh();
        $this->assertNull($booking->cancellation_request_status);
    }

    public function test_patient_cannot_double_request_cancellation_if_already_pending(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'TEST-CAN-03',
            'patient_id' => $this->patient->id,
            'booking_date' => now()->addDay(),
            'collection_type' => 'Home Collection',
            'amount' => 600.00,
            'payment_method' => 'Cash',
            'status' => 'Booked',
            'cancellation_request_status' => 'requested',
            'cancellation_reason' => 'Initial reason',
            'cancellation_requested_at' => now()->subMinutes(10),
            'test_details' => [['id' => 1, 'name' => 'CBC', 'price' => 600]],
        ]);

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->post(route('patient.bookings.request_cancellation', $booking->id), [
                'reason' => 'Second attempt',
            ]);

        $response->assertSessionHas('error');

        $booking->refresh();
        $this->assertEquals('Initial reason', $booking->cancellation_reason);
    }

    public function test_admin_can_approve_cancellation_with_auto_razorpay_refund_and_coins_restoration(): void
    {
        // Setup coupon
        $coupon = Coupon::create([
            'title' => 'Test 50 Off',
            'code' => 'TESTCANCEL50',
            'discount_type' => 'fixed',
            'discount_value' => 50,
            'usage_count' => 1,
            'is_active' => true,
        ]);

        PatientCoupon::create([
            'patient_id' => $this->patient->id,
            'coupon_id' => $coupon->id,
            'is_used' => true,
            'used_at' => now(),
        ]);

        $initialPatientCoins = $this->patient->reward_coins; // 100

        $booking = Booking::create([
            'booking_reference' => 'TEST-CAN-REFUND-01',
            'patient_id' => $this->patient->id,
            'booking_date' => now()->addDays(2),
            'collection_type' => 'Home Collection',
            'amount' => 750.00,
            'paid_amount' => 750.00,
            'payment_method' => 'Online',
            'payment_status' => 'Paid',
            'razorpay_payment_id' => 'pay_mock123456789',
            'status' => 'Booked',
            'cancellation_request_status' => 'requested',
            'cancellation_reason' => 'Personal emergency',
            'cancellation_requested_at' => now(),
            'coins_redeemed' => 50,
            'coins_discount' => 50.00,
            'coupon_code' => $coupon->code,
            'discount_amount' => 50.00,
            'test_details' => [['id' => 1, 'name' => 'Thyroid', 'price' => 850]],
        ]);

        PaymentTransaction::create([
            'transaction_reference' => 'TXN-'.rand(1000, 9999),
            'booking_id' => $booking->id,
            'patient_id' => $this->patient->id,
            'razorpay_payment_id' => 'pay_mock123456789',
            'amount' => 750.00,
            'status' => 'completed',
            'payment_method' => 'Online',
        ]);

        // Mock RazorpayService
        $mockRazorpay = Mockery::mock(RazorpayService::class);
        $mockRazorpay->shouldReceive('refundPayment')
            ->once()
            ->with(
                'pay_mock123456789',
                750.00,
                Mockery::type('array')
            )
            ->andReturn([
                'success' => true,
                'refund_id' => 'rfnd_mock_success_001',
                'amount' => 750.00,
                'status' => 'processed',
            ]);

        $this->app->instance(RazorpayService::class, $mockRazorpay);

        // Act as Admin
        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.bookings.cancellation.approve', $booking->id), [
                'admin_notes' => 'Cancellation verified by Dr. Admin. Full refund processed.',
                'auto_refund' => '1',
            ]);

        $response->assertSessionHas('success');

        $booking->refresh();
        $this->assertEquals('Cancelled', $booking->status);
        $this->assertEquals('approved', $booking->cancellation_request_status);
        $this->assertEquals('Cancellation verified by Dr. Admin. Full refund processed.', $booking->cancellation_admin_notes);
        $this->assertEquals('refunded', $booking->refund_status);
        $this->assertEquals(750.00, (float) $booking->refund_amount);
        $this->assertEquals('rfnd_mock_success_001', $booking->refund_id);
        $this->assertNotNull($booking->refunded_at);

        // Assert payment transaction marked refunded
        $this->assertDatabaseHas('payment_transactions', [
            'booking_id' => $booking->id,
            'razorpay_payment_id' => 'pay_mock123456789',
            'status' => 'refunded',
        ]);

        // Assert coins were restored to patient
        $this->patient->refresh();
        $this->assertEquals($initialPatientCoins + 50, $this->patient->reward_coins);

        // Assert coupon usage was decremented
        $coupon->refresh();
        $this->assertEquals(0, $coupon->usage_count);

        // Assert PatientCoupon record was deleted
        $this->assertDatabaseMissing('patient_coupons', [
            'patient_id' => $this->patient->id,
            'coupon_id' => $coupon->id,
        ]);
    }

    public function test_admin_can_reject_cancellation_with_reason(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'TEST-CAN-REJ-01',
            'patient_id' => $this->patient->id,
            'booking_date' => now(),
            'collection_type' => 'Home Collection',
            'amount' => 450.00,
            'payment_method' => 'Cash',
            'status' => 'Confirmed',
            'cancellation_request_status' => 'requested',
            'cancellation_reason' => 'Changed mind',
            'cancellation_requested_at' => now(),
            'test_details' => [['id' => 1, 'name' => 'CBC', 'price' => 450]],
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.bookings.cancellation.reject', $booking->id), [
                'rejection_reason' => 'Phlebotomist has already dispatched with fresh sterile vials.',
            ]);

        $response->assertSessionHas('success');

        $booking->refresh();
        $this->assertEquals('Confirmed', $booking->status); // Status preserved
        $this->assertEquals('rejected', $booking->cancellation_request_status);
        $this->assertEquals('Phlebotomist has already dispatched with fresh sterile vials.', $booking->cancellation_admin_notes);
        $this->assertNotNull($booking->cancellation_processed_at);
    }
}
