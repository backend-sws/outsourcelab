<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use App\Models\Test;
use App\Models\TestCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DiagnosticSeeder extends Seeder
{
    /**
     * Run the diagnostic chain database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        // 1. Wipe old test and package data to ensure clean slate
        Package::truncate();
        Test::truncate();
        TestCategory::truncate();
        Category::truncate();

        Schema::enableForeignKeyConstraints();

        // -------------------------------------------------------------
        // 2. SEED DEPARTMENTS & CLINICAL PARAMETERS (Pathology Specialties)
        // -------------------------------------------------------------
        $departments = [
            [
                'name' => 'Complete Hemogram / CBC',
                'parameters' => [
                    'Hemoglobin (Hb)',
                    'RBC Count',
                    'Total Leukocyte Count (WBC)',
                    'Platelet Count',
                    'Packed Cell Volume (PCV / Hematocrit)',
                    'Mean Corpuscular Volume (MCV)',
                    'Mean Corpuscular Hemoglobin (MCH)',
                    'Mean Corpuscular Hemoglobin Concentration (MCHC)',
                    'Red Cell Distribution Width (RDW-CV)',
                    'RDW-SD',
                    'Neutrophils %',
                    'Lymphocytes %',
                    'Monocytes %',
                    'Eosinophils %',
                    'Basophils %',
                    'Absolute Neutrophil Count (ANC)',
                    'Absolute Lymphocyte Count (ALC)',
                    'Absolute Monocyte Count (AMC)',
                    'Absolute Eosinophil Count (AEC)',
                    'Absolute Basophil Count (ABC)',
                    'Mean Platelet Volume (MPV)',
                    'Platelet Distribution Width (PDW)',
                    'Plateletcrit (PCT)',
                    'Erythrocyte Sedimentation Rate (ESR - Westergren)',
                ],
            ],
            [
                'name' => 'Lipid Profile / Cardiac Risk',
                'parameters' => [
                    'Total Cholesterol',
                    'HDL Cholesterol (Good Cholesterol)',
                    'LDL Cholesterol (Bad Cholesterol)',
                    'VLDL Cholesterol',
                    'Serum Triglycerides',
                    'Non-HDL Cholesterol',
                    'Total Cholesterol / HDL Ratio',
                    'LDL / HDL Ratio',
                ],
            ],
            [
                'name' => 'Liver Function Test (LFT)',
                'parameters' => [
                    'Total Bilirubin',
                    'Direct (Conjugated) Bilirubin',
                    'Indirect (Unconjugated) Bilirubin',
                    'SGOT / AST (Aspartate Aminotransferase)',
                    'SGPT / ALT (Alanine Aminotransferase)',
                    'Alkaline Phosphatase (ALP)',
                    'Gamma Glutamyl Transferase (GGT)',
                    'Total Serum Protein',
                    'Serum Albumin',
                    'Serum Globulin',
                    'Albumin / Globulin (A/G) Ratio',
                    'SGOT / SGPT Ratio',
                ],
            ],
            [
                'name' => 'Kidney / Renal Function (KFT)',
                'parameters' => [
                    'Blood Urea Nitrogen (BUN)',
                    'Serum Creatinine',
                    'Serum Uric Acid',
                    'Blood Urea',
                    'BUN / Serum Creatinine Ratio',
                    'Serum Calcium Total',
                    'Serum Phosphorus',
                    'Serum Sodium (Na+)',
                    'Serum Potassium (K+)',
                    'Serum Chloride (Cl-)',
                ],
            ],
            [
                'name' => 'Thyroid Profile Total',
                'parameters' => [
                    'Total Triiodothyronine (T3)',
                    'Total Thyroxine (T4)',
                    'Thyroid Stimulating Hormone (TSH - Ultrasensitive)',
                ],
            ],
            [
                'name' => 'Diabetes / Glycemic Profile',
                'parameters' => [
                    'Fasting Blood Glucose (Sugar)',
                    'Post Prandial (PP) Blood Sugar',
                    'HbA1c (Glycated Hemoglobin)',
                    'Estimated Average Glucose (eAG)',
                ],
            ],
            [
                'name' => 'Urine Routine & Microscopy',
                'parameters' => [
                    'Specific Gravity',
                    'pH Reaction',
                    'Urine Protein / Albumin',
                    'Urine Glucose (Sugar)',
                    'Urine Ketone Bodies',
                    'Urine Bilirubin',
                    'Urobilinogen',
                    'Pus Cells (WBCs)',
                    'Red Blood Cells (RBCs)',
                    'Epithelial Cells',
                    'Casts',
                    'Crystals',
                    'Bacteria',
                    'Urine Color',
                    'Urine Transparency / Appearance',
                ],
            ],
            [
                'name' => 'Vitamins & Bone Mineral Health',
                'parameters' => [
                    'Vitamin D 25-Hydroxy Total',
                    'Vitamin B12 (Cyanocobalamin)',
                    'Serum Calcium',
                    'Serum Ionic Calcium',
                    'Serum Phosphorus Inorganic',
                    'Serum Magnesium',
                ],
            ],
            [
                'name' => 'Iron Deficiency & Anemia Profile',
                'parameters' => [
                    'Serum Iron',
                    'Total Iron Binding Capacity (TIBC)',
                    'Unsaturated Iron Binding Capacity (UIBC)',
                    'Transferrin Saturation %',
                    'Serum Ferritin',
                ],
            ],
            [
                'name' => 'Inflammatory & Cardiac Enzymes',
                'parameters' => [
                    'High Sensitivity C-Reactive Protein (hs-CRP)',
                    'D-Dimer',
                    'Homocysteine',
                    'Creatine Kinase (CK-NAC)',
                ],
            ],
        ];

        $deptModels = [];
        foreach ($departments as $deptData) {
            $deptModels[$deptData['name']] = TestCategory::create($deptData);
        }

        // -------------------------------------------------------------
        // 3. SEED AUDIENCE DEMOGRAPHIC CATEGORIES
        // -------------------------------------------------------------
        $catFullBody = Category::create([
            'name' => 'Full Body Checkup',
            'sub_category' => [
                ['name' => 'Basic Preventive Screening', 'image' => 'https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Advanced Full Body Checkup', 'image' => 'https://images.unsplash.com/photo-1579684385127-1ef15d508118?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Executive Platinum Comprehensive', 'image' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?auto=format&fit=crop&w=800&q=80'],
            ],
            'is_active' => true,
        ]);

        $catMen = Category::create([
            'name' => "Men's Health",
            'sub_category' => [
                ['name' => 'Men Under 40 Vitality', 'image' => 'https://images.unsplash.com/photo-1517838277536-f5f99be501cd?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Men 40+ Senior Health', 'image' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Executive Working Men', 'image' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=800&q=80'],
            ],
            'is_active' => true,
        ]);

        $catWomen = Category::create([
            'name' => "Women's Health (FemCliffe)",
            'sub_category' => [
                ['name' => 'PCOS & PCOD Care', 'image' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Antenatal & Pregnancy Screening', 'image' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Hormonal Wellness & Vitality', 'image' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Women 40+ Menopause Profile', 'image' => 'https://images.unsplash.com/photo-1581579438747-1dc8d17bbce4?auto=format&fit=crop&w=800&q=80'],
            ],
            'is_active' => true,
        ]);

        $catSenior = Category::create([
            'name' => 'Senior Citizen Care',
            'sub_category' => [
                ['name' => 'Joint & Bone Health', 'image' => 'https://images.unsplash.com/photo-1582750433449-648ed127bb54?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Cardiac & Diabetes Screen', 'image' => 'https://images.unsplash.com/photo-1628348068343-c6a848d2b6dd?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Elderly Vital Organ Check', 'image' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?auto=format&fit=crop&w=800&q=80'],
            ],
            'is_active' => true,
        ]);

        $catHabit = Category::create([
            'name' => 'Habit & Lifestyle Risk',
            'sub_category' => [
                ['name' => 'Smokers & High Pollution Shield', 'image' => 'https://images.unsplash.com/photo-1584036561566-baf8f5f1b144?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Alcohol & Liver Wellness Screen', 'image' => 'https://images.unsplash.com/photo-1559839734-2b71ea197ec2?auto=format&fit=crop&w=800&q=80'],
                ['name' => 'Stress & Fatigue Profile', 'image' => 'https://images.unsplash.com/photo-1506126613408-eca07ce68773?auto=format&fit=crop&w=800&q=80'],
            ],
            'is_active' => true,
        ]);

        // -------------------------------------------------------------
        // 4. SEED AUTHENTIC SINGLE LAB TESTS
        // -------------------------------------------------------------
        $singleTests = [
            [
                'name' => 'Complete Blood Count (CBC) with ESR',
                'test_category_id' => $deptModels['Complete Hemogram / CBC']->id,
                'category_ids' => [$deptModels['Complete Hemogram / CBC']->id],
                'price' => 350.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'No special fasting required. Random blood sample.',
                'report_delivery_time' => 'Within 6 Hours',
            ],
            [
                'name' => 'HbA1c (Glycated Hemoglobin - 3 Months Sugar)',
                'test_category_id' => $deptModels['Diabetes / Glycemic Profile']->id,
                'category_ids' => [$deptModels['Diabetes / Glycemic Profile']->id],
                'price' => 450.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Non-fasting. Can be done anytime of the day.',
                'report_delivery_time' => 'Within 4 Hours',
            ],
            [
                'name' => 'Fasting Blood Sugar (Glucose Fasting)',
                'test_category_id' => $deptModels['Diabetes / Glycemic Profile']->id,
                'category_ids' => [$deptModels['Diabetes / Glycemic Profile']->id],
                'price' => 100.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Strict 10-12 hours overnight fasting mandatory. Only water allowed.',
                'report_delivery_time' => 'Within 3 Hours',
            ],
            [
                'name' => 'Lipid Profile (Complete Cholesterol Screen)',
                'test_category_id' => $deptModels['Lipid Profile / Cardiac Risk']->id,
                'category_ids' => [$deptModels['Lipid Profile / Cardiac Risk']->id],
                'price' => 650.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Mandatory 10-12 hours fasting. Avoid fatty meals night prior.',
                'report_delivery_time' => 'Same Day (Within 8 Hrs)',
            ],
            [
                'name' => 'Liver Function Test (LFT - 12 Parameters)',
                'test_category_id' => $deptModels['Liver Function Test (LFT)']->id,
                'category_ids' => [$deptModels['Liver Function Test (LFT)']->id],
                'price' => 650.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Overnight fasting of 8-10 hours recommended.',
                'report_delivery_time' => 'Same Day',
            ],
            [
                'name' => 'Kidney Function Test (KFT with Electrolytes)',
                'test_category_id' => $deptModels['Kidney / Renal Function (KFT)']->id,
                'category_ids' => [$deptModels['Kidney / Renal Function (KFT)']->id],
                'price' => 750.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Fasting of 8-10 hours recommended.',
                'report_delivery_time' => 'Same Day',
            ],
            [
                'name' => 'Thyroid Profile Total (T3, T4, TSH Ultrasensitive)',
                'test_category_id' => $deptModels['Thyroid Profile Total']->id,
                'category_ids' => [$deptModels['Thyroid Profile Total']->id],
                'price' => 450.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Early morning blood sample preferred before taking thyroid medication.',
                'report_delivery_time' => 'Within 6 Hours',
            ],
            [
                'name' => 'Vitamin D3 (25-Hydroxy Cholecalciferol)',
                'test_category_id' => $deptModels['Vitamins & Bone Mineral Health']->id,
                'category_ids' => [$deptModels['Vitamins & Bone Mineral Health']->id],
                'price' => 999.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'No fasting required. Random blood sample.',
                'report_delivery_time' => 'Within 12 Hours',
            ],
            [
                'name' => 'Vitamin B12 (Cyanocobalamin)',
                'test_category_id' => $deptModels['Vitamins & Bone Mineral Health']->id,
                'category_ids' => [$deptModels['Vitamins & Bone Mineral Health']->id],
                'price' => 799.00,
                'is_featured' => true,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'Overnight fasting of 8-10 hours recommended.',
                'report_delivery_time' => 'Same Day',
            ],
            [
                'name' => 'Urine Routine & Complete Microscopy',
                'test_category_id' => $deptModels['Urine Routine & Microscopy']->id,
                'category_ids' => [$deptModels['Urine Routine & Microscopy']->id],
                'price' => 250.00,
                'is_featured' => false,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'First morning mid-stream urine sample collected in sterile cup.',
                'report_delivery_time' => 'Within 3 Hours',
            ],
            [
                'name' => 'High Sensitivity C-Reactive Protein (hs-CRP)',
                'test_category_id' => $deptModels['Inflammatory & Cardiac Enzymes']->id,
                'category_ids' => [$deptModels['Inflammatory & Cardiac Enzymes']->id],
                'price' => 600.00,
                'is_featured' => false,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => 'No fasting required. Key early predictor of coronary artery disease.',
                'report_delivery_time' => 'Within 8 Hours',
            ],
            [
                'name' => 'Iron Deficiency Anemia Profile (with Ferritin)',
                'test_category_id' => $deptModels['Iron Deficiency & Anemia Profile']->id,
                'category_ids' => [$deptModels['Iron Deficiency & Anemia Profile']->id],
                'price' => 850.00,
                'is_featured' => false,
                'is_active' => true,
                'home_collection_available' => true,
                'preparation_instructions' => '10-12 hours overnight fasting recommended. Do not take iron supplements 24h prior.',
                'report_delivery_time' => 'Same Day',
            ],
        ];

        foreach ($singleTests as $testData) {
            Test::create($testData);
        }

        // -------------------------------------------------------------
        // 5. SEED FLAGSHIP HEALTH CHECKUP PACKAGES (Real Combo Diagnostics)
        // -------------------------------------------------------------
        $packages = [
            [
                'name' => 'Fit India Full Body Checkup with Vitamin Screening',
                'type' => 'general',
                'display_sections' => ['top_booked'],
                'category_ids' => [$catFullBody->id, $catMen->id],
                'subcategory' => 'Advanced Full Body Checkup',
                'price' => 1299.00,
                'total_parameters' => 78,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'India’s most recommended annual preventive health checkup. Covers 78 vital biomarkers including Complete Hemogram (CBC), Lipid Profile, Liver & Kidney Function, Thyroid, Fasting Sugar, Urine Examination, and Essential Vitamins.',
                'parameters' => [
                    'Complete Hemogram / CBC',
                    'Lipid Profile / Cardiac Risk',
                    'Liver Function Test (LFT)',
                    'Kidney / Renal Function (KFT)',
                    'Thyroid Profile Total',
                    'Fasting Blood Glucose (Sugar)',
                    'Urine Routine & Microscopy',
                    'Vitamin D 25-Hydroxy Total',
                    'Vitamin B12 (Cyanocobalamin)',
                ],
            ],
            [
                'name' => 'Av Wellcare Platinum Comprehensive Health Panel',
                'type' => 'general',
                'display_sections' => ['top_booked'],
                'category_ids' => [$catFullBody->id, $catSenior->id],
                'subcategory' => 'Executive Platinum Comprehensive',
                'price' => 1999.00,
                'total_parameters' => 95,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Flagship master health checkup designed for complete head-to-toe organ screening. Evaluates cardiac risk factors (hs-CRP), HbA1c 3-month sugar, full bone minerals, iron deficiency, and full organ functions.',
                'parameters' => [
                    'Complete Hemogram / CBC',
                    'Lipid Profile / Cardiac Risk',
                    'Liver Function Test (LFT)',
                    'Kidney / Renal Function (KFT)',
                    'Thyroid Profile Total',
                    'Diabetes / Glycemic Profile',
                    'Urine Routine & Microscopy',
                    'Vitamins & Bone Mineral Health',
                    'Iron Deficiency & Anemia Profile',
                    'High Sensitivity C-Reactive Protein (hs-CRP)',
                ],
            ],
            [
                'name' => 'Av Wellcare Basic Vital Preventive Screen',
                'type' => 'general',
                'display_sections' => ['top_booked'],
                'category_ids' => [$catFullBody->id],
                'subcategory' => 'Basic Preventive Screening',
                'price' => 699.00,
                'total_parameters' => 45,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Essential vital screening covering blood count, cholesterol baseline, liver and kidney vitals, urine routine, and fasting sugar.',
                'parameters' => [
                    'Complete Hemogram / CBC',
                    'Total Cholesterol',
                    'Serum Triglycerides',
                    'Serum Creatinine',
                    'Blood Urea',
                    'SGOT / AST (Aspartate Aminotransferase)',
                    'SGPT / ALT (Alanine Aminotransferase)',
                    'Fasting Blood Glucose (Sugar)',
                    'Urine Routine & Microscopy',
                ],
            ],
            [
                'name' => 'FemCliffe Complete Women Hormonal & Vital Care',
                'type' => 'femcliffe',
                'display_sections' => ['femcliffe', 'top_booked'],
                'category_ids' => [$catWomen->id],
                'subcategory' => 'Hormonal Wellness & Vitality',
                'price' => 1799.00,
                'total_parameters' => 68,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Exclusively formulated for women to detect anemia, hormonal imbalances, thyroid disorders, bone density risks, and metabolic concerns like PCOS/PCOD.',
                'parameters' => [
                    'Complete Hemogram / CBC',
                    'Thyroid Profile Total',
                    'Iron Deficiency & Anemia Profile',
                    'Vitamins & Bone Mineral Health',
                    'Liver Function Test (LFT)',
                    'Kidney / Renal Function (KFT)',
                    'Fasting Blood Glucose (Sugar)',
                    'Urine Routine & Microscopy',
                ],
            ],
            [
                'name' => 'FemCliffe PCOS & Reproductive Hormone Screen',
                'type' => 'femcliffe',
                'display_sections' => ['femcliffe'],
                'category_ids' => [$catWomen->id],
                'subcategory' => 'PCOS & PCOD Care',
                'price' => 1499.00,
                'total_parameters' => 54,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Targeted evaluation for irregular cycles, unexplained weight gain, acne, and androgen excess. Includes thyroid profile, fasting glucose, and vital blood parameters.',
                'parameters' => [
                    'Complete Hemogram / CBC',
                    'Thyroid Profile Total',
                    'Fasting Blood Glucose (Sugar)',
                    'Lipid Profile / Cardiac Risk',
                    'Liver Function Test (LFT)',
                    'Serum Creatinine',
                    'Urine Routine & Microscopy',
                ],
            ],
            [
                'name' => 'Smokers & High Pollution Risk Shield',
                'type' => 'habit',
                'display_sections' => ['habit', 'top_booked'],
                'category_ids' => [$catHabit->id],
                'subcategory' => 'Smokers & High Pollution Shield',
                'price' => 1499.00,
                'total_parameters' => 56,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Specialized screening for active and passive smokers. Checks systemic inflammation (hs-CRP), cardiovascular strain, oxygen-carrying capacity (CBC/ESR), and liver detoxification markers.',
                'parameters' => [
                    'Complete Hemogram / CBC',
                    'High Sensitivity C-Reactive Protein (hs-CRP)',
                    'Lipid Profile / Cardiac Risk',
                    'Liver Function Test (LFT)',
                    'Kidney / Renal Function (KFT)',
                    'Urine Routine & Microscopy',
                ],
            ],
            [
                'name' => 'Alcohol & Liver Detox Wellness Screen',
                'type' => 'habit',
                'display_sections' => ['habit'],
                'category_ids' => [$catHabit->id],
                'subcategory' => 'Alcohol & Liver Wellness Screen',
                'price' => 1299.00,
                'total_parameters' => 52,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'In-depth assessment for regular alcohol consumers. Focuses on Gamma GT (GGT), AST/ALT ratio, fatty liver indicators, uric acid, and metabolic waste clearance.',
                'parameters' => [
                    'Liver Function Test (LFT)',
                    'Lipid Profile / Cardiac Risk',
                    'Serum Uric Acid',
                    'Serum Creatinine',
                    'Blood Urea',
                    'Complete Hemogram / CBC',
                    'Fasting Blood Glucose (Sugar)',
                ],
            ],
            [
                'name' => 'Senior Citizen Golden Vitality Profile',
                'type' => 'general',
                'display_sections' => ['top_booked'],
                'category_ids' => [$catSenior->id, $catFullBody->id],
                'subcategory' => 'Elderly Vital Organ Check',
                'price' => 1899.00,
                'total_parameters' => 85,
                'is_featured' => true,
                'is_active' => true,
                'description' => 'Comprehensive geriatric profile evaluating arthritis & joint health, calcium levels, cardiac health, kidney filtration, HbA1c diabetic control, and complete blood profile.',
                'parameters' => [
                    'Complete Hemogram / CBC',
                    'Lipid Profile / Cardiac Risk',
                    'Liver Function Test (LFT)',
                    'Kidney / Renal Function (KFT)',
                    'Thyroid Profile Total',
                    'HbA1c (Glycated Hemoglobin)',
                    'Fasting Blood Glucose (Sugar)',
                    'Vitamins & Bone Mineral Health',
                    'Urine Routine & Microscopy',
                    'High Sensitivity C-Reactive Protein (hs-CRP)',
                ],
            ],
        ];

        foreach ($packages as $pkgData) {
            Package::create($pkgData);
        }
    }
}
