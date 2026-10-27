<?php

namespace Tests\Feature;

use App\Models\Address;
use App\Models\Agent;
use App\Models\Booking;
use App\Models\Patient;
use App\Models\User;
use App\Services\AutoAssignPhlebotomistService;
use Tests\TestCase;

class AgentDeactivationTest extends TestCase
{
    public function test_admin_can_toggle_agent_status(): void
    {
        $admin = User::first() ?? User::factory()->create();
        $agent = Agent::create([
            'name' => 'Toggle Agent '.rand(100, 999),
            'email' => 'toggle'.rand(100, 999).'@example.com',
            'phone' => '9988'.rand(100000, 999999),
            'password' => bcrypt('password123'),
            'status' => 'active',
        ]);

        $this->assertEquals('active', $agent->status);

        // Deactivate agent
        $response = $this->actingAs($admin)->post(route('admin.agents.toggle_status', $agent->id));
        $response->assertSessionHas('success');
        $this->assertEquals('inactive', $agent->fresh()->status);

        // Reactivate agent
        $response = $this->actingAs($admin)->post(route('admin.agents.toggle_status', $agent->id));
        $response->assertSessionHas('success');
        $this->assertEquals('active', $agent->fresh()->status);

        $agent->delete();
    }

    public function test_deactivating_agent_unassigns_or_reassigns_active_bookings(): void
    {
        $admin = User::first() ?? User::factory()->create();

        // Agent to be deactivated
        $agentA = Agent::create([
            'name' => 'Agent A '.rand(100, 999),
            'email' => 'agentA'.rand(100, 999).'@example.com',
            'phone' => '9988'.rand(100000, 999999),
            'password' => bcrypt('password123'),
            'status' => 'active',
            'serviceable_pincodes' => '800099',
        ]);

        $patient = Patient::first() ?? Patient::create([
            'name' => 'Test Patient',
            'mobile' => '9876543210',
            'email' => 'patient@test.com',
        ]);

        $address = Address::create([
            'patient_id' => $patient->id,
            'title' => 'Home',
            'full_address' => 'Sample road',
            'pincode' => '800099',
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-DEACT-'.rand(1000, 9999),
            'patient_id' => $patient->id,
            'address_id' => $address->id,
            'agent_id' => $agentA->id,
            'test_details' => [['id' => 1, 'name' => 'CBC Test', 'type' => 'test', 'price' => 500]],
            'collection_type' => 'Home Collection',
            'collection_slot' => '08:00 AM - 09:00 AM',
            'booking_date' => now()->addDays(2)->format('Y-m-d'),
            'amount' => 500,
            'payment_method' => 'Cash',
            'status' => 'Confirmed',
            'sample_status' => 'Assigned',
        ]);

        $this->assertEquals($agentA->id, $booking->fresh()->agent_id);

        // Deactivate agentA
        $response = $this->actingAs($admin)->post(route('admin.agents.toggle_status', $agentA->id));
        $response->assertSessionHas('success');

        $this->assertEquals('inactive', $agentA->fresh()->status);
        // Booking should NO LONGER be assigned to inactive agentA
        $freshBooking = $booking->fresh();
        $this->assertNotEquals($agentA->id, $freshBooking->agent_id);

        // Clean up
        $booking->delete();
        $address->delete();
        $agentA->delete();
    }

    public function test_deactivated_agent_cannot_login_or_access_dashboard(): void
    {
        $agent = Agent::create([
            'name' => 'Inactive Agent '.rand(100, 999),
            'email' => 'inactive'.rand(100, 999).'@example.com',
            'phone' => '9977'.rand(100000, 999999),
            'password' => bcrypt('secret123'),
            'status' => 'inactive',
        ]);

        // Attempt login via agent portal
        $response = $this->post(route('agent.login.submit'), [
            'email' => $agent->email,
            'password' => 'secret123',
        ]);

        $response->assertSessionHas('error');
        $this->assertNull(session('agent_id'));

        // If session was somehow pre-set, dashboard must reject and clear session
        $dashResponse = $this->withSession(['agent_id' => $agent->id])->get(route('agent.dashboard'));
        $dashResponse->assertRedirect(route('agent.login'));
        $this->assertNull(session('agent_id'));

        $agent->delete();
    }

    public function test_admin_cannot_manually_assign_inactive_agent(): void
    {
        $admin = User::first() ?? User::factory()->create();

        $inactiveAgent = Agent::create([
            'name' => 'Inactive Agent '.rand(100, 999),
            'email' => 'inactive2'.rand(100, 999).'@example.com',
            'phone' => '9966'.rand(100000, 999999),
            'password' => bcrypt('secret123'),
            'status' => 'inactive',
        ]);

        $patient = Patient::first() ?? Patient::create([
            'name' => 'Test Patient',
            'mobile' => '9876543210',
            'email' => 'patient@test.com',
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-TEST-MAN-'.rand(1000, 9999),
            'patient_id' => $patient->id,
            'test_details' => [['id' => 1, 'name' => 'CBC Test', 'type' => 'test', 'price' => 300]],
            'collection_type' => 'Home Collection',
            'booking_date' => now()->format('Y-m-d'),
            'amount' => 300,
            'payment_method' => 'Cash',
            'status' => 'Booked',
            'sample_status' => 'Pending',
        ]);

        $response = $this->actingAs($admin)->post(route('admin.bookings.assign_agent', $booking->id), [
            'agent_id' => $inactiveAgent->id,
        ]);

        $response->assertSessionHasErrors('agent_id');
        $this->assertNull($booking->fresh()->agent_id);

        $booking->delete();
        $inactiveAgent->delete();
    }

    public function test_auto_assign_service_never_assigns_inactive_agent(): void
    {
        $targetDate = now()->addDays(4)->format('Y-m-d');
        $slotTitle = '07:00 AM - 08:00 AM';
        $pincode = '800088';

        $inactiveAgent = Agent::create([
            'name' => 'Exclusive Pin Inactive Agent '.rand(100, 999),
            'email' => 'pin'.rand(100, 999).'@example.com',
            'phone' => '9955'.rand(100000, 999999),
            'password' => bcrypt('secret123'),
            'status' => 'inactive',
            'serviceable_pincodes' => $pincode,
        ]);

        $patient = Patient::first() ?? Patient::create([
            'name' => 'Test Patient',
            'mobile' => '9876543210',
            'email' => 'patient@test.com',
        ]);

        $address = Address::create([
            'patient_id' => $patient->id,
            'title' => 'Home',
            'full_address' => 'Pincode specific road',
            'pincode' => $pincode,
        ]);

        $booking = Booking::create([
            'booking_reference' => 'BK-AUTO-PIN-'.rand(1000, 9999),
            'patient_id' => $patient->id,
            'address_id' => $address->id,
            'test_details' => [['id' => 1, 'name' => 'CBC Test', 'type' => 'test', 'price' => 400]],
            'collection_type' => 'Home Collection',
            'collection_slot' => $slotTitle,
            'booking_date' => $targetDate,
            'amount' => 400,
            'payment_method' => 'Cash',
            'status' => 'Booked',
            'sample_status' => 'Pending',
        ]);

        $service = app(AutoAssignPhlebotomistService::class);
        $assigned = $service->assign($booking);

        if ($assigned) {
            $this->assertNotEquals($inactiveAgent->id, $assigned->id);
            $this->assertEquals('active', $assigned->status);
        } else {
            $this->assertNull($booking->fresh()->agent_id);
        }

        $booking->delete();
        $address->delete();
        $inactiveAgent->delete();
    }
}
