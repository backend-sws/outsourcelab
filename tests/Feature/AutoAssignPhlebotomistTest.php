<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Agent;
use App\Models\AgentLeave;
use App\Models\Booking;
use App\Models\Patient;
use App\Services\AutoAssignPhlebotomistService;
use Tests\TestCase;

class AutoAssignPhlebotomistTest extends TestCase
{
    public function test_checkout_slots_availability_endpoint(): void
    {
        $response = $this->postJson(route('checkout.check_slots'), [
            'pincode' => '800001',
            'date' => now()->addDays(2)->format('Y-m-d'),
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'serviceable',
            'total_on_duty_phlebos',
            'slots' => [
                '*' => ['id', 'title', 'period', 'is_available', 'reason', 'remaining_capacity'],
            ],
        ]);
    }

    public function test_slot_becomes_unavailable_when_phlebotomist_is_on_leave(): void
    {
        $targetDate = now()->addDays(2)->format('Y-m-d');
        $slotTitle = '07:00 AM - 08:00 AM';

        $agent = Agent::where('status', 'active')->first() ?? Agent::create([
            'name' => 'Test Phlebo',
            'email' => 'phlebo@test.com',
            'phone' => '9998887776',
            'password' => bcrypt('password123'),
            'status' => 'active',
            'max_daily_capacity' => 15,
            'serviceable_pincodes' => '800001, 800002',
        ]);
        $agent->update(['serviceable_pincodes' => '800001, 800002']);

        $leave = AgentLeave::create([
            'agent_id' => $agent->id,
            'leave_date' => $targetDate,
            'slot_title' => $slotTitle,
            'leave_type' => 'slot_specific',
            'status' => 'approved',
            'reason' => 'Doctor appointment',
        ]);

        $service = app(AutoAssignPhlebotomistService::class);
        $result = $service->checkSlotAvailabilityForPincode('800001', $targetDate);

        $targetSlot = collect($result['slots'])->firstWhere('title', $slotTitle);
        $this->assertNotNull($targetSlot);
        $this->assertFalse($targetSlot['is_available']);
        $this->assertEquals('Phlebotomist off-duty in your area', $targetSlot['reason']);

        // Clean up test leave
        $leave->delete();
    }

    public function test_auto_assignment_assigns_on_duty_phlebotomist_covering_pincode(): void
    {
        $targetDate = now()->addDays(3)->format('Y-m-d');
        $slotTitle = '08:00 AM - 09:00 AM';

        $agent = Agent::where('status', 'active')->first() ?? Agent::create([
            'name' => 'Test Phlebo',
            'email' => 'phlebo@test.com',
            'phone' => '9998887776',
            'password' => bcrypt('password123'),
            'status' => 'active',
            'max_daily_capacity' => 15,
            'serviceable_pincodes' => '800001, 800002',
        ]);
        $agent->update(['serviceable_pincodes' => '800001, 800002']);

        $patient = Patient::first() ?? Patient::create([
            'name' => 'Test Patient',
            'mobile' => '9876543210',
            'email' => 'testpatient@example.com',
            'gender' => 'Male',
            'age' => 28,
        ]);

        $address = Address::create([
            'patient_id' => $patient->id,
            'title' => 'Home',
            'full_address' => 'Flat 101, Boring Road, Patna',
            'pincode' => '800001',
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-TEST-'.rand(1000, 9999),
            'patient_id' => $patient->id,
            'address_id' => $address->id,
            'test_details' => [['id' => 1, 'name' => 'CBC Test', 'type' => 'test', 'price' => 500]],
            'collection_type' => 'Home Collection',
            'collection_slot' => $slotTitle,
            'booking_date' => $targetDate,
            'amount' => 500,
            'payment_method' => 'Cash',
            'status' => 'Booked',
            'payment_status' => 'Pending',
        ]);

        $service = app(AutoAssignPhlebotomistService::class);
        $assigned = $service->assign($booking);

        $this->assertNotNull($assigned);
        $this->assertEquals($agent->id, $assigned->id);
        $this->assertEquals($agent->id, $booking->fresh()->agent_id);
        $this->assertEquals('Assigned', $booking->fresh()->sample_status);

        // Clean up
        $booking->delete();
        $address->delete();
    }
}
