<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Booking;
use App\Models\City;
use App\Models\NotificationLog;
use App\Models\Patient;
use App\Models\Setting;
use App\Models\Test;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class DuplicateBookingPreventionTest extends TestCase
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

        Setting::set('collection_fee_enabled', '1', 'service');
        Setting::set('home_collection_fee', '100', 'service');
        Setting::set('free_collection_threshold', '500', 'service');

        $randMobile = '91'.rand(10000000, 99999999);
        $this->patient = Patient::create([
            'name' => 'Amit Kumar',
            'mobile' => $randMobile,
            'email' => 'amit_'.$randMobile.'@example.com',
            'age' => 32,
            'gender' => 'Male',
        ]);

        $this->address = Address::create([
            'patient_id' => $this->patient->id,
            'title' => 'Home',
            'full_address' => 'House 12, Kankarbagh, Patna',
            'pincode' => '800001',
        ]);

        $this->testItem = Test::create([
            'name' => 'CBC Test',
            'code' => 'CBC-DUP-'.rand(100, 999),
            'price' => 300,
            'sample_type' => 'Blood',
            'is_active' => true,
        ]);
    }

    public function test_duplicate_place_booking_within_30_seconds_returns_existing_booking(): void
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

        // First booking call
        $response1 = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $payload);

        $response1->assertOk();
        $this->assertTrue($response1->json('success'));
        $bookingId1 = $response1->json('booking_id');

        // Verify exactly 1 booking exists in DB
        $this->assertEquals(1, Booking::where('patient_id', $this->patient->id)->count());

        // Second duplicate booking call immediately after
        $response2 = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $payload);

        $response2->assertOk();
        $this->assertTrue($response2->json('success'));
        $bookingId2 = $response2->json('booking_id');

        // Both calls should return the same booking id
        $this->assertEquals($bookingId1, $bookingId2);

        // Crucial check: still only 1 booking in database, not 2!
        $this->assertEquals(1, Booking::where('patient_id', $this->patient->id)->count());
    }

    public function test_switching_from_uncompleted_online_attempt_to_cash_cleans_up_ghost_booking(): void
    {
        // 1. Simulate an online order initialization that was abandoned
        $abandonedOnlineBooking = Booking::create([
            'booking_reference' => 'BK-'.strtoupper(substr(uniqid(), -6)),
            'patient_id' => $this->patient->id,
            'address_id' => $this->address->id,
            'test_details' => [['id' => $this->testItem->id, 'name' => 'CBC Test', 'type' => 'test', 'price' => 300]],
            'collection_type' => 'Home Collection',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'amount' => 400,
            'collection_fee' => 100,
            'payment_method' => 'Online',
            'payment_status' => 'Pending',
            'status' => 'Pending',
            'booking_date' => now()->addDay(),
        ]);

        $this->assertEquals(1, Booking::where('patient_id', $this->patient->id)->count());

        // 2. Patient switches to Cash and submits booking
        $cashPayload = [
            'cart' => [
                ['id' => $this->testItem->id, 'type' => 'test'],
            ],
            'collection_type' => 'Home Collection',
            'booking_date' => now()->addDay()->format('Y-m-d').' 08:00 AM',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'address_id' => $this->address->id,
            'payment_method' => 'Cash',
        ];

        $cashResponse = $this->withSession(['patient_id' => $this->patient->id])
            ->postJson(route('patient.place_booking'), $cashPayload);

        $cashResponse->assertOk();
        $this->assertTrue($cashResponse->json('success'));

        // The abandoned online booking must have been cleaned up, leaving ONLY the cash booking!
        $patientBookings = Booking::where('patient_id', $this->patient->id)->get();
        $this->assertCount(1, $patientBookings);
        $this->assertEquals('Cash', $patientBookings->first()->payment_method);
        $this->assertTrue(in_array($patientBookings->first()->status, ['Booked', 'Confirmed']));
    }

    public function test_patient_notification_feed_does_not_leak_email_sms_whatsapp_audit_logs(): void
    {
        // Simulate delivery logs for email, sms, and whatsapp
        NotificationLog::create([
            'notifiable_type' => Patient::class,
            'notifiable_id' => $this->patient->id,
            'channel' => 'email',
            'event' => 'booking_confirmed',
            'recipient_name' => $this->patient->name,
            'recipient_contact' => $this->patient->email,
            'status' => 'sent',
        ]);
        NotificationLog::create([
            'notifiable_type' => Patient::class,
            'notifiable_id' => $this->patient->id,
            'channel' => 'sms',
            'event' => 'booking_confirmed',
            'recipient_name' => $this->patient->name,
            'recipient_contact' => $this->patient->mobile,
            'status' => 'skipped',
        ]);
        NotificationLog::create([
            'notifiable_type' => Patient::class,
            'notifiable_id' => $this->patient->id,
            'channel' => 'whatsapp',
            'event' => 'booking_confirmed',
            'recipient_name' => $this->patient->name,
            'recipient_contact' => $this->patient->mobile,
            'status' => 'skipped',
        ]);

        // Simulate 1 proper in-app notification
        NotificationLog::create([
            'notifiable_type' => Patient::class,
            'notifiable_id' => $this->patient->id,
            'channel' => 'in_app',
            'event' => 'booking_placed',
            'recipient_name' => $this->patient->name,
            'subject' => 'Booking #BK-TEST Placed',
            'body' => 'Your test has been scheduled.',
            'status' => 'sent',
        ]);

        // Call notification feed endpoint
        $response = $this->withSession(['patient_id' => $this->patient->id])
            ->getJson(route('patient.notifications.unreadFeed'));

        $response->assertOk();
        $feed = $response->json('notifications');

        // Crucial Assertion: feed must ONLY contain the 1 in_app notification, NOT 4!
        $this->assertCount(1, $feed);
        $this->assertEquals('Booking #BK-TEST Placed', $feed[0]['title']);
    }
}
