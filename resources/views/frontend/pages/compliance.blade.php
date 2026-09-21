@extends('frontend.layouts.app')

@section('title', 'Statutory Compliance & Bio-Medical Waste Disclosures | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-slate-200/40 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Statutory Compliance</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-14 text-white shadow-2xl relative overflow-hidden mb-12">
        <div class="absolute top-0 right-0 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>

        <div class="relative z-10 max-w-3xl">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-scale-balanced text-amber-400"></i> Regulatory Mandate & Transparency
            </span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white leading-tight mb-4">
                Statutory Compliances & Environmental Safety
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm leading-relaxed mb-6 font-normal">
                Av Wellcare Diagnostics strictly adheres to all statutory norms established by the Ministry of Health and Family Welfare (MoHFW), the Central Pollution Control Board (CPCB), the Atomic Energy Regulatory Board (AERB), and state regulatory agencies.
            </p>

            <div class="flex flex-wrap gap-3 text-xs font-semibold">
                <div class="px-3 py-1.5 bg-white/10 rounded-lg border border-white/10 text-teal-200">
                    <i class="fas fa-check text-emerald-400 mr-1"></i> BMWM Rules 2016 Compliant
                </div>
                <div class="px-3 py-1.5 bg-white/10 rounded-lg border border-white/10 text-teal-200">
                    <i class="fas fa-check text-emerald-400 mr-1"></i> PCPNDT Act Strictly Enforced
                </div>
                <div class="px-3 py-1.5 bg-white/10 rounded-lg border border-white/10 text-teal-200">
                    <i class="fas fa-check text-emerald-400 mr-1"></i> AERB Shielding Clearances
                </div>
            </div>
        </div>
    </div>

    <!-- Corporate Registration & Entity Data -->
    <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm mb-12">
        <h2 class="text-lg font-black text-gray-900 mb-6 flex items-center gap-2">
            <i class="fas fa-building-columns text-teal-700"></i> Corporate & Legal Registration Information
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 text-xs">
            <div class="p-4 bg-gray-50 rounded-2xl">
                <span class="text-gray-400 uppercase font-bold text-[10px] block mb-1">Company Legal Name</span>
                <strong class="text-gray-900 text-sm">{{ \App\Models\Setting::get('company_legal_name', 'Av Wellcare Lifetech Pvt. Ltd.') }}</strong>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl">
                <span class="text-gray-400 uppercase font-bold text-[10px] block mb-1">Corporate Identity Number (CIN)</span>
                <strong class="text-gray-900 text-sm font-mono">{{ \App\Models\Setting::get('cin_number', 'U85190UP2021PTC149892') }}</strong>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl">
                <span class="text-gray-400 uppercase font-bold text-[10px] block mb-1">Authorized Supervisory Authority</span>
                <strong class="text-gray-900 text-sm">Registrar of Companies (ROC Kanpur, UP)</strong>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl sm:col-span-2">
                <span class="text-gray-400 uppercase font-bold text-[10px] block mb-1">Registered Corporate Office</span>
                <span class="text-gray-700 font-semibold">{{ \App\Models\Setting::get('registered_address', 'H-21, 2nd Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301') }}</span>
            </div>

            <div class="p-4 bg-gray-50 rounded-2xl">
                <span class="text-gray-400 uppercase font-bold text-[10px] block mb-1">National Reference Facility</span>
                <span class="text-gray-700 font-semibold">{{ \App\Models\Setting::get('reference_lab_address', 'H-21, 4th Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301') }}</span>
            </div>
        </div>
    </div>

    <!-- Statutory Declarations -->
    <div class="space-y-6 mb-12">
        <!-- Bio-Medical Waste Management (BMWM) -->
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-lg">
                    <i class="fas fa-biohazard"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900">1. Bio-Medical Waste Management (BMWM) Rules, 2016 Disclosures</h3>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed mb-4">
                In strict compliance with Rule 13 of the Bio-Medical Waste Management Rules 2016, all human physiological samples, sharps, consumables, and infectious reagents generated across our laboratory premises are segregated at point of origin in barcoded, color-coded receptacles (Yellow, Red, White translucent, Blue) and handed over exclusively to state pollution control board (SPCB) authorized Common Bio-Medical Waste Treatment Facilities (CBWTF) for incineration and autoclaving.
            </p>
            <div class="overflow-x-auto">
                <table class="w-full text-xs text-left text-gray-600 border border-gray-100 rounded-xl overflow-hidden">
                    <thead class="bg-gray-50 text-gray-900 font-bold uppercase text-[10px]">
                        <tr>
                            <th class="p-3 border-b">Category / Color</th>
                            <th class="p-3 border-b">Type of Waste Material</th>
                            <th class="p-3 border-b">Treatment & Disposal Route</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <tr>
                            <td class="p-3 font-bold text-amber-600">Yellow Receptacle</td>
                            <td class="p-3">Infectious swabs, cotton, expired clinical specimens</td>
                            <td class="p-3">Authorized Incineration / Plasma Pyrolysis</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-bold text-rose-600">Red Receptacle</td>
                            <td class="p-3">Contaminated plastic vacutainers, pipette tips, tubing</td>
                            <td class="p-3">Autoclaving / Shredding & Plastic Recycling</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-bold text-slate-600">White Translucent</td>
                            <td class="p-3">Needles, scalpels, sharps (puncture-proof box)</td>
                            <td class="p-3">Dry heat sterilization / Sharp pit disposal</td>
                        </tr>
                        <tr>
                            <td class="p-3 font-bold text-blue-600">Blue Box</td>
                            <td class="p-3">Broken reagent glass vials, ampoules, glass slides</td>
                            <td class="p-3">Disinfection (Sodium hypochlorite) & Autoclave</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- PCPNDT Declaration -->
        <div class="bg-white rounded-3xl p-8 border border-rose-100 shadow-sm bg-gradient-to-r from-white to-rose-50/20">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-lg">
                    <i class="fas fa-person-dress text-rose-500"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900">2. PCPNDT Act Statutory Public Declaration</h3>
            </div>
            <div class="p-4 bg-rose-50 border border-rose-200 rounded-2xl text-xs text-rose-900 font-semibold leading-relaxed mb-4">
                <strong>STATUTORY PROHIBITION NOTICE:</strong> Under the Pre-Conception and Pre-Natal Diagnostic Techniques (Prohibition of Sex Selection) Act, 1994 (PCPNDT Act), prenatal sex determination or disclosing the sex of the fetus in any form by ultrasound or genetic diagnostic methods is illegal, strictly forbidden, and punishable under the law with imprisonment and financial penalties.
            </div>
            <p class="text-xs text-gray-600 leading-relaxed">
                Av Wellcare Diagnostics upholds zero tolerance toward sex determination. Our diagnostic procedures and maternal screenings comply fully with Section 4(3) of the Act.
            </p>
        </div>

        <!-- Quality Control / EQAS Programs -->
        <div class="bg-white rounded-3xl p-8 border border-gray-100 shadow-sm">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center text-lg">
                    <i class="fas fa-certificate"></i>
                </div>
                <h3 class="text-lg font-black text-gray-900">3. External Quality Assessment Schemes (EQAS)</h3>
            </div>
            <p class="text-xs text-gray-600 leading-relaxed mb-4">
                To guarantee uncompromised analytical veracity, our laboratory participates in continuous external blind peer assessment schemes:
            </p>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <strong class="text-teal-800 block mb-1">CMC Vellore EQAS Program</strong>
                    <span class="text-gray-600">Monthly blind serum evaluations covering clinical biochemistry, electrolytes, and immunoassays.</span>
                </div>
                <div class="p-4 rounded-xl bg-gray-50 border border-gray-100">
                    <strong class="text-teal-800 block mb-1">Bio-Rad Unity Real-Time Inter-Lab Program</strong>
                    <span class="text-gray-600">Daily multi-rule Levey-Jennings control monitoring comparing our analyzer variances against thousands of global labs.</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Nodal Compliance Officer Contact -->
    <div class="bg-slate-900 text-white rounded-3xl p-8 flex flex-col sm:flex-row items-center justify-between gap-6 mb-16">
        <div>
            <span class="text-[10px] font-bold uppercase tracking-wider text-teal-400 block mb-1">Statutory Redressal</span>
            <h4 class="text-base sm:text-lg font-black text-white mb-1">Nodal Compliance & Grievance Desk</h4>
            <p class="text-xs text-gray-400">For statutory inquiries, regulatory verification, or bio-waste audit logs, contact our legal secretariat.</p>
        </div>
        <div class="text-right flex-shrink-0">
            <a href="mailto:{{ \App\Models\Setting::get('contact_email', 'care@avwellcarediagnostics.com') }}" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs rounded-xl inline-block transition">
                <i class="fas fa-envelope mr-1.5"></i> legal@avwellcarediagnostics.com
            </a>
        </div>
    </div>
</div>
@endsection
