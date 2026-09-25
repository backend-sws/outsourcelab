@extends('frontend.layouts.app')

@section('title', 'Online Pharmacy - Genuine Medicines & Doorstep Delivery | Coming Soon | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Glow & Subtle Background Orbs -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/70">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/35 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-emerald-200/30 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 left-1/3 w-80 h-80 bg-indigo-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-7xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Online Pharmacy</span>
    </nav>

    <!-- Main Hero Banner (Coming Soon Showcase) -->
    <div class="relative bg-gradient-to-br from-teal-950 via-slate-900 to-emerald-950 rounded-3xl p-8 sm:p-14 lg:p-16 text-white shadow-2xl overflow-hidden mb-12 border border-teal-800/40">
        <!-- Decorative Background Glows & Medical Patterns -->
        <div class="absolute -top-24 -right-24 w-96 h-96 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-24 -left-24 w-96 h-96 bg-teal-500/15 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute top-1/2 right-12 transform -translate-y-1/2 opacity-5 pointer-events-none hidden lg:block text-[280px] font-black select-none">
            <i class="fas fa-prescription-bottle-alt"></i>
        </div>

        <div class="relative z-10 max-w-3xl space-y-6">
            <!-- Launching Soon Status Pill -->
            <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-gradient-to-r from-emerald-500/20 via-teal-500/20 to-amber-500/20 text-emerald-300 border border-emerald-500/30 text-xs font-extrabold uppercase tracking-widest shadow-inner">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                <i class="fas fa-rocket text-amber-400"></i>
                <span>Av Wellcare Pharmacy • Launching Very Soon</span>
            </div>

            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black tracking-tight text-white leading-tight">
                100% Genuine Medicines, <br class="hidden sm:inline">
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-teal-300 via-emerald-300 to-amber-200">
                    Delivered Directly to Your Doorstep.
                </span>
            </h1>

            <p class="text-gray-300 text-sm sm:text-base lg:text-lg leading-relaxed font-medium max-w-2xl">
                We're extending our trusted clinical diagnostic care to pharmaceutical wellness. Soon you can order certified prescription medicines, chronic care refills, healthcare devices, and wellness essentials with cold-chain security.
            </p>

            <!-- Key Feature Badges -->
            <div class="flex flex-wrap gap-3 pt-2 text-xs font-bold text-teal-100">
                <div class="px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 flex items-center gap-2 shadow-xs">
                    <i class="fas fa-certificate text-amber-400"></i> 100% Verified Manufacturers
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 flex items-center gap-2 shadow-xs">
                    <i class="fas fa-temperature-arrow-down text-cyan-300"></i> Cold-Chain Insulin & Vaccines
                </div>
                <div class="px-3.5 py-2 rounded-xl bg-white/10 backdrop-blur-md border border-white/10 flex items-center gap-2 shadow-xs">
                    <i class="fas fa-motorcycle text-emerald-300"></i> Express Home Delivery
                </div>
            </div>

            <!-- Get Notified on Launch Card -->
            <div class="pt-4 max-w-xl">
                <div class="p-4 sm:p-5 rounded-2xl bg-white/10 backdrop-blur-md border border-white/15 shadow-lg space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-extrabold uppercase tracking-wider text-teal-200 flex items-center gap-1.5">
                            <i class="fas fa-bell text-amber-400"></i>
                            <span>Get Notified on Launch & Get Flat 20% OFF</span>
                        </span>
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-amber-400/20 text-amber-300 border border-amber-400/30">VIP Benefit</span>
                    </div>

                    <form id="pharmacyNotifyForm" onsubmit="handleNotifySubmit(event)" class="flex flex-col sm:flex-row gap-2">
                        <input 
                            type="text" 
                            id="notifyInput" 
                            required 
                            placeholder="Enter Mobile Number or Email ID" 
                            class="flex-1 px-4 py-2.5 rounded-xl bg-slate-900/80 border border-teal-500/40 text-white placeholder-gray-400 text-xs font-bold outline-none focus:ring-2 focus:ring-emerald-400 transition"
                        >
                        <button 
                            type="submit" 
                            id="notifyBtn" 
                            class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-emerald-500 to-teal-600 hover:from-emerald-600 hover:to-teal-700 text-white font-black text-xs transition shadow-md flex items-center justify-center gap-1.5 whitespace-nowrap cursor-pointer"
                        >
                            <i class="fas fa-paper-plane text-[11px]"></i>
                            <span>Notify Me</span>
                        </button>
                    </form>

                    <p id="notifySuccessMsg" class="hidden text-xs font-bold text-emerald-300 flex items-center gap-1.5">
                        <i class="fas fa-check-circle text-emerald-400"></i>
                        <span>Thank you! We've noted your interest and will send you an exclusive early access pass.</span>
                    </p>
                </div>
            </div>

        </div>
    </div>

    <!-- Feature Pillars Section -->
    <div class="space-y-6 mb-16">
        <div class="text-center max-w-2xl mx-auto space-y-2">
            <span class="text-xs font-black uppercase tracking-widest text-teal-800 bg-teal-50 px-3 py-1 rounded-full border border-teal-200">
                What to Expect
            </span>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                Healthcare Convenience Tailored for You
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 font-medium">
                Bringing the same uncompromised accuracy and care you experience with our lab diagnostics directly to your pharmaceutical needs.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 hover:border-teal-400 shadow-sm hover:shadow-md transition duration-200 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-teal-50 text-teal-800 flex items-center justify-center text-xl font-bold border border-teal-200 shadow-2xs">
                    <i class="fas fa-prescription"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">Upload Doctor's Slip</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Simply take a photo of your doctor's handwritten or digital prescription. Our licensed pharmacists will digitize, verify dosage, and prepare your cart in minutes.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-teal-700">
                        <i class="fas fa-check text-[10px]"></i> Zero Hassle Re-ordering
                    </span>
                </div>
            </div>

            <!-- Card 2 -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 hover:border-emerald-400 shadow-sm hover:shadow-md transition duration-200 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-700 flex items-center justify-center text-xl font-bold border border-emerald-200 shadow-2xs">
                    <i class="fas fa-shield-halved"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">100% Authentic Medicines</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Strict sourcing directly from certified pharmaceutical companies. Every single batch is tracked with genuine barcode stamps, eliminating any counterfeit risks.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-emerald-700">
                        <i class="fas fa-check text-[10px]"></i> Batch-Level Verification
                    </span>
                </div>
            </div>

            <!-- Card 3 -->
            <div class="bg-white rounded-3xl p-6 sm:p-7 border border-slate-200 hover:border-indigo-400 shadow-sm hover:shadow-md transition duration-200 space-y-4">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-700 flex items-center justify-center text-xl font-bold border border-indigo-200 shadow-2xs">
                    <i class="fas fa-truck-fast"></i>
                </div>
                <h3 class="text-lg font-black text-slate-900">Safe & Rapid Delivery</h3>
                <p class="text-xs text-slate-600 leading-relaxed font-medium">
                    Equipped with specialized cold-pack thermal insulated boxes for insulin, hormonal injections, and eye drops. Real-time GPS tracking from the dispensary to your door.
                </p>
                <div class="pt-2">
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold text-indigo-700">
                        <i class="fas fa-check text-[10px]"></i> 2°C - 8°C Cold Chain Assurance
                    </span>
                </div>
            </div>
        </div>
    </div>

    <!-- Need Diagnostics Today? Quick Action Banner -->
    <div class="bg-gradient-to-r from-teal-900 to-slate-900 rounded-3xl p-6 sm:p-10 text-white flex flex-col md:flex-row items-center justify-between gap-6 shadow-xl border border-teal-800">
        <div class="space-y-2 text-center md:text-left">
            <h3 class="text-xl sm:text-2xl font-black text-white">Need Blood Tests or Health Checkups Today?</h3>
            <p class="text-xs sm:text-sm text-teal-100/80 font-medium max-w-xl">
                Our certified phlebotomists are available across your city for safe home sample collection with fast digital reports.
            </p>
        </div>
        <div class="flex items-center gap-3 flex-wrap justify-center">
            <a href="/" class="px-5 py-3 rounded-xl bg-white text-teal-900 hover:bg-teal-50 font-black text-xs transition shadow-md flex items-center gap-2">
                <i class="fas fa-flask text-teal-700"></i>
                <span>Explore Lab Tests</span>
            </a>
            <a href="{{ route('patient.prescriptions') }}" class="px-5 py-3 rounded-xl bg-teal-800 hover:bg-teal-700 border border-teal-700 text-white font-black text-xs transition shadow-md flex items-center gap-2">
                <i class="fas fa-file-medical"></i>
                <span>Upload Doctor Slip</span>
            </a>
        </div>
    </div>
</div>

<script>
    function handleNotifySubmit(e) {
        e.preventDefault();
        const input = document.getElementById('notifyInput');
        const btn = document.getElementById('notifyBtn');
        const msg = document.getElementById('notifySuccessMsg');

        if (!input.value.trim()) return;

        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Submitting...';

        setTimeout(() => {
            btn.classList.add('hidden');
            input.disabled = true;
            msg.classList.remove('hidden');
        }, 600);
    }
</script>
@endsection
