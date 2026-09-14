@extends('admin.layout.app')

@section('title', 'Admin Dashboard')
@section('header', 'Overview')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Top Grid: Main Left Content (2 Cols on xl) + Right Sidebar (1 Col on xl) -->
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-8">
        
        <!-- LEFT 2 COLUMNS: Stats, Banner, Featured Services, Timeline Schedule -->
        <div class="xl:col-span-2 space-y-8">
            
            <!-- 1. Top Section: My Lab Stats -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Lab Performance Stats</h2>
                    <span class="text-xs text-slate-400 font-medium flex items-center gap-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                        Live Updating
                    </span>
                </div>

                <!-- 3 Key Stat Cards matching screenshot (32 Pending, 67% Goal, 18 Enrolled) + 4th Revenue Stat -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Stat Card 1: Pending Bookings -->
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1 tracking-tight">
                                    {{ $pendingBookings ?? 0 }}
                                </div>
                                <div class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                    Pending Bookings
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-purple-500/10 dark:bg-purple-500/20 border border-purple-500/20 flex items-center justify-center text-purple-600 dark:text-purple-400 group-hover:rotate-12 transition-transform">
                                <i class="fas fa-stopwatch text-base"></i>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-[11px] text-amber-500 dark:text-amber-400 font-medium">
                            <i class="fas fa-clock mr-1"></i> Awaiting sample collection
                        </div>
                    </div>

                    <!-- Stat Card 2: Weekly Goal Reached -->
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1 tracking-tight">
                                    {{ $completionRate ?? 67 }}%
                                </div>
                                <div class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                    Goal Reached
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-emerald-500/10 dark:bg-emerald-500/20 border border-emerald-500/20 flex items-center justify-center text-emerald-600 dark:text-emerald-400 group-hover:scale-110 transition-transform">
                                <i class="fas fa-bullseye text-base"></i>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-[11px] text-emerald-600 dark:text-emerald-400 font-medium">
                            <i class="fas fa-arrow-trend-up mr-1"></i> +12% from last week
                        </div>
                    </div>

                    <!-- Stat Card 3: Active Tests -->
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="text-3xl font-extrabold text-slate-900 dark:text-white mb-1 tracking-tight">
                                    {{ $activeTests ?? 0 }}
                                </div>
                                <div class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                    Active Tests
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-cyan-500/10 dark:bg-cyan-500/20 border border-cyan-500/20 flex items-center justify-center text-cyan-600 dark:text-cyan-400 group-hover:-rotate-12 transition-transform">
                                <i class="fas fa-flask-vial text-base"></i>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-[11px] text-cyan-600 dark:text-cyan-400 font-medium">
                            <i class="fas fa-check-circle mr-1"></i> Ready for ordering
                        </div>
                    </div>

                    <!-- Stat Card 4: Total Revenue -->
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden group hover:scale-[1.02] transition-all duration-300">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white mb-1 tracking-tight">
                                    ₹{{ number_format($totalRevenue ?? 0, 0) }}
                                </div>
                                <div class="text-xs font-medium text-slate-500 dark:text-slate-400">
                                    Total Revenue
                                </div>
                            </div>
                            <div class="w-10 h-10 rounded-xl bg-indigo-500/10 dark:bg-indigo-500/20 border border-indigo-500/20 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform">
                                <i class="fas fa-indian-rupee-sign text-base"></i>
                            </div>
                        </div>
                        <div class="mt-3 flex items-center text-[11px] text-indigo-600 dark:text-indigo-400 font-medium">
                            <i class="fas fa-layer-group mr-1"></i> {{ $totalBookings ?? 0 }} Bookings total
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Quick Action Banner ("Career Guide tools and resources" Style) -->
            <div class="glass-card rounded-2xl p-6 relative overflow-hidden bg-gradient-to-r from-indigo-950/40 via-purple-950/30 to-slate-900/40 border border-indigo-500/20">
                <div class="absolute -right-6 -bottom-6 w-36 h-36 bg-gradient-to-br from-indigo-500/20 to-purple-500/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 relative z-10">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-purple-500 flex items-center justify-center text-white text-xl shadow-lg shadow-indigo-500/30 flex-shrink-0">
                            <i class="fas fa-notes-medical"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-900 dark:text-white">Diagnostic Tools & Quick Management</h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5 max-w-xl">
                                Verify incoming patient appointments, update sample status, and manage diagnostic packages in real-time.
                            </p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <a href="{{ route('admin.bookings.index') }}" class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-xs font-semibold shadow-lg shadow-indigo-600/30 hover:scale-105 transition-all flex items-center gap-2 whitespace-nowrap">
                            <span>Manage Bookings</span>
                            <i class="fas fa-arrow-right text-[10px]"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. Featured Diagnostics / Enrolment Section ("My Enrolment" Style) -->
            <div>
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-tight">Active Health Packages</h2>
                    <a href="{{ route('admin.packages.index') }}" class="text-xs font-semibold text-indigo-500 hover:text-indigo-400 flex items-center gap-1 transition-colors">
                        View all <i class="fas fa-chevron-right text-[10px]"></i>
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Package Card 1 -->
                    @if(isset($featuredPackages[0]))
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden group hover:scale-[1.01] transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3.5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-500/20 via-cyan-500/10 to-indigo-500/20 border border-emerald-500/30 flex items-center justify-center text-emerald-400 text-2xl shadow-md">
                                    <i class="fas fa-shield-heart"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-sm group-hover:text-indigo-400 transition-colors">
                                        {{ $featuredPackages[0]->name }}
                                    </h4>
                                    <div class="flex items-center space-x-3 text-[11px] text-slate-400 mt-1">
                                        <span class="flex items-center gap-1"><i class="fas fa-vial text-emerald-400"></i> ₹{{ $featuredPackages[0]->price }}</span>
                                        <span class="text-slate-500">•</span>
                                        <span class="flex items-center gap-1"><i class="fas fa-clock text-cyan-400"></i> 12h Fasting</span>
                                    </div>
                                </div>
                            </div>
                            <button class="text-slate-400 hover:text-white p-1">
                                <i class="fas fa-ellipsis-vertical text-sm"></i>
                            </button>
                        </div>

                        <!-- Progress Bar & Actions -->
                        <div class="space-y-2 mt-4 pt-4 border-t border-slate-100 dark:border-white/[0.06]">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-500 dark:text-slate-400 font-medium">Demand Rate</span>
                                <span class="font-bold text-emerald-400">84%</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-200 dark:bg-white/[0.08] overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-emerald-500 to-cyan-500 rounded-full" style="width: 84%"></div>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[11px] text-slate-400">Active in Catalog</span>
                                <a href="{{ route('admin.packages.edit', $featuredPackages[0]->id) }}" class="px-3.5 py-1.5 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-500 dark:text-indigo-400 border border-indigo-500/30 text-xs font-semibold transition-all">
                                    Manage
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-indigo-500/20 text-indigo-400 flex items-center justify-center text-xl">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-800 dark:text-white">Comprehensive Health Panel</h4>
                                <p class="text-xs text-slate-400">65 Parameters Included</p>
                            </div>
                        </div>
                    </div>
                    @endif

                    <!-- Package Card 2 -->
                    @if(isset($featuredPackages[1]))
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden group hover:scale-[1.01] transition-all">
                        <div class="flex items-start justify-between mb-4">
                            <div class="flex items-center space-x-3.5">
                                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-indigo-500/20 via-purple-500/10 to-pink-500/20 border border-indigo-500/30 flex items-center justify-center text-indigo-400 text-2xl shadow-md">
                                    <i class="fas fa-dna"></i>
                                </div>
                                <div>
                                    <h4 class="font-bold text-slate-900 dark:text-white text-sm group-hover:text-indigo-400 transition-colors">
                                        {{ $featuredPackages[1]->name }}
                                    </h4>
                                    <div class="flex items-center space-x-3 text-[11px] text-slate-400 mt-1">
                                        <span class="flex items-center gap-1"><i class="fas fa-vial text-purple-400"></i> ₹{{ $featuredPackages[1]->price }}</span>
                                        <span class="text-slate-500">•</span>
                                        <span class="flex items-center gap-1"><i class="fas fa-clock text-cyan-400"></i> Same-Day</span>
                                    </div>
                                </div>
                            </div>
                            <button class="text-slate-400 hover:text-white p-1">
                                <i class="fas fa-ellipsis-vertical text-sm"></i>
                            </button>
                        </div>

                        <!-- Progress Bar & Actions -->
                        <div class="space-y-2 mt-4 pt-4 border-t border-slate-100 dark:border-white/[0.06]">
                            <div class="flex justify-between items-center text-xs">
                                <span class="text-slate-500 dark:text-slate-400 font-medium">Demand Rate</span>
                                <span class="font-bold text-indigo-400">62%</span>
                            </div>
                            <div class="w-full h-2 rounded-full bg-slate-200 dark:bg-white/[0.08] overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-indigo-500 to-purple-500 rounded-full" style="width: 62%"></div>
                            </div>
                            <div class="flex justify-between items-center pt-2">
                                <span class="text-[11px] text-slate-400">Active in Catalog</span>
                                <a href="{{ route('admin.packages.edit', $featuredPackages[1]->id) }}" class="px-3.5 py-1.5 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-500 dark:text-indigo-400 border border-indigo-500/30 text-xs font-semibold transition-all">
                                    Manage
                                </a>
                            </div>
                        </div>
                    </div>
                    @else
                    <div class="glass-card rounded-2xl p-5 relative overflow-hidden">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-xl bg-purple-500/20 text-purple-400 flex items-center justify-center text-xl">
                                <i class="fas fa-heart-pulse"></i>
                            </div>
                            <div>
                                <h4 class="font-bold text-sm text-slate-800 dark:text-white">Cardiac & Lipid Profile</h4>
                                <p class="text-xs text-slate-400">32 Parameters Included</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- 4. Schedule & Bookings Timeline ("Assignments" Style) -->
            <div class="glass-card rounded-2xl p-6">
                <!-- Header with Date range and navigation -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-6">
                    <div class="flex items-center space-x-2">
                        <h3 class="text-base font-bold text-slate-900 dark:text-white">Today's Schedule & Appointments</h3>
                        <span class="text-xs text-slate-400 font-medium">({{ now()->format('M d') }} - {{ now()->addDays(14)->format('M d') }})</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                            <i class="fas fa-chevron-left text-xs"></i>
                        </button>
                        <button class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] flex items-center justify-center text-slate-400 hover:text-white transition-colors">
                            <i class="fas fa-chevron-right text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Horizontal Date Strip matching screenshot (S M T W T F S 01..15 with 08 active) -->
                <div class="flex items-center justify-between overflow-x-auto pb-4 mb-6 border-b border-slate-100 dark:border-white/[0.06] text-center gap-2">
                    @php
                        $days = ['S', 'M', 'T', 'W', 'T', 'F', 'S', 'S', 'M', 'T', 'W', 'T', 'F', 'S'];
                        $currentDayNum = (int)now()->format('d');
                    @endphp
                    @for($i = 1; $i <= 14; $i++)
                        @php
                            $dayDate = now()->subDays(3)->addDays($i);
                            $isSelected = $dayDate->isToday();
                        @endphp
                        <div class="flex flex-col items-center flex-shrink-0 cursor-pointer group">
                            <span class="text-[10px] uppercase font-bold text-slate-400 mb-1.5 group-hover:text-indigo-400">
                                {{ $dayDate->format('D')[0] }}
                            </span>
                            <div class="w-9 h-9 rounded-full flex items-center justify-center text-xs font-bold transition-all {{ $isSelected ? 'bg-gradient-to-tr from-indigo-600 to-purple-600 text-white shadow-lg shadow-indigo-500/40 ring-4 ring-indigo-500/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-white/[0.06]' }}">
                                {{ $dayDate->format('d') }}
                            </div>
                        </div>
                    @endfor
                </div>

                <!-- Vertical Timeline Appointments (Matching screenshot layout) -->
                <div class="space-y-4">
                    @forelse($recentBookings as $index => $booking)
                        @php
                            $times = ['09:30 - 10:00', '10:30 - 11:00', '11:30 - 12:00', '14:00 - 14:30', '15:30 - 16:00', '16:30 - 17:00'];
                            $timeSlot = $times[$index % count($times)];
                        @endphp
                        <div class="flex items-center space-x-4 p-3.5 rounded-xl hover:bg-slate-100 dark:hover:bg-white/[0.03] transition-colors group">
                            <!-- Time column -->
                            <div class="w-24 flex-shrink-0 text-xs font-semibold text-slate-400 group-hover:text-indigo-400 transition-colors">
                                {{ $timeSlot }}
                            </div>

                            <!-- Vertical Bar Accent -->
                            <div class="w-1 h-9 rounded-full {{ $booking->status == 'Completed' ? 'bg-emerald-500' : ($booking->status == 'Pending' ? 'bg-amber-500' : 'bg-indigo-500') }} flex-shrink-0"></div>

                            <!-- Appointment Info -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <h5 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                                        {{ $booking->patient->name ?? 'Patient Record' }} 
                                        <span class="text-xs font-normal text-slate-400">(#{{ $booking->booking_reference }})</span>
                                    </h5>
                                    
                                    <!-- Right Action & Avatar Stack -->
                                    <div class="flex items-center space-x-3">
                                        <div class="flex -space-x-2 overflow-hidden">
                                            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-slate-900 object-cover" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=50" alt="">
                                            <img class="inline-block h-6 w-6 rounded-full ring-2 ring-slate-900 object-cover" src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=50" alt="">
                                        </div>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="w-7 h-7 rounded-full border border-slate-300 dark:border-white/[0.2] flex items-center justify-center text-slate-400 hover:text-white hover:border-indigo-400 transition-colors">
                                            <i class="fas fa-chevron-right text-[10px]"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="flex items-center space-x-2 text-[11px] text-slate-500 dark:text-slate-400 mt-0.5">
                                    <span>₹{{ $booking->amount }}</span>
                                    <span>•</span>
                                    <span class="font-medium {{ $booking->status == 'Completed' ? 'text-emerald-400' : ($booking->status == 'Pending' ? 'text-amber-400' : 'text-indigo-400') }}">
                                        {{ $booking->status }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-6 text-slate-400 text-xs">
                            No appointments scheduled for this timeline.
                        </div>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- RIGHT 1 COLUMN: Student Profile / Super Admin Profile & March Statistics Ring -->
        <div class="space-y-8">
            
            <!-- 1. Super Admin Profile Card (Matching "Student Profile" in Screenshot) -->
            <div class="glass-card rounded-2xl p-6 text-center relative overflow-hidden">
                <div class="text-left mb-6">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Admin Profile</h3>
                </div>

                <!-- Avatar with glowing neon violet ring -->
                <div class="relative inline-block mx-auto mb-4">
                    <div class="w-24 h-24 rounded-full p-1 bg-gradient-to-tr from-indigo-500 via-purple-500 to-cyan-400 shadow-xl shadow-purple-500/30">
                        <img class="w-full h-full rounded-full object-cover border-2 border-slate-900" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=200&auto=format&fit=crop&q=80" alt="Super Admin Profile">
                    </div>
                    <span class="absolute bottom-1 right-2 w-4 h-4 rounded-full bg-emerald-500 ring-2 ring-slate-900"></span>
                </div>

                <h4 class="text-lg font-extrabold text-slate-900 dark:text-white">Super Admin</h4>
                <p class="text-xs text-slate-400 mt-0.5">@adminWellcare</p>

                <!-- 3 Mini Stats (Rank, Average, Course -> Level, Avg Time, Tests) -->
                <div class="grid grid-cols-3 gap-2 mt-6 pt-6 border-t border-slate-100 dark:border-white/[0.06]">
                    <div>
                        <div class="text-lg font-bold text-slate-900 dark:text-white">Chief</div>
                        <div class="text-[11px] text-slate-400 font-medium">Rank</div>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-slate-900 dark:text-white">4.2 h</div>
                        <div class="text-[11px] text-slate-400 font-medium">Avg Report</div>
                    </div>
                    <div>
                        <div class="text-lg font-bold text-slate-900 dark:text-white">{{ $activeTests ?? 18 }}</div>
                        <div class="text-[11px] text-slate-400 font-medium">Tests</div>
                    </div>
                </div>
            </div>

            <!-- 2. Statistics on March / Analytics Ring Chart (Matching Screenshot) -->
            <div class="glass-card rounded-2xl p-6 relative overflow-hidden">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-base font-bold text-slate-900 dark:text-white">Statistics on {{ now()->format('F') }}</h3>
                </div>

                <!-- SVG Doughnut Chart Ring (Purple, Green, Cyan, Amber segments with 67% Avg in Center) -->
                <div class="relative w-44 h-44 mx-auto my-4 flex items-center justify-center">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 120 120">
                        <!-- Background Ring -->
                        <circle cx="60" cy="60" r="48" fill="transparent" stroke="rgba(255, 255, 255, 0.05)" stroke-width="12"></circle>
                        
                        <!-- Segment 1: Purple (Completed) -->
                        <circle cx="60" cy="60" r="48" fill="transparent" stroke="#8b5cf6" stroke-width="12"
                                stroke-dasharray="301.6" stroke-dashoffset="100" stroke-linecap="round" class="transition-all duration-1000 ease-out"></circle>
                                
                        <!-- Segment 2: Green (Sample Collected) -->
                        <circle cx="60" cy="60" r="48" fill="transparent" stroke="#10b981" stroke-width="12"
                                stroke-dasharray="301.6" stroke-dashoffset="210" stroke-linecap="round" class="transition-all duration-1000 ease-out"></circle>

                        <!-- Segment 3: Cyan / Yellow (Pending) -->
                        <circle cx="60" cy="60" r="48" fill="transparent" stroke="#f59e0b" stroke-width="12"
                                stroke-dasharray="301.6" stroke-dashoffset="270" stroke-linecap="round" class="transition-all duration-1000 ease-out"></circle>
                    </svg>

                    <!-- Center Label -->
                    <div class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                            {{ $completionRate ?? 67 }}%
                        </span>
                        <span class="text-[11px] font-semibold text-slate-400">Avg Success</span>
                    </div>
                </div>

                <!-- Breakdown Progress Bars matching screenshot -->
                <div class="space-y-4 mt-6">
                    <!-- Item 1: Class complete -> Test complete -->
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Tests Completed</span>
                            <span class="text-slate-400 font-bold">68%</span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-slate-200 dark:bg-white/[0.08] overflow-hidden">
                            <div class="h-full bg-purple-500 rounded-full" style="width: 68%"></div>
                        </div>
                    </div>

                    <!-- Item 2: Assignment complete -> Sample collected -->
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Sample Collected</span>
                            <span class="text-slate-400 font-bold">85%</span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-slate-200 dark:bg-white/[0.08] overflow-hidden">
                            <div class="h-full bg-emerald-500 rounded-full" style="width: 85%"></div>
                        </div>
                    </div>

                    <!-- Item 3: Session complete -> Reports Ready -->
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Reports Dispatched</span>
                            <span class="text-slate-400 font-bold">60%</span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-slate-200 dark:bg-white/[0.08] overflow-hidden">
                            <div class="h-full bg-cyan-500 rounded-full" style="width: 60%"></div>
                        </div>
                    </div>

                    <!-- Item 4: Others -> Pending Review -->
                    <div>
                        <div class="flex justify-between items-center text-xs mb-1.5">
                            <span class="text-slate-600 dark:text-slate-300 font-medium">Pending Review</span>
                            <span class="text-slate-400 font-bold">25%</span>
                        </div>
                        <div class="w-full h-1.5 rounded-full bg-slate-200 dark:bg-white/[0.08] overflow-hidden">
                            <div class="h-full bg-amber-500 rounded-full" style="width: 25%"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Bottom Section: Complete Recent Bookings Table (100% Data Preservation) -->
    <div class="glass-card rounded-2xl overflow-hidden border border-slate-200 dark:border-white/[0.08]">
        <div class="p-6 border-b border-slate-100 dark:border-white/[0.06] flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Recent Lab Bookings</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Detailed ledger of recent patient appointments and payment status</p>
            </div>
            <a href="{{ route('admin.bookings.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-white/[0.06] hover:bg-slate-200 dark:hover:bg-white/[0.1] text-indigo-500 dark:text-indigo-400 text-xs font-semibold transition-all inline-flex items-center gap-2 self-start sm:self-auto">
                <span>View Full Database</span>
                <i class="fas fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-white/[0.06] bg-slate-50/50 dark:bg-white/[0.02] text-slate-400 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-semibold">Reference</th>
                        <th class="px-6 py-4 font-semibold">Patient</th>
                        <th class="px-6 py-4 font-semibold">Date & Time</th>
                        <th class="px-6 py-4 font-semibold">Amount</th>
                        <th class="px-6 py-4 font-semibold">Status</th>
                        <th class="px-6 py-4 font-semibold text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/[0.06] text-sm">
                    @forelse($recentBookings ?? [] as $booking)
                    <tr class="hover:bg-slate-50/60 dark:hover:bg-white/[0.02] transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                            #{{ $booking->booking_reference }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-medium text-slate-800 dark:text-slate-200">{{ $booking->patient->name ?? 'Guest Patient' }}</div>
                            <div class="text-xs text-slate-400">{{ $booking->patient->phone ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 text-slate-500 dark:text-slate-400 text-xs">
                            {{ $booking->booking_date ? $booking->booking_date->format('M d, Y h:i A') : 'N/A' }}
                        </td>
                        <td class="px-6 py-4 font-bold text-slate-800 dark:text-slate-200">
                            ₹{{ number_format($booking->amount, 2) }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                {{ $booking->status == 'Completed' ? 'bg-emerald-500/10 text-emerald-400 border border-emerald-500/30' : 
                                  ($booking->status == 'Pending' ? 'bg-amber-500/10 text-amber-400 border border-amber-500/30' : 
                                  ($booking->status == 'Cancelled' ? 'bg-rose-500/10 text-rose-400 border border-rose-500/30' : 
                                   'bg-indigo-500/10 text-indigo-400 border border-indigo-500/30')) }}">
                                <span class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $booking->status == 'Completed' ? 'bg-emerald-400' : ($booking->status == 'Pending' ? 'bg-amber-400' : ($booking->status == 'Cancelled' ? 'bg-rose-400' : 'bg-indigo-400')) }}"></span>
                                {{ $booking->status }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right space-x-2">
                            <a href="{{ route('admin.bookings.show', $booking->id) }}" class="inline-flex items-center px-3 py-1.5 rounded-lg bg-indigo-500/10 hover:bg-indigo-500/20 text-indigo-400 border border-indigo-500/30 text-xs font-semibold transition-colors">
                                <i class="fas fa-eye mr-1.5 text-[10px]"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-10 text-center text-slate-400 text-sm">
                            <i class="fas fa-calendar-xmark text-2xl mb-2 block text-slate-500"></i>
                            No recent bookings found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
