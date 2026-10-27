<?php

namespace Tests\Feature;

use App\Models\Agent;
use App\Models\Booking;
use App\Models\Package;
use App\Models\Patient;
use App\Models\Test;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class AdminBookingTestsModificationTest extends TestCase
{
    use DatabaseTransactions;

    protected User $adminUser;

    protected Patient $patient;

    protected Test $test1;

    protected Test $test2;

    protected Package $package1;

    protected function setUp(): void
    {
        parent::setUp();

        $this->adminUser = User::first() ?? User::factory()->create();

        $this->patient = Patient::first() ?? Patient::create([
            'name' => 'Test Patient',
            'mobile' => '91'.rand(10000000, 99999999),
            'email' => 'testpatient@example.com',
            'gender' => 'male',
            'age' => 28,
        ]);

        $this->test1 = Test::where('is_active', true)->first() ?? Test::create([
            'name' => 'Complete Blood Count (CBC)',
            'price' => 350,
            'is_active' => true,
            'sample_type' => 'Blood',
        ]);

        $this->test2 = Test::where('is_active', true)->where('id', '!=', $this->test1->id)->first() ?? Test::create([
            'name' => 'Thyroid Profile',
            'price' => 450,
            'is_active' => true,
            'sample_type' => 'Blood',
        ]);

        $this->package1 = Package::where('is_active', true)->first() ?? Package::create([
            'name' => 'Full Body Health Package',
            'price' => 899,
            'is_active' => true,
        ]);
    }

    public function test_admin_booking_show_page_includes_tests_and_catalog(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'BK-'.strtoupper(bin2hex(random_bytes(3))),
            'patient_id' => $this->patient->id,
            'collection_type' => 'Home Collection',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'booking_date' => now()->addDay(),
            'amount' => 350,
            'collection_fee' => 100,
            'status' => 'Pending',
            'payment_status' => 'Pending',
            'payment_method' => 'Cash',
            'test_details' => [
                [
                    'id' => $this->test1->id,
                    'name' => $this->test1->name,
                    'title' => $this->test1->name,
                    'type' => 'test',
                    'price' => 350,
                ],
            ],
        ]);

        $response = $this->actingAs($this->adminUser)->get(route('admin.bookings.show', $booking->id));

        $response->assertStatus(200);
        $response->assertViewHas('allTests');
        $response->assertViewHas('allPackages');
        $response->assertSee('Manage / Add Tests');
        $response->assertSee('Complete Blood Count');
    }

    public function test_admin_can_add_and_remove_tests_from_booking(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'BK-'.strtoupper(bin2hex(random_bytes(3))),
            'patient_id' => $this->patient->id,
            'collection_type' => 'Home Collection',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'booking_date' => now()->addDay(),
            'amount' => 350,
            'collection_fee' => 100,
            'status' => 'Pending',
            'payment_status' => 'Pending',
            'payment_method' => 'Cash',
            'test_details' => [
                [
                    'id' => $this->test1->id,
                    'name' => $this->test1->name,
                    'title' => $this->test1->name,
                    'type' => 'test',
                    'price' => 350,
                ],
            ],
        ]);

        // Replace test1 with test2 + package1
        $newTests = [
            [
                'id' => $this->test2->id,
                'type' => 'test',
                'price' => (float) $this->test2->price,
            ],
            [
                'id' => $this->package1->id,
                'type' => 'package',
                'price' => (float) $this->package1->price,
            ],
        ];

        $response = $this->actingAs($this->adminUser)
            ->from(route('admin.bookings.show', $booking->id))
            ->post(route('admin.bookings.updateTests', $booking->id), [
                'tests' => json_encode($newTests),
                'collection_fee' => 0,
                'payment_status' => 'Pending',
            ]);

        $response->assertRedirect(route('admin.bookings.show', $booking->id));
        $response->assertSessionHas('success');

        $booking->refresh();

        $this->assertCount(2, $booking->test_details);
        $testIds = collect($booking->test_details)->pluck('id')->all();
        $this->assertContains($this->test2->id, $testIds);
        $this->assertContains($this->package1->id, $testIds);
        $this->assertNotContains($this->test1->id, $testIds);

        // Expected subtotal = test2 price + package1 price
        $expectedSubtotal = (float) $this->test2->price + (float) $this->package1->price;
        $this->assertEquals(0, $booking->collection_fee);
        $this->assertEquals($expectedSubtotal, $booking->amount);
    }

    public function test_admin_can_update_booking_with_custom_item_price_and_payment_status(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'BK-'.strtoupper(bin2hex(random_bytes(3))),
            'patient_id' => $this->patient->id,
            'collection_type' => 'Home Collection',
            'booking_date' => now()->addDay(),
            'amount' => 500,
            'collection_fee' => 0,
            'status' => 'Pending',
            'payment_status' => 'Paid',
            'payment_method' => 'Online',
            'test_details' => [
                [
                    'id' => $this->test1->id,
                    'name' => $this->test1->name,
                    'title' => $this->test1->name,
                    'type' => 'test',
                    'price' => 500,
                ],
            ],
        ]);

        // Add test2 with custom negotiated price 300, set status to Partial Cash
        $newTests = [
            [
                'id' => $this->test1->id,
                'type' => 'test',
                'price' => 500,
            ],
            [
                'id' => $this->test2->id,
                'type' => 'test',
                'price' => 300,
            ],
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.bookings.updateTests', $booking->id), [
                'tests' => json_encode($newTests),
                'amount' => 800,
                'payment_status' => 'Partial Online / Cash on Collection',
            ]);

        $response->assertSessionHas('success');

        $booking->refresh();
        $this->assertCount(2, $booking->test_details);
        $this->assertEquals(800, $booking->amount);
        $this->assertEquals(500, $booking->paid_amount);
        $this->assertEquals(300, $booking->due_amount);
        $this->assertEquals('Partial Online / Cash on Collection', $booking->payment_status);
    }

    public function test_modifying_paid_booking_sets_correct_due_amount_for_new_tests_only(): void
    {
        // 1. Create a fully paid booking of 350
        $agent = Agent::first() ?? Agent::create([
            'name' => 'Field Phlebo',
            'phone' => '9876543210',
            'email' => 'phlebo'.rand(100, 999).'@example.com',
            'is_active' => true,
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-'.strtoupper(bin2hex(random_bytes(3))),
            'patient_id' => $this->patient->id,
            'agent_id' => $agent->id,
            'collection_type' => 'Home Collection',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'booking_date' => now()->addDay(),
            'amount' => 350,
            'paid_amount' => 350,
            'collection_fee' => 0,
            'status' => 'Confirmed',
            'payment_status' => 'Paid',
            'payment_method' => 'Online',
            'test_details' => [
                [
                    'id' => $this->test1->id,
                    'name' => $this->test1->name,
                    'title' => $this->test1->name,
                    'type' => 'test',
                    'price' => 350,
                ],
            ],
        ]);

        $this->assertEquals(0, $booking->due_amount);

        // 2. Admin adds test2 (price 450). Total becomes 800.
        $testsPayload = [
            [
                'id' => $this->test1->id,
                'type' => 'test',
                'price' => 350,
            ],
            [
                'id' => $this->test2->id,
                'type' => 'test',
                'price' => 450,
            ],
        ];

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.bookings.updateTests', $booking->id), [
                'tests' => json_encode($testsPayload),
                'amount' => 800,
            ]);

        $response->assertSessionHas('success');

        $booking->refresh();
        // Total bill is 800, already paid is 350, remaining due to be collected is ONLY 450!
        $this->assertEquals(800, $booking->amount);
        $this->assertEquals(350, $booking->paid_amount);
        $this->assertEquals(450, $booking->due_amount);
        $this->assertEquals('Partial Online / Cash on Collection', $booking->payment_status);

        // 3. Admin show page shows exactly 450 Cash Due
        $showResponse = $this->actingAs($this->adminUser)->get(route('admin.bookings.show', $booking->id));
        $showResponse->assertStatus(200);
        $showResponse->assertSee('₹450 Cash Due');
        $showResponse->assertSee('₹350 already paid');

        // 4. Agent visits dashboard and sees CASH DUE: ₹450 (not ₹800!)
        $agentResponse = $this->withSession(['agent_id' => $agent->id])->get(route('agent.dashboard'));
        $agentResponse->assertStatus(200);
        $agentResponse->assertSee('CASH DUE: ₹450');
        $agentResponse->assertSee('Collect Cash ₹450');

        // 5. Agent collects the remaining ₹450 cash
        $collectResponse = $this->withSession(['agent_id' => $agent->id])
            ->post(route('agent.collect_money', $booking->id), ['payment_mode' => 'Cash']);
        $collectResponse->assertSessionHas('success');

        $booking->refresh();
        $this->assertEquals('Paid', $booking->payment_status);
        $this->assertEquals(800, $booking->paid_amount);
        $this->assertEquals(0, $booking->due_amount);
    }

    public function test_admin_cannot_save_empty_tests_list(): void
    {
        $booking = Booking::create([
            'booking_reference' => 'BK-'.strtoupper(bin2hex(random_bytes(3))),
            'patient_id' => $this->patient->id,
            'collection_type' => 'Home Collection',
            'booking_date' => now()->addDay(),
            'amount' => 350,
            'collection_fee' => 100,
            'status' => 'Pending',
            'payment_status' => 'Pending',
            'payment_method' => 'Cash',
            'test_details' => [
                [
                    'id' => $this->test1->id,
                    'name' => $this->test1->name,
                    'type' => 'test',
                    'price' => 350,
                ],
            ],
        ]);

        $response = $this->actingAs($this->adminUser)
            ->post(route('admin.bookings.updateTests', $booking->id), [
                'tests' => json_encode([]),
            ]);

        $response->assertSessionHas('error');

        $booking->refresh();
        $this->assertCount(1, $booking->test_details);
    }
}
