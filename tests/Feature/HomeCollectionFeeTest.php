<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Booking;
use App\Models\City;
use App\Models\MembershipPlan;
use App\Models\Patient;
use App\Models\PatientMembership;
use App\Models\Setting;
use App\Models\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class HomeCollectionFeeTest extends TestCase
{
    use DatabaseTransactions;

    protected Patient $patient;

    protected Address $address;

    protected Test $cheapTest;

    protected Test $expensiveTest;

    protected function setUp(): void
    {
        parent::setUp();

        City::firstOrCreate(
            ['name' => 'Patna'],
            [
                'state' => 'Bihar',
                'serviceable_pincodes' => ['800001', '800014'],
                'is_active' => true,
                'is_default' => true,
            ]
        );

        Setting::set('collection_fee_enabled', '1', 'service');
        Setting::set('home_collection_fee', '100', 'service');
        Setting::set('free_collection_threshold', '500', 'service');

        $randMobile = '91'.rand(10000000, 99999999);
        $this->patient = Patient::create([
            'name' => 'Rahul Sharma',
            'mobile' => $randMobile,
            'email' => 'rahul_'.$randMobile.'@example.com',
            'age' => 28,
            'gender' => 'Male',
        ]);

        $this->address = Address::create([
            'patient_id' => $this->patient->id,
            'title' => 'Home',
            'full_address' => 'Flat 202, Shivalik Residency, Patna',
            'pincode' => '800001',
        ]);

        $this->cheapTest = Test::create([
            'name' => 'Random Blood Sugar (RBS)',
            'price' => 150,
            'mrp' => 250,
            'is_active' => true,
        ]);

        $this->expensiveTest = Test::create([
            'name' => 'Complete Blood Count (CBC) with ESR',
            'price' => 650,
            'mrp' => 900,
            'is_active' => true,
        ]);
    }

    public function test_under_threshold_home_collection_incurs_collection_fee(): void
    {
        $payload = [
            'cart' => [
                ['id' => $this->cheapTest->id, 'type' => 'test'],
            ],
            'collection_type' => 'Home Collection',
            'payment_method' => 'Cash',
            'booking_date' => now()->addDay()->toDateString().' 08:00:00',
            'collection_slot' => '07:00 AM - 08:00 AM',
            'address_id' => $this->address->id,
        ];

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'final_amount' => 250, // 150 (test) + 100 (fee)
            'collection_fee' => 100,
        ]);

        $booking = Booking::find($response->json('booking_id'));
        $this->assertNotNull($booking);
        $this->assertEquals(250, $booking->amount);
        $this->assertEquals(100, $booking->collection_fee);
    }

    public function test_above_threshold_home_collection_gets_free_collection(): void
    {
        $payload = [
            'cart' => [
                ['id' => $this->expensiveTest->id, 'type' => 'test'],
            ],
            'collection_type' => 'Home Collection',
            'payment_method' => 'Cash',
            'booking_date' => now()->addDay()->toDateString().' 08:00:00',
            'collection_slot' => '07:00 AM - 08:00 AM',
            'address_id' => $this->address->id,
        ];

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'final_amount' => 650, // 650 test (no collection fee because >= 500)
            'collection_fee' => 0,
        ]);

        $booking = Booking::find($response->json('booking_id'));
        $this->assertNotNull($booking);
        $this->assertEquals(650, $booking->amount);
        $this->assertEquals(0, $booking->collection_fee);
    }

    public function test_vip_member_gets_free_home_collection_regardless_of_order_value(): void
    {
        $plan = MembershipPlan::create([
            'name' => 'Gold VIP Pass',
            'price' => 499,
            'discount_percentage' => 10,
            'duration_in_months' => 12,
            'is_active' => true,
        ]);

        PatientMembership::create([
            'patient_id' => $this->patient->id,
            'membership_plan_id' => $plan->id,
            'plan_name_snapshot' => $plan->name,
            'discount_percentage' => $plan->discount_percentage,
            'price_paid' => $plan->price,
            'started_at' => now()->subDay(),
            'expires_at' => now()->addMonths(12),
            'status' => 'active',
        ]);

        $payload = [
            'cart' => [
                ['id' => $this->cheapTest->id, 'type' => 'test'], // ₹150 test
            ],
            'collection_type' => 'Home Collection',
            'payment_method' => 'Cash',
            'booking_date' => now()->addDay()->toDateString().' 08:00:00',
            'collection_slot' => '07:00 AM - 08:00 AM',
            'address_id' => $this->address->id,
        ];

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $payload);

        $response->assertStatus(200);
        // 150 - 10% (15) = 135, collection fee = 0
        $response->assertJson([
            'success' => true,
            'final_amount' => 135,
            'collection_fee' => 0,
        ]);

        $booking = Booking::find($response->json('booking_id'));
        $this->assertEquals(135, $booking->amount);
        $this->assertEquals(0, $booking->collection_fee);
    }

    public function test_lab_walkin_is_never_charged_collection_fee(): void
    {
        $payload = [
            'cart' => [
                ['id' => $this->cheapTest->id, 'type' => 'test'], // ₹150 test
            ],
            'collection_type' => 'Lab Walk-in',
            'payment_method' => 'Cash',
            'booking_date' => now()->addDay()->toDateString().' 08:00:00',
            'collection_slot' => '07:00 AM - 08:00 AM',
            'address_id' => $this->address->id,
        ];

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $payload);

        $response->assertStatus(200);
        $response->assertJson([
            'success' => true,
            'final_amount' => 150,
            'collection_fee' => 0,
        ]);

        $booking = Booking::find($response->json('booking_id'));
        $this->assertEquals(150, $booking->amount);
        $this->assertEquals(0, $booking->collection_fee);
    }
}
