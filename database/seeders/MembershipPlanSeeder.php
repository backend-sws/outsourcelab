<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MembershipPlan::updateOrCreate(
            ['slug' => 'wellcare-vip-gold-pass'],
            [
                'name' => 'Wellcare VIP Gold Pass',
                'tagline' => 'Best for individuals & families for annual preventive wellness',
                'duration_type' => 'years',
                'duration_value' => 1,
                'price' => 499.00,
                'original_price' => 1499.00,
                'discount_percentage' => 20,
                'free_home_collection' => true,
                'free_teleconsultation' => true,
                'priority_reports' => true,
                'family_coverage_limit' => 4,
                'benefits' => [
                    'Flat 20% OFF on all Diagnostic Tests & Health Packages',
                    'Zero Home Sample Collection Fee on every booking (Save ₹150/visit)',
                    'Unlimited Free Doctor Tele-Consultations on lab reports',
                    'Priority 6-8h Digital Report Delivery on WhatsApp & Email',
                    'Covers up to 4 Family Members on the same account',
                    'Dedicated VIP Support Helpline & Phlebotomist Slot Priority',
                ],
                'theme_color' => 'gold',
                'is_popular' => true,
                'is_active' => true,
            ]
        );

        MembershipPlan::updateOrCreate(
            ['slug' => 'wellcare-care-plus-platinum'],
            [
                'name' => 'Wellcare Care+ Platinum Pass',
                'tagline' => 'Maximum savings & comprehensive multi-year healthcare security',
                'duration_type' => 'years',
                'duration_value' => 2,
                'price' => 899.00,
                'original_price' => 2999.00,
                'discount_percentage' => 25,
                'free_home_collection' => true,
                'free_teleconsultation' => true,
                'priority_reports' => true,
                'family_coverage_limit' => 6,
                'benefits' => [
                    'Flat 25% OFF on all Diagnostic Tests & Health Packages',
                    'Full 2-Year Long-Term Price Protection & VIP Shield',
                    'Zero Home Sample Collection Fee (Always 100% Free)',
                    '1 Complimentary Annual CBC with ESR Blood Profile',
                    'Unlimited Free Tele-Consultation with Senior Physicians',
                    'Covers up to 6 Family Members including Elderly Parents',
                    'Super-Fast Express Report Processing (Certified Lab)',
                ],
                'theme_color' => 'platinum',
                'is_popular' => false,
                'is_active' => true,
            ]
        );
    }
}
