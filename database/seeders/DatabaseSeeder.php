<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@wellcare.com'],
            [
                'name' => 'Super Admin',
                'password' => bcrypt('password123'),
            ]
        );

        // Seed Sample Reviews if empty
        if (\App\Models\Review::count() === 0) {
            \App\Models\Review::create([
                'author_name' => 'Rahul Sharma',
                'rating'      => 5,
                'comment'     => 'Very punctual and hygienic home sample collection. Got reports online on WhatsApp within 6 hours. Highly recommended!',
                'status'      => 'Approved',
            ]);

            \App\Models\Review::create([
                'author_name' => 'Priya Patel',
                'rating'      => 5,
                'comment'     => 'Booked Full Body Checkup for my parents. The phlebotomist was very gentle and professional. Great service!',
                'status'      => 'Approved',
            ]);

            \App\Models\Review::create([
                'author_name' => 'Ananya Verma',
                'rating'      => 4,
                'comment'     => 'Fast test report delivery and seamless booking experience on the portal. Will use again.',
                'status'      => 'Approved',
            ]);

            \App\Models\Review::create([
                'author_name' => 'Vikram Malhotra',
                'rating'      => 5,
                'comment'     => 'Affordable packages and accurate diagnostic reports. Very satisfied with the customer care response.',
                'status'      => 'Pending', // For admin to approve/reject
            ]);
        }

        // Seed Sample Contact Enquiries if empty
        if (\App\Models\ContactEnquiry::count() === 0) {
            \App\Models\ContactEnquiry::create([
                'name'    => 'Deepak Gupta',
                'email'   => 'deepak@example.com',
                'subject' => 'Corporate Health Checkup Tie-up',
                'message' => 'Hello team, we are looking for annual health checkups for our 50 employees. Please share package details and corporate discounts.',
                'status'  => 'Unread',
            ]);

            \App\Models\ContactEnquiry::create([
                'name'    => 'Sunita Joshi',
                'email'   => 'sunita@example.com',
                'subject' => 'Home Sample Collection Enquiry',
                'message' => 'Do you provide early morning 6:30 AM blood sample collection for diabetic fasting test at home?',
                'status'  => 'Unread',
            ]);
        }

        // Seed Categories and Single Health Checkup Tests if empty
        if (\App\Models\Test::count() === 0) {
            $catBlood = \App\Models\TestCategory::firstOrCreate(['name' => 'General Blood Tests']);
            $catThyroid = \App\Models\TestCategory::firstOrCreate(['name' => 'Thyroid Care']);
            $catHeart = \App\Models\TestCategory::firstOrCreate(['name' => 'Cardiac & Lipid']);
            $catDiabetes = \App\Models\TestCategory::firstOrCreate(['name' => 'Diabetes Care']);
            $catVitamins = \App\Models\TestCategory::firstOrCreate(['name' => 'Vitamins & Immunity']);
            $catLiverKidney = \App\Models\TestCategory::firstOrCreate(['name' => 'Organ Health']);

            \App\Models\Test::create([
                'name' => 'Complete Blood Count (CBC) with ESR',
                'test_category_id' => $catBlood->id,
                'price' => 350.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'No special preparation needed. Random sample.',
                'report_delivery_time' => 'Within 6 Hours'
            ]);

            \App\Models\Test::create([
                'name' => 'Thyroid Profile Total (T3, T4, TSH)',
                'test_category_id' => $catThyroid->id,
                'price' => 550.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Overnight fasting of 8-10 hours recommended.',
                'report_delivery_time' => 'Same Day (Within 8 Hrs)'
            ]);

            \App\Models\Test::create([
                'name' => 'Lipid Profile (Complete Cholesterol & Triglycerides)',
                'test_category_id' => $catHeart->id,
                'price' => 650.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Mandatory 10-12 hours fasting. Only water allowed.',
                'report_delivery_time' => 'Same Day'
            ]);

            \App\Models\Test::create([
                'name' => 'HbA1c (Glycated Hemoglobin - 3 Months Average Sugar)',
                'test_category_id' => $catDiabetes->id,
                'price' => 450.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Non-fasting. Can be done anytime of the day.',
                'report_delivery_time' => 'Within 6 Hours'
            ]);

            \App\Models\Test::create([
                'name' => 'Vitamin D3 (25-Hydroxy Cholecalciferol)',
                'test_category_id' => $catVitamins->id,
                'price' => 999.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'No fasting required. Morning sample preferred.',
                'report_delivery_time' => 'Within 12 Hours'
            ]);

            \App\Models\Test::create([
                'name' => 'Liver Function Test (LFT - 11 Parameters)',
                'test_category_id' => $catLiverKidney->id,
                'price' => 600.00,
                'is_featured' => false,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Overnight fasting of 8-10 hours recommended.',
                'report_delivery_time' => 'Same Day'
            ]);

            \App\Models\Test::create([
                'name' => 'Kidney Function Test (KFT with Electrolytes)',
                'test_category_id' => $catLiverKidney->id,
                'price' => 700.00,
                'is_featured' => false,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Fasting of 8-10 hours recommended.',
                'report_delivery_time' => 'Same Day'
            ]);

            \App\Models\Test::create([
                'name' => 'Vitamin B12 (Cyanocobalamin)',
                'test_category_id' => $catVitamins->id,
                'price' => 799.00,
                'is_featured' => false,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Overnight fasting of 8-10 hours.',
                'report_delivery_time' => 'Same Day'
            ]);
        }

        // Seed Sample Patients / Users if empty
        if (\App\Models\Patient::count() === 0) {
            $p1 = \App\Models\Patient::create([
                'name' => 'Rajesh Sharma',
                'email' => 'rajesh.sharma@example.com',
                'mobile' => '9876543210',
                'gender' => 'Male',
                'age' => '34',
                'password' => bcrypt('password123'),
                'last_login_at' => now()->subHours(2),
            ]);
            $p1->addresses()->create([
                'title' => 'Home',
                'full_address' => 'Flat 402, Sunshine Apartments, MG Road, Mumbai',
                'pincode' => '400001'
            ]);
            $p1->familyMembers()->create([
                'name' => 'Kavita Sharma',
                'relation' => 'Spouse',
                'gender' => 'Female',
                'age' => 31
            ]);
            $p1->bookings()->create([
                'booking_reference' => 'BK-' . strtoupper(substr(uniqid(), -6)),
                'test_details' => [['name' => 'Complete Blood Count (CBC)', 'price' => 350.00]],
                'collection_type' => 'Home Collection',
                'amount' => 350.00,
                'payment_method' => 'Cash',
                'payment_status' => 'Pending',
                'status' => 'Booked',
                'booking_date' => now()->addDay()
            ]);

            $p2 = \App\Models\Patient::create([
                'name' => 'Pooja Verma',
                'email' => 'pooja.verma@example.com',
                'mobile' => '9812345678',
                'gender' => 'Female',
                'age' => '28',
                'password' => bcrypt('password123'),
                'last_login_at' => now()->subDays(1),
            ]);
            $p2->addresses()->create([
                'title' => 'Office',
                'full_address' => 'Sector 62, Electronic City, Noida',
                'pincode' => '201309'
            ]);
            $p2->bookings()->create([
                'booking_reference' => 'BK-' . strtoupper(substr(uniqid(), -6)),
                'test_details' => [['name' => 'Thyroid Profile Total (T3, T4, TSH)', 'price' => 550.00]],
                'collection_type' => 'Home Collection',
                'amount' => 550.00,
                'payment_method' => 'Online',
                'payment_status' => 'Paid',
                'status' => 'Report Ready',
                'booking_date' => now()->subDays(2)
            ]);

            $p3 = \App\Models\Patient::create([
                'name' => 'Amitabh Sen',
                'email' => 'amitabh.sen@example.com',
                'mobile' => '9745612389',
                'gender' => 'Male',
                'age' => '45',
                'password' => bcrypt('password123'),
                'last_login_at' => now()->subDays(4),
            ]);
        }

        // Seed Sample Coupons if empty
        if (\App\Models\Coupon::count() === 0) {
            $welcomeCoupon = \App\Models\Coupon::create([
                'code' => 'WELCOME15',
                'title' => 'First-Time Login Welcome Discount',
                'description' => 'Exclusive 15% discount for your very first lab test or health checkup booking at Wellcare.',
                'coupon_type' => 'welcome',
                'discount_type' => 'percentage',
                'discount_value' => 15.00,
                'min_order_amount' => 0.00,
                'max_discount_amount' => 500.00,
                'is_banner' => false,
                'is_active' => true,
            ]);

            $bannerCoupon = \App\Models\Coupon::create([
                'code' => 'WELLCARE20',
                'title' => 'Super Saver Minimum Spend Offer',
                'description' => 'Get 20% discount on all diagnostic lab tests on orders above ₹999.',
                'coupon_type' => 'banner',
                'discount_type' => 'percentage',
                'discount_value' => 20.00,
                'min_order_amount' => 999.00,
                'max_discount_amount' => 1000.00,
                'is_banner' => true,
                'banner_text' => 'Special Health Deal: Flat 20% OFF on all lab tests for bookings above ₹999! Use Code: WELLCARE20',
                'is_active' => true,
            ]);

            // Assign Welcome Coupon to all existing patients
            $allPatients = \App\Models\Patient::all();
            foreach ($allPatients as $p) {
                \App\Models\PatientCoupon::firstOrCreate([
                    'patient_id' => $p->id,
                    'coupon_id' => $welcomeCoupon->id,
                ]);
            }
        }
    }
}
