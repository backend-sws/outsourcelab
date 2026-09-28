<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Diagnostic Report & Patient Portal | Av Wellcare Diagnostics</title>
    @include('partials.favicon')
    
    <!-- Google Fonts & Tailwind -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Plus Jakarta Sans"', 'Inter', 'sans-serif'],
                    },
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
        body { 
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; 
            letter-spacing: -0.01em;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-800 m-0 p-0 font-sans min-h-screen flex flex-col md:flex-row antialiased selection:bg-teal-500 selection:text-white">

    <!-- Left Side: Branding / Info (Light Theme) -->
    <div class="hidden md:flex flex-col justify-between w-1/2 p-10 lg:p-16 relative md:rounded-r-[2.5rem] shadow-2xl overflow-hidden bg-gradient-to-br from-emerald-100/90 via-teal-100/80 to-teal-200/90 border-r border-teal-200/50">
        
        <!-- Ambient animated blobs -->
        <div class="absolute top-[-15%] left-[-15%] w-[65%] h-[65%] bg-teal-400/25 rounded-full blur-[90px] pointer-events-none"></div>
        <div class="absolute bottom-[-15%] right-[-15%] w-[65%] h-[65%] bg-emerald-400/25 rounded-full blur-[90px] pointer-events-none"></div>
        
        <!-- Subtle Grid Overlay -->
        <div class="absolute inset-0 bg-[linear-gradient(to_right,#0f766e0a_1px,transparent_1px),linear-gradient(to_bottom,#0f766e0a_1px,transparent_1px)] bg-[size:28px_28px] pointer-events-none"></div>

        <!-- Top Logo -->
        <div class="relative z-10 flex items-center gap-3">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 group">
                <img src="{{ asset('logo.png') }}" alt="Av Wellcare Logo" class="h-16 w-auto p-1 object-contain drop-shadow-sm transition-transform duration-300 group-hover:scale-105">
            </a>
        </div>

        <!-- Middle Content -->
        <div class="relative z-10 max-w-lg my-auto py-12">
            <div class="inline-flex items-center gap-2 border border-teal-700/20 text-teal-800 font-bold text-xs px-3.5 py-1.5 rounded-full mb-6 uppercase tracking-wider bg-white/70 backdrop-blur-md shadow-sm">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                <span>Verified Patient Records</span>
            </div>
            
            <h1 class="text-3xl lg:text-4xl xl:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.15] mb-5">
                Your Health Records, <br>
                <span class="bg-gradient-to-r from-teal-800 via-teal-700 to-emerald-700 bg-clip-text text-transparent">
                    Delivered Instantly.
                </span>
            </h1>
            
            <p class="text-slate-700 text-sm lg:text-base leading-relaxed mb-8 font-normal max-w-md">
                Securely access your verified laboratory reports, diagnostic history, invoices, and doctor test certificates anytime, anywhere.
            </p>

            <div class="flex items-center gap-4 text-xs font-semibold text-slate-700">
                <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-1.5 rounded-xl border border-teal-600/10">
                    <i class="fas fa-lock text-emerald-600"></i>
                    <span>256-Bit Encrypted</span>
                </div>
                <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-1.5 rounded-xl border border-teal-600/10">
                    <i class="fas fa-bolt text-amber-600"></i>
                    <span>Instant PDF Download</span>
                </div>
            </div>
        </div>

        <!-- Bottom Footer Info -->
        <div class="relative z-10 flex flex-wrap gap-12 lg:gap-16 border-t border-teal-800/10 pt-8">
            <div>
                <h4 class="text-slate-900 font-extrabold text-2xl lg:text-3xl tracking-tight mb-0.5">100%</h4>
                <p class="text-teal-900/80 text-[11px] font-bold uppercase tracking-wider">Private & Confidential</p>
            </div>
            <div>
                <h4 class="text-slate-900 font-extrabold text-2xl lg:text-3xl tracking-tight mb-0.5">24/7</h4>
                <p class="text-teal-900/80 text-[11px] font-bold uppercase tracking-wider">Online Availability</p>
            </div>
        </div>
    </div>

    <!-- Right Side: Clean Form with Tabs -->
    <div class="w-full md:w-1/2 flex flex-col justify-center p-6 sm:p-12 lg:p-20 relative min-h-screen bg-white">
        
        <!-- Top Back Link -->
        <div class="absolute top-6 right-6 sm:top-8 sm:right-8 flex items-center gap-3">
            @if(config('pathology.sso_enabled', true))
            <a href="{{ route('lis.login') }}" class="hidden sm:inline-flex items-center gap-2 text-xs font-bold text-amber-800 hover:text-amber-900 bg-amber-50 hover:bg-amber-100/70 px-3.5 py-2 rounded-xl transition border border-amber-200/60">
                <i class="fas fa-user-md text-[11px] text-amber-600"></i> LIS Staff / Doctor Login
            </a>
            @endif
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-teal-700 bg-slate-100 hover:bg-teal-50 px-4 py-2 rounded-xl transition border border-slate-200/80">
                <i class="fas fa-arrow-left text-[10px]"></i> Back to Home
            </a>
        </div>

        <!-- Mobile Logo -->
        <div class="md:hidden flex justify-center items-center gap-2 mb-8 mt-12">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 w-auto">
        </div>

        <div class="max-w-md w-full mx-auto">
            <!-- Header -->
            <div class="mb-6">
                <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-md border border-teal-100 inline-block mb-3">
                    Patient Diagnostic Services
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Patient Report Center</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Track your lab report status, download signed PDF reports, or log in to your Patient Portal dashboard.
                </p>
            </div>

            <!-- Tab Switcher -->
            <div class="flex p-1 mb-6 bg-slate-100 rounded-2xl border border-slate-200/80">
                <button 
                    type="button" 
                    id="tabBtnTrack" 
                    onclick="switchTab('track')"
                    class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all shadow-sm bg-white text-slate-900 flex items-center justify-center gap-2 cursor-pointer"
                >
                    <i class="fas fa-file-pdf text-teal-600"></i>
                    <span>Download Report</span>
                </button>
                <button 
                    type="button" 
                    id="tabBtnPortal" 
                    onclick="switchTab('portal')"
                    class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900 flex items-center justify-center gap-2 cursor-pointer"
                >
                    <i class="fas fa-user-circle text-amber-600"></i>
                    <span>Patient Portal SSO</span>
                </button>
            </div>

            <!-- Error Banner -->
            <div id="statusAlertBox" class="hidden mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-3">
                <i class="fas fa-circle-exclamation text-base text-rose-500 flex-shrink-0"></i>
                <span id="statusAlertMessage">No record found. Please verify details.</span>
            </div>

            <!-- Success Banner -->
            <div id="statusSuccessBox" class="hidden mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3">
                <i class="fas fa-circle-check text-base text-emerald-500 flex-shrink-0"></i>
                <span id="statusSuccessMessage">Authentication verified! Redirecting to Patient Portal...</span>
            </div>

            <!-- ============================================== -->
            <!-- TAB 1: QUICK REPORT TRACK & DOWNLOAD -->
            <!-- ============================================== -->
            <div id="tabContentTrack">
                <form id="trackReportForm" class="space-y-5">
                    @csrf
                    <!-- Booking ID / Bill Number -->
                    <div>
                        <label for="booking_ref" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Bill Number / Booking Reference
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-receipt text-sm"></i>
                            </div>
                            <input 
                                type="text" 
                                id="booking_ref" 
                                name="ref" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm uppercase tracking-wide" 
                                placeholder="e.g. INV-2609-0015 or PAT-1138" 
                                required 
                                autofocus
                            >
                        </div>
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="mobile_number" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Registered Mobile Number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-phone-alt text-sm"></i>
                            </div>
                            <input 
                                type="tel" 
                                id="mobile_number" 
                                name="mobile" 
                                maxlength="10" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm" 
                                placeholder="10 Digit Mobile Number" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        id="trackSubmitBtn"
                        class="w-full mt-3 flex justify-center items-center gap-2 py-3.5 px-6 rounded-2xl shadow-lg shadow-teal-800/20 text-sm font-bold text-white bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 hover:shadow-teal-800/30 active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-teal-600/30 transition-all cursor-pointer"
                    >
                        <span id="trackBtnText">View & Download Report</span>
                        <i class="fas fa-arrow-right text-xs" id="trackBtnIcon"></i>
                    </button>
                </form>

                <!-- Live Report Results Container -->
                <div id="reportResultContainer" class="hidden mt-6 pt-6 border-t border-slate-200 space-y-4">
                    <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200/90 shadow-sm space-y-3">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider" id="resBillNo">REF #--</p>
                                <h4 class="text-base font-extrabold text-slate-900" id="resPatientName">Patient Name</h4>
                            </div>
                            <span id="resStatusBadge" class="px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-1.5">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                <span id="resStatusText">Under Analysis</span>
                            </span>
                        </div>

                        <!-- Tests List -->
                        <div id="resTestsList" class="space-y-1.5 pt-2 border-t border-slate-200/60">
                            <!-- Populated dynamically -->
                        </div>

                        <!-- Direct Download Button -->
                        <div id="resDownloadArea" class="pt-2">
                            <a 
                                id="resDownloadLink" 
                                href="#" 
                                target="_blank" 
                                class="w-full inline-flex justify-center items-center gap-2 py-3 px-4 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-700/20 transition-all"
                            >
                                <i class="fas fa-file-pdf text-sm"></i>
                                <span>Download Signed PDF Report</span>
                                <i class="fas fa-arrow-up-right-from-square text-[10px] ml-1"></i>
                            </a>
                        </div>

                        <!-- One-click Patient Portal Launcher from Result -->
                        <div class="pt-3 border-t border-slate-200/70">
                            <button 
                                type="button" 
                                onclick="loginToPortalWithCurrentDetails()" 
                                class="w-full inline-flex justify-center items-center gap-2 py-2.5 px-4 rounded-xl text-xs font-bold text-amber-900 bg-amber-100/70 hover:bg-amber-100 border border-amber-300/60 transition"
                            >
                                <i class="fas fa-user-shield text-amber-700"></i>
                                <span>Open in Full Patient Portal Dashboard</span>
                                <i class="fas fa-arrow-right text-[10px]"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================================== -->
            <!-- TAB 2: PATIENT PORTAL SSO LOGIN -->
            <!-- ============================================== -->
            <div id="tabContentPortal" class="hidden">
                <form id="portalLoginForm" method="POST" action="{{ $directPortalLoginUrl }}" class="space-y-5">
                    @csrf
                    <input type="hidden" name="api_key" value="{{ $apiKey }}">

                    <div class="p-3.5 rounded-2xl bg-amber-50/80 border border-amber-200/80 text-xs text-amber-900 leading-relaxed flex items-start gap-2.5">
                        <i class="fas fa-circle-info text-amber-600 text-sm mt-0.5 flex-shrink-0"></i>
                        <span>
                            Log in to view all your test history, invoices, health certificates, and family patient records in one unified Patient Portal.
                        </span>
                    </div>

                    <!-- Bill Number / Patient ID -->
                    <div>
                        <label for="portal_patient_id" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Bill Number / Patient ID
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-id-card text-sm"></i>
                            </div>
                            <input 
                                type="text" 
                                id="portal_patient_id" 
                                name="patient_id" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm uppercase tracking-wide" 
                                placeholder="e.g. INV-2609-0015 or PAT-1138" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Mobile Number -->
                    <div>
                        <label for="portal_phone" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                            Registered Mobile Number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fas fa-phone-alt text-sm"></i>
                            </div>
                            <input 
                                type="tel" 
                                id="portal_phone" 
                                name="phone" 
                                maxlength="10" 
                                class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm" 
                                placeholder="10 Digit Mobile Number" 
                                required
                            >
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit" 
                        id="portalSubmitBtn" 
                        class="w-full mt-3 flex justify-center items-center gap-2 py-3.5 px-6 rounded-2xl shadow-lg shadow-teal-800/20 text-sm font-bold text-white bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 hover:shadow-teal-800/30 active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-teal-600/30 transition-all cursor-pointer"
                    >
                        <span id="portalBtnText">Login to Patient Portal</span>
                        <i class="fas fa-arrow-right text-xs" id="portalBtnIcon"></i>
                    </button>
                </form>
            </div>
            
            <!-- Quick Assistance -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <a href="{{ route('home') }}#contact-enquiry" class="hover:text-teal-700 transition flex items-center gap-1.5 font-semibold">
                    <i class="fas fa-headset text-teal-600"></i> Need Help with Reports?
                </a>
                @if(config('pathology.sso_enabled', true))
                <a href="{{ route('lis.login') }}" class="hover:text-teal-700 transition flex items-center gap-1.5 font-semibold">
                    <i class="fas fa-user-md text-teal-600"></i> Doctor & LIS Staff Login
                </a>
                @endif
            </div>

            <!-- Footer Notice -->
            <div class="mt-8 text-center">
                <p class="text-xs text-slate-400 font-normal leading-relaxed">
                    Powered by Pathology LIS Cloud. Secured with 256-Bit SSL Encryption.
                </p>
            </div>
        </div>
    </div>

    <!-- JavaScript Handling -->
    <script>
        // Tab switching
        function switchTab(tab) {
            hideAlerts();
            const tabTrack = document.getElementById('tabContentTrack');
            const tabPortal = document.getElementById('tabContentPortal');
            const btnTrack = document.getElementById('tabBtnTrack');
            const btnPortal = document.getElementById('tabBtnPortal');

            if (tab === 'portal') {
                tabTrack.classList.add('hidden');
                tabPortal.classList.remove('hidden');
                btnPortal.className = 'flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all shadow-sm bg-white text-slate-900 flex items-center justify-center gap-2 cursor-pointer';
                btnTrack.className = 'flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900 flex items-center justify-center gap-2 cursor-pointer';
                // Sync values from track tab if present
                const trackRef = document.getElementById('booking_ref').value.trim();
                const trackMobile = document.getElementById('mobile_number').value.trim();
                if (trackRef && !document.getElementById('portal_patient_id').value) {
                    document.getElementById('portal_patient_id').value = trackRef;
                }
                if (trackMobile && !document.getElementById('portal_phone').value) {
                    document.getElementById('portal_phone').value = trackMobile;
                }
            } else {
                tabPortal.classList.add('hidden');
                tabTrack.classList.remove('hidden');
                btnTrack.className = 'flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all shadow-sm bg-white text-slate-900 flex items-center justify-center gap-2 cursor-pointer';
                btnPortal.className = 'flex-1 py-2.5 px-3 rounded-xl text-xs font-bold transition-all text-slate-600 hover:text-slate-900 flex items-center justify-center gap-2 cursor-pointer';
                // Sync values from portal tab if present
                const portalId = document.getElementById('portal_patient_id').value.trim();
                const portalPhone = document.getElementById('portal_phone').value.trim();
                if (portalId && !document.getElementById('booking_ref').value) {
                    document.getElementById('booking_ref').value = portalId;
                }
                if (portalPhone && !document.getElementById('mobile_number').value) {
                    document.getElementById('mobile_number').value = portalPhone;
                }
            }
        }

        // Check URL query parameters for default tab
        document.addEventListener('DOMContentLoaded', () => {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.get('tab') === 'portal') {
                switchTab('portal');
            }
        });

        // Alerts helper
        const alertBox = document.getElementById('statusAlertBox');
        const alertMsg = document.getElementById('statusAlertMessage');
        const successBox = document.getElementById('statusSuccessBox');
        const successMsg = document.getElementById('statusSuccessMessage');

        function showError(msg) {
            alertMsg.textContent = msg;
            alertBox.classList.remove('hidden');
            successBox.classList.add('hidden');
        }

        function showSuccess(msg) {
            successMsg.textContent = msg;
            successBox.classList.remove('hidden');
            alertBox.classList.add('hidden');
        }

        function hideAlerts() {
            alertBox.classList.add('hidden');
            successBox.classList.add('hidden');
        }

        // ==========================================
        // 1. TRACK & DOWNLOAD REPORT FORM
        // ==========================================
        const trackForm = document.getElementById('trackReportForm');
        const trackBtn = document.getElementById('trackSubmitBtn');
        const trackBtnText = document.getElementById('trackBtnText');
        const trackBtnIcon = document.getElementById('trackBtnIcon');
        const resultContainer = document.getElementById('reportResultContainer');
        const resBillNo = document.getElementById('resBillNo');
        const resPatientName = document.getElementById('resPatientName');
        const resStatusBadge = document.getElementById('resStatusBadge');
        const resStatusText = document.getElementById('resStatusText');
        const resTestsList = document.getElementById('resTestsList');
        const resDownloadArea = document.getElementById('resDownloadArea');
        const resDownloadLink = document.getElementById('resDownloadLink');

        trackForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlerts();
            resultContainer.classList.add('hidden');

            const ref = document.getElementById('booking_ref').value.trim();
            const mobile = document.getElementById('mobile_number').value.trim();

            if (!ref || !mobile) {
                showError('Please provide both Bill Number / Reference ID and Registered Mobile.');
                return;
            }

            trackBtn.disabled = true;
            trackBtnText.textContent = 'Searching Records...';
            trackBtnIcon.className = 'fas fa-circle-notch fa-spin text-xs';

            try {
                const response = await fetch('{{ route("download.report.track") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ ref, mobile })
                });

                const json = await response.json();

                if (json.success && json.data) {
                    renderReportResult(json.data);
                } else {
                    showError(json.message || 'No diagnostic records found for the provided details.');
                }
            } catch (err) {
                showError('Connection error. Please check your internet or try again later.');
            } finally {
                trackBtn.disabled = false;
                trackBtnText.textContent = 'View & Download Report';
                trackBtnIcon.className = 'fas fa-arrow-right text-xs';
            }
        });

        function renderReportResult(data) {
            resBillNo.textContent = 'REF: ' + (data.bill_number || 'N/A');
            resPatientName.textContent = data.patient_name || 'Patient';

            const isReady = !!data.is_ready;
            const stage = data.current_stage || (isReady ? 'Report Ready' : 'Processing');

            if (isReady) {
                resStatusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-100 text-emerald-800 border border-emerald-200 flex items-center gap-1.5';
                resStatusBadge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span><span>Report Ready</span>';
            } else {
                resStatusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-amber-100 text-amber-800 border border-amber-200 flex items-center gap-1.5';
                resStatusBadge.innerHTML = '<span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span><span>' + stage + '</span>';
            }

            // Render Tests
            resTestsList.innerHTML = '';
            if (Array.isArray(data.tests) && data.tests.length > 0) {
                data.tests.forEach(t => {
                    const testStatus = (t.status || 'pending').toLowerCase();
                    const isApproved = testStatus === 'approved' || testStatus === 'ready';
                    const pillClass = isApproved ? 'bg-emerald-50 text-emerald-700 border-emerald-200' : 'bg-slate-100 text-slate-600 border-slate-200';
                    const pillIcon = isApproved ? 'fa-check' : 'fa-clock';
                    
                    const row = document.createElement('div');
                    row.className = 'flex items-center justify-between text-xs py-1';
                    row.innerHTML = `
                        <span class="font-medium text-slate-700">${t.name || 'Diagnostic Test'}</span>
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md border text-[10px] font-semibold uppercase ${pillClass}">
                            <i class="fas ${pillIcon}"></i> ${isApproved ? 'Approved' : 'In Progress'}
                        </span>
                    `;
                    resTestsList.appendChild(row);
                });
            }

            // Render download button
            if (isReady && data.download_url) {
                resDownloadLink.href = data.download_url;
                resDownloadArea.classList.remove('hidden');
            } else {
                resDownloadArea.classList.add('hidden');
            }

            resultContainer.classList.remove('hidden');
        }

        // ==========================================
        // 2. PATIENT PORTAL SSO LOGIN FORM
        // ==========================================
        const portalForm = document.getElementById('portalLoginForm');
        const portalBtn = document.getElementById('portalSubmitBtn');
        const portalBtnText = document.getElementById('portalBtnText');
        const portalBtnIcon = document.getElementById('portalBtnIcon');

        portalForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            hideAlerts();

            const patientId = document.getElementById('portal_patient_id').value.trim();
            const phone = document.getElementById('portal_phone').value.trim();

            if (!patientId || !phone) {
                showError('Please enter both Bill Number / Patient ID and Mobile Number.');
                return;
            }

            portalBtn.disabled = true;
            portalBtn.classList.add('opacity-80');
            portalBtnText.textContent = 'Verifying Credentials...';
            portalBtnIcon.className = 'fas fa-circle-notch fa-spin text-xs';

            try {
                const response = await fetch('{{ route("download.report.patient_login") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ patient_id: patientId, phone: phone })
                });

                const data = await response.json();

                if (data.success && data.data && data.data.redirect_url) {
                    showSuccess('Login verified! Redirecting to Patient Portal...');
                    portalBtnText.textContent = 'Launching Portal...';
                    portalBtnIcon.className = 'fas fa-check text-xs';
                    // Seamless redirect to authenticated dashboard
                    window.location.href = data.data.redirect_url;
                } else {
                    showError(data.message || 'Patient details not found. Please verify Bill/Patient ID and registered mobile.');
                    resetPortalBtn();
                }
            } catch (err) {
                // If AJAX fails, fallback to direct HTML form submit
                showError('Network error connecting to API. Retrying direct portal login...');
                portalForm.submit();
            }
        });

        function resetPortalBtn() {
            portalBtn.disabled = false;
            portalBtn.classList.remove('opacity-80');
            portalBtnText.textContent = 'Login to Patient Portal';
            portalBtnIcon.className = 'fas fa-arrow-right text-xs';
        }

        // Quick helper: launch portal from current track inputs
        function loginToPortalWithCurrentDetails() {
            const ref = document.getElementById('booking_ref').value.trim();
            const mobile = document.getElementById('mobile_number').value.trim();
            if (ref && mobile) {
                document.getElementById('portal_patient_id').value = ref;
                document.getElementById('portal_phone').value = mobile;
                switchTab('portal');
                portalForm.dispatchEvent(new Event('submit'));
            } else {
                switchTab('portal');
            }
        }
    </script>

</body>
</html>
