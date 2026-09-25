<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ContactEnquiry;
use App\Models\Coupon;
use App\Models\Package;
use App\Models\Patient;
use App\Models\PatientCoupon;
use App\Models\Review;
use App\Models\Test;
use App\Models\TestCategory;
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
        if (Review::count() === 0) {
            Review::create([
                'author_name' => 'Rahul Sharma',
                'rating' => 5,
                'comment' => 'Very punctual and hygienic home sample collection. Got reports online on WhatsApp within 6 hours. Highly recommended!',
                'status' => 'Approved',
            ]);

            Review::create([
                'author_name' => 'Priya Patel',
                'rating' => 5,
                'comment' => 'Booked Full Body Checkup for my parents. The phlebotomist was very gentle and professional. Great service!',
                'status' => 'Approved',
            ]);

            Review::create([
                'author_name' => 'Ananya Verma',
                'rating' => 4,
                'comment' => 'Fast test report delivery and seamless booking experience on the portal. Will use again.',
                'status' => 'Approved',
            ]);

            Review::create([
                'author_name' => 'Vikram Malhotra',
                'rating' => 5,
                'comment' => 'Affordable packages and accurate diagnostic reports. Very satisfied with the customer care response.',
                'status' => 'Pending', // For admin to approve/reject
            ]);
        }

        // Seed Sample Contact Enquiries if empty
        if (ContactEnquiry::count() === 0) {
            ContactEnquiry::create([
                'name' => 'Deepak Gupta',
                'email' => 'deepak@example.com',
                'subject' => 'Corporate Health Checkup Tie-up',
                'message' => 'Hello team, we are looking for annual health checkups for our 50 employees. Please share package details and corporate discounts.',
                'status' => 'Unread',
            ]);

            ContactEnquiry::create([
                'name' => 'Sunita Joshi',
                'email' => 'sunita@example.com',
                'subject' => 'Home Sample Collection Enquiry',
                'message' => 'Do you provide early morning 6:30 AM blood sample collection for diabetic fasting test at home?',
                'status' => 'Unread',
            ]);
        }

        // Seed Categories and Single Health Checkup Tests if empty
        // if (Test::count() === 0) {
        //     $catBlood = TestCategory::firstOrCreate(['name' => 'General Blood Tests']);
        //     $catThyroid = TestCategory::firstOrCreate(['name' => 'Thyroid Care']);
        //     $catHeart = TestCategory::firstOrCreate(['name' => 'Cardiac & Lipid']);
        //     $catDiabetes = TestCategory::firstOrCreate(['name' => 'Diabetes Care']);
        //     $catVitamins = TestCategory::firstOrCreate(['name' => 'Vitamins & Immunity']);
        //     $catLiverKidney = TestCategory::firstOrCreate(['name' => 'Organ Health']);

        //     Test::create([
        //         'name' => 'Complete Blood Count (CBC) with ESR',
        //         'test_category_id' => $catBlood->id,
        //         'price' => 350.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'No special preparation needed. Random sample.',
        //         'report_delivery_time' => 'Within 6 Hours',
        //     ]);

        //     Test::create([
        //         'name' => 'Thyroid Profile Total (T3, T4, TSH)',
        //         'test_category_id' => $catThyroid->id,
        //         'price' => 550.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'Overnight fasting of 8-10 hours recommended.',
        //         'report_delivery_time' => 'Same Day (Within 8 Hrs)',
        //     ]);

        //     Test::create([
        //         'name' => 'Lipid Profile (Complete Cholesterol & Triglycerides)',
        //         'test_category_id' => $catHeart->id,
        //         'price' => 650.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'Mandatory 10-12 hours fasting. Only water allowed.',
        //         'report_delivery_time' => 'Same Day',
        //     ]);

        //     Test::create([
        //         'name' => 'HbA1c (Glycated Hemoglobin - 3 Months Average Sugar)',
        //         'test_category_id' => $catDiabetes->id,
        //         'price' => 450.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'Non-fasting. Can be done anytime of the day.',
        //         'report_delivery_time' => 'Within 6 Hours',
        //     ]);

        //     Test::create([
        //         'name' => 'Vitamin D3 (25-Hydroxy Cholecalciferol)',
        //         'test_category_id' => $catVitamins->id,
        //         'price' => 999.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'No fasting required. Morning sample preferred.',
        //         'report_delivery_time' => 'Within 12 Hours',
        //     ]);

        //     Test::create([
        //         'name' => 'Liver Function Test (LFT - 11 Parameters)',
        //         'test_category_id' => $catLiverKidney->id,
        //         'price' => 600.00,
        //         'is_featured' => false,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'Overnight fasting of 8-10 hours recommended.',
        //         'report_delivery_time' => 'Same Day',
        //     ]);

        //     Test::create([
        //         'name' => 'Kidney Function Test (KFT with Electrolytes)',
        //         'test_category_id' => $catLiverKidney->id,
        //         'price' => 700.00,
        //         'is_featured' => false,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'Fasting of 8-10 hours recommended.',
        //         'report_delivery_time' => 'Same Day',
        //     ]);

        //     Test::create([
        //         'name' => 'Vitamin B12 (Cyanocobalamin)',
        //         'test_category_id' => $catVitamins->id,
        //         'price' => 799.00,
        //         'is_featured' => false,
        //         'is_active' => true,
        //         'home_collection_available' => true,
        //         'preparation_instructions' => 'Overnight fasting of 8-10 hours.',
        //         'report_delivery_time' => 'Same Day',
        //     ]);
        // }

        // Seed Sample Patients / Users if empty
        // if (Patient::count() === 0) {
        //     $p1 = Patient::create([
        //         'name' => 'Rajesh Sharma',
        //         'email' => 'rajesh.sharma@example.com',
        //         'mobile' => '9876543210',
        //         'gender' => 'Male',
        //         'age' => '34',
        //         'password' => bcrypt('password123'),
        //         'last_login_at' => now()->subHours(2),
        //     ]);
        //     $p1->addresses()->create([
        //         'title' => 'Home',
        //         'full_address' => 'Flat 402, Sunshine Apartments, MG Road, Mumbai',
        //         'pincode' => '400001',
        //     ]);
        //     $p1->familyMembers()->create([
        //         'name' => 'Kavita Sharma',
        //         'relation' => 'Spouse',
        //         'gender' => 'Female',
        //         'age' => 31,
        //     ]);
        //     $p1->bookings()->create([
        //         'booking_reference' => 'BK-'.strtoupper(substr(uniqid(), -6)),
        //         'test_details' => [['name' => 'Complete Blood Count (CBC)', 'price' => 350.00]],
        //         'collection_type' => 'Home Collection',
        //         'amount' => 350.00,
        //         'payment_method' => 'Cash',
        //         'payment_status' => 'Pending',
        //         'status' => 'Booked',
        //         'booking_date' => now()->addDay(),
        //     ]);

        //     $p2 = Patient::create([
        //         'name' => 'Pooja Verma',
        //         'email' => 'pooja.verma@example.com',
        //         'mobile' => '9812345678',
        //         'gender' => 'Female',
        //         'age' => '28',
        //         'password' => bcrypt('password123'),
        //         'last_login_at' => now()->subDays(1),
        //     ]);
        //     $p2->addresses()->create([
        //         'title' => 'Office',
        //         'full_address' => 'Sector 62, Electronic City, Noida',
        //         'pincode' => '201309',
        //     ]);
        //     $p2->bookings()->create([
        //         'booking_reference' => 'BK-'.strtoupper(substr(uniqid(), -6)),
        //         'test_details' => [['name' => 'Thyroid Profile Total (T3, T4, TSH)', 'price' => 550.00]],
        //         'collection_type' => 'Home Collection',
        //         'amount' => 550.00,
        //         'payment_method' => 'Online',
        //         'payment_status' => 'Paid',
        //         'status' => 'Report Ready',
        //         'booking_date' => now()->subDays(2),
        //     ]);

        //     $p3 = Patient::create([
        //         'name' => 'Amitabh Sen',
        //         'email' => 'amitabh.sen@example.com',
        //         'mobile' => '9745612389',
        //         'gender' => 'Male',
        //         'age' => '45',
        //         'password' => bcrypt('password123'),
        //         'last_login_at' => now()->subDays(4),
        //     ]);
        // }

        // Seed Sample Coupons if empty
        if (Coupon::count() === 0) {
            $welcomeCoupon = Coupon::create([
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

            $bannerCoupon = Coupon::create([
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
            $allPatients = Patient::all();
            foreach ($allPatients as $p) {
                PatientCoupon::firstOrCreate([
                    'patient_id' => $p->id,
                    'coupon_id' => $welcomeCoupon->id,
                ]);
            }
        }

        // Seed Categories if empty
        // if (Category::count() === 0) {
        //     Category::create([
        //         'name' => 'Full Body Checkup',
        //         'sub_category' => ['Basic Screening', 'Advanced Full Body', 'Executive Comprehensive'],
        //         'is_active' => true,
        //     ]);
        //     Category::create([
        //         'name' => "Women's Health",
        //         'sub_category' => ['PCOS/PCOD Profile', 'Pregnancy Care', 'Hormonal Wellness'],
        //         'is_active' => true,
        //     ]);
        //     Category::create([
        //         'name' => 'Habit & Lifestyle Risk',
        //         'sub_category' => ['Smokers Panel', 'Alcohol Screening', 'Stress & Fatigue'],
        //         'is_active' => true,
        //     ]);
        //     Category::create([
        //         'name' => 'Senior Citizen Care',
        //         'sub_category' => ['Bone Health', 'Cardiac Care', 'Diabetes Monitoring'],
        //         'is_active' => true,
        //     ]);
        // }

        // Seed Sample Packages if empty
        // if (Package::count() === 0) {
        //     $cat1 = Category::where('name', 'Full Body Checkup')->first();
        //     $cat2 = Category::where('name', "Women's Health")->first();
        //     $cat3 = Category::where('name', 'Habit & Lifestyle Risk')->first();

        //     Package::create([
        //         'name' => 'Fit India Full Body Checkup with Vitamin Screening',
        //         'type' => 'general',
        //         'display_sections' => ['top_booked'],
        //         'category_ids' => $cat1 ? [$cat1->id] : [],
        //         'subcategory' => 'Advanced Full Body',
        //         'price' => 1299.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'description' => 'Comprehensive 85 parameters full body checkup covering Complete Hemogram, Lipid Profile, Liver & Kidney Function, Thyroid and Vitamin D & B12.',
        //         'parameters' => ['Complete Hemogram (24 Tests)', 'Lipid Profile (8 Tests)', 'Liver Function Test (11 Tests)', 'Kidney Function Test (10 Tests)', 'Thyroid Profile Total (3 Tests)', 'Vitamin D & B12 (2 Tests)'],
        //     ]);

        //     Package::create([
        //         'name' => 'Complete Comprehensive Health Panel (95 Parameters)',
        //         'type' => 'general',
        //         'display_sections' => ['top_booked'],
        //         'category_ids' => $cat1 ? [$cat1->id] : [],
        //         'subcategory' => 'Executive Comprehensive',
        //         'price' => 1999.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'description' => 'Our flagship diagnostic health panel covering 95 critical health vitals, HbA1c, Iron studies, Cardiac risk factors, and electrolytes.',
        //         'parameters' => ['Cardiac Risk Markers', 'HbA1c & Fasting Glucose', 'Iron Deficiency Profile', 'Liver & Kidney Complete', 'Electrolytes Serum'],
        //     ]);

        //     Package::create([
        //         'name' => 'Smokers & High Pollution Health Shield',
        //         'type' => 'habit',
        //         'display_sections' => ['habit'],
        //         'category_ids' => $cat3 ? [$cat3->id] : [],
        //         'subcategory' => 'Smokers Panel',
        //         'price' => 1499.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'description' => 'Targeted health screen designed for regular smokers and urban dwellers exposed to heavy air pollution. Includes lung biomarker markers, cardiac enzymes and inflammatory markers.',
        //         'parameters' => ['HsCRP (High Sensitive CRP)', 'Lipid Cardiac Risk Profile', 'CBC with Absolute Eosinophil Count', 'Liver Enzymes & Bilirubin'],
        //     ]);

        //     Package::create([
        //         'name' => 'Alcohol & Liver Wellness Screening',
        //         'type' => 'habit',
        //         'display_sections' => ['habit', 'top_booked'],
        //         'category_ids' => $cat3 ? [$cat3->id] : [],
        //         'subcategory' => 'Alcohol Screening',
        //         'price' => 1199.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'description' => 'Specialized organ check evaluating fatty liver risks, liver enzyme elevations, uric acid, and metabolic dysfunction.',
        //         'parameters' => ['Gamma Glutamyl Transferase (GGT)', 'SGOT / SGPT Ratio', 'Serum Bilirubin Total & Direct', 'Serum Uric Acid & Creatinine'],
        //     ]);

        //     Package::create([
        //         'name' => 'Femcliffe Complete Women Hormonal & Vital Care',
        //         'type' => 'femcliffe',
        //         'display_sections' => ['femcliffe', 'top_booked'],
        //         'category_ids' => $cat2 ? [$cat2->id] : [],
        //         'subcategory' => 'PCOS/PCOD Profile',
        //         'price' => 1899.00,
        //         'is_featured' => true,
        //         'is_active' => true,
        //         'description' => 'Dedicated women health wellness screen covering hormone balance (LH, FSH, Prolactin, TSH), Iron deficiency, Calcium & Vitamin D for bone density.',
        //         'parameters' => ['LH & FSH Hormone Ratio', 'Serum Prolactin', 'Thyroid Profile Total', 'Ferritin & Iron Studies', 'Calcium & Vitamin D3'],
        //     ]);

        //     Package::create([
        //         'name' => 'Femcliffe Pregnancy & Maternity Health Screen',
        //         'type' => 'femcliffe',
        //         'display_sections' => ['femcliffe'],
        //         'category_ids' => $cat2 ? [$cat2->id] : [],
        //         'subcategory' => 'Pregnancy Care',
        //         'price' => 2499.00,
        //         'is_featured' => false,
        //         'is_active' => true,
        //         'description' => 'Vital antenatal health panel checking blood group Rh typing, Glucose Tolerance, Complete Urine Analysis, Thyroid, and Infectious disease markers.',
        //         'parameters' => ['Blood Group & Rh Typing', 'Glucose Challenge Test', 'Urine Routine & Microscopic', 'Hemoglobin & Platelet Count'],
        //     ]);
        // }
    }
}
