@extends('frontend.layouts.app')

@section('title', 'Franchise Opportunity - Open a Diagnostic Collection Centre | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-amber-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-teal-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Franchise Opportunity</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-400/20 text-amber-300 border border-amber-400/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-store text-amber-400"></i> High ROI Healthcare Venture
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                Start Your Own Diagnostic Collection Centre (DCC)
            </h1>
            <p class="text-gray-200 text-sm sm:text-base leading-relaxed mb-6 font-normal">
                Join India's fastest-growing diagnostic network. Partner with Av Wellcare Diagnostics as a franchise owner to serve your neighborhood with 3,600+ lab tests with low upfront capital and high recurring returns.
            </p>

            <div class="flex flex-wrap gap-4 text-xs font-semibold">
                <a href="#franchise-form" class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-slate-950 font-black rounded-xl transition shadow-lg flex items-center gap-2">
                    Apply for Franchise <i class="fas fa-arrow-down"></i>
                </a>
                <div class="px-3.5 py-3 rounded-xl bg-white/10 border border-white/10 flex items-center gap-2 text-teal-100">
                    <i class="fas fa-chart-line text-amber-400"></i> Projected Break-even: 3 to 6 Months
                </div>
            </div>
        </div>
    </div>

    <!-- Franchise Highlights Grid -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6 mb-16">
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-indian-rupee-sign"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 font-mono mb-1">₹2.5L - ₹4L</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Low Initial Setup</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-ruler-combined"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 font-mono mb-1">150 - 250 sq.ft</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Compact Space Needed</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-percent"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 font-mono mb-1">Up to 45%</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Gross Operating Margins</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 mx-auto flex items-center justify-center text-xl mb-3">
                <i class="fas fa-truck-fast"></i>
            </div>
            <div class="text-2xl sm:text-3xl font-black text-gray-900 font-mono mb-1">Daily Pickup</div>
            <p class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Automated Cold Logistics</p>
        </div>
    </div>

    <!-- What Av Wellcare Provides -->
    <div class="mb-16">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <span class="text-xs font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200 inline-block mb-3">Comprehensive Franchise Support</span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Everything You Need to Run a Thriving Diagnostic Hub
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-2">
                We handle the heavy laboratory processing, quality diagnostic compliance, pathologist reporting, and logistics, letting you focus on local customer care.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-laptop-medical"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base mb-2">Cloud LIS Billing & Patient Software</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Zero software subscription cost. Instant patient registration, barcode generation, automated SMS report dispatch, and real-time revenue accounting.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base mb-2">Phlebotomy Training & Certification</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    We train your collection staff in sterile vacutainer venipuncture, centrifuge operation, cold chain preservation, and pediatric handling standards.
                </p>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-700 flex items-center justify-center text-xl mb-4">
                    <i class="fas fa-bullhorn"></i>
                </div>
                <h4 class="font-bold text-gray-900 text-base mb-2">Marketing & Local Launch Collateral</h4>
                <p class="text-xs text-gray-600 leading-relaxed">
                    Exterior glow-signage design, standardized interior clinic branding, promotional camp flyers, doctor referral pads, and local Google My Business setup.
                </p>
            </div>
        </div>
    </div>

    <!-- Onboarding Timeline / 4-Step Process -->
    <div class="bg-white rounded-3xl p-8 sm:p-10 border border-gray-100 shadow-sm mb-16">
        <h3 class="text-xl font-black text-gray-900 mb-8 text-center">4 Simple Steps to Launch Your Diagnostic Centre</h3>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 relative">
                <div class="w-8 h-8 rounded-full bg-teal-700 text-white font-black text-xs flex items-center justify-center mb-3">1</div>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Apply Online</h4>
                <p class="text-xs text-gray-500">Submit your site location, city, and floor space details.</p>
            </div>
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 relative">
                <div class="w-8 h-8 rounded-full bg-teal-700 text-white font-black text-xs flex items-center justify-center mb-3">2</div>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Site Feasibility</h4>
                <p class="text-xs text-gray-500">Our area sales manager conducts a catchment area and footfall assessment.</p>
            </div>
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 relative">
                <div class="w-8 h-8 rounded-full bg-teal-700 text-white font-black text-xs flex items-center justify-center mb-3">3</div>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Fit-out & Training</h4>
                <p class="text-xs text-gray-500">Interior setup, branding installation, centrifuge commissioning, and staff training.</p>
            </div>
            <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100 relative">
                <div class="w-8 h-8 rounded-full bg-emerald-600 text-white font-black text-xs flex items-center justify-center mb-3">4</div>
                <h4 class="font-bold text-sm text-gray-900 mb-1">Grand Opening</h4>
                <p class="text-xs text-gray-500">Inauguration camp, local marketing activation, and commencement of sample intake.</p>
            </div>
        </div>
    </div>

    <!-- Franchise Application Form -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-12 mb-16" id="franchise-form">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <span class="text-xs font-extrabold uppercase tracking-wider text-amber-700 bg-amber-50 px-3 py-1 rounded-full border border-amber-200 inline-block mb-3">Franchise Desk</span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900">
                    Apply for Franchise Partnership
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-2">
                    Submit your application below. Our franchise onboarding team will contact you within 24 hours.
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
                <input type="hidden" name="subject" value="Franchise Opportunity Application">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Applicant Full Name *</label>
                        <input type="text" name="name" required placeholder="Your full name"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Mobile / WhatsApp Number *</label>
                        <input type="tel" name="phone" required placeholder="10-digit mobile number"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Email Address *</label>
                        <input type="email" name="email" required placeholder="your.email@example.com"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Proposed City & Pincode *</label>
                        <input type="text" name="city_pincode" required placeholder="e.g. Patna, 800001 or Noida, 201301"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Commercial Space Available</label>
                        <select name="space_available" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                            <option value="150-250 sq.ft (Owned)">150 - 250 sq.ft (Owned)</option>
                            <option value="150-250 sq.ft (Rented)">150 - 250 sq.ft (Rented)</option>
                            <option value="Above 250 sq.ft">Above 250 sq.ft</option>
                            <option value="Looking for premises currently">Looking for premises currently</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Ready Investment Budget</label>
                        <select name="investment_budget" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition">
                            <option value="₹2.5 Lakhs - ₹4 Lakhs">₹2.5 Lakhs - ₹4 Lakhs</option>
                            <option value="₹4 Lakhs - ₹7 Lakhs">₹4 Lakhs - ₹7 Lakhs</option>
                            <option value="Above ₹7 Lakhs">Above ₹7 Lakhs (Multiple Units)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Prior Healthcare / Business Experience *</label>
                    <textarea name="message" rows="3" required minlength="5" placeholder="Briefly describe your background (e.g. pharmacist, lab technician, distributor, or business entrepreneur)..."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-amber-500 focus:bg-white transition"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 bg-amber-500 hover:bg-amber-400 text-slate-950 font-black text-xs uppercase tracking-wider rounded-xl transition shadow-md">
                    Submit Franchise Application
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
