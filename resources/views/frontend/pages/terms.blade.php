@extends('frontend.layouts.app')

@section('title', 'Terms & Conditions - Service Agreements | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-slate-200/40 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-4xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Terms & Conditions</span>
    </nav>

    <!-- Header Section -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm mb-10">
        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200 inline-flex items-center gap-1.5 mb-4">
            <i class="fas fa-file-contract text-teal-600"></i> Service Agreement
        </span>
        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight mb-4">
            Terms & Conditions of Service
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
            Effective Date: January 1, 2024 &nbsp;|&nbsp; Last Updated: {{ date('F Y') }}
        </p>
        <p class="text-xs text-gray-600 mt-4 leading-relaxed">
            Please read these Terms & Conditions ("Terms") carefully before using the diagnostic testing and home sample collection services provided by {{ \App\Models\Setting::get('company_legal_name', 'Av Wellcare Lifetech Pvt. Ltd.') }} ("Av Wellcare Diagnostics", "Company", "we", or "us"). By scheduling an appointment, ordering a test, or purchasing a membership plan, you agree to be bound by these Terms.
        </p>
    </div>

    <!-- Terms Body -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm space-y-8 text-gray-700 text-xs sm:text-sm leading-relaxed mb-16">
        
        <!-- Section 1 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">1.</span> Diagnostic Nature & Medical Disclaimer
            </h2>
            <div class="p-4 bg-amber-50 border border-amber-200 rounded-2xl text-xs text-amber-900 font-medium mb-3">
                <strong>IMPORTANT CLINICAL NOTICE:</strong> Diagnostic laboratory tests, pathology reports, and health screening packages are clinical aids designed to assist licensed healthcare providers. They do not constitute an independent medical prescription or definitive diagnosis. All laboratory findings must be correlated clinically with your symptoms and reviewed by a qualified doctor.
            </div>
            <p class="text-gray-600">
                Biological reference intervals indicated in our reports are established on standardized demographic populations and analyzer calibrations. Individual values may vary according to age, gender, medical history, concurrent medication, and circadian rhythm.
            </p>
        </section>

        <hr class="border-gray-100">

        <!-- Section 2 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">2.</span> Patient Preparation & Pre-Test Guidelines
            </h2>
            <p class="text-gray-600 mb-3">
                Accurate diagnostic outcomes depend critically upon proper patient adherence to preparation protocols:
            </p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li><strong>Fasting Protocols:</strong> For fasting panels (e.g. Fasting Blood Sugar, Lipid Profile), the patient must observe 10 to 12 hours of overnight fasting. Plain water intake is permitted.</li>
                <li><strong>Medication Declarations:</strong> Patients are advised to inform the phlebotomist of any anticoagulants (blood thinners), insulin, corticosteroids, or thyroid supplements currently being consumed.</li>
                <li><strong>Pediatric & Geriatric Care:</strong> An adult guardian must be present during collection for minors or dependent elderly individuals.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 3 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">3.</span> Home Sample Collection & Consent
            </h2>
            <p class="text-gray-600 mb-3">
                By booking a doorstep phlebotomy visit:
            </p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li>You give informed consent to our trained phlebotomist to perform venipuncture (drawing blood from a vein) using sterile, disposable needles and evacuated blood tubes.</li>
                <li>You acknowledge that minor temporary bruising, localized tenderness, or transient lightheadedness are infrequent but standard physiological reactions to needle insertion.</li>
                <li>You agree to provide a clean, well-lit, and seated environment for the phlebotomist to conduct the procedure safely.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 4 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">4.</span> Turnaround Time (TAT) & Sample Redraws
            </h2>
            <p class="text-gray-600 mb-3">
                Turnaround times specified on our website or booking confirmation are good-faith estimates calculated from the moment of sample receipt at the processing laboratory.
            </p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li>On rare occasions, biological specimens may exhibit hemolysis (ruptured red blood cells), severe lipemia, or micro-clots that compromise analytical veracity. In such cases, the laboratory may reject the specimen and request a <strong>complimentary sample redraw</strong> at zero extra charge to ensure medical accuracy.</li>
                <li>Report delivery may also experience minor delays during national holidays, weather disruptions, or equipment calibration cycles.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 5 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">5.</span> Cancellation, Rescheduling & Refund Policy
            </h2>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li><strong>Rescheduling:</strong> You may reschedule your home collection appointment free of charge up to 2 hours before the scheduled time slot.</li>
                <li><strong>Cancellation Before Sample Collection:</strong> If you cancel your prepaid order prior to sample collection, a 100% full refund is initiated to the original payment source.</li>
                <li><strong>Non-Refundable Post Collection:</strong> Once biological samples have been collected, barcoded, and ingested into laboratory processing, orders cannot be cancelled or refunded as laboratory reagents and single-use consumables are expended.</li>
                <li><strong>Refund Processing Timeline:</strong> Approved refunds are credited to the user's bank account or UPI handle within 3 to 5 business days, depending on bank clearing cycles.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 6 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">6.</span> Governing Law & Judicial Jurisdiction
            </h2>
            <p class="text-gray-600">
                These Terms shall be governed by and construed in accordance with the laws of the Republic of India. Any disputes, claims, or legal proceedings arising out of or in connection with these Terms or services rendered shall be subject to the exclusive jurisdiction of the competent courts located in <strong>Gautam Buddha Nagar (Noida), Uttar Pradesh</strong>.
            </p>
        </section>
    </div>
</div>
@endsection
