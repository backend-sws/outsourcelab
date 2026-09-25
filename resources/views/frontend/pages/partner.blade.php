@extends('frontend.layouts.app')

@section('title', 'Partner With Us - Doctors, Corporates & Hospitals | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-blue-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Partner With Us</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-brand-secondary/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-handshake text-amber-400"></i> Strategic Healthcare Alliances
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                Elevate Clinical Accuracy & Patient Wellness Together
            </h1>
            <p class="text-gray-200 text-sm sm:text-base leading-relaxed mb-6 font-normal">
                Partner with Av Wellcare Diagnostics to leverage our high-throughput central reference labs, robotic automation, and pan-India cold-chain logistics for doctors, hospitals, and corporate workforces.
            </p>

            <div class="flex flex-wrap gap-4 text-xs font-semibold">
                <a href="#partner-form" class="px-6 py-3 bg-brand-secondary hover:bg-emerald-500 text-brand-dark font-black rounded-xl transition shadow-lg flex items-center gap-2">
                    Submit Partnership Enquiry <i class="fas fa-arrow-down"></i>
                </a>
                <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('helpline_primary', '8988988787')) }}" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition border border-white/20 flex items-center gap-2">
                    <i class="fas fa-phone-alt text-amber-400"></i> Speak to Partnership Head
                </a>
            </div>
        </div>
    </div>

    <!-- Partnership Tracks -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-16">
        <!-- Track 1: Doctors & Clinics -->
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-teal-50 text-teal-700 flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-user-doctor"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-3">Doctors & Clinicians</h3>
                <p class="text-xs text-gray-600 leading-relaxed mb-6">
                    Empowering medical practitioners with reproducible analytical precision, rapid critical alerts, and dedicated pathologist consultations for complex cases.
                </p>
                <ul class="space-y-3 text-xs text-gray-700 mb-6">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-teal-600"></i> Instant critical value SMS/WhatsApp alert
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-teal-600"></i> Second-opinion tele-pathology support
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-teal-600"></i> Access to rare & esoteric biomarker tests
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-teal-600"></i> Home sample phlebotomy for elderly patients
                    </li>
                </ul>
            </div>
            <a href="#partner-form" onclick="selectPartnerType('Doctor / Clinic')" class="w-full py-2.5 px-4 bg-teal-50 hover:bg-teal-100 text-teal-800 text-xs font-bold rounded-xl text-center transition">
                Doctor Collaboration &rarr;
            </a>
        </div>

        <!-- Track 2: Corporates & Employers -->
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-building"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-3">Corporate Wellness</h3>
                <p class="text-xs text-gray-600 leading-relaxed mb-6">
                    Preventive employee checkups, on-site wellness camps, pre-employment medical checks, and executive health analytics to boost workforce vitality.
                </p>
                <ul class="space-y-3 text-xs text-gray-700 mb-6">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-blue-600"></i> Turnkey on-premise sample collection camps
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-blue-600"></i> Anonymized workforce aggregate health risk dashboard
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-blue-600"></i> Flexible employee subsidy / corporate billing
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-blue-600"></i> Pan-India coverage for distributed remote teams
                    </li>
                </ul>
            </div>
            <a href="#partner-form" onclick="selectPartnerType('Corporate Wellness')" class="w-full py-2.5 px-4 bg-blue-50 hover:bg-blue-100 text-blue-800 text-xs font-bold rounded-xl text-center transition">
                Corporate Tie-Up &rarr;
            </a>
        </div>

        <!-- Track 3: Hospitals & Nursing Homes -->
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm flex flex-col justify-between hover:shadow-md transition">
            <div>
                <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-2xl mb-6">
                    <i class="fas fa-hospital"></i>
                </div>
                <h3 class="text-xl font-black text-gray-900 mb-3">Hospitals & Nursing Homes</h3>
                <p class="text-xs text-gray-600 leading-relaxed mb-6">
                    Outsource laboratory operations or esoteric testing to cut equipment capex and maintenance overheads while retaining rapid emergency turnarounds.
                </p>
                <ul class="space-y-3 text-xs text-gray-700 mb-6">
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-600"></i> Zero equipment Capex / Opex liability
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-600"></i> Bidirectional HL7 / API integration with hospital HIS
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-600"></i> Dedicated dispatch riders for STAT routine samples
                    </li>
                    <li class="flex items-center gap-2">
                        <i class="fas fa-check text-emerald-600"></i> Standard clinical quality validation & audits
                    </li>
                </ul>
            </div>
            <a href="#partner-form" onclick="selectPartnerType('Hospital / Nursing Home')" class="w-full py-2.5 px-4 bg-emerald-50 hover:bg-emerald-100 text-emerald-800 text-xs font-bold rounded-xl text-center transition">
                Hospital Lab Outsourcing &rarr;
            </a>
        </div>
    </div>

    <!-- Partnership Enquiry Form Section -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-12 mb-16" id="partner-form">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <span class="text-xs font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200 inline-block mb-3">Join Our Network</span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900">
                    Get in Touch with our Institutional Desk
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-2">
                    Fill out the partnership form below. Our institutional partnerships director will respond within 4 business hours.
                </p>
            </div>

            @if(session('enquiry_success'))
                <div class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-bold flex items-center gap-2">
                    <i class="fas fa-check-circle text-emerald-600 text-base"></i>
                    {{ session('enquiry_success') }}
                </div>
            @endif

            <form action="{{ route('enquiries.store') }}" method="POST" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Full Name / Contact Person *</label>
                        <input type="text" name="name" required placeholder="Dr. / Mr. / Ms. Full Name"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Phone / Mobile Number *</label>
                        <input type="tel" name="phone" required placeholder="10-digit mobile number"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Work Email *</label>
                        <input type="email" name="email" required placeholder="name@institution.com"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Partnership Category *</label>
                        <select name="subject" id="partnerCategorySelect" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                            <option value="Doctor Collaboration">Doctor / Clinician Collaboration</option>
                            <option value="Corporate Wellness">Corporate Health Screening</option>
                            <option value="Hospital / Nursing Home">Hospital / Lab Outsourcing</option>
                            <option value="Other Institutional Tie-up">Other Institutional Tie-up</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Organization / Clinic Name & City *</label>
                    <input type="text" name="organization" placeholder="e.g. Apex Health Clinic, Noida"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Collaboration Requirements / Notes *</label>
                    <textarea name="message" rows="3" required minlength="5" placeholder="Tell us about your estimated monthly sample volume, workforce size, or specific test panels needed..."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-md">
                    Submit Partnership Request
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function selectPartnerType(type) {
        const select = document.getElementById('partnerCategorySelect');
        if (select) {
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value.includes(type) || type.includes(select.options[i].value)) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }
    }
</script>
@endsection
