@extends('admin.layouts.app')

@section('title', isset($plan) ? 'Edit Membership Plan' : 'Create Membership Card')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.memberships.index') }}" class="w-10 h-10 rounded-xl bg-white dark:bg-white/[0.05] border border-slate-200 dark:border-white/[0.08] text-slate-500 hover:text-slate-900 dark:hover:text-white flex items-center justify-center transition shadow-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white">
                    {{ isset($plan) ? 'Edit Membership Card: ' . $plan->name : 'Create New VIP Membership Card' }}
                </h1>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Define membership duration in years or months, discount percentages, and loyalty benefits.</p>
            </div>
        </div>
    </div>

    <!-- Main Form Container -->
    <div class="bg-white dark:bg-white/[0.02] border border-slate-200/80 dark:border-white/[0.05] rounded-3xl p-6 sm:p-8 shadow-sm">
        <form action="{{ isset($plan) ? route('admin.memberships.update', $plan->id) : route('admin.memberships.store') }}" method="POST" class="space-y-6">
            @csrf
            @if(isset($plan))
                @method('PUT')
            @endif

            <!-- 1. Basic Plan Identity -->
            <div class="space-y-4">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <i class="fas fa-id-card text-amber-500"></i>
                    <span>Plan Identity & Branding</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Name -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Membership Card Title <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $plan->name ?? '') }}" 
                            placeholder="e.g. Wellcare VIP Gold Pass (1 Year)" 
                            required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-sm font-bold text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                        >
                    </div>

                    <!-- Tagline -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Short Subtitle / Tagline
                        </label>
                        <input 
                            type="text" 
                            name="tagline" 
                            value="{{ old('tagline', $plan->tagline ?? '') }}" 
                            placeholder="e.g. Best for individuals & annual preventive health checkups" 
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-semibold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                        >
                    </div>

                    <!-- Theme Color -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Visual Card Theme <span class="text-rose-500">*</span>
                        </label>
                        @php
                            $selectedTheme = old('theme_color', $plan->theme_color ?? 'gold');
                        @endphp
                        <select name="theme_color" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                            <option value="gold" {{ $selectedTheme === 'gold' ? 'selected' : '' }}>👑 Gold (Warm Amber / Luxury)</option>
                            <option value="platinum" {{ $selectedTheme === 'platinum' ? 'selected' : '' }}>💎 Platinum (Sleek Slate / Premium)</option>
                            <option value="emerald" {{ $selectedTheme === 'emerald' ? 'selected' : '' }}>🌿 Emerald (Teal / Health Wellness)</option>
                            <option value="purple" {{ $selectedTheme === 'purple' ? 'selected' : '' }}>💜 Royal Purple (Executive Care)</option>
                        </select>
                    </div>

                    <!-- Family Coverage Limit -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Family Members Covered <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="number" 
                                name="family_coverage_limit" 
                                value="{{ old('family_coverage_limit', $plan->family_coverage_limit ?? 4) }}" 
                                min="1" 
                                max="20" 
                                required
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                            >
                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">Members</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. Validity Duration & Pricing -->
            <div class="pt-6 border-t border-slate-100 dark:border-white/[0.05] space-y-4">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <i class="fas fa-calendar-alt text-teal-500"></i>
                    <span>Validity & Pricing Structure</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <!-- Duration Type -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Duration Unit <span class="text-rose-500">*</span>
                        </label>
                        @php
                            $selectedDurationType = old('duration_type', $plan->duration_type ?? 'years');
                        @endphp
                        <select name="duration_type" class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500">
                            <option value="years" {{ $selectedDurationType === 'years' ? 'selected' : '' }}>Years (Annual)</option>
                            <option value="months" {{ $selectedDurationType === 'months' ? 'selected' : '' }}>Months</option>
                        </select>
                    </div>

                    <!-- Duration Value -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Duration Number <span class="text-rose-500">*</span>
                        </label>
                        <input 
                            type="number" 
                            name="duration_value" 
                            value="{{ old('duration_value', $plan->duration_value ?? 1) }}" 
                            min="1" 
                            max="60" 
                            required
                            placeholder="e.g. 1 (for 1 Year)"
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-bold text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                        >
                    </div>

                    <!-- Discount Percentage -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Test Discount Rate <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <input 
                                type="number" 
                                name="discount_percentage" 
                                value="{{ old('discount_percentage', $plan->discount_percentage ?? 20) }}" 
                                min="1" 
                                max="90" 
                                required
                                placeholder="20"
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-black text-emerald-600 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                            >
                            <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">% OFF</span>
                        </div>
                    </div>

                    <!-- Selling Price -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Selling Price (₹) <span class="text-rose-500">*</span>
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">₹</span>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="price" 
                                value="{{ old('price', $plan->price ?? 499) }}" 
                                required
                                placeholder="499.00"
                                class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-sm font-black text-slate-900 dark:text-white outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                            >
                        </div>
                    </div>

                    <!-- Original MRP (Strikethrough) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                            Original MRP (Strikethrough)
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-slate-400">₹</span>
                            <input 
                                type="number" 
                                step="0.01" 
                                name="original_price" 
                                value="{{ old('original_price', $plan->original_price ?? 1499) }}" 
                                placeholder="1499.00"
                                class="w-full pl-8 pr-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-sm font-bold text-slate-600 dark:text-slate-400 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500"
                            >
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. Key Benefits Checklist & Toggles -->
            <div class="pt-6 border-t border-slate-100 dark:border-white/[0.05] space-y-4">
                <h3 class="text-xs font-black uppercase tracking-wider text-slate-400 flex items-center gap-2">
                    <i class="fas fa-gift text-indigo-500"></i>
                    <span>Included Health Perks & Clinical Features</span>
                </h3>

                <!-- Feature Checkboxes -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.02] cursor-pointer hover:bg-slate-100 dark:hover:bg-white/[0.04] transition">
                        <input type="checkbox" name="free_home_collection" value="1" {{ old('free_home_collection', $plan->free_home_collection ?? true) ? 'checked' : '' }} class="rounded text-amber-500 focus:ring-amber-400">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Free Home Collection</span>
                            <span class="text-[10px] text-slate-500">Waive ₹150 sample collection fee</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.02] cursor-pointer hover:bg-slate-100 dark:hover:bg-white/[0.04] transition">
                        <input type="checkbox" name="free_teleconsultation" value="1" {{ old('free_teleconsultation', $plan->free_teleconsultation ?? true) ? 'checked' : '' }} class="rounded text-amber-500 focus:ring-amber-400">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Doctor Tele-Consult</span>
                            <span class="text-[10px] text-slate-500">Free call on every lab report</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3.5 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.02] cursor-pointer hover:bg-slate-100 dark:hover:bg-white/[0.04] transition">
                        <input type="checkbox" name="priority_reports" value="1" {{ old('priority_reports', $plan->priority_reports ?? true) ? 'checked' : '' }} class="rounded text-amber-500 focus:ring-amber-400">
                        <div>
                            <span class="block text-xs font-bold text-slate-800 dark:text-slate-200">Priority WhatsApp Reports</span>
                            <span class="text-[10px] text-slate-500">Fast 6-8 hour processing</span>
                        </div>
                    </label>
                </div>

                <!-- Custom Benefit Bullet Points -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider mb-2">
                        Custom Plan Benefits (One bullet point per line)
                    </label>
                    @php
                        $benefitsText = '';
                        if (isset($plan) && is_array($plan->benefits)) {
                            $benefitsText = implode("\n", $plan->benefits);
                        }
                    @endphp
                    <textarea 
                        name="benefits_raw" 
                        rows="5" 
                        placeholder="Flat 20% OFF on all Diagnostic Tests & Packages&#10;Zero Home Sample Collection Fee (Always Free)&#10;1 Complimentary Annual CBC Blood Profile&#10;Covers up to 4 Family Members on the same account"
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-white/[0.08] bg-slate-50/50 dark:bg-white/[0.03] text-xs font-medium text-slate-800 dark:text-slate-200 outline-none focus:ring-2 focus:ring-amber-500/20 focus:border-amber-500 leading-relaxed font-mono"
                    >{{ old('benefits_raw', $benefitsText) }}</textarea>
                    <p class="text-[11px] text-slate-400 mt-1">These will be rendered as interactive checkmark benefits on the plan card and checkout upsell.</p>
                </div>

                <!-- Display Flags -->
                <div class="flex items-center gap-6 pt-2">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_popular" value="1" {{ old('is_popular', $plan->is_popular ?? false) ? 'checked' : '' }} class="rounded text-amber-500 focus:ring-amber-400">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">★ Highlight as "Most Popular / Best Value"</span>
                    </label>

                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', $plan->is_active ?? true) ? 'checked' : '' }} class="rounded text-emerald-500 focus:ring-emerald-400">
                        <span class="text-xs font-bold text-slate-700 dark:text-slate-300">Active (Visible on checkout & patient portal)</span>
                    </label>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 border-t border-slate-100 dark:border-white/[0.05] flex items-center justify-end gap-3">
                <a href="{{ route('admin.memberships.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-white/[0.08] text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2.5 rounded-xl bg-amber-500 hover:bg-amber-600 text-slate-950 text-xs font-extrabold transition shadow-sm shadow-amber-500/30 flex items-center gap-2">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ isset($plan) ? 'Update Plan' : 'Save & Publish Plan' }}</span>
                </button>
            </div>

        </form>
    </div>
</div>
@endsection
