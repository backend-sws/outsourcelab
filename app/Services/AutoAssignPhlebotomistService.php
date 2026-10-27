<?php

namespace App\Services;

use App\Models\Agent;
use App\Models\Booking;
use App\Models\CollectionSlot;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class AutoAssignPhlebotomistService
{
    /**
     * Auto-assign a suitable, on-duty phlebotomist to a booking based on area/pincode, date, and slot.
     */
    public function assign(Booking $booking): ?Agent
    {
        $address = $booking->address;
        $pincode = $address?->pincode ? trim((string) $address->pincode) : null;
        $bookingDate = $booking->booking_date;
        $dateYmd = $bookingDate ? $bookingDate->format('Y-m-d') : null;
        $slotTitle = $booking->collection_slot;

        if (! $pincode || ! $dateYmd) {
            Log::info("Auto-assignment skipped for Booking #{$booking->booking_reference}: Missing pincode or booking date.");

            return null;
        }

        // 1. Fetch active phlebotomists
        $activeAgents = Agent::where('status', 'active')->get();

        if ($activeAgents->isEmpty()) {
            Log::notice('Auto-assignment: No active phlebotomist found in system.');

            return null;
        }

        // 2. Filter candidates who cover this pincode (if any agent has explicit pincodes configured)
        $hasAnyExplicitPincodes = Agent::where('status', 'active')
            ->whereNotNull('serviceable_pincodes')
            ->where('serviceable_pincodes', '!=', '')
            ->exists();

        if ($hasAnyExplicitPincodes) {
            $directMatches = $activeAgents->filter(function (Agent $agent) use ($pincode) {
                return $agent->servesPincode($pincode);
            });

            if ($directMatches->isNotEmpty()) {
                $candidates = $directMatches;
            } else {
                // Fallback to active agents with no explicit pincodes or wildcard
                $fallbackAgents = $activeAgents->filter(function (Agent $agent) {
                    return empty($agent->serviceable_pincodes) || in_array('*', $agent->pincode_list, true);
                });
                $candidates = $fallbackAgents->isNotEmpty() ? $fallbackAgents : collect();
            }
        } else {
            $candidates = $activeAgents;
        }

        if ($candidates->isEmpty()) {
            Log::notice("Auto-assignment: No active phlebotomist covers pincode {$pincode} for booking #{$booking->booking_reference}.");

            return null;
        }

        // 3. Filter candidates who are NOT on leave on this date & slot
        $onDutyAgents = $candidates->filter(function (Agent $agent) use ($dateYmd, $slotTitle) {
            return ! $agent->isOnLeave($dateYmd, $slotTitle);
        });

        if ($onDutyAgents->isEmpty()) {
            Log::notice("Auto-assignment: All phlebotomists covering pincode {$pincode} are on leave / off-duty on {$dateYmd}.");

            return null;
        }

        // 4. Filter candidates who have capacity remaining for this slot
        $availableAgents = $onDutyAgents->filter(function (Agent $agent) use ($dateYmd, $slotTitle) {
            return empty($slotTitle) || $agent->hasRemainingCapacity($dateYmd, $slotTitle);
        });

        // If all candidate phlebos reached their max capacity, fallback to the on-duty phlebo with the least bookings
        $pool = $availableAgents->isNotEmpty() ? $availableAgents : $onDutyAgents;

        // 5. Pick phlebotomist with lowest active workload on that date (Load Balancing)
        $selectedAgent = $pool->sortBy(function (Agent $agent) use ($dateYmd, $slotTitle) {
            $query = Booking::where('agent_id', $agent->id)
                ->whereDate('booking_date', $dateYmd)
                ->whereNotIn('sample_status', ['Cancelled']);

            if (! empty($slotTitle)) {
                $query->where('collection_slot', $slotTitle);
            }

            return $query->count();
        })->first();

        if ($selectedAgent) {
            $booking->agent_id = $selectedAgent->id;

            if (empty($booking->sample_status) || in_array($booking->sample_status, ['Pending', 'Booked'])) {
                $booking->sample_status = 'Assigned';
            }
            if (in_array($booking->status, ['Pending', 'Booked'])) {
                $booking->status = 'Confirmed';
            }
            $booking->save();

            Log::info("Booking #{$booking->booking_reference} successfully auto-assigned to Phlebotomist {$selectedAgent->name} (ID: {$selectedAgent->id}, Pincode: {$pincode}, Slot: {$slotTitle}).");

            try {
                $booking->load(['patient', 'agent', 'address']);
                app(NotificationService::class)->bookingConfirmed($booking);
            } catch (\Throwable $e) {
                Log::warning('Booking auto-assignment notification failed: '.$e->getMessage());
            }

            return $selectedAgent;
        }

        return null;
    }

    /**
     * Check slot availability for a specific pincode and collection date.
     * Used dynamically on the checkout page to disable/hide slots if phlebos are on leave.
     *
     * @return array{
     *     serviceable: bool,
     *     message: string,
     *     total_on_duty_phlebos: int,
     *     slots: array<int, array<string, mixed>>
     * }
     */
    public function checkSlotAvailabilityForPincode(string $pincode, string $dateYmd): array
    {
        $cleanPin = trim($pincode);

        // 1. Check active phlebos
        $activeAgents = Agent::where('status', 'active')->get();
        if ($activeAgents->isEmpty()) {
            return [
                'serviceable' => false,
                'message' => 'No active collection agents currently available.',
                'total_on_duty_phlebos' => 0,
                'slots' => [],
            ];
        }

        $hasAnyExplicitPincodes = Agent::where('status', 'active')
            ->whereNotNull('serviceable_pincodes')
            ->where('serviceable_pincodes', '!=', '')
            ->exists();

        if ($hasAnyExplicitPincodes) {
            $directMatches = $activeAgents->filter(fn (Agent $a) => $a->servesPincode($cleanPin));
            if ($directMatches->isNotEmpty()) {
                $coveringPhlebos = $directMatches;
            } else {
                $fallbackAgents = $activeAgents->filter(fn (Agent $a) => empty($a->serviceable_pincodes) || in_array('*', $a->pincode_list, true));
                $coveringPhlebos = $fallbackAgents->isNotEmpty() ? $fallbackAgents : collect();
            }
        } else {
            $coveringPhlebos = $activeAgents;
        }

        if ($coveringPhlebos->isEmpty()) {
            return [
                'serviceable' => false,
                'message' => "Home collection is currently not serviceable in pincode {$cleanPin}.",
                'total_on_duty_phlebos' => 0,
                'slots' => [],
            ];
        }

        // 2. Filter phlebos on duty for the date (checking weekly off and full-day leaves)
        $onDutyForDay = $coveringPhlebos->filter(function (Agent $agent) use ($dateYmd) {
            return ! $agent->isOnLeave($dateYmd, null);
        });

        // 3. Fetch all active collection slots
        $allSlots = CollectionSlot::active()->ordered()->get();

        $slotResults = [];

        foreach ($allSlots as $slot) {
            // Check which phlebos are available for this specific slot (not on slot-specific leave)
            $availableForSlot = $onDutyForDay->filter(function (Agent $agent) use ($dateYmd, $slot) {
                return ! $agent->isOnLeave($dateYmd, $slot->title);
            });

            if ($availableForSlot->isEmpty()) {
                $slotResults[] = [
                    'id' => $slot->id,
                    'title' => $slot->title,
                    'period' => $slot->period,
                    'is_available' => false,
                    'reason' => 'Phlebotomist off-duty in your area',
                    'remaining_capacity' => 0,
                ];

                continue;
            }

            // Calculate total capacity of on-duty phlebotomists covering this pincode
            $totalCapacity = $availableForSlot->sum(function (Agent $a) {
                return $a->max_orders_per_slot ?: 2;
            });

            // Count existing bookings for this pincode + date + slot
            $bookedCount = Booking::whereDate('booking_date', $dateYmd)
                ->where('collection_slot', $slot->title)
                ->whereNotIn('sample_status', ['Cancelled'])
                ->whereHas('address', function ($q) use ($cleanPin) {
                    $q->where('pincode', $cleanPin);
                })
                ->count();

            $remaining = max(0, $totalCapacity - $bookedCount);
            $isAvailable = $remaining > 0;

            // Check if slot has expired for today's time
            if ($isAvailable && Booking::isSlotExpiredForDate($dateYmd, $slot->title)) {
                $isAvailable = false;
                $reason = 'Slot time has passed';
            } else {
                $reason = $isAvailable ? 'Available' : 'Slot fully booked in your area';
            }

            $slotResults[] = [
                'id' => $slot->id,
                'title' => $slot->title,
                'period' => $slot->period,
                'is_available' => $isAvailable,
                'reason' => $reason,
                'remaining_capacity' => $remaining,
            ];
        }

        return [
            'serviceable' => true,
            'message' => 'Serviceable',
            'total_on_duty_phlebos' => $onDutyForDay->count(),
            'slots' => $slotResults,
        ];
    }
}
