<!DOCTYPE html>
<html lang="en" class="h-full overflow-hidden">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WellCare Admin — @yield('title', 'Dashboard')</title>

    @include('partials.favicon')

    <!-- Flash theme before paint to prevent flicker -->
    <script>
        // Default: light mode. Only go dark if user explicitly chose dark.
        const savedTheme = localStorage.getItem('admin_theme');
        if (savedTheme === 'dark') {
            document.documentElement.classList.add('dark');
        }
    </script>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            300: '#5eead4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                            950: '#042f2e',
                        },
                        adark: {
                            bg:      '#030f0e',
                            sidebar: '#051210',
                            surface: '#071a18',
                            card:    '#0b2220',
                            border:  'rgba(45,212,191,0.10)',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        html, body {
            height: 100%;
            max-height: 100%;
            overflow: hidden;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* ── Custom Scrollbar ── */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        .dark ::-webkit-scrollbar-thumb { background: rgba(45,212,191,0.18); border-radius: 9999px; }
        .dark ::-webkit-scrollbar-thumb:hover { background: rgba(45,212,191,0.30); }
        ::-webkit-scrollbar-thumb { background: rgba(0,0,0,0.12); border-radius: 9999px; }

        /* ── Glass Cards ── */
        .glass-card {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.25s ease-in-out;
        }
        .dark .glass-card {
            background: rgba(11,34,32,0.72);
            border: 1px solid rgba(45,212,191,0.10);
            box-shadow: 0 10px 30px -10px rgba(0,0,0,0.5);
        }
        html:not(.dark) .glass-card {
            background: rgba(255,255,255,0.97);
            border: 1px solid rgba(226,232,240,0.90);
            box-shadow: 0 4px 20px -2px rgba(0,0,0,0.05);
        }

        /* ── Active Sidebar Item ── */
        .dark .sidebar-item-active {
            background: linear-gradient(90deg, rgba(13,148,136,0.28), rgba(20,184,166,0.12));
            border: 1px solid rgba(45,212,191,0.35);
            color: #ffffff;
            box-shadow: 0 0 16px rgba(13,148,136,0.20);
        }
        html:not(.dark) .sidebar-item-active {
            background: linear-gradient(90deg, rgba(13,148,136,0.12), rgba(20,184,166,0.06));
            border: 1px solid rgba(13,148,136,0.30);
            color: #0f766e;
            font-weight: 600;
        }

        /* ── Teal Glow Effects ── */
        .glow-teal  { box-shadow: 0 0 18px rgba(13,148,136,0.35); }
        .glow-amber { box-shadow: 0 0 18px rgba(245,158,11,0.30); }
        .glow-rose  { box-shadow: 0 0 18px rgba(244, 63,94,0.30); }

        /* ── Dark mode overrides for sub-page components ── */
        .dark .bg-white {
            background-color: rgba(11,34,32,0.75) !important;
            border-color: rgba(45,212,191,0.10) !important;
            color: #f1f5f9;
        }
        .dark .bg-gray-50, .dark .bg-slate-50 {
            background-color: rgba(7,26,24,0.60) !important;
            border-color: rgba(45,212,191,0.07) !important;
        }
        .dark .text-gray-800, .dark .text-gray-900,
        .dark .text-slate-800, .dark .text-slate-900 { color: #f8fafc !important; }
        .dark .text-gray-700, .dark .text-gray-600   { color: #cbd5e1 !important; }
        .dark .text-gray-500                          { color: #94a3b8 !important; }
        .dark .border-gray-100, .dark .border-gray-200,
        .dark .divide-gray-100 { border-color: rgba(45,212,191,0.10) !important; }
        .dark tr:hover { background-color: rgba(45,212,191,0.04) !important; }
        .dark input:not([type="checkbox"]):not([type="radio"]), .dark select, .dark textarea {
            background-color: rgba(255,255,255,0.04) !important;
            border-color: rgba(45,212,191,0.15) !important;
            color: #f8fafc !important;
        }

        /* ── Micro Animations ── */
        @keyframes subtle-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.85; }
        }
        .animate-subtle-pulse { animation: subtle-pulse 3s infinite ease-in-out; }

        @keyframes slide-in-up {
            from { transform: translateY(8px); opacity: 0; }
            to   { transform: translateY(0);   opacity: 1; }
        }
        .slide-in-up { animation: slide-in-up 0.25s ease-out; }

        /* ── Sidebar subtle teal border glow ── */
        .dark aside {
            box-shadow: 2px 0 40px -8px rgba(13,148,136,0.15);
        }
    </style>
</head>
<body class="h-full bg-slate-50 text-slate-800 dark:bg-[#030f0e] dark:text-slate-100 antialiased overflow-hidden selection:bg-teal-500 selection:text-white">

    <div class="flex h-full max-h-screen w-full relative overflow-hidden">

        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/65 backdrop-blur-sm z-30 hidden transition-opacity opacity-0 md:hidden"></div>

        <!-- ══════════════════════ SIDEBAR ══════════════════════ -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white dark:bg-[#051210] border-r border-slate-200 dark:border-teal-900/50 transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col justify-between flex-shrink-0 h-full">

            <!-- Brand Header -->
            <div>
                <div class="h-[72px] flex items-center justify-between px-5 border-b border-slate-100 dark:border-teal-900/40">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                        <img src="{{ asset('logo.png') }}" alt="AV Wellcare Diagnostics" class="h-9 w-auto object-contain group-hover:scale-105 transition-transform">
                        <span class="text-[9px] uppercase font-bold tracking-widest px-1.5 py-0.5 rounded bg-teal-500/15 text-teal-600 dark:text-teal-400 border border-teal-500/25 self-end mb-1">Admin</span>
                    </a>
                    <button id="closeSidebarBtn" class="md:hidden text-slate-400 hover:text-white p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <!-- Navigation -->
                <div class="py-4 px-3.5 space-y-5 overflow-y-auto max-h-[calc(100vh-240px)]">

                    <!-- Section: Main -->
                    <div>
                        <div class="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-teal-700/60 dark:text-teal-600/60">Main</div>
                        <nav class="space-y-1">

                            <!-- Dashboard -->
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-gauge-high w-5 text-center text-sm {{ request()->routeIs('admin.dashboard') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Overview</span>
                                </div>
                                @if(request()->routeIs('admin.dashboard'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shadow-[0_0_8px_#2dd4bf]"></span>
                                @endif
                            </a>

                            <!-- Users -->
                            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-users w-5 text-center text-sm {{ request()->routeIs('admin.users.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Users</span>
                                </div>
                                @if(request()->routeIs('admin.users.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shadow-[0_0_8px_#2dd4bf]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>

                            <!-- Bookings -->
                            <a href="{{ route('admin.bookings.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.bookings.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-calendar-check w-5 text-center text-sm {{ request()->routeIs('admin.bookings.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Bookings</span>
                                </div>
                                @if(request()->routeIs('admin.bookings.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shadow-[0_0_8px_#2dd4bf]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>

                            <!-- Payment Transactions -->
                            <a href="{{ route('admin.transactions.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.transactions.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-receipt w-5 text-center text-sm {{ request()->routeIs('admin.transactions.*') ? 'text-emerald-400' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Payment Logs</span>
                                </div>
                                @if(request()->routeIs('admin.transactions.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 shadow-[0_0_8px_#34d399]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>

                            <!-- Field Agents -->
                            <a href="{{ route('admin.agents.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.agents.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-id-badge w-5 text-center text-sm {{ request()->routeIs('admin.agents.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Field Agents</span>
                                </div>
                                @if(request()->routeIs('admin.agents.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shadow-[0_0_8px_#2dd4bf]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>

                            <!-- Notifications -->
                            <a href="{{ route('admin.notifications.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.notifications.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-bell w-5 text-center text-sm {{ request()->routeIs('admin.notifications.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Notifications</span>
                                </div>
                                @if(request()->routeIs('admin.notifications.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shadow-[0_0_8px_#2dd4bf]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>
                        </nav>
                    </div>

                    <!-- Section: Catalog -->
                    <div>
                        <div class="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-teal-700/60 dark:text-teal-600/60">Catalog</div>
                        <nav class="space-y-1">

                            <!-- Audience Categories -->
                            <a href="{{ route('admin.categories.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.categories.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-tags w-5 text-center text-sm {{ request()->routeIs('admin.categories.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Audience Categories</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                            </a>

                            <!-- Departments & Parameters -->
                            <a href="{{ route('admin.departments.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.departments.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-microscope w-5 text-center text-sm {{ request()->routeIs('admin.departments.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Departments</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                            </a>

                            <!-- Single Lab Tests -->
                            <a href="{{ route('admin.tests.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.tests.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-vial w-5 text-center text-sm {{ request()->routeIs('admin.tests.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Single Lab Tests</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                            </a>

                            <!-- Health Packages -->
                            <a href="{{ route('admin.packages.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.packages.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-boxes-stacked w-5 text-center text-sm {{ request()->routeIs('admin.packages.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Health Packages</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Section: Manage & Feedback -->
                    <div>
                        <div class="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-teal-700/60 dark:text-teal-600/60">Manage & Feedback</div>
                        <nav class="space-y-1">

                            <!-- Patient Reviews -->
                            <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.reviews.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-star-half-stroke w-5 text-center text-sm {{ request()->routeIs('admin.reviews.*') ? 'text-amber-400' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Patient Reviews</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                            </a>

                            <!-- Enquiries -->
                            <a href="{{ route('admin.enquiries.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.enquiries.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-comment-dots w-5 text-center text-sm {{ request()->routeIs('admin.enquiries.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Enquiries</span>
                                </div>
                                <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Section: Promotions -->
                    <div>
                        <div class="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-teal-700/60 dark:text-teal-600/60">Promotions</div>
                        <nav class="space-y-1">

                            <!-- Coupons -->
                            <a href="{{ route('admin.coupons.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.coupons.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-ticket-alt w-5 text-center text-sm {{ request()->routeIs('admin.coupons.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Coupons</span>
                                </div>
                                @if(request()->routeIs('admin.coupons.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shadow-[0_0_8px_#2dd4bf]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>

                            <!-- VIP Memberships -->
                            <a href="{{ route('admin.memberships.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.memberships.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-crown w-5 text-center text-sm {{ request()->routeIs('admin.memberships.*') ? 'text-amber-400' : 'text-amber-400/60' }}"></i>
                                    <span>VIP Memberships</span>
                                </div>
                                @if(request()->routeIs('admin.memberships.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-400 shadow-[0_0_8px_#f59e0b]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>

                            <!-- Rewards & Coins -->
                            <a href="{{ route('admin.rewards.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.rewards.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-coins w-5 text-center text-sm {{ request()->routeIs('admin.rewards.*') ? 'text-yellow-400' : 'text-yellow-400/60' }}"></i>
                                    <span>Rewards & Coins</span>
                                </div>
                                @if(request()->routeIs('admin.rewards.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-400 shadow-[0_0_8px_#eab308]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>

                            <!-- Site Settings -->
                            <a href="{{ route('admin.settings.index') }}" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.settings.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-sliders w-5 text-center text-sm {{ request()->routeIs('admin.settings.*') ? 'text-teal-500' : 'text-slate-400 dark:text-slate-500' }}"></i>
                                    <span>Site Settings</span>
                                </div>
                                @if(request()->routeIs('admin.settings.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-teal-400 shadow-[0_0_8px_#2dd4bf]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
                                @endif
                            </a>
                        </nav>
                    </div>

                    <!-- Section: Others -->
                    <div>
                        <div class="px-2.5 mb-2 text-[10px] font-bold uppercase tracking-wider text-teal-700/60 dark:text-teal-600/60">Others</div>
                        <nav class="space-y-1">
                            <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-all">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-external-link-alt w-5 text-center text-sm text-slate-400 dark:text-slate-500"></i>
                                    <span>Live Website</span>
                                </div>
                                <span class="text-[9px] bg-teal-500/10 text-teal-600 dark:text-teal-400 font-bold px-1.5 py-0.5 rounded border border-teal-500/20">Live</span>
                            </a>
                            <a href="{{ route('agent.login') }}" target="_blank" class="flex items-center justify-between px-3 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-all">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-motorcycle w-5 text-center text-sm text-teal-500"></i>
                                    <span>Agent Portal</span>
                                </div>
                                <span class="text-[9px] bg-teal-500/10 text-teal-600 dark:text-teal-400 font-bold px-1.5 py-0.5 rounded border border-teal-500/20">Collector</span>
                            </a>
                        </nav>
                    </div>

                </div>
            </div>

            <!-- Bottom: Info Banner & Logout -->
            <div class="p-3.5 border-t border-slate-100 dark:border-teal-900/40 space-y-3">
                <!-- Teal branded info card -->
                <div class="relative overflow-hidden rounded-2xl p-3.5 bg-gradient-to-br from-teal-900/70 via-teal-800/40 to-slate-900/80 border border-teal-700/30 text-white">
                    <div class="absolute -right-5 -bottom-5 w-20 h-20 bg-teal-500/15 rounded-full blur-xl"></div>
                    <div class="space-y-1 mb-3 text-xs">
                        <div class="flex items-center gap-2 font-medium text-slate-200">
                            <i class="fas fa-check-circle text-teal-400 text-xs"></i>
                            <span>Live Diagnostics</span>
                        </div>
                        <div class="flex items-center gap-2 font-medium text-slate-200">
                            <i class="fas fa-check-circle text-teal-400 text-xs"></i>
                            <span>Instant Reports</span>
                        </div>
                        <div class="flex items-center gap-2 font-medium text-slate-200">
                            <i class="fas fa-shield-alt text-teal-400 text-xs"></i>
                            <span>HIPAA Compliant</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="block w-full text-center py-2 px-3 rounded-xl bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-500 hover:to-teal-600 text-white text-xs font-semibold shadow-md shadow-teal-700/30 transition-all">
                        Check Live Bookings
                    </a>
                </div>

                <!-- Logout -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3.5 py-2.5 rounded-xl text-sm font-medium text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition-colors">
                        <i class="fas fa-arrow-right-from-bracket text-xs"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>
        <!-- ════════════════════ END SIDEBAR ════════════════════ -->

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50 dark:bg-[#030f0e] h-full overflow-hidden">

            <!-- ══════════════════════ TOP HEADER ══════════════════════ -->
            <header class="h-[72px] flex-shrink-0 sticky top-0 bg-white/90 dark:bg-[#030f0e]/95 backdrop-blur-xl border-b border-slate-200 dark:border-teal-900/40 flex items-center justify-between px-4 sm:px-7 z-30 transition-colors duration-300">

                <!-- Left: Mobile Toggle & Breadcrumb -->
                <div class="flex items-center space-x-4">
                    <button id="mobileMenuBtn" class="md:hidden p-2 rounded-xl text-slate-500 hover:text-teal-600 dark:text-slate-400 dark:hover:text-teal-400 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">
                        <i class="fas fa-bars-staggered text-xl"></i>
                    </button>

                    <!-- Breadcrumb -->
                    <div class="flex items-center space-x-2.5 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-teal-50 dark:bg-teal-900/30 flex items-center justify-center text-teal-600 dark:text-teal-400 border border-teal-200/60 dark:border-teal-800/40">
                            <i class="fas fa-flask-vial text-xs"></i>
                        </div>
                        <div class="flex items-center space-x-2 font-medium text-xs sm:text-sm">
                            <span class="text-slate-400">WellCare</span>
                            <span class="text-slate-300 dark:text-slate-600">/</span>
                            <span class="text-slate-800 dark:text-white font-semibold">@yield('header', 'Overview')</span>
                        </div>
                    </div>
                </div>

                <!-- Right Tools -->
                <div class="flex items-center space-x-2 sm:space-x-4">

                    <!-- Search -->
                    <div class="hidden lg:flex items-center relative">
                        <i class="fas fa-search absolute left-3.5 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Search booking, patient, test..." class="w-60 pl-9 pr-10 py-2 bg-slate-100 dark:bg-teal-950/40 border border-slate-200 dark:border-teal-900/50 rounded-xl text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-teal-500/40 transition-all">
                        <span class="absolute right-2.5 px-1.5 py-0.5 rounded text-[9px] font-semibold bg-slate-200 dark:bg-teal-900/50 text-slate-400">⌘/</span>
                    </div>

                    <!-- Refresh -->
                    <button onclick="window.location.reload()" title="Refresh" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-teal-950/40 border border-slate-200 dark:border-teal-900/50 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50 dark:hover:bg-teal-900/30 transition-all">
                        <i class="fas fa-rotate-right text-xs"></i>
                    </button>

                    <!-- Notifications Bell & Dropdown -->
                    <div class="relative" id="adminNotifDropdownContainer">
                        <button id="adminNotifBtn" type="button" aria-label="Notifications" class="relative w-9 h-9 rounded-xl bg-slate-100 dark:bg-teal-950/40 border border-slate-200 dark:border-teal-900/50 flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-teal-600 dark:hover:text-teal-400 hover:bg-teal-50 dark:hover:bg-teal-900/30 transition-all focus:outline-none">
                            <i class="fas fa-bell text-xs"></i>
                            <span id="adminNotifBadge" class="hidden absolute -top-1.5 -right-1.5 min-w-[18px] h-[18px] px-1 rounded-full bg-rose-500 text-white text-[9px] font-black flex items-center justify-center ring-2 ring-white dark:ring-[#030f0e] shadow-sm animate-pulse">0</span>
                        </button>

                        <!-- Notification Dropdown Menu -->
                        <div id="adminNotifMenu" class="hidden slide-in-up absolute right-0 mt-2 w-80 sm:w-96 rounded-2xl bg-white dark:bg-[#071a18] border border-slate-200 dark:border-teal-900/50 shadow-2xl shadow-black/30 z-50 overflow-hidden">
                            <!-- Dropdown Header -->
                            <div class="p-3.5 px-4 bg-slate-50 dark:bg-teal-950/30 border-b border-slate-100 dark:border-teal-900/40 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="font-bold text-xs text-slate-900 dark:text-white">Notifications</span>
                                    <span id="adminNotifHeaderCount" class="hidden px-2 py-0.5 rounded-full text-[10px] font-black bg-teal-500/15 text-teal-600 dark:text-teal-400 border border-teal-500/20">0 Unread</span>
                                </div>
                                <button type="button" onclick="markAllAdminNotifsRead()" class="text-[11px] font-semibold text-teal-600 dark:text-teal-400 hover:underline">
                                    Mark all as read
                                </button>
                            </div>

                            <!-- Notification Items List -->
                            <div id="adminNotifList" class="max-h-80 overflow-y-auto divide-y divide-slate-100 dark:divide-teal-900/30">
                                <div class="p-6 text-center text-xs text-slate-400">
                                    <i class="fas fa-spinner fa-spin text-teal-500 mb-2 text-base block"></i>
                                    <span>Loading alerts...</span>
                                </div>
                            </div>

                            <!-- Dropdown Footer -->
                            <div class="p-2.5 bg-slate-50 dark:bg-teal-950/20 border-t border-slate-100 dark:border-teal-900/40 text-center">
                                <a href="{{ route('admin.notifications.index') }}" class="text-xs font-bold text-teal-600 dark:text-teal-400 hover:underline flex items-center justify-center gap-1.5 py-1">
                                    <span>View All Notification Logs</span>
                                    <i class="fas fa-arrow-right text-[10px]"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Theme Toggle -->
                    <div class="flex items-center space-x-2 pl-2 border-l border-slate-200 dark:border-teal-900/40">
                        <span class="text-xs font-semibold text-slate-400 hidden sm:inline-block">Theme</span>
                        <button id="themeToggleBtn" type="button" aria-label="Toggle Theme" class="relative inline-flex h-7 w-14 items-center rounded-full bg-slate-200 dark:bg-teal-900/60 border border-slate-300 dark:border-teal-700/40 p-1 transition-colors duration-300 focus:outline-none">
                            <span id="themeToggleThumb" class="inline-block h-5 w-5 transform rounded-full bg-white dark:bg-teal-500 shadow-md transition-transform duration-300 flex items-center justify-center text-[10px] translate-x-7 dark:translate-x-7">
                                <i id="themeIcon" class="fas fa-moon text-white"></i>
                            </span>
                        </button>
                    </div>

                    <!-- Profile Avatar + Dropdown -->
                    <div class="relative pl-1">
                        <button id="profileDropdownBtn" type="button" class="flex items-center space-x-2.5 p-1.5 rounded-xl hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-all focus:outline-none">
                            <div class="relative">
                                <div class="h-9 w-9 rounded-full bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center text-white font-bold text-sm ring-2 ring-teal-500/30 shadow-sm">
                                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                </div>
                                <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-[#030f0e]"></span>
                            </div>
                            <div class="hidden xl:block text-left">
                                <div class="text-xs font-bold text-slate-800 dark:text-white leading-tight flex items-center gap-1.5">
                                    <span>{{ auth()->user()->name ?? 'Super Admin' }}</span>
                                    <i id="profileChevron" class="fas fa-chevron-down text-[9px] text-slate-400 transition-transform duration-200"></i>
                                </div>
                                <div class="text-[10px] text-teal-600 dark:text-teal-400 font-medium">Administrator</div>
                            </div>
                            <i class="xl:hidden fas fa-chevron-down text-[10px] text-slate-400"></i>
                        </button>

                        <!-- Dropdown Menu -->
                        <div id="profileDropdownMenu" class="hidden slide-in-up absolute right-0 mt-2 w-60 rounded-2xl bg-white dark:bg-[#071a18] border border-slate-200 dark:border-teal-900/50 shadow-2xl shadow-black/30 py-2 z-50">
                            <div class="px-4 py-3 border-b border-slate-100 dark:border-teal-900/40">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-teal-500 to-teal-700 flex items-center justify-center text-white font-bold text-sm flex-shrink-0">
                                        {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="text-xs font-bold text-slate-900 dark:text-white">{{ auth()->user()->name ?? 'Super Admin' }}</div>
                                        <div class="text-[11px] text-slate-400 truncate">{{ auth()->user()->email ?? 'admin@wellcare.com' }}</div>
                                    </div>
                                </div>
                                <span class="inline-block mt-2 text-[10px] font-bold uppercase tracking-wider px-2 py-0.5 rounded-md bg-teal-500/10 text-teal-600 dark:text-teal-400 border border-teal-500/20">
                                    Super Administrator
                                </span>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">
                                    <i class="fas fa-chart-line w-4 text-teal-500"></i>
                                    <span>Dashboard Overview</span>
                                </a>
                                <a href="{{ route('admin.users.index') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">
                                    <i class="fas fa-users w-4 text-teal-500"></i>
                                    <span>Manage Users</span>
                                </a>
                                <a href="{{ route('admin.bookings.index') }}" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">
                                    <i class="fas fa-calendar-check w-4 text-teal-500"></i>
                                    <span>All Bookings</span>
                                </a>
                                <a href="{{ url('/') }}" target="_blank" class="flex items-center space-x-2.5 px-4 py-2 text-xs font-medium text-slate-700 dark:text-slate-300 hover:bg-teal-50 dark:hover:bg-teal-900/20 transition-colors">
                                    <i class="fas fa-external-link-alt w-4 text-teal-500"></i>
                                    <span>View Live Website</span>
                                </a>
                            </div>

                            <div class="border-t border-slate-100 dark:border-teal-900/40 pt-1 mt-1 px-1">
                                <form method="POST" action="{{ route('admin.logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center space-x-2 px-3 py-2 text-xs font-semibold text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10 rounded-xl transition-colors">
                                        <i class="fas fa-arrow-right-from-bracket w-4 text-rose-500"></i>
                                        <span>Sign Out / Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Logout -->
                    <form method="POST" action="{{ route('admin.logout') }}" class="inline-flex">
                        @csrf
                        <button type="submit" title="Sign Out" class="h-9 px-3 rounded-xl bg-rose-500/10 hover:bg-rose-500 text-rose-600 dark:text-rose-400 hover:text-white border border-rose-500/20 hover:border-rose-500 flex items-center space-x-1.5 text-xs font-semibold transition-all group">
                            <i class="fas fa-power-off text-xs group-hover:scale-110 transition-transform"></i>
                            <span class="hidden sm:inline">Logout</span>
                        </button>
                    </form>
                </div>
            </header>
            <!-- ══════════════════ END TOP HEADER ══════════════════ -->

            <!-- Main Scrollable Body -->
            <main id="adminMainScroll" class="flex-1 overflow-y-auto px-4 sm:px-7 py-6 sm:py-7 space-y-6">

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 flex items-center justify-between shadow-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-circle-check text-emerald-500 text-lg"></i>
                            <span class="text-sm font-medium text-emerald-700 dark:text-emerald-300">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-300 text-sm ml-4">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 flex items-center justify-between shadow-lg">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-circle-exclamation text-rose-500 text-lg"></i>
                            <span class="text-sm font-medium text-rose-700 dark:text-rose-300">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-300 text-sm ml-4">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- ══════════════════════ SCRIPTS ══════════════════════ -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // ── Theme Toggle ──
            const themeToggleBtn   = document.getElementById('themeToggleBtn');
            const themeToggleThumb = document.getElementById('themeToggleThumb');
            const themeIcon        = document.getElementById('themeIcon');
            const htmlEl           = document.documentElement;

            function applyTheme(theme) {
                if (theme === 'dark') {
                    htmlEl.classList.add('dark');
                    localStorage.setItem('admin_theme', 'dark');
                    if (themeToggleThumb) {
                        themeToggleThumb.classList.remove('translate-x-0');
                        themeToggleThumb.classList.add('translate-x-7');
                    }
                    if (themeIcon) themeIcon.className = 'fas fa-moon text-white';
                } else {
                    htmlEl.classList.remove('dark');
                    localStorage.setItem('admin_theme', 'light');
                    if (themeToggleThumb) {
                        themeToggleThumb.classList.remove('translate-x-7');
                        themeToggleThumb.classList.add('translate-x-0');
                    }
                    if (themeIcon) themeIcon.className = 'fas fa-sun text-amber-500';
                }
            }

            // Default to light mode unless user explicitly selected dark
            const currentTheme = localStorage.getItem('admin_theme') || 'light';
            applyTheme(currentTheme);

            if (themeToggleBtn) {
                themeToggleBtn.addEventListener('click', () => applyTheme(htmlEl.classList.contains('dark') ? 'light' : 'dark'));
            }

            // ── Mobile Sidebar ──
            const sidebar          = document.getElementById('sidebar');
            const sidebarOverlay   = document.getElementById('sidebarOverlay');
            const mobileMenuBtn    = document.getElementById('mobileMenuBtn');
            const closeSidebarBtn  = document.getElementById('closeSidebarBtn');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => sidebarOverlay.classList.remove('opacity-0'), 10);
            }
            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('opacity-0');
                setTimeout(() => sidebarOverlay.classList.add('hidden'), 300);
            }

            if (mobileMenuBtn)   mobileMenuBtn.addEventListener('click', openSidebar);
            if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
            if (sidebarOverlay)  sidebarOverlay.addEventListener('click', closeSidebar);

            // ── Profile Dropdown ──
            const profileBtn  = document.getElementById('profileDropdownBtn');
            const profileMenu = document.getElementById('profileDropdownMenu');
            const chevron     = document.getElementById('profileChevron');

            if (profileBtn && profileMenu) {
                profileBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    if (adminNotifMenu) adminNotifMenu.classList.add('hidden');
                    const hidden = profileMenu.classList.contains('hidden');
                    profileMenu.classList.toggle('hidden', !hidden);
                    if (chevron) chevron.classList.toggle('rotate-180', hidden);
                });
                document.addEventListener('click', (e) => {
                    if (!profileMenu.contains(e.target) && !profileBtn.contains(e.target)) {
                        profileMenu.classList.add('hidden');
                        if (chevron) chevron.classList.remove('rotate-180');
                    }
                });
            }

            // ── Admin Notifications Bell & Dropdown ──
            const adminNotifBtn = document.getElementById('adminNotifBtn');
            const adminNotifMenu = document.getElementById('adminNotifMenu');
            const adminNotifBadge = document.getElementById('adminNotifBadge');
            const adminNotifHeaderCount = document.getElementById('adminNotifHeaderCount');
            const adminNotifList = document.getElementById('adminNotifList');

            window.loadAdminNotifications = function() {
                fetch("{{ route('admin.notifications.unreadFeed') }}", {
                    headers: { 'Accept': 'application/json' }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.unread_count > 0) {
                        adminNotifBadge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                        adminNotifBadge.classList.remove('hidden');
                        adminNotifHeaderCount.textContent = `${data.unread_count} Unread`;
                        adminNotifHeaderCount.classList.remove('hidden');
                    } else {
                        adminNotifBadge.classList.add('hidden');
                        adminNotifHeaderCount.classList.add('hidden');
                    }

                    if (!data.notifications || data.notifications.length === 0) {
                        adminNotifList.innerHTML = `
                            <div class="p-8 text-center text-xs text-slate-400">
                                <i class="far fa-bell-slash text-2xl text-slate-300 dark:text-slate-600 mb-2 block"></i>
                                <span>No notifications yet</span>
                            </div>
                        `;
                        return;
                    }

                    adminNotifList.innerHTML = data.notifications.map(item => `
                        <div onclick="handleAdminNotifClick(${item.id}, '${item.action_url}')" class="p-3.5 px-4 flex items-start gap-3 hover:bg-slate-50 dark:hover:bg-teal-950/40 transition cursor-pointer ${item.is_read ? 'opacity-70' : 'bg-teal-50/40 dark:bg-teal-900/15'}">
                            <div class="w-8 h-8 rounded-xl flex items-center justify-center flex-shrink-0 ${item.badge_class}">
                                <i class="${item.icon} text-xs"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between gap-1">
                                    <h5 class="text-xs font-bold text-slate-900 dark:text-white truncate ${item.is_read ? '' : 'text-teal-600 dark:text-teal-400'}">${item.title}</h5>
                                    ${!item.is_read ? '<span class="w-2 h-2 rounded-full bg-teal-500 flex-shrink-0 animate-pulse"></span>' : ''}
                                </div>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 line-clamp-2 mt-0.5 leading-snug">${item.message}</p>
                                <span class="text-[10px] text-slate-400 mt-1 block">${item.time_ago}</span>
                            </div>
                        </div>
                    `).join('');
                })
                .catch(() => {
                    adminNotifList.innerHTML = `
                        <div class="p-4 text-center text-xs text-rose-500">
                            Failed to load notifications
                        </div>
                    `;
                });
            };

            window.handleAdminNotifClick = function(notifId, actionUrl) {
                fetch(`{{ url('/admin/notifications/mark-read') }}/${notifId}`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                }).finally(() => {
                    if (actionUrl && actionUrl !== '#' && !actionUrl.includes('javascript')) {
                        window.location.href = actionUrl;
                    } else {
                        loadAdminNotifications();
                    }
                });
            };

            window.markAllAdminNotifsRead = function() {
                fetch("{{ route('admin.notifications.markRead') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    }
                }).then(() => {
                    loadAdminNotifications();
                });
            };

            if (adminNotifBtn && adminNotifMenu) {
                adminNotifBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isHidden = adminNotifMenu.classList.contains('hidden');
                    if (profileMenu) profileMenu.classList.add('hidden');
                    adminNotifMenu.classList.toggle('hidden', !isHidden);
                });

                document.addEventListener('click', (e) => {
                    if (!adminNotifMenu.contains(e.target) && !adminNotifBtn.contains(e.target)) {
                        adminNotifMenu.classList.add('hidden');
                    }
                });
            }

            // Load on startup
            loadAdminNotifications();

            // ── Auto-dismiss flash messages ──
            setTimeout(() => {
                document.querySelectorAll('[data-flash]').forEach(el => el.remove());
            }, 5000);
        });
    </script>

    @yield('scripts')
</body>
</html>
