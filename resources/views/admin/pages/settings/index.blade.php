@extends('admin.layouts.app')

@section('title', 'Site Settings & Credentials')
@section('header', 'Site Settings')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-sliders text-teal-500"></i>
                <span>System Configuration & Gateway Credentials</span>
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">
                Configure payment gateways, email SMTP, SMS & WhatsApp notification APIs, frontend branding, and operational settings.
            </p>
        </div>
    </div>

    @if(session('success'))
        <div class="p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-600 dark:text-emerald-400 text-sm font-semibold flex items-center gap-2 shadow-sm">
            <i class="fas fa-check-circle text-emerald-500 text-lg"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <!-- Settings Container with Tabs -->
    <div class="glass-card rounded-2xl overflow-hidden p-6">
        <!-- Tab Navigation -->
        <div class="flex flex-wrap gap-2 border-b border-slate-200 dark:border-white/[0.08] pb-4 mb-6" id="settingsTabs">
            <!-- General & Content -->
            <button type="button" onclick="switchSettingsTab('general')" class="settings-tab-btn active px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 bg-teal-600 text-white shadow-md" data-tab="general">
                <i class="fas fa-gem"></i> General & Branding
            </button>
            <button type="button" onclick="switchSettingsTab('contact')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="contact">
                <i class="fas fa-phone-alt"></i> Helpline & Contact
            </button>
            <button type="button" onclick="switchSettingsTab('addresses')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="addresses">
                <i class="fas fa-map-marker-alt"></i> Lab Addresses
            </button>
            <button type="button" onclick="switchSettingsTab('social')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="social">
                <i class="fas fa-share-nodes"></i> Social Links
            </button>
            <button type="button" onclick="switchSettingsTab('pincodes')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="pincodes">
                <i class="fas fa-truck-medical"></i> Pincodes
            </button>

            <!-- Gateways & API Credentials -->
            <button type="button" onclick="switchSettingsTab('razorpay')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="razorpay">
                <i class="fas fa-credit-card text-emerald-500"></i> Razorpay Gateway
            </button>
            <button type="button" onclick="switchSettingsTab('email')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="email">
                <i class="fas fa-envelope text-teal-500"></i> Email (SMTP)
            </button>
            <button type="button" onclick="switchSettingsTab('sms')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="sms">
                <i class="fas fa-comment-sms text-sky-500"></i> SMS Gateway
            </button>
            <button type="button" onclick="switchSettingsTab('whatsapp')" class="settings-tab-btn px-4 py-2 rounded-xl text-xs font-bold uppercase tracking-wider transition flex items-center gap-2 text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-white/[0.04]" data-tab="whatsapp">
                <i class="fab fa-whatsapp text-emerald-500"></i> WhatsApp API
            </button>
        </div>

        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="active_tab" id="activeTabInput" value="{{ session('active_tab', 'general') }}">

            <!-- TAB 1: General & Branding -->
            <div id="settings-panel-general" class="settings-tab-content space-y-5">
                <input type="hidden" name="settings_group" value="general">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Website / Brand Name</label>
                        <input type="text" name="site_name" value="{{ $settings['site_name'] ?? 'Av Wellcare Diagnostics' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Tagline</label>
                        <input type="text" name="site_tagline" value="{{ $settings['site_tagline'] ?? 'Fast, Reliable Diagnostics' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5 pt-2">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Corporate CIN Number</label>
                        <input type="text" name="cin_number" value="{{ $settings['cin_number'] ?? 'CIN: U85190UP2021PTC149892' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Footer Copyright Notice</label>
                        <input type="text" name="copyright_text" value="{{ $settings['copyright_text'] ?? 'Av Wellcare Diagnostics © 2026. All rights reserved.' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
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
                            <input type="file" name="site_logo" accept="image/*" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 dark:file:bg-teal-500/20 file:text-teal-600 dark:file:text-teal-400 hover:file:bg-teal-100 transition cursor-pointer">
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
                            <input type="file" name="site_favicon" accept="image/x-icon,image/png,image/svg+xml,image/jpeg" class="text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-teal-50 dark:file:bg-teal-500/20 file:text-teal-600 dark:file:text-teal-400 hover:file:bg-teal-100 transition cursor-pointer">
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Displays in browser tabs and bookmarks (ICO, PNG, or SVG).</p>
                    </div>
                </div>
            </div>

            <!-- TAB 2: Helpline & Contact Details -->
            <div id="settings-panel-contact" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="contact">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Primary Helpline (Header & Footer)</label>
                        <input type="text" name="helpline_primary" value="{{ $settings['helpline_primary'] ?? '898 898 8787' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Secondary Phone / Landline</label>
                        <input type="text" name="helpline_secondary" value="{{ $settings['helpline_secondary'] ?? '+91 9876543210' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Official WhatsApp Helpline Number</label>
                        <input type="text" name="whatsapp_number" value="{{ $settings['whatsapp_number'] ?? '8988988787' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Customer Support Email</label>
                        <input type="email" name="support_email" value="{{ $settings['support_email'] ?? 'care@avwellcarediagnostics.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Home Sample Collection Operating Hours</label>
                    <input type="text" name="collection_timing" value="{{ $settings['collection_timing'] ?? 'Daily 6:00 AM – 9:00 PM (Trained Phlebotomists)' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                </div>
            </div>

            <!-- TAB 3: Official Lab Addresses -->
            <div id="settings-panel-addresses" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="contact">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Company Registered Address</label>
                    <textarea name="registered_address" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">{{ $settings['registered_address'] ?? '' }}</textarea>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">National Reference Lab Address</label>
                    <textarea name="reference_lab_address" rows="3" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">{{ $settings['reference_lab_address'] ?? '' }}</textarea>
                </div>
            </div>

            <!-- TAB 4: Social Media Links -->
            <div id="settings-panel-social" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="social">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-facebook text-blue-500 mr-1"></i> Facebook Page URL</label>
                        <input type="url" name="social_facebook" value="{{ $settings['social_facebook'] ?? 'https://facebook.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-twitter text-sky-400 mr-1"></i> Twitter / X Profile URL</label>
                        <input type="url" name="social_twitter" value="{{ $settings['social_twitter'] ?? 'https://twitter.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-linkedin text-blue-600 mr-1"></i> LinkedIn Company URL</label>
                        <input type="url" name="social_linkedin" value="{{ $settings['social_linkedin'] ?? 'https://linkedin.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-youtube text-red-500 mr-1"></i> YouTube Channel URL</label>
                        <input type="url" name="social_youtube" value="{{ $settings['social_youtube'] ?? 'https://youtube.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fab fa-instagram text-pink-500 mr-1"></i> Instagram Profile URL</label>
                        <input type="url" name="social_instagram" value="{{ $settings['social_instagram'] ?? 'https://instagram.com' }}" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>
                </div>
            </div>

            <!-- TAB 5: Serviceable Pincodes -->
            <div id="settings-panel-pincodes" class="settings-tab-content space-y-5 hidden">
                <input type="hidden" name="settings_group" value="service">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Serviceable Pincodes (Comma Separated)</label>
                    <textarea name="serviceable_pincodes" rows="4" class="w-full px-4 py-3 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-teal-500 transition" placeholder="800001, 800002, 110001, 201301, 201309...">{{ $settings['serviceable_pincodes'] ?? '800001, 800002, 110001, 201301, 201309, 400001, 560001' }}</textarea>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                        <i class="fas fa-info-circle mr-1 text-teal-400"></i> Enter all pincodes where home sample collection is supported. Checkout will validate patient address pincode dynamically against this list.
                    </p>
                </div>
            </div>

            <!-- TAB 6: Razorpay Payment Gateway -->
            <div id="settings-panel-razorpay" class="settings-tab-content space-y-6 hidden">
                <input type="hidden" name="settings_group" value="payment">
                
                <!-- Webhook URL Display & Copy Card -->
                <div class="p-5 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-slate-50 dark:to-white/[0.02] border border-emerald-500/30">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div>
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-black text-[10px] uppercase tracking-wider mb-1.5">
                                <i class="fas fa-bolt"></i> Automated Server-to-Server Webhook
                            </span>
                            <h4 class="font-black text-slate-900 dark:text-white text-sm">Razorpay Webhook Endpoint URL</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Configure this exact URL in your Razorpay Dashboard &rarr; Settings &rarr; Webhooks.</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <input type="text" id="webhookUrlInput" readonly value="{{ url('/api/razorpay/webhook') }}" class="px-3 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/10 font-mono text-xs text-emerald-600 dark:text-emerald-400 font-bold select-all">
                            <button type="button" onclick="copyWebhookUrl()" class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-sm transition flex items-center gap-1.5 flex-shrink-0">
                                <i class="fas fa-copy text-xs"></i>
                                <span id="copyWebhookBtnText">Copy URL</span>
                            </button>
                        </div>
                    </div>

                    <div class="mt-3 pt-3 border-t border-emerald-500/20 text-[11px] text-slate-500 dark:text-slate-400 flex items-center gap-2 flex-wrap">
                        <span class="font-bold text-slate-700 dark:text-slate-300">Required Webhook Events:</span>
                        <span class="px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 font-mono font-bold text-[10px] text-teal-600">payment.captured</span>
                        <span class="px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 font-mono font-bold text-[10px] text-teal-600">order.paid</span>
                        <span class="px-2 py-0.5 rounded-md bg-white dark:bg-slate-800 font-mono font-bold text-[10px] text-rose-500">payment.failed</span>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Razorpay Enable / Disable -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Enable Razorpay Gateway</label>
                        <select name="razorpay_enabled" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                            <option value="1" {{ ($settings['razorpay_enabled'] ?? '1') == '1' ? 'selected' : '' }}>Enabled (Online Checkout Active)</option>
                            <option value="0" {{ ($settings['razorpay_enabled'] ?? '1') == '0' ? 'selected' : '' }}>Disabled (Cash on Collection Only)</option>
                        </select>
                    </div>

                    <!-- Environment Mode -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Environment Mode</label>
                        <select name="razorpay_mode" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                            <option value="test" {{ ($settings['razorpay_mode'] ?? 'test') == 'test' ? 'selected' : '' }}>Test / Sandbox Mode (rzp_test_...)</option>
                            <option value="live" {{ ($settings['razorpay_mode'] ?? 'test') == 'live' ? 'selected' : '' }}>Live / Production Mode (rzp_live_...)</option>
                        </select>
                    </div>

                    <!-- Key ID -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Razorpay Key ID</label>
                        <input type="text" name="razorpay_key_id" value="{{ $settings['razorpay_key_id'] ?? env('RAZORPAY_KEY_ID', '') }}" 
                            placeholder="rzp_test_xxxxxxxxxxxxxxxx or rzp_live_xxxxxxxxxxxxxxxx"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-emerald-500 transition">
                        <p class="text-[11px] text-slate-400 mt-1">Found in Razorpay Dashboard &rarr; Settings &rarr; API Keys</p>
                    </div>

                    <!-- Key Secret -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Razorpay Key Secret</label>
                        <div class="relative">
                            <input type="password" id="razorpaySecretInput" name="razorpay_key_secret" value="{{ $settings['razorpay_key_secret'] ?? env('RAZORPAY_KEY_SECRET', '') }}" 
                                placeholder="Enter Razorpay Key Secret"
                                class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-emerald-500 transition">
                            <button type="button" onclick="toggleInputVisibility('razorpaySecretInput', 'secretEyeIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <i class="fas fa-eye text-xs" id="secretEyeIcon"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Kept confidential and securely stored.</p>
                    </div>

                    <!-- Webhook Secret -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Razorpay Webhook Secret</label>
                        <div class="relative">
                            <input type="password" id="razorpayWebhookSecretInput" name="razorpay_webhook_secret" value="{{ $settings['razorpay_webhook_secret'] ?? env('RAZORPAY_WEBHOOK_SECRET', '') }}" 
                                placeholder="Secret string configured in Razorpay Webhook creation dialog"
                                class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-emerald-500 transition">
                            <button type="button" onclick="toggleInputVisibility('razorpayWebhookSecretInput', 'webhookSecretEyeIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <i class="fas fa-eye text-xs" id="webhookSecretEyeIcon"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Used to verify that incoming webhook requests originate from Razorpay servers.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 7: Email / SMTP Gateway -->
            <div id="settings-panel-email" class="settings-tab-content space-y-6 hidden">
                <input type="hidden" name="settings_group" value="mail">

                <div class="p-5 rounded-2xl bg-gradient-to-r from-teal-500/10 via-emerald-500/5 to-slate-50 dark:to-white/[0.02] border border-teal-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-teal-500/20 text-teal-600 dark:text-teal-400 font-black text-[10px] uppercase tracking-wider mb-1.5">
                            <i class="fas fa-paper-plane"></i> Email Channel Engine
                        </span>
                        <h4 class="font-black text-slate-900 dark:text-white text-sm">SMTP Server & Outgoing Mail Settings</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Configure your transactional SMTP provider (Gmail, Brevo, SendGrid, Postmark, AWS SES, or custom mail server).</p>
                    </div>
                    <div>
                        <a href="{{ route('admin.notifications.index') }}" class="px-3.5 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white font-bold text-xs shadow-sm transition inline-flex items-center gap-1.5">
                            <i class="fas fa-bell"></i>
                            <span>View Notification Logs</span>
                        </a>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Enable Email Notifications -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Email Notifications Active</label>
                        <select name="email_notifications_enabled" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                            <option value="1" {{ ($settings['email_notifications_enabled'] ?? '1') == '1' ? 'selected' : '' }}>Enabled (Send Real Emails)</option>
                            <option value="0" {{ ($settings['email_notifications_enabled'] ?? '1') == '0' ? 'selected' : '' }}>Disabled (Skip Sending)</option>
                        </select>
                    </div>

                    <!-- Mail Driver / Mailer -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Mail Driver (Mailer)</label>
                        <select name="mail_mailer" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                            <option value="smtp" {{ ($settings['mail_mailer'] ?? config('mail.default', 'smtp')) == 'smtp' ? 'selected' : '' }}>SMTP (Recommended for Live)</option>
                            <option value="log" {{ ($settings['mail_mailer'] ?? config('mail.default', 'smtp')) == 'log' ? 'selected' : '' }}>Log (Writes to storage/logs - Testing)</option>
                            <option value="sendmail" {{ ($settings['mail_mailer'] ?? config('mail.default', 'smtp')) == 'sendmail' ? 'selected' : '' }}>Sendmail (Server default)</option>
                        </select>
                    </div>

                    <!-- SMTP Host -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">SMTP Host</label>
                        <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? env('MAIL_HOST', 'smtp.gmail.com') }}" 
                            placeholder="e.g. smtp.gmail.com or smtp.mailgun.org"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-teal-500 transition">
                        <p class="text-[11px] text-slate-400 mt-1">Hostname of your outgoing mail server.</p>
                    </div>

                    <!-- SMTP Port & Encryption -->
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">SMTP Port</label>
                            <input type="number" name="mail_port" value="{{ $settings['mail_port'] ?? env('MAIL_PORT', 587) }}" 
                                placeholder="587"
                                class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-teal-500 transition">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Encryption</label>
                            <select name="mail_encryption" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                                <option value="tls" {{ ($settings['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'tls')) == 'tls' ? 'selected' : '' }}>TLS (Port 587)</option>
                                <option value="ssl" {{ ($settings['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'tls')) == 'ssl' ? 'selected' : '' }}>SSL (Port 465)</option>
                                <option value="null" {{ ($settings['mail_encryption'] ?? env('MAIL_ENCRYPTION', 'tls')) == 'null' ? 'selected' : '' }}>None</option>
                            </select>
                        </div>
                    </div>

                    <!-- SMTP Username -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">SMTP Username / Email</label>
                        <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? env('MAIL_USERNAME', '') }}" 
                            placeholder="e.g. notifications@avwellcare.com"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-teal-500 transition">
                    </div>

                    <!-- SMTP Password -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">SMTP Password / App Password</label>
                        <div class="relative">
                            <input type="password" id="mailPasswordInput" name="mail_password" value="{{ $settings['mail_password'] ?? env('MAIL_PASSWORD', '') }}" 
                                placeholder="Enter SMTP password or app-specific password"
                                class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-teal-500 transition">
                            <button type="button" onclick="toggleInputVisibility('mailPasswordInput', 'mailPassEyeIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <i class="fas fa-eye text-xs" id="mailPassEyeIcon"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">If using Gmail, use a 16-character Google App Password.</p>
                    </div>

                    <!-- From Address -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Sender "From" Email Address</label>
                        <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? env('MAIL_FROM_ADDRESS', 'noreply@avwellcare.com') }}" 
                            placeholder="noreply@avwellcare.com"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-teal-500 transition">
                    </div>

                    <!-- From Name -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Sender "From" Display Name</label>
                        <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? env('MAIL_FROM_NAME', 'AV Wellcare Diagnostics') }}" 
                            placeholder="AV Wellcare Diagnostics"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-teal-500 transition">
                    </div>

                    <!-- Admin Notification Email -->
                    <div class="md:col-span-2">
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Admin Notification Alerts Recipient Email</label>
                        <input type="email" name="mail_admin_address" value="{{ $settings['mail_admin_address'] ?? env('MAIL_ADMIN_ADDRESS', 'admin@avwellcare.com') }}" 
                            placeholder="admin@avwellcare.com"
                            class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-teal-500 transition">
                        <p class="text-[11px] text-slate-400 mt-1">This email address will receive notifications for new bookings, sample collection updates, and new field agent registrations.</p>
                    </div>
                </div>
            </div>

            <!-- TAB 8: SMS Gateway (MSG91 / Twilio) -->
            <div id="settings-panel-sms" class="settings-tab-content space-y-6 hidden">
                <input type="hidden" name="settings_group" value="sms">

                <div class="p-5 rounded-2xl bg-gradient-to-r from-sky-500/10 via-teal-500/5 to-slate-50 dark:to-white/[0.02] border border-sky-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-sky-500/20 text-sky-600 dark:text-sky-400 font-black text-[10px] uppercase tracking-wider mb-1.5">
                            <i class="fas fa-comment-sms"></i> Mobile SMS Gateway
                        </span>
                        <h4 class="font-black text-slate-900 dark:text-white text-sm">SMS Gateway API Credentials</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Send instant transactional SMS alerts to patients and phlebotomists via MSG91 or Twilio.</p>
                    </div>
                    <div>
                        @if(($settings['sms_enabled'] ?? '0') == '1' && (!empty($settings['msg91_auth_key']) || !empty($settings['twilio_sid'])))
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                                <i class="fas fa-circle-check"></i> Gateway Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">
                                <i class="fas fa-plug"></i> Stub Mode (Fill Keys to Activate)
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Enable SMS -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Enable SMS Service</label>
                        <select name="sms_enabled" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                            <option value="1" {{ ($settings['sms_enabled'] ?? '0') == '1' ? 'selected' : '' }}>Enabled (Send Real SMS)</option>
                            <option value="0" {{ ($settings['sms_enabled'] ?? '0') == '0' ? 'selected' : '' }}>Disabled / Stub (Skip Sending)</option>
                        </select>
                    </div>

                    <!-- SMS Provider -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Active SMS Provider</label>
                        <select name="sms_provider" id="smsProviderSelect" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold" onchange="toggleSmsProviderSections(this.value)">
                            <option value="msg91" {{ ($settings['sms_provider'] ?? 'msg91') == 'msg91' ? 'selected' : '' }}>MSG91 (India DLT Compliant)</option>
                            <option value="twilio" {{ ($settings['sms_provider'] ?? 'msg91') == 'twilio' ? 'selected' : '' }}>Twilio (International / Global)</option>
                        </select>
                    </div>
                </div>

                <!-- MSG91 Credentials Block -->
                <div id="msg91Section" class="p-5 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/10 space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-white/10">
                        <span class="w-2.5 h-2.5 rounded-full bg-sky-500"></span>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">MSG91 Credentials</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">MSG91 Auth Key</label>
                            <div class="relative">
                                <input type="password" id="msg91AuthKeyInput" name="msg91_auth_key" value="{{ $settings['msg91_auth_key'] ?? env('MSG91_AUTH_KEY', '') }}" 
                                    placeholder="Enter your MSG91 Authkey"
                                    class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-sky-500 transition">
                                <button type="button" onclick="toggleInputVisibility('msg91AuthKeyInput', 'msg91KeyEyeIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                    <i class="fas fa-eye text-xs" id="msg91KeyEyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Sender ID / Header</label>
                            <input type="text" name="msg91_sender_id" value="{{ $settings['msg91_sender_id'] ?? env('MSG91_SENDER_ID', 'OUTSLAB') }}" 
                                placeholder="e.g. OUTSLAB"
                                class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono uppercase focus:ring-2 focus:ring-sky-500 transition">
                            <p class="text-[11px] text-slate-400 mt-1">6-char DLT approved header.</p>
                        </div>

                        <div class="md:col-span-3">
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">MSG91 Flow / Template ID (Optional)</label>
                            <input type="text" name="msg91_template_id" value="{{ $settings['msg91_template_id'] ?? env('MSG91_TEMPLATE_ID', '') }}" 
                                placeholder="e.g. 6423a8bc..."
                                class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-sky-500 transition">
                        </div>
                    </div>
                </div>

                <!-- Twilio Credentials Block -->
                <div id="twilioSection" class="p-5 rounded-2xl bg-slate-50 dark:bg-white/[0.02] border border-slate-200 dark:border-white/10 space-y-4">
                    <div class="flex items-center gap-2 pb-2 border-b border-slate-200 dark:border-white/10">
                        <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                        <h4 class="text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300">Twilio Credentials</h4>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Twilio Account SID</label>
                            <input type="text" name="twilio_sid" value="{{ $settings['twilio_sid'] ?? env('TWILIO_SID', '') }}" 
                                placeholder="ACxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
                                class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-sky-500 transition">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Twilio Auth Token</label>
                            <div class="relative">
                                <input type="password" id="twilioTokenInput" name="twilio_token" value="{{ $settings['twilio_token'] ?? env('TWILIO_TOKEN', '') }}" 
                                    placeholder="Enter Twilio Auth Token"
                                    class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-sky-500 transition">
                                <button type="button" onclick="toggleInputVisibility('twilioTokenInput', 'twilioTokenEyeIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                    <i class="fas fa-eye text-xs" id="twilioTokenEyeIcon"></i>
                                </button>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Twilio Sender Number (From)</label>
                            <input type="text" name="twilio_from" value="{{ $settings['twilio_from'] ?? env('TWILIO_FROM', '') }}" 
                                placeholder="+1234567890"
                                class="w-full px-4 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-sky-500 transition">
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB 9: WhatsApp Gateway (Interakt / AiSensy) -->
            <div id="settings-panel-whatsapp" class="settings-tab-content space-y-6 hidden">
                <input type="hidden" name="settings_group" value="whatsapp">

                <div class="p-5 rounded-2xl bg-gradient-to-r from-emerald-500/10 via-teal-500/5 to-slate-50 dark:to-white/[0.02] border border-emerald-500/30 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full bg-emerald-500/20 text-emerald-600 dark:text-emerald-400 font-black text-[10px] uppercase tracking-wider mb-1.5">
                            <i class="fab fa-whatsapp"></i> WhatsApp Business API
                        </span>
                        <h4 class="font-black text-slate-900 dark:text-white text-sm">WhatsApp Gateway API Credentials</h4>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Send rich WhatsApp booking confirmations, sample collection alerts, and report PDFs to patients.</p>
                    </div>
                    <div>
                        @if(($settings['whatsapp_enabled'] ?? '0') == '1' && (!empty($settings['interakt_api_key']) || !empty($settings['aisensy_api_key'])))
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                                <i class="fas fa-circle-check"></i> Gateway Active
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400">
                                <i class="fas fa-plug"></i> Stub Mode (Fill Keys to Activate)
                            </span>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <!-- Enable WhatsApp -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Enable WhatsApp Service</label>
                        <select name="whatsapp_enabled" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                            <option value="1" {{ ($settings['whatsapp_enabled'] ?? '0') == '1' ? 'selected' : '' }}>Enabled (Send Real WhatsApp)</option>
                            <option value="0" {{ ($settings['whatsapp_enabled'] ?? '0') == '0' ? 'selected' : '' }}>Disabled / Stub (Skip Sending)</option>
                        </select>
                    </div>

                    <!-- WhatsApp Provider -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Active WhatsApp Provider</label>
                        <select name="whatsapp_provider" class="w-full px-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-semibold">
                            <option value="interakt" {{ ($settings['whatsapp_provider'] ?? 'interakt') == 'interakt' ? 'selected' : '' }}>Interakt (Official Meta BSP)</option>
                            <option value="aisensy" {{ ($settings['whatsapp_provider'] ?? 'interakt') == 'aisensy' ? 'selected' : '' }}>AiSensy (Official Meta BSP)</option>
                        </select>
                    </div>

                    <!-- Interakt API Key -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fas fa-key text-emerald-500 mr-1"></i> Interakt API Key</label>
                        <div class="relative">
                            <input type="password" id="interaktApiKeyInput" name="interakt_api_key" value="{{ $settings['interakt_api_key'] ?? env('INTERAKT_API_KEY', '') }}" 
                                placeholder="Enter Interakt API Key"
                                class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-emerald-500 transition">
                            <button type="button" onclick="toggleInputVisibility('interaktApiKeyInput', 'interaktKeyEyeIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <i class="fas fa-eye text-xs" id="interaktKeyEyeIcon"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Obtained from Interakt Dashboard &rarr; Settings &rarr; Developer Settings.</p>
                    </div>

                    <!-- AiSensy API Key -->
                    <div>
                        <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2"><i class="fas fa-key text-emerald-500 mr-1"></i> AiSensy API Key</label>
                        <div class="relative">
                            <input type="password" id="aisensyApiKeyInput" name="aisensy_api_key" value="{{ $settings['aisensy_api_key'] ?? env('AISENSY_API_KEY', '') }}" 
                                placeholder="Enter AiSensy API Key"
                                class="w-full pl-4 pr-10 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-900/50 border border-slate-200 dark:border-white/[0.1] text-sm text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-emerald-500 transition">
                            <button type="button" onclick="toggleInputVisibility('aisensyApiKeyInput', 'aisensyKeyEyeIcon')" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                                <i class="fas fa-eye text-xs" id="aisensyKeyEyeIcon"></i>
                            </button>
                        </div>
                        <p class="text-[11px] text-slate-400 mt-1">Obtained from AiSensy Dashboard &rarr; Manage &rarr; API Key.</p>
                    </div>
                </div>
            </div>

            <!-- Submit Button (Always Visible at bottom) -->
            <div class="mt-8 pt-6 border-t border-slate-200 dark:border-white/[0.08] flex items-center justify-between">
                <div class="text-xs text-slate-400">
                    <i class="fas fa-shield-halved text-teal-500 mr-1"></i> All API credentials and secrets are encrypted & securely stored.
                </div>
                <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white font-bold text-sm shadow-lg shadow-teal-500/25 transition">
                    <i class="fas fa-save"></i>
                    <span>Save All Credentials</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchSettingsTab(tabKey) {
        if (!tabKey) tabKey = 'general';
        // Normalize any variations: '#tab-email', 'tab-email', 'email', 'settings-panel-email'
        const cleanKey = String(tabKey).replace(/^#/, '').replace(/^settings-panel-/, '').replace(/^tab-/, '');
        
        // Hide all tabs
        document.querySelectorAll('.settings-tab-content').forEach(el => el.classList.add('hidden'));
        
        // Show selected tab panel
        const targetPanel = document.getElementById('settings-panel-' + cleanKey);
        if (targetPanel) {
            targetPanel.classList.remove('hidden');
        }

        // Update tab buttons style
        document.querySelectorAll('.settings-tab-btn').forEach(btn => {
            btn.classList.remove('bg-teal-600', 'text-white', 'shadow-md');
            btn.classList.add('text-slate-600', 'dark:text-slate-400', 'bg-slate-100', 'dark:bg-white/[0.04]');
        });

        // Highlight active button (supports data-tab="email" or data-tab="tab-email")
        const activeBtn = document.querySelector(`.settings-tab-btn[data-tab="${cleanKey}"]`)
            || document.querySelector(`.settings-tab-btn[data-tab="tab-${cleanKey}"]`);
        if (activeBtn) {
            activeBtn.classList.add('bg-teal-600', 'text-white', 'shadow-md');
            activeBtn.classList.remove('text-slate-600', 'dark:text-slate-400', 'bg-slate-100', 'dark:bg-white/[0.04]');
        }

        // Remember active tab in hidden input for form submission
        const activeInput = document.getElementById('activeTabInput');
        if (activeInput) {
            activeInput.value = cleanKey;
        }

        // Keep clean hash without causing any browser viewport jump
        if (history.replaceState) {
            history.replaceState(null, null, '#tab-' + cleanKey);
        }

        // Strictly keep header and layout scroll pinned to top
        window.scrollTo(0, 0);
        const mainEl = document.getElementById('adminMainScroll') || document.querySelector('main');
        if (mainEl && mainEl.scrollTop > 0) {
            mainEl.scrollTop = 0;
        }
    }

    function toggleInputVisibility(inputId, iconId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(iconId);
        if (!input) return;

        if (input.type === 'password') {
            input.type = 'text';
            if (icon) {
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            }
        } else {
            input.type = 'password';
            if (icon) {
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    }

    function copyWebhookUrl() {
        const input = document.getElementById('webhookUrlInput');
        input.select();
        navigator.clipboard.writeText(input.value);
        const btnText = document.getElementById('copyWebhookBtnText');
        btnText.innerText = 'Copied!';
        setTimeout(() => { btnText.innerText = 'Copy URL'; }, 2000);
    }

    // Auto-select tab based on hash or session on page load
    document.addEventListener('DOMContentLoaded', function () {
        // Prevent and undo any initial browser anchor jump
        window.scrollTo(0, 0);
        const mainEl = document.getElementById('adminMainScroll') || document.querySelector('main');
        if (mainEl) {
            mainEl.scrollTop = 0;
        }

        let initialTab = 'general';
        const hash = window.location.hash.replace('#', '');
        const savedTab = document.getElementById('activeTabInput')?.value;

        if (hash) {
            initialTab = hash;
        } else if (savedTab) {
            initialTab = savedTab;
        }

        switchSettingsTab(initialTab);

        // One more tick to ensure rendering stays at top
        setTimeout(function() {
            window.scrollTo(0, 0);
            if (mainEl) mainEl.scrollTop = 0;
        }, 10);
    });
</script>
@endsection
