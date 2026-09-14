<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agent Portal') - Wellcare Diagnostics</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            primary: '#0d9488',
                            secondary: '#eab308',
                            dark: '#115e59',
                            light: '#f0fdfa',
                        }
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-slate-100 text-slate-800 min-h-screen flex flex-col pb-20 md:pb-6">

    <!-- Top Agent Header -->
    <header class="bg-slate-900 text-white shadow-md sticky top-0 z-40">
        <div class="max-w-5xl mx-auto px-4 py-3.5 flex justify-between items-center">
            <!-- Left: Brand & Agent Badge -->
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-teal-500 to-emerald-400 flex items-center justify-center text-slate-950 font-black shadow-md shadow-teal-500/20">
                    <i class="fas fa-vial text-lg"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <span class="font-extrabold text-sm tracking-tight text-white">Wellcare</span>
                        <span class="text-[10px] uppercase font-bold tracking-wider px-2 py-0.5 rounded-full bg-teal-500/20 text-teal-300 border border-teal-500/30">
                            Collector Portal
                        </span>
                    </div>
                    <div class="text-xs text-slate-400 flex items-center gap-1.5 mt-0.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                        <span class="font-semibold text-slate-200">{{ $agent->name ?? 'Agent' }}</span>
                        @if(!empty($agent->phone))
                            <span class="text-slate-500">|</span>
                            <span class="text-slate-400">{{ $agent->phone }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right: Action Buttons & Logout -->
            <div class="flex items-center space-x-2">
                <a href="{{ route('home') }}" class="hidden sm:inline-flex items-center px-3 py-1.5 text-xs font-semibold text-slate-300 hover:text-white bg-slate-800 rounded-lg hover:bg-slate-700 transition">
                    <i class="fas fa-external-link-alt mr-1.5"></i> Website
                </a>
                <a href="{{ route('agent.logout') }}" class="inline-flex items-center px-3 py-1.5 text-xs font-bold text-rose-300 hover:text-white bg-rose-500/10 hover:bg-rose-600 border border-rose-500/20 rounded-lg transition">
                    <i class="fas fa-sign-out-alt mr-1.5"></i> Logout
                </a>
            </div>
        </div>

        <!-- Navigation Tabs (Desktop & Tablet) -->
        <div class="border-t border-slate-800 bg-slate-900/90 backdrop-blur-md">
            <div class="max-w-5xl mx-auto px-4 flex space-x-1 sm:space-x-4">
                <a href="{{ route('agent.dashboard') }}" class="py-3 px-3.5 text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 transition-all {{ request()->routeIs('agent.dashboard') ? 'border-teal-400 text-teal-300 bg-white/5' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Assigned Visits</span>
                </a>
                <a href="{{ route('agent.progress') }}" class="py-3 px-3.5 text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 transition-all {{ request()->routeIs('agent.progress') ? 'border-teal-400 text-teal-300 bg-white/5' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
                    <i class="fas fa-route"></i>
                    <span>Live Progress</span>
                </a>
                <a href="{{ route('agent.collections') }}" class="py-3 px-3.5 text-xs sm:text-sm font-bold flex items-center gap-2 border-b-2 transition-all {{ request()->routeIs('agent.collections') ? 'border-teal-400 text-teal-300 bg-white/5' : 'border-transparent text-slate-400 hover:text-slate-200' }}">
                    <i class="fas fa-hand-holding-usd"></i>
                    <span>Money Collections</span>
                </a>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main class="flex-grow max-w-5xl w-full mx-auto px-3 sm:px-4 py-5">
        <!-- Flash Alerts -->
        @if(session('success'))
            <div class="mb-5 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-800 flex items-center gap-3 text-sm font-semibold shadow-sm">
                <i class="fas fa-check-circle text-emerald-600 text-lg"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-5 p-4 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-800 flex items-center gap-3 text-sm font-semibold shadow-sm">
                <i class="fas fa-exclamation-circle text-rose-600 text-lg"></i>
                <span>{{ session('error') }}</span>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-5 p-4 rounded-xl bg-blue-500/10 border border-blue-500/30 text-blue-800 flex items-center gap-3 text-sm font-semibold shadow-sm">
                <i class="fas fa-info-circle text-blue-600 text-lg"></i>
                <span>{{ session('info') }}</span>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Mobile Bottom Navigation Bar (Fixed) -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-slate-200 shadow-2xl z-50 py-1.5 px-4 flex justify-around">
        <a href="{{ route('agent.dashboard') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-[11px] font-bold transition-all {{ request()->routeIs('agent.dashboard') ? 'text-teal-700 font-extrabold' : 'text-slate-400 hover:text-slate-600' }}">
            <i class="fas fa-clipboard-list text-base mb-0.5"></i>
            <span>Visits</span>
        </a>
        <a href="{{ route('agent.progress') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-[11px] font-bold transition-all {{ request()->routeIs('agent.progress') ? 'text-teal-700 font-extrabold' : 'text-slate-400 hover:text-slate-600' }}">
            <i class="fas fa-route text-base mb-0.5"></i>
            <span>Progress</span>
        </a>
        <a href="{{ route('agent.collections') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-[11px] font-bold transition-all {{ request()->routeIs('agent.collections') ? 'text-teal-700 font-extrabold' : 'text-slate-400 hover:text-slate-600' }}">
            <i class="fas fa-hand-holding-usd text-base mb-0.5"></i>
            <span>Money</span>
        </a>
        <a href="{{ route('agent.logout') }}" class="flex flex-col items-center py-1 px-3 rounded-lg text-[11px] font-bold text-rose-500 hover:text-rose-700">
            <i class="fas fa-sign-out-alt text-base mb-0.5"></i>
            <span>Exit</span>
        </a>
    </nav>

    @stack('scripts')
</body>
</html>
