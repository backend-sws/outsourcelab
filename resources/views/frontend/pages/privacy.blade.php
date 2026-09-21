@extends('frontend.layouts.app')

@section('title', 'Privacy Policy & Health Data Protection | Av Wellcare Diagnostics')

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
        <span class="text-teal-800 font-bold">Privacy Policy</span>
    </nav>

    <!-- Header Section -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm mb-10">
        <span class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-50 text-teal-800 border border-teal-200 inline-flex items-center gap-1.5 mb-4">
            <i class="fas fa-shield-halved text-teal-600"></i> Data Privacy & Confidentiality
        </span>
        <h1 class="text-2xl sm:text-4xl font-black text-gray-900 tracking-tight mb-4">
            Privacy Policy & Health Data Protection
        </h1>
        <p class="text-xs sm:text-sm text-gray-500 leading-relaxed">
            Effective Date: January 1, 2024 &nbsp;|&nbsp; Last Updated: {{ date('F Y') }}
        </p>
        <p class="text-xs text-gray-600 mt-4 leading-relaxed">
            {{ \App\Models\Setting::get('company_legal_name', 'Av Wellcare Lifetech Pvt. Ltd.') }} ("Av Wellcare Diagnostics", "we", "our", or "us") is deeply dedicated to maintaining the confidentiality, integrity, and security of your personal and sensitive health data. This Privacy Policy details our governance under the <strong>Digital Personal Data Protection (DPDP) Act, 2023</strong> and the <strong>Information Technology (Reasonable Security Practices and Procedures and Sensitive Personal Data or Information) Rules, 2011</strong>.
        </p>
    </div>

    <!-- Policy Articles Body -->
    <div class="bg-white rounded-3xl p-8 sm:p-12 border border-gray-100 shadow-sm space-y-8 text-gray-700 text-xs sm:text-sm leading-relaxed mb-16">
        
        <!-- Section 1 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">1.</span> Information We Collect
            </h2>
            <p class="mb-3">When you schedule a diagnostic test, book a home phlebotomy collection, or request online report downloads, we collect the following categories of information:</p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li><strong>Personal Identifiers:</strong> Full legal name, date of birth / age, biological gender, mobile telephone number, email address, and home collection residential address including postal pincode.</li>
                <li><strong>Sensitive Personal Data or Information (SPDI):</strong> Physician test prescriptions, medical symptoms, clinical history, diagnostic biomarker measurements, pathology specimen records, and doctor-signed diagnostic reports.</li>
                <li><strong>Transactional Data:</strong> Payment transaction reference numbers, order totals, and invoice IDs. Note: We never store your debit/credit card CVV or net-banking credentials on our servers; payments are processed securely through PCI-DSS certified payment gateways.</li>
                <li><strong>Technical Telemetry:</strong> Device IP address, browser type, operating system, and anonymous usage analytics to maintain website stability.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 2 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">2.</span> How We Use Your Health Data
            </h2>
            <p class="mb-3">We process your data strictly for legitimate healthcare and clinical purposes:</p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li>To dispatch certified phlebotomists to your doorstep with cold-chain transport apparatus.</li>
                <li>To execute laboratory biochemical, hematological, immunological, and molecular assays under standard operating procedures.</li>
                <li>To deliver password-protected, encrypted diagnostic test reports via secure SMS, WhatsApp, and portal download links.</li>
                <li>To facilitate telephonic medical consultations or report reviews requested by you.</li>
                <li>To fulfill mandatory public health reporting obligations mandated by statutory epidemiological authorities (e.g. notifiable communicable diseases under National Center for Disease Control guidelines).</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 3 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">3.</span> Sample Storage & Biological Specimen Disposal
            </h2>
            <p class="text-gray-600 mb-3">
                Blood, serum, plasma, and urine specimens collected during phlebotomy visits are processed in our reference and satellite laboratories. Following analytical sign-off:
            </p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li>Specimens are retained under refrigeration (2°C - 8°C or -20°C depending on test stability) for 48 to 72 hours to allow for repeat runs or physician re-evaluations if clinically indicated.</li>
                <li>Following the retention window, all biological samples are chemically disinfected, neutralized, and disposed of through authorized Bio-Medical Waste Management (BMWM) contractors in accordance with the Bio-Medical Waste Management Rules, 2016.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 4 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">4.</span> Technical Security & Information Safeguards
            </h2>
            <p class="text-gray-600 mb-3">
                We implement bank-grade physical, administrative, and technical safeguards:
            </p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li><strong>Encryption:</strong> All web traffic and digital report downloads operate over 256-bit TLS/SSL transport layers. Stored medical files utilize AES-256 encryption at rest.</li>
                <li><strong>Role-Based Access:</strong> Only certified laboratory technologists and certifying MD Pathologists possess credentials to input, calibrate, and release clinical findings.</li>
                <li><strong>Anonymized Barcode Tracking:</strong> Specimens traveling from collection points to processing analyzers are identified only by machine-readable barcodes to prevent unauthorized patient identification in transit.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 5 -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">5.</span> Your Rights Under the DPDP Act, 2023
            </h2>
            <p class="text-gray-600 mb-3">As a patient and data principal, you have the following legal rights:</p>
            <ul class="list-disc pl-5 space-y-2 text-gray-600">
                <li><strong>Right to Access:</strong> Request a complete summary of your personal and health records maintained in our systems.</li>
                <li><strong>Right to Correction:</strong> Request correction or updation of any inaccurate personal identifiers (e.g. spelling of name, age, phone number).</li>
                <li><strong>Right to Grievance Redressal:</strong> Register grievances with our designated Data Protection Officer for prompt investigation and resolution.</li>
            </ul>
        </section>

        <hr class="border-gray-100">

        <!-- Section 6: Grievance Officer -->
        <section>
            <h2 class="text-base sm:text-lg font-black text-gray-900 mb-3 flex items-center gap-2">
                <span class="text-teal-700 font-mono">6.</span> Data Protection & Grievance Officer
            </h2>
            <p class="text-gray-600 mb-4">
                In compliance with the Information Technology Act 2000 and DPDP Act 2023, the details of our Grievance Officer are provided below:
            </p>
            <div class="p-5 bg-gray-50 rounded-2xl border border-gray-100">
                <p class="font-bold text-gray-900">Grievance & Privacy Redressal Officer</p>
                <p class="text-xs text-gray-600 mt-1"><strong>Company:</strong> {{ \App\Models\Setting::get('company_legal_name', 'Av Wellcare Lifetech Pvt. Ltd.') }}</p>
                <p class="text-xs text-gray-600"><strong>Address:</strong> {{ \App\Models\Setting::get('registered_address', 'H-21, 2nd Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301') }}</p>
                <p class="text-xs text-gray-600"><strong>Email:</strong> <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'care@avwellcarediagnostics.com') }}" class="text-teal-700 font-bold underline">{{ \App\Models\Setting::get('contact_email', 'care@avwellcarediagnostics.com') }}</a></p>
                <p class="text-xs text-gray-600"><strong>Response Window:</strong> All grievances are acknowledged within 24 hours and addressed within 15 business days.</p>
            </div>
        </section>
    </div>
</div>
@endsection
