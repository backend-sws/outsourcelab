<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Booking;
use App\Models\City;
use App\Models\Patient;
use App\Models\RewardTransaction;
use App\Models\Setting;
use App\Models\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class RewardCoinsEarningRuleTest extends TestCase
{
    use DatabaseTransactions;

    protected Patient $patient;

    protected Address $address;

    protected Test $testItem;

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

        Setting::set('reward_enabled', '1', 'reward');
        Setting::set('reward_coin_value', '1.00', 'reward');
        Setting::set('reward_earn_type', 'percentage', 'reward');
        Setting::set('reward_earn_value', '10', 'reward'); // 10% earned
        Setting::set('reward_min_order_to_earn', '100', 'reward');

        $randMobile = '91'.rand(10000000, 99999999);
        $this->patient = Patient::create([
            'name' => 'Kavita Singh',
            'mobile' => $randMobile,
            'email' => 'kavita_'.$randMobile.'@example.com',
            'age' => 29,
            'gender' => 'Female',
            'reward_coins' => 0,
        ]);

        $this->address = Address::create([
            'patient_id' => $this->patient->id,
            'title' => 'Home',
            'full_address' => 'Flat 401, Bailey Road, Patna',
            'pincode' => '800001',
        ]);

        $this->testItem = Test::create([
            'name' => 'Thyroid Profile',
            'code' => 'THY-COIN-'.rand(100, 999),
            'price' => 500,
            'sample_type' => 'Blood',
            'is_active' => true,
        ]);
    }

    public function test_coins_are_not_awarded_at_booking_placement(): void
    {
        $payload = [
            'cart' => [
                ['id' => $this->testItem->id, 'type' => 'test'],
            ],
            'collection_type' => 'Home Collection',
            'booking_date' => now()->addDay()->format('Y-m-d').' 08:00 AM',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'address_id' => $this->address->id,
            'payment_method' => 'Cash',
        ];

        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $payload);

        $response->assertOk();
        $this->assertTrue($response->json('success'));
        $bookingId = $response->json('booking_id');

        $booking = Booking::findOrFail($bookingId);

        // coins_earned should be calculated (10% on total order amount)
        $this->assertEquals(60, $booking->coins_earned);

        // CRITICAL ASSERTION: Patient balance must STILL be 0!
        $this->patient->refresh();
        $this->assertEquals(0, $this->patient->reward_coins);

        // No credit transaction must exist
        $creditTxCount = RewardTransaction::where('booking_id', $bookingId)
            ->where('type', 'credit')
            ->count();
        $this->assertEquals(0, $creditTxCount);
    }

    public function test_coins_only_awarded_when_both_completed_and_paid(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'BK-COIN-'.rand(1000, 9999),
            'patient_id' => $this->patient->id,
            'address_id' => $this->address->id,
            'test_details' => [['id' => $this->testItem->id, 'name' => 'Thyroid', 'type' => 'test', 'price' => 500]],
            'collection_type' => 'Home Collection',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'amount' => 500,
            'coins_earned' => 50,
            'payment_method' => 'Cash',
            'payment_status' => 'Pending',
            'status' => 'Booked',
            'booking_date' => now()->addDay(),
        ]);

        // Scenario 1: Marked as Sample Collected -> No coins
        $booking->update(['status' => 'Sample Collected']);
        $this->assertEquals(0, $this->patient->fresh()->reward_coins);

        // Scenario 2: Marked as Report Ready -> No coins
        $booking->update(['status' => 'Report Ready']);
        $this->assertEquals(0, $this->patient->fresh()->reward_coins);

        // Scenario 3: Marked as Completed BUT payment still Pending -> No coins!
        $booking->update(['status' => 'Completed']);
        $this->assertEquals(0, $this->patient->fresh()->reward_coins);

        // Scenario 4: Payment collected and marked as Paid -> BOTH COMPLETED & PAID!
        $booking->update(['payment_status' => 'Paid']);

        // Coins must now be credited!
        $this->assertEquals(50, $this->patient->fresh()->reward_coins);

        // Exactly 1 credit transaction logged
        $this->assertEquals(1, RewardTransaction::where('booking_id', $booking->id)->where('type', 'credit')->count());

        // Scenario 5: Subsequent save does not duplicate credit
        $booking->update(['money_collected_at' => now()]);
        $this->assertEquals(50, $this->patient->fresh()->reward_coins);
        $this->assertEquals(1, RewardTransaction::where('booking_id', $booking->id)->where('type', 'credit')->count());
    }
}
