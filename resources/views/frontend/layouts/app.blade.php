<!DOCTYPE html>
<html lang="en" class="overflow-x-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ \App\Models\Setting::get('site_name', 'Av Wellcare Diagnostics') }} - {{ \App\Models\Setting::get('site_tagline', 'Fast, Reliable Diagnostics') }}</title>
    @include('frontend.partials.style')
</head>
<body class="bg-gray-50 text-gray-800 m-0 p-0 overflow-x-hidden w-full max-w-full">
    @if(session('impersonated_by_admin'))
    <!-- Super Admin Impersonation Top Banner -->
    <div class="bg-gradient-to-r from-amber-600 via-orange-600 to-rose-600 text-white px-4 py-2.5 shadow-md sticky top-0 z-[9999] border-b border-white/20">
        <div class="container mx-auto flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-2.5">
                <span class="flex h-2.5 w-2.5 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-white opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-white"></span>
                </span>
                <div class="text-xs sm:text-sm font-medium">
                    <span class="font-black uppercase tracking-wider bg-black/25 px-2 py-0.5 rounded text-[11px] mr-1">Admin Full Access Mode</span>
                    Managing account of <strong class="underline decoration-white/60 underline-offset-2">{{ session('impersonated_patient_name') ?? 'Patient #' . session('patient_id') }}</strong>
                    — you can edit profile, bookings, addresses, and medical records.
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('patient.exit_impersonate') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white text-orange-950 hover:bg-orange-50 font-bold text-xs shadow-sm transition-all hover:scale-105">
                    <i class="fas fa-arrow-left text-xs"></i>
                    <span>Exit & Return to Admin Panel</span>
                </a>
            </div>
        </div>
    </div>
    @endif

    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')
    
    @include('frontend.partials.modals.login')
    @include('frontend.partials.modals.prescription')
    @include('patient.modals.add-member')
    @include('patient.modals.change-address')
    @include('patient.modals.add-address')
    @include('patient.modals.modify-booking')
    
    @include('frontend.partials.floating-welcome-ticket')
    @include('frontend.partials.floating-video')

    @include('frontend.partials.scripts')
</body>
</html>