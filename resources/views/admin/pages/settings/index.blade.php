@extends('admin.layouts.app')

@section('title', 'Site Settings & CMS')
@section('header', 'Site Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-sliders text-indigo-500"></i>
                <span>Frontend CMS & Site Settings</span>
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Manage all frontend dynamic content, contact details, social links, addresses, stats counters, and serviceable pincodes.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 text-sm font-semibold flex items-center gap-2">
            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Settings Container with Tabs -->
    <div class="glass-card rounded-2xl overflow-hidden p-6">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-2 border-b border-slate-200 dark:border-white/[0.08] pb-4 mb-6" id="settingsTabs">
            <button type="button" onclick="switchSettingsTab('tab-general')" class="settings-tab-btn active px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 bg-indigo-600 text-white shadow-md">
                <i class="fas fa-gem"></i> General & Branding
            </button>
            <button type="button" onclick="switchSettingsTab('tab-contact')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]">
                <i class="fas fa-phone-alt"></i> Helpline & Contact
            </button>
            <button type="button" onclick="switchSettingsTab('tab-addresses')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]">
                <i class="fas fa-map-marker-alt"></i> Lab Addresses
            </button>
            <button type="button" onclick="switchSettingsTab('tab-social')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]">
                <i class="fas fa-share-nodes"></i> Social Links
            </button>
            <button type="button" onclick="switchSettingsTab('tab-stats')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]">
                <i class="fas fa-chart-line"></i> Homepage Stats
            </button>
            <button type="button" onclick="switchSettingsTab('tab-pincodes')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]">
                <i class="fas fa-truck-medical"></i> Serviceable Pincodes
            </button>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- TAB 1: General & Branding -->
            <div id="tab-general" class="settings-tab-content space-y-5">
                <input type="hidden" name="settings_group" value="general">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Website / Brand Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Av Wellcare Diagnostics' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Fast, Reliable Diagnostics' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Corporate CIN Number</label>
                        <input type="text" name="cin_number" value="{{ $settings['cin_number'] ?? 'CIN: U85190UP2021PTC149892' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Footer Copyright Notice</label>
                        <input type="text" name="copyright_text" value="{{ $settings['copyright_text'] ?? 'Av Wellcare Diagnostics © 2026. All rights reserved.' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Site Logo (Header & Branding)</label>
                        <div class="flex items-center gap-4">
                            @if(!empty($settings['site_logo']))
                                <img src="{{ $settings['site_logo'] }}" alt="Logo" class="h-12 w-auto object-contain p-2 rounded-xl bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/10">
                            @else
                                <img src="{{ asset('logo.png') }}" alt="Default Logo" class="h-12 w-auto object-contain p-2 rounded-xl bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/10">
                            @endif
                            <input type="file" name="site_logo" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-500/20 file:text-indigo-600 dark:file:text-indigo-400 hover:file:bg-indigo-100 transition cursor-pointer">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Recommended format: Transparent PNG or SVG.</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Browser Tabbar Favicon</label>
                        <div class="flex items-center gap-4">
                            @php
                                $rawFavicon = $settings['site_favicon'] ?? null;
                                $currentFavicon = $rawFavicon ? (str_starts_with($rawFavicon, 'http') ? $rawFavicon : asset($rawFavicon)) : asset('favicon.png');
                            @endphp
                            <img src="{{ $currentFavicon }}" alt="Favicon" class="h-12 w-12 object-contain p-2 rounded-xl bg-slate-100 dark:bg-white/10 border border-slate-200 dark:border-white/10 shadow-sm">
                            <input type="file" name="site_favicon" accept="image/x-icon,image/png,image/svg+xml,image/jpeg" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 dark:file:bg-indigo-500/20 file:text-indigo-600 dark:file:text-indigo-400 hover:file:bg-indigo-100 transition cursor-pointer">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Displays in browser tabs and bookmarks (ICO, PNG, or SVG).</p>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Helpline & Contact Details -->
            <div id="tab-contact" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="contact">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Primary Helpline (Header & Footer)</label>
                        <input type="text" name="helpline_primary" value="{{ $settings['helpline_primary'] ?? '898 898 8787' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Secondary Phone / Landline</label>
                        <input type="text" name="helpline_secondary" value="{{ $settings['helpline_secondary'] ?? '+91 9876543210' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Official WhatsApp Number</label>
                        <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '8988988787' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Customer Support Email</label>
                        <input type="email" name="support_email" value="{{ $settings['support_email'] ?? 'care@avwellcarediagnostics.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Home Sample Collection Operating Hours</label>
                    <input type="text" name="collection_timing" value="{{ $settings['collection_timing'] ?? 'Daily 6:00 AM – 9:00 PM (Trained Phlebotomists)' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                </div>
            </div>

            <!-- TAB 3: Official Lab Addresses -->
            <div id="tab-addresses" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="contact">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Company Registered Address</label>
                    <textarea name="registered_address" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">{{ $settings['registered_address'] ?? '' }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">National Reference Lab Address</label>
                    <textarea name="reference_lab_address" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">{{ $settings['reference_lab_address'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- TAB 4: Social Media Links -->
            <div id="tab-social" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="social">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-facebook text-blue-500 mr-1"></i> Facebook Page URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? 'https://facebook.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-twitter text-sky-400 mr-1"></i> Twitter / X Profile URL</label>
                        <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? 'https://twitter.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-linkedin text-blue-600 mr-1"></i> LinkedIn Company URL</label>
                        <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? 'https://linkedin.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-youtube text-red-500 mr-1"></i> YouTube Channel URL</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? 'https://youtube.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-instagram text-pink-500 mr-1"></i> Instagram Profile URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://instagram.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition">
                    </div>
                </div>
            </div>

            <!-- TAB 5: Homepage Stats Counter -->
            <div id="tab-stats" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="stats">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Stat 1 -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/40 border border-slate-200 dark:border-white/[0.05] space-y-3">
                        <span class="text-xs font-bold uppercase text-indigo-500">Stat Card 1</span>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Target Value</label>
                                <input type="number" name="stat_lives_touched_val" value="{{ $settings['stat_lives_touched_val'] ?? '1' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Label Text</label>
                                <input type="text" name="stat_lives_touched_text" value="{{ $settings['stat_lives_touched_text'] ?? 'Crore+ Lives Touched' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Stat 2 -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/40 border border-slate-200 dark:border-white/[0.05] space-y-3">
                        <span class="text-xs font-bold uppercase text-pink-500">Stat Card 2</span>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Target Value</label>
                                <input type="number" name="stat_owned_labs_val" value="{{ $settings['stat_owned_labs_val'] ?? '80' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Label Text</label>
                                <input type="text" name="stat_owned_labs_text" value="{{ $settings['stat_owned_labs_text'] ?? '+ Self-Owned Labs' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Stat 3 -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/40 border border-slate-200 dark:border-white/[0.05] space-y-3">
                        <span class="text-xs font-bold uppercase text-blue-500">Stat Card 3</span>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Target Value</label>
                                <input type="number" name="stat_collection_centres_val" value="{{ $settings['stat_collection_centres_val'] ?? '2000' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Label Text</label>
                                <input type="text" name="stat_collection_centres_text" value="{{ $settings['stat_collection_centres_text'] ?? '+ Collection Centres' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Stat 4 -->
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-900/40 border border-slate-200 dark:border-white/[0.05] space-y-3">
                        <span class="text-xs font-bold uppercase text-purple-500">Stat Card 4</span>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Target Value</label>
                                <input type="number" name="stat_phlebotomists_val" value="{{ $settings['stat_phlebotomists_val'] ?? '1500' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                            <div>
                                <label class="block text-[11px] font-semibold text-slate-400">Label Text</label>
                                <input type="text" name="stat_phlebotomists_text" value="{{ $settings['stat_phlebotomists_text'] ?? '+ Trained Phlebotomists' }}" class="w-full px-3 py-2 rounded-lg bg-white dark:bg-slate-800 border border-slate-200 dark:border-white/10 text-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 6: Serviceable Pincodes -->
            <div id="tab-pincodes" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="service">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Serviceable Pincodes (Comma Separated)</label>
                    <textarea name="serviceable_pincodes" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-indigo-500 transition" placeholder="800001, 800002, 110001, 201301, 201309...">{{ $settings['serviceable_pincodes'] ?? '800001, 800002, 110001, 201301, 201309, 400001, 560001' }}</textarea>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                        <i class="fas fa-info-circle mr-1 text-indigo-400"></i> Enter all pincodes where home sample collection is supported. Checkout will validate patient address pincode dynamically against this list.
                    </p>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-white/[0.08] flex justify-end">
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white font-bold text-sm shadow-lg shadow-indigo-500/25 transition">
                    <i class="fas fa-save"></i>
                    <span>Save Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchSettingsTab(tabId) {
        document.querySelectorAll('.settings-tab-content').forEach(el => el.classList.add('hidden'));
        document.getElementById(tabId).classList.remove('hidden');

        document.querySelectorAll('.settings-tab-btn').forEach(btn => {
            btn.classList.remove('bg-indigo-600', 'text-white', 'shadow-md');
            btn.classList.add('text-slate-600', 'dark:text-slate-400', 'bg-slate-100', 'dark:bg-white/[0.04]');
        });

        const activeBtn = event.currentTarget;
        activeBtn.classList.add('bg-indigo-600', 'text-white', 'shadow-md');
        activeBtn.classList.remove('text-slate-600', 'dark:text-slate-400', 'bg-slate-100', 'dark:bg-white/[0.04]');
    }
</script>
@endsection
