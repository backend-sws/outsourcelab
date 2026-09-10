<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin - @yield('title', 'Dashboard')</title>
    
    <!-- Inline script to prevent theme flash -->
    <script>
        const savedTheme = localStorage.getItem('admin_theme');
        if (savedTheme === 'light') {
            document.documentElement.classList.remove('dark');
        } else {
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
                        fobe: {
                            bg: '#0a0b1c',
                            sidebar: '#0d0e23',
                            surface: '#12142d',
                            card: '#161838',
                            cardHover: '#1d2048',
                            cardBorder: 'rgba(255, 255, 255, 0.08)',
                            pillActive: 'rgba(99, 102, 241, 0.25)',
                            neonPurple: '#8b5cf6',
                            neonIndigo: '#6366f1',
                            neonCyan: '#06b6d4',
                            neonGreen: '#10b981',
                            neonPink: '#ec4899',
                            neonYellow: '#f59e0b',
                        }
                    }
                }
            }
        }
    </script>
    
    <!-- Google Fonts & FontAwesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        body { 
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; 
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.15);
            border-radius: 9999px;
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.25);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 9999px;
        }

        /* Glassmorphism Cards */
        .glass-card {
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            transition: all 0.25s ease-in-out;
        }
        .dark .glass-card {
            background: rgba(22, 24, 56, 0.72);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.5);
        }
        .light .glass-card, html:not(.dark) .glass-card {
            background: rgba(255, 255, 255, 0.95);
            border: 1px solid rgba(226, 232, 240, 0.9);
            box-shadow: 0 4px 20px -2px rgba(0, 0, 0, 0.05);
        }

        /* Active Sidebar Item Style (Matching Screenshot) */
        .dark .sidebar-item-active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.3), rgba(139, 92, 246, 0.18));
            border: 1px solid rgba(139, 92, 246, 0.45);
            color: #ffffff;
            box-shadow: 0 0 18px rgba(139, 92, 246, 0.25);
        }
        html:not(.dark) .sidebar-item-active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.15), rgba(139, 92, 246, 0.10));
            border: 1px solid rgba(99, 102, 241, 0.35);
            color: #4338ca;
            font-weight: 600;
        }

        /* Live Neon Glow Effects */
        .neon-border-purple {
            box-shadow: 0 0 15px rgba(139, 92, 246, 0.35);
        }
        .neon-border-cyan {
            box-shadow: 0 0 15px rgba(6, 182, 212, 0.35);
        }
        .neon-border-green {
            box-shadow: 0 0 15px rgba(16, 185, 129, 0.35);
        }

        /* Auto Dark Mode styling for standard elements across admin subpages */
        .dark .bg-white {
            background-color: rgba(22, 24, 56, 0.72) !important;
            border-color: rgba(255, 255, 255, 0.08) !important;
            color: #f1f5f9;
        }
        .dark .bg-gray-50, .dark .bg-gray-50\/50, .dark .bg-slate-50 {
            background-color: rgba(18, 20, 45, 0.6) !important;
            border-color: rgba(255, 255, 255, 0.06) !important;
        }
        .dark .text-gray-800, .dark .text-gray-900, .dark .text-slate-800, .dark .text-slate-900 {
            color: #f8fafc !important;
        }
        .dark .text-gray-700, .dark .text-gray-600 {
            color: #cbd5e1 !important;
        }
        .dark .text-gray-500 {
            color: #94a3b8 !important;
        }
        .dark .border-gray-100, .dark .border-gray-200, .dark .divide-gray-100 {
            border-color: rgba(255, 255, 255, 0.08) !important;
        }
        .dark tr:hover {
            background-color: rgba(255, 255, 255, 0.03) !important;
        }
        .dark input:not([type="checkbox"]):not([type="radio"]), .dark select, .dark textarea {
            background-color: rgba(255, 255, 255, 0.05) !important;
            border-color: rgba(255, 255, 255, 0.1) !important;
            color: #f8fafc !important;
        }

        /* Micro Pulse Animation */
        @keyframes subtle-pulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.85; }
        }
        .animate-subtle-pulse {
            animation: subtle-pulse 3s infinite ease-in-out;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 dark:bg-[#0a0b1c] dark:text-slate-100 antialiased overflow-hidden selection:bg-indigo-500 selection:text-white">
    <div class="flex h-screen w-full relative">
        <!-- Mobile Sidebar Overlay -->
        <div id="sidebarOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-30 hidden transition-opacity opacity-0 md:hidden"></div>

        <!-- Sidebar (Fobework Style) -->
        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-64 bg-white dark:bg-[#0d0e23] border-r border-slate-200 dark:border-white/[0.06] transform -translate-x-full md:relative md:translate-x-0 transition-transform duration-300 ease-in-out flex flex-col justify-between shadow-2xl md:shadow-none">
            <!-- Top Brand & Header -->
            <div>
                <div class="h-20 flex items-center justify-between px-6 border-b border-slate-100 dark:border-white/[0.06]">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-cyan-400 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30 group-hover:scale-105 transition-transform">
                            <i class="fas fa-cubes text-lg"></i>
                        </div>
                        <div>
                            <div class="font-extrabold text-base tracking-tight text-slate-900 dark:text-white flex items-center gap-1.5">
                                WellCare
                                <span class="text-[10px] uppercase font-bold tracking-widest px-1.5 py-0.5 rounded bg-indigo-500/20 text-indigo-500 dark:text-indigo-400 border border-indigo-500/30">Admin</span>
                            </div>
                            <p class="text-[11px] text-slate-400 dark:text-slate-400 font-medium">Diagnostic Lab Studio</p>
                        </div>
                    </a>
                    
                    <button id="closeSidebarBtn" class="md:hidden text-slate-400 hover:text-white p-1">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>

                <!-- Navigation List -->
                <div class="py-5 px-4 space-y-6 overflow-y-auto max-h-[calc(100vh-250px)]">
                    <!-- Section: Main -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-400">
                            Main
                        </div>
                        <nav class="space-y-1.5">
                            <!-- Dashboard / Overview -->
                            <a href="{{ route('admin.dashboard') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-home-alt w-5 text-center text-base {{ request()->routeIs('admin.dashboard') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Overview</span>
                                </div>
                                @if(request()->routeIs('admin.dashboard'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 shadow-[0_0_8px_#818cf8]"></span>
                                @endif
                            </a>

                            <!-- Users / Logged-in Accounts -->
                            <a href="{{ route('admin.users.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-users w-5 text-center text-base {{ request()->routeIs('admin.users.*') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Users</span>
                                </div>
                                @if(request()->routeIs('admin.users.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 shadow-[0_0_8px_#818cf8]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-xs text-slate-400 dark:text-slate-400"></i>
                                @endif
                            </a>

                            <!-- Bookings -->
                            <a href="{{ route('admin.bookings.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.bookings.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-calendar-check w-5 text-center text-base {{ request()->routeIs('admin.bookings.*') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Bookings</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-slate-400 dark:text-slate-400"></i>
                            </a>

                            <!-- Tests Catalog -->
                            <a href="{{ route('admin.tests.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.tests.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-flask-vial w-5 text-center text-base {{ request()->routeIs('admin.tests.*') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Lab Tests</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-slate-400 dark:text-slate-400"></i>
                            </a>

                            <!-- Packages -->
                            <a href="{{ route('admin.packages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.packages.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-layer-group w-5 text-center text-base {{ request()->routeIs('admin.packages.*') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Health Packages</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-slate-400 dark:text-slate-400"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Section: Manage -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-400">
                            Manage & Feedback
                        </div>
                        <nav class="space-y-1.5">
                            <!-- Reviews -->
                            <a href="{{ route('admin.reviews.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.reviews.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-star-half-stroke w-5 text-center text-base {{ request()->routeIs('admin.reviews.*') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Patient Reviews</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-slate-400 dark:text-slate-400"></i>
                            </a>

                            <!-- Enquiries -->
                            <a href="{{ route('admin.enquiries.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.enquiries.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-comment-dots w-5 text-center text-base {{ request()->routeIs('admin.enquiries.*') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Enquiries</span>
                                </div>
                                <i class="fas fa-chevron-right text-xs text-slate-400 dark:text-slate-400"></i>
                            </a>
                        </nav>
                    </div>

                    <!-- Section: Coupons & Offers (Below Manage & Feedback) -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-400">
                            Promotions & Coupons
                        </div>
                        <nav class="space-y-1.5">
                            <!-- Coupons -->
                            <a href="{{ route('admin.coupons.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium transition-all {{ request()->routeIs('admin.coupons.*') ? 'sidebar-item-active' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04]' }}">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-ticket-alt w-5 text-center text-base {{ request()->routeIs('admin.coupons.*') ? 'text-indigo-500 dark:text-indigo-400' : 'text-slate-400' }}"></i>
                                    <span>Coupons</span>
                                </div>
                                @if(request()->routeIs('admin.coupons.*'))
                                    <span class="w-1.5 h-1.5 rounded-full bg-indigo-400 shadow-[0_0_8px_#818cf8]"></span>
                                @else
                                    <i class="fas fa-chevron-right text-xs text-slate-400 dark:text-slate-400"></i>
                                @endif
                            </a>
                        </nav>
                    </div>

                    <!-- Section: Others -->
                    <div>
                        <div class="px-3 mb-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-400">
                            Others
                        </div>
                        <nav class="space-y-1.5">
                            <a href="{{ url('/') }}" target="_blank" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-sm font-medium text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.04] transition-all">
                                <div class="flex items-center space-x-3">
                                    <i class="fas fa-external-link-alt w-5 text-center text-base text-slate-400"></i>
                                    <span>Live Website</span>
                                </div>
                            </a>
                        </nav>
                    </div>
                </div>
            </div>

            <!-- Bottom Upgrade / Info Card & Logout -->
            <div class="p-4 border-t border-slate-100 dark:border-white/[0.06] space-y-3">
                <!-- Upgrade banner card matching screenshot -->
                <div class="relative overflow-hidden rounded-2xl p-4 bg-gradient-to-br from-indigo-900/60 via-purple-900/40 to-slate-900/80 border border-indigo-500/30 text-white shadow-lg">
                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-indigo-500/20 rounded-full blur-xl"></div>
                    <div class="space-y-1 mb-3 text-xs">
                        <div class="flex items-center gap-2 font-medium text-slate-200">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Live Diagnostics</span>
                        </div>
                        <div class="flex items-center gap-2 font-medium text-slate-200">
                            <i class="fas fa-check-circle text-indigo-400 text-xs"></i>
                            <span>Instant Reports</span>
                        </div>
                        <div class="flex items-center gap-2 font-medium text-slate-200">
                            <i class="fas fa-shield-alt text-indigo-400 text-xs"></i>
                            <span>HIPAA Compliant</span>
                        </div>
                    </div>
                    <a href="{{ route('admin.bookings.index') }}" class="block w-full text-center py-2 px-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-semibold shadow-md shadow-indigo-600/30 transition-all">
                        Check Live Bookings
                    </a>
                </div>

                <!-- Logout Button -->
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="w-full flex items-center justify-center space-x-2 px-3.5 py-2.5 rounded-xl text-sm font-medium text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors">
                        <i class="fas fa-arrow-right-from-bracket"></i>
                        <span>Sign Out</span>
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col min-w-0 bg-slate-50 dark:bg-[#0a0b1c] overflow-hidden">
            <!-- Top Header (Fobework Style) -->
            <header class="h-20 bg-white/80 dark:bg-[#0a0b1c]/90 backdrop-blur-xl border-b border-slate-200 dark:border-white/[0.06] flex items-center justify-between px-4 sm:px-8 z-20 transition-colors duration-300">
                <!-- Left: Mobile Toggle & Breadcrumb -->
                <div class="flex items-center space-x-4">
                    <button id="mobileMenuBtn" class="md:hidden p-2 rounded-xl text-slate-500 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-white/[0.06] transition-colors">
                        <i class="fas fa-bars-staggered text-xl"></i>
                    </button>
                    
                    <!-- Breadcrumbs matching screenshot: [icon] School / Overview -->
                    <div class="flex items-center space-x-2.5 text-sm">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/[0.05] flex items-center justify-center text-slate-400 dark:text-slate-400 border border-slate-200 dark:border-white/[0.06]">
                            <i class="fas fa-table-cells-large text-xs"></i>
                        </div>
                        <div class="flex items-center space-x-2 font-medium text-slate-400 dark:text-slate-400 text-xs sm:text-sm">
                            <span>Lab</span>
                            <span class="text-slate-300 dark:text-slate-400">/</span>
                            <span class="text-slate-900 dark:text-white font-semibold">@yield('header', 'Overview')</span>
                        </div>
                    </div>
                </div>

                <!-- Right Tools: Search, Theme Toggle, Notifications, Profile -->
                <div class="flex items-center space-x-3 sm:space-x-5">
                    <!-- Search Input (Fobework Style) -->
                    <div class="hidden lg:flex items-center relative">
                        <i class="fas fa-search absolute left-3.5 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Search test, booking, patient..." class="w-64 pl-9 pr-12 py-2 bg-slate-100 dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.08] rounded-xl text-xs text-slate-800 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/50 transition-all">
                        <span class="absolute right-2.5 px-1.5 py-0.5 rounded text-[10px] font-semibold bg-slate-200 dark:bg-white/[0.08] text-slate-400 dark:text-slate-400">⌘/</span>
                    </div>

                    <!-- History / Refresh Tooltip Button -->
                    <button onclick="window.location.reload()" title="Refresh Dashboard" class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.08] flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/[0.06] transition-all">
                        <i class="fas fa-rotate-right text-xs"></i>
                    </button>

                    <!-- Notifications Button -->
                    <button class="relative w-9 h-9 rounded-xl bg-slate-100 dark:bg-[#12142d] border border-slate-200 dark:border-white/[0.08] flex items-center justify-center text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-200 dark:hover:bg-white/[0.06] transition-all">
                        <i class="fas fa-bell text-xs"></i>
                        <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-indigo-500 ring-2 ring-white dark:ring-[#0a0b1c] animate-pulse"></span>
                    </button>

                    <!-- Dark to White / Light Mode Theme Toggle Switch (Matching "Switch to Pro" position) -->
                    <div class="flex items-center space-x-2 pl-2 border-l border-slate-200 dark:border-white/[0.08]">
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400 hidden sm:inline-block">Theme</span>
                        <button id="themeToggleBtn" type="button" aria-label="Toggle Theme" class="relative inline-flex h-7 w-14 items-center rounded-full bg-slate-200 dark:bg-indigo-900/60 border border-slate-300 dark:border-indigo-500/40 p-1 transition-colors duration-300 focus:outline-none">
                            <span id="themeToggleThumb" class="inline-block h-5 w-5 transform rounded-full bg-white dark:bg-indigo-500 shadow-md transition-transform duration-300 flex items-center justify-center text-[10px] text-amber-500 dark:text-white translate-x-7 dark:translate-x-7">
                                <i id="themeIcon" class="fas fa-moon"></i>
                            </span>
                        </button>
                    </div>

                    <!-- User Profile Avatar Pill -->
                    <div class="flex items-center space-x-3 pl-2">
                        <div class="relative">
                            <img class="h-9 w-9 rounded-full object-cover ring-2 ring-indigo-500/40 shadow-sm" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100&auto=format&fit=crop&q=80" alt="Admin Avatar">
                            <span class="absolute bottom-0 right-0 block h-2.5 w-2.5 rounded-full bg-emerald-500 ring-2 ring-white dark:ring-[#0a0b1c]"></span>
                        </div>
                        <div class="hidden xl:block text-left">
                            <div class="text-xs font-bold text-slate-800 dark:text-white leading-tight">Super Admin</div>
                            <div class="text-[10px] text-slate-400">@adminWellcare</div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Main Scrollable Body Area -->
            <main class="flex-1 overflow-y-auto px-4 sm:px-8 py-6 sm:py-8 space-y-6">
                <!-- Alerts / Flash Messages -->
                @if(session('success'))
                    <div class="p-4 rounded-2xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 flex items-center justify-between shadow-lg shadow-emerald-500/5 animate-fade-in">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-circle-check text-emerald-400 text-lg"></i>
                            <span class="text-sm font-medium text-emerald-700 dark:text-emerald-300">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-emerald-400 hover:text-emerald-300 text-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif
                
                @if(session('error'))
                    <div class="p-4 rounded-2xl bg-rose-500/10 border border-rose-500/30 text-rose-400 flex items-center justify-between shadow-lg shadow-rose-500/5 animate-fade-in">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-circle-exclamation text-rose-400 text-lg"></i>
                            <span class="text-sm font-medium text-rose-700 dark:text-rose-300">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="text-rose-400 hover:text-rose-300 text-sm">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endif

                <!-- Yield Content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Responsive Sidebar and Theme Switcher JavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Theme Toggle Logic
            const themeToggleBtn = document.getElementById('themeToggleBtn');
            const themeToggleThumb = document.getElementById('themeToggleThumb');
            const themeIcon = document.getElementById('themeIcon');
            const htmlElement = document.documentElement;

            function applyTheme(theme) {
                if (theme === 'light') {
                    htmlElement.classList.remove('dark');
                    localStorage.setItem('admin_theme', 'light');
                    themeToggleThumb.classList.remove('translate-x-7');
                    themeToggleThumb.classList.add('translate-x-0');
                    themeIcon.className = 'fas fa-sun text-amber-500';
                } else {
                    htmlElement.classList.add('dark');
                    localStorage.setItem('admin_theme', 'dark');
                    themeToggleThumb.classList.remove('translate-x-0');
                    themeToggleThumb.classList.add('translate-x-7');
                    themeIcon.className = 'fas fa-moon text-white';
                }
            }

            // Init theme toggle button position
            const currentTheme = localStorage.getItem('admin_theme') || (htmlElement.classList.contains('dark') ? 'dark' : 'light');
            applyTheme(currentTheme);

            themeToggleBtn.addEventListener('click', function() {
                const isDark = htmlElement.classList.contains('dark');
                applyTheme(isDark ? 'light' : 'dark');
            });

            // Mobile Sidebar Drawer Logic
            const sidebar = document.getElementById('sidebar');
            const sidebarOverlay = document.getElementById('sidebarOverlay');
            const mobileMenuBtn = document.getElementById('mobileMenuBtn');
            const closeSidebarBtn = document.getElementById('closeSidebarBtn');

            function openSidebar() {
                sidebar.classList.remove('-translate-x-full');
                sidebarOverlay.classList.remove('hidden');
                setTimeout(() => {
                    sidebarOverlay.classList.remove('opacity-0');
                }, 10);
            }

            function closeSidebar() {
                sidebar.classList.add('-translate-x-full');
                sidebarOverlay.classList.add('opacity-0');
                setTimeout(() => {
                    sidebarOverlay.classList.add('hidden');
                }, 300);
            }

            if (mobileMenuBtn) mobileMenuBtn.addEventListener('click', openSidebar);
            if (closeSidebarBtn) closeSidebarBtn.addEventListener('click', closeSidebar);
            if (sidebarOverlay) sidebarOverlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>
</html>
