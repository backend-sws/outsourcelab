@extends('frontend.layouts.app')

@section('title', 'Careers at Av Wellcare Diagnostics - Join Our Healthcare Team')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-purple-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Careers</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-96 h-96 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-purple-500/15 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-briefcase text-amber-400"></i> Build Your Healthcare Career
            </span>
            <h1 class="text-3xl sm:text-5xl font-black tracking-tight text-white leading-tight mb-5">
                Work With Purpose. Impact Millions of Lives.
            </h1>
            <p class="text-gray-200 text-sm sm:text-base leading-relaxed mb-6 font-normal">
                Join a dynamic team of clinical pathologists, molecular scientists, phlebotomists, and digital health innovators dedicated to transforming preventative diagnosis across India.
            </p>

            <div class="flex flex-wrap gap-4 text-xs font-semibold">
                <a href="#open-positions" class="px-6 py-3 bg-brand-secondary hover:bg-emerald-500 text-brand-dark font-black rounded-xl transition shadow-lg flex items-center gap-2">
                    View Open Roles <i class="fas fa-arrow-down"></i>
                </a>
                <a href="#apply-form" class="px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-bold rounded-xl transition border border-white/20 flex items-center gap-2">
                    Drop Your Resume <i class="fas fa-file-arrow-up"></i>
                </a>
            </div>
        </div>
    </div>

    <!-- Why Join Us Pillars -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-16">
        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-700 mx-auto flex items-center justify-center text-xl mb-4">
                <i class="fas fa-microscope"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1">State-of-the-Art Tech</h3>
            <p class="text-xs text-gray-500">Operate on gold-standard automated analyzers (Roche, Sysmex, Bio-Rad HPLC).</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 mx-auto flex items-center justify-center text-xl mb-4">
                <i class="fas fa-seedling"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1">Accelerated Growth</h3>
            <p class="text-xs text-gray-500">Fast-track promotional cycles with ongoing training and skill certifications.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 mx-auto flex items-center justify-center text-xl mb-4">
                <i class="fas fa-heart-pulse"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1">Health & Wellness</h3>
            <p class="text-xs text-gray-500">Comprehensive health insurance coverage and annual screenings for you and family.</p>
        </div>

        <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center">
            <div class="w-12 h-12 rounded-2xl bg-purple-50 text-purple-700 mx-auto flex items-center justify-center text-xl mb-4">
                <i class="fas fa-award"></i>
            </div>
            <h3 class="font-bold text-gray-900 text-sm mb-1">Meritocracy</h3>
            <p class="text-xs text-gray-500">Transparent incentive structures, spot bonuses, and quality excellence awards.</p>
        </div>
    </div>

    <!-- Open Positions Section -->
    <div class="mb-16" id="open-positions">
        <div class="max-w-2xl mb-8">
            <span class="text-xs font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200 inline-block mb-3">Opportunities</span>
            <h2 class="text-2xl sm:text-3xl font-black text-gray-900 tracking-tight">
                Current Openings
            </h2>
            <p class="text-xs sm:text-sm text-gray-500 mt-1">
                Explore open vacancies across our national reference lab, regional centres, and field phlebotomy teams.
            </p>
        </div>

        <div class="space-y-4">
            <!-- Job 1 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:shadow-sm transition">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-teal-50 text-teal-800 border border-teal-200">Clinical Pathology</span>
                        <span class="text-xs text-gray-400">&bull; Full Time</span>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Consultant Pathologist (MD / DNB Pathology)</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-location-dot text-gray-400 mr-1"></i> National Reference Lab, Noida & Satellite Hubs &nbsp;|&nbsp; 
                        <i class="fas fa-briefcase text-gray-400 mr-1"></i> 2 - 6 Years Experience
                    </p>
                </div>
                <a href="#apply-form" onclick="selectRole('Consultant Pathologist')" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl transition shadow flex-shrink-0">
                    Apply Now
                </a>
            </div>

            <!-- Job 2 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:shadow-sm transition">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-blue-50 text-blue-800 border border-blue-200">Lab Operations</span>
                        <span class="text-xs text-gray-400">&bull; Full Time</span>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Senior Medical Laboratory Technologist (MLT / BMLT)</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-location-dot text-gray-400 mr-1"></i> Central Lab, Sector 63, Noida &nbsp;|&nbsp; 
                        <i class="fas fa-briefcase text-gray-400 mr-1"></i> 1 - 4 Years Experience
                    </p>
                </div>
                <a href="#apply-form" onclick="selectRole('Senior Medical Lab Technologist')" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl transition shadow flex-shrink-0">
                    Apply Now
                </a>
            </div>

            <!-- Job 3 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:shadow-sm transition">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-800 border border-amber-200">Home Care</span>
                        <span class="text-xs text-gray-400">&bull; Multiple Openings</span>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Phlebotomist / Home Sample Collection Executive</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-location-dot text-gray-400 mr-1"></i> Delhi NCR, Patna, Lucknow, Varanasi & Multiple Cities &nbsp;|&nbsp; 
                        <i class="fas fa-briefcase text-gray-400 mr-1"></i> 0 - 3 Years (Fresher DMLT Welcome)
                    </p>
                </div>
                <a href="#apply-form" onclick="selectRole('Phlebotomist / Home Collection Executive')" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl transition shadow flex-shrink-0">
                    Apply Now
                </a>
            </div>

            <!-- Job 4 -->
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-xs flex flex-col md:flex-row items-start md:items-center justify-between gap-4 hover:shadow-sm transition">
                <div>
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-purple-50 text-purple-800 border border-purple-200">Sales & Growth</span>
                        <span class="text-xs text-gray-400">&bull; Full Time</span>
                    </div>
                    <h3 class="text-base font-bold text-gray-900">Area Sales Manager - Doctor & Hospital Ties</h3>
                    <p class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-location-dot text-gray-400 mr-1"></i> Delhi NCR / Western UP / Bihar &nbsp;|&nbsp; 
                        <i class="fas fa-briefcase text-gray-400 mr-1"></i> 2 - 5 Years Diagnostic Sales
                    </p>
                </div>
                <a href="#apply-form" onclick="selectRole('Area Sales Manager')" class="px-5 py-2 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl transition shadow flex-shrink-0">
                    Apply Now
                </a>
            </div>
        </div>
    </div>

    <!-- Career Application Form -->
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-12 mb-16" id="apply-form">
        <div class="max-w-2xl mx-auto">
            <div class="text-center mb-8">
                <span class="text-xs font-extrabold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-full border border-teal-200 inline-block mb-3">Careers Portal</span>
                <h2 class="text-2xl sm:text-3xl font-black text-gray-900">
                    Submit Your Application
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 mt-2">
                    Our Human Resources department reviews every application carefully and connects within 48 hours for shortlisted candidates.
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
                <input type="hidden" name="subject" value="Job Application">

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Full Name *</label>
                        <input type="text" name="name" required placeholder="Candidate's full name"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Mobile Number *</label>
                        <input type="tel" name="phone" required placeholder="10-digit mobile number"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Email Address *</label>
                        <input type="email" name="email" required placeholder="your.email@example.com"
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Role Applied For *</label>
                        <select name="role_applied" id="roleAppliedSelect" required
                                class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                            <option value="Consultant Pathologist">Consultant Pathologist (MD / DNB)</option>
                            <option value="Senior Medical Lab Technologist">Senior Medical Lab Technologist (MLT)</option>
                            <option value="Phlebotomist / Home Collection Executive">Phlebotomist / Home Collection Executive</option>
                            <option value="Area Sales Manager">Area Sales Manager (B2B Healthcare)</option>
                            <option value="Customer Support Executive">Customer Care / Patient Concierge</option>
                            <option value="Other Medical Role">Other Medical / Operations Role</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Current City / Location *</label>
                        <input type="text" name="city" required placeholder="e.g. Noida, Delhi, Patna, etc."
                               class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1">Total Experience</label>
                        <select name="experience" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                            <option value="Fresher (< 1 year)">Fresher (&lt; 1 year)</option>
                            <option value="1 - 3 Years">1 - 3 Years</option>
                            <option value="3 - 6 Years">3 - 6 Years</option>
                            <option value="6+ Years">6+ Years</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">LinkedIn Profile or Google Drive Resume Link</label>
                    <input type="url" name="resume_url" placeholder="https://linkedin.com/in/... or drive link"
                           class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition">
                </div>

                <div>
                    <label class="block text-xs font-bold text-gray-700 mb-1">Summary of Qualifications / Experience *</label>
                    <textarea name="message" rows="3" required minlength="5" placeholder="Describe your educational degrees (DMLT, BMLT, MD, etc.), current employer, and notice period..."
                              class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-xs font-semibold focus:outline-none focus:ring-2 focus:ring-teal-500 focus:bg-white transition"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs uppercase tracking-wider rounded-xl transition shadow-md">
                    Submit Job Application
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    function selectRole(role) {
        const select = document.getElementById('roleAppliedSelect');
        if (select) {
            for (let i = 0; i < select.options.length; i++) {
                if (select.options[i].value.includes(role) || role.includes(select.options[i].value)) {
                    select.selectedIndex = i;
                    break;
                }
            }
        }
    }
</script>
@endsection
