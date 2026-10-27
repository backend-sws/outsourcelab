@php
    $patientModel = $profile ?? $patient ?? (session('patient_id') ? \App\Models\Patient::find(session('patient_id')) : null);
    $userName = is_array($patientModel) ? ($patientModel['name'] ?? 'Patient') : ($patientModel?->name ?? 'Patient');
    $userMobile = is_array($patientModel) ? ($patientModel['mobile'] ?? '') : ($patientModel?->mobile ?? '');
    $activeVip = ($patientModel instanceof \App\Models\Patient) ? $patientModel->activeMembership() : null;
@endphp

<div class="w-full md:w-1/3 lg:w-1/4 space-y-3 sm:space-y-4">
    <!-- User Info -->
    <div class="bg-white rounded-xl border border-gray-200 p-3.5 sm:p-4 shadow-sm flex items-center justify-between">
        <div class="flex items-center space-x-3 min-w-0">
            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-blue-50 text-brand-dark rounded-full flex items-center justify-center font-bold text-base sm:text-lg border border-blue-100 flex-shrink-0">
                <i class="far fa-user"></i>
            </div>
            <div class="min-w-0">
                <h4 class="font-extrabold text-brand-dark text-sm sm:text-base truncate {{ (empty($userName) || strtolower($userName) === 'self') ? 'text-rose-600' : '' }}">
                    {{ (!empty($userName) && strtolower($userName) !== 'self') ? $userName : 'Name Missing *' }}
                </h4>
                <p class="text-xs font-medium truncate {{ empty($userMobile) ? 'text-rose-600 font-bold' : 'text-gray-500' }}">
                    {{ !empty($userMobile) ? '+91 ' . $userMobile : 'Phone Missing *' }}
                </p>
            </div>
        </div>
        <div class="flex items-center gap-1.5 flex-shrink-0">
            <a href="{{ route('patient.dashboard') }}#profile-form" 
               id="sidebarEditProfileBtn"
               onclick="if (typeof switchDashboardTab === 'function') { event.preventDefault(); switchDashboardTab('profile'); const el = document.getElementById('profile-form'); if (el) { el.scrollIntoView({ behavior: 'smooth', block: 'start' }); el.classList.add('ring-2', 'ring-brand-secondary', 'ring-offset-2'); setTimeout(() => el.classList.remove('ring-2', 'ring-brand-secondary', 'ring-offset-2'), 1500); } if (history.pushState) { history.pushState(null, null, '#profile-form'); } else { window.location.hash = 'profile-form'; } }" 
               class="text-gray-400 hover:text-brand-secondary hover:bg-teal-50 w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center transition cursor-pointer" 
               title="Edit Profile">
                <i class="far fa-edit text-sm sm:text-base"></i>
            </a>

            <!-- Mobile Menu Toggle Button (Visible only on mobile) -->
            <button type="button" 
                    id="mobilePatientMenuToggle"
                    onclick="togglePatientMobileSidebar()"
                    class="md:hidden flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-teal-50 hover:bg-teal-100 border border-teal-200 text-teal-800 text-xs font-black transition shadow-2xs cursor-pointer">
                <i class="fas fa-bars text-teal-700" id="mobileMenuIcon"></i>
                <span id="mobileMenuText">Menu</span>
            </button>
        </div>
    </div>

    <!-- Mobile Quick Navigation Bar (Visible on mobile for 1-tap switching) -->
    <div class="md:hidden flex items-center gap-1.5 overflow-x-auto pb-1 no-scrollbar text-xs">
        <a href="{{ route('patient.dashboard') }}" class="px-3 py-1.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ request()->routeIs('patient.dashboard') ? 'bg-brand-dark text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-th-large text-[10px]"></i> Dashboard
        </a>
        <a href="{{ route('patient.bookings') }}" class="px-3 py-1.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ request()->routeIs('patient.bookings*') ? 'bg-brand-dark text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            <i class="far fa-calendar-check text-[10px]"></i> Bookings
        </a>
        <a href="{{ route('patient.reports') }}" class="px-3 py-1.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ request()->routeIs('patient.reports*') ? 'bg-brand-dark text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            <i class="far fa-file-alt text-[10px]"></i> Reports
        </a>
        <a href="{{ route('patient.prescriptions') }}" class="px-3 py-1.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ request()->routeIs('patient.prescriptions*') ? 'bg-brand-dark text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">
            <i class="fas fa-file-medical text-[10px]"></i> Rx
        </a>
        <a href="{{ route('patient.membership') }}" class="px-3 py-1.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ request()->routeIs('patient.membership*') ? 'bg-amber-500 text-white shadow-2xs' : 'bg-white border border-amber-200 text-amber-800' }}">
            <i class="fas fa-crown text-[10px]"></i> VIP
        </a>
        <a href="{{ route('patient.coupons') }}" class="px-3 py-1.5 rounded-xl font-bold whitespace-nowrap transition flex items-center gap-1.5 {{ request()->routeIs('patient.coupons*') ? 'bg-indigo-600 text-white shadow-2xs' : 'bg-white border border-gray-200 text-gray-700' }}">
            <i class="fas fa-ticket-alt text-[10px]"></i> Coupons
        </a>
        <button type="button" onclick="togglePatientMobileSidebar()" class="px-2.5 py-1.5 rounded-xl font-bold whitespace-nowrap bg-gray-100 hover:bg-gray-200 text-gray-700 border border-gray-200 flex items-center gap-1 cursor-pointer">
            <span>More</span> <i class="fas fa-chevron-down text-[9px]"></i>
        </button>
    </div>

    <!-- Full Sidebar Cards (Hidden on mobile by default so page content is immediately visible, shown on toggle or md:screens) -->
    <div id="patientSidebarFullMenu" class="hidden md:block space-y-4">
    @if($activeVip)
        <!-- VIP Member Status Card -->
        <div class="rounded-2xl bg-gradient-to-br from-slate-950 via-slate-900 to-amber-950 p-4 border border-amber-500/40 text-white shadow-md relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 w-24 h-24 rounded-full bg-amber-500/10 blur-xl"></div>
            <div class="flex items-center justify-between relative z-10 mb-2">
                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-amber-500/20 text-amber-300 text-[10px] font-black uppercase tracking-wider border border-amber-500/30">
                    <i class="fas fa-crown text-amber-400"></i> VIP Member
                </span>
                <span class="text-[10px] font-bold text-slate-300">
                    {{ $activeVip->days_remaining > 0 ? $activeVip->days_remaining.'d left' : 'Active' }}
                </span>
            </div>
            <h5 class="text-xs font-black text-white truncate">{{ $activeVip->plan_name_snapshot }}</h5>
            <p class="text-[11px] text-amber-200/90 font-semibold mt-0.5">Flat {{ $activeVip->discount_percentage }}% OFF on all tests</p>
            <a href="{{ route('patient.membership') }}" class="mt-3 block text-center py-2 px-3 rounded-xl bg-gradient-to-r from-amber-400 to-amber-500 hover:from-amber-500 hover:to-amber-600 text-slate-950 text-xs font-black transition shadow-sm">
                Manage VIP Perks &rarr;
            </a>
        </div>
    @else
        <!-- Become a VIP CTA Card -->
        <div class="rounded-2xl bg-gradient-to-br from-amber-500/10 via-orange-500/5 to-white p-4 border border-amber-300 shadow-sm relative overflow-hidden">
            <div class="flex items-center gap-2.5 mb-2">
                <div class="w-7 h-7 rounded-lg bg-amber-500 text-white flex items-center justify-center text-xs font-bold shadow-sm">
                    <i class="fas fa-crown"></i>
                </div>
                <div>
                    <h5 class="text-xs font-black text-brand-dark">Wellcare VIP Pass</h5>
                    <p class="text-[10px] text-amber-700 font-bold">Save up to 25% on every test</p>
                </div>
            </div>
            <p class="text-[11px] text-gray-600 font-medium leading-relaxed">
                Free home sample collection + flat test discounts for your whole family.
            </p>
            <a href="{{ route('patient.membership') }}" class="mt-3 block text-center py-2 px-3 rounded-xl bg-gradient-to-r from-amber-500 to-amber-600 hover:from-amber-600 hover:to-amber-700 text-white text-xs font-black shadow-sm transition">
                Explore VIP Plans &rarr;
            </a>
        </div>
    @endif

    <!-- My Details -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <h5 class="font-extrabold text-brand-dark text-lg p-4 pb-2">My Details</h5>
        <ul class="text-sm font-semibold text-gray-700 divide-y divide-gray-100">
            <li><a href="{{ route('patient.dashboard') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.dashboard') || request()->routeIs('patient.profile.edit') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}"><span class="flex items-center"><i class="fas fa-th-large w-6 {{ request()->routeIs('patient.dashboard') || request()->routeIs('patient.profile.edit') ? 'text-brand-secondary' : 'text-gray-400' }}"></i> Dashboard</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('patient.bookings') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.bookings*') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}"><span class="flex items-center"><i class="far fa-calendar-check w-6 {{ request()->routeIs('patient.bookings*') ? 'text-brand-secondary' : 'text-gray-400' }}"></i> My Bookings</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('patient.transactions') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.transactions*') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}"><span class="flex items-center"><i class="fas fa-receipt w-6 {{ request()->routeIs('patient.transactions*') ? 'text-brand-secondary' : 'text-gray-400' }}"></i> Payment History</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('patient.reports') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.reports*') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}"><span class="flex items-center"><i class="far fa-file-alt w-6 {{ request()->routeIs('patient.reports*') ? 'text-brand-secondary' : 'text-gray-400' }}"></i> Test Reports</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li>
                <a href="{{ route('patient.notifications') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.notifications*') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-bell w-6 {{ request()->routeIs('patient.notifications*') ? 'text-brand-secondary' : 'text-teal-600' }}"></i> 
                        <span>Notifications</span>
                    </span> 
                    @php
                        $sidebarUnreadCount = session('patient_id') ? \App\Models\NotificationLog::where('notifiable_type', \App\Models\Patient::class)->where('notifiable_id', session('patient_id'))->whereNull('read_at')->count() : 0;
                    @endphp
                    @if($sidebarUnreadCount > 0)
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-black bg-rose-500 text-white animate-pulse">{{ $sidebarUnreadCount }}</span>
                    @else
                        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                    @endif
                </a>
            </li>
            <li><a href="{{ route('patient.family_members') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.family_members') ? 'text-brand-secondary bg-gray-50' : '' }}"><span class="flex items-center"><i class="fas fa-users w-6 {{ request()->routeIs('patient.family_members') ? 'text-brand-secondary' : 'text-gray-400' }}"></i> Family Members</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('patient.prescriptions') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.prescriptions') ? 'text-brand-secondary bg-gray-50' : '' }}"><span class="flex items-center"><i class="fas fa-file-medical w-6 {{ request()->routeIs('patient.prescriptions') ? 'text-brand-secondary' : 'text-gray-400' }}"></i> Prescription</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('patient.address_book') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.address_book') ? 'text-brand-secondary bg-gray-50' : '' }}"><span class="flex items-center"><i class="fas fa-map-marker-alt w-6 {{ request()->routeIs('patient.address_book') ? 'text-brand-secondary' : 'text-gray-400' }}"></i> Address book</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
        </ul>
    </div>

    <!-- My Benefits -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <h5 class="font-extrabold text-brand-dark text-lg p-4 pb-2 flex items-center justify-between">
            <span>My Benefits</span>
            <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-700">OFFERS</span>
        </h5>
        <ul class="text-sm font-semibold text-gray-700 divide-y divide-gray-100">
            <li>
                <a href="{{ route('patient.coupons') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.coupons') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-ticket-alt w-6 {{ request()->routeIs('patient.coupons') ? 'text-brand-secondary' : 'text-indigo-500' }}"></i> 
                        <span>My Coupons</span>
                    </span> 
                    <span class="flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.membership') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.membership*') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-crown w-6 {{ request()->routeIs('patient.membership*') ? 'text-amber-500' : ($activeVip ? 'text-amber-500' : 'text-amber-400') }}"></i> 
                        <span>{{ $activeVip ? 'VIP Membership' : 'Become a VIP' }}</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        @if($activeVip)
                            <span class="text-[10px] font-black uppercase px-2 py-0.5 rounded-full bg-amber-100 text-amber-800">ACTIVE</span>
                        @endif
                        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                    </span>
                </a>
            </li>
            <li>
                <a href="{{ route('patient.rewards') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition {{ request()->routeIs('patient.rewards*') ? 'text-brand-secondary bg-gray-50 font-bold' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-coins w-6 {{ request()->routeIs('patient.rewards*') ? 'text-amber-500' : 'text-yellow-500' }}"></i> 
                        <span>Health Coins</span>
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="text-xs font-black px-2 py-0.5 rounded-full bg-amber-100 text-amber-900 border border-amber-200">
                            {{ number_format($patientModel?->reward_coins ?? 0) }} 🪙
                        </span>
                        <i class="fas fa-chevron-right text-gray-300 text-xs"></i>
                    </span>
                </a>
            </li>
            <li><a href="{{ route('patient.coupons') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-gift w-6 text-gray-400"></i> My Gift Card</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('patient.membership') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-heartbeat w-6 text-gray-400"></i> One Health</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('calculators.bmi') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-utensils w-6 text-gray-400"></i> Diet Plan</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('calculators.index') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-weight w-6 text-gray-400"></i> Measure Your Health</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('faqs') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="far fa-question-circle w-6 text-gray-400"></i> Queries & Tickets</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
        </ul>
    </div>

    <!-- Legal & Privacy -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
        <h5 class="font-extrabold text-brand-dark text-lg p-4 pb-2">Legal & Privacy</h5>
        <ul class="text-sm font-semibold text-gray-700 divide-y divide-gray-100">
            <li><a href="{{ route('privacy') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-shield-alt w-6 text-gray-400"></i> Privacy Policy</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('patient.profile.edit') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-cog w-6 text-gray-400"></i> Account Settings</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="{{ route('terms') }}" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-file-contract w-6 text-gray-400"></i> Terms & Conditions</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
        </ul>
    </div>

    @if(session('impersonated_by_admin'))
        <!-- Admin Mode Return Button in Sidebar -->
        <div class="p-3 bg-amber-50 border border-amber-300 rounded-xl mt-3 shadow-sm">
            <div class="flex items-center gap-1.5 text-xs font-bold text-amber-900 mb-2">
                <i class="fas fa-shield-alt text-amber-600"></i>
                <span>Admin Impersonation Mode</span>
            </div>
            <a href="{{ route('patient.exit_impersonate') }}" class="block text-center bg-amber-600 hover:bg-amber-700 text-white font-bold py-2 px-3 rounded-lg text-xs transition shadow-sm">
                <i class="fas fa-arrow-left mr-1"></i> Return to Admin Panel
            </a>
        </div>
    @endif

    <!-- Logout -->
    <a href="{{ route('patient.logout') }}" class="inline-block bg-white border border-gray-200 rounded-lg py-2 px-4 text-sm font-bold text-gray-500 hover:text-red-500 hover:border-red-200 transition shadow-sm mt-2">
        <i class="fas fa-sign-out-alt mr-2 transform rotate-180"></i> Logout
    </a>
    </div>{{-- End #patientSidebarFullMenu --}}
</div>{{-- End Outer Sidebar Container --}}

<script>
    function togglePatientMobileSidebar() {
        const container = document.getElementById('patientSidebarFullMenu');
        const icon = document.getElementById('mobileMenuIcon');
        const text = document.getElementById('mobileMenuText');
        if (!container) return;

        const isHidden = container.classList.contains('hidden');
        if (isHidden) {
            container.classList.remove('hidden');
            if (icon) icon.className = 'fas fa-times text-teal-700';
            if (text) text.innerText = 'Close';
        } else {
            container.classList.add('hidden');
            if (icon) icon.className = 'fas fa-bars text-teal-700';
            if (text) text.innerText = 'Menu';
        }
    }
</script>
