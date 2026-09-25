<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIS Laboratory Login | Av Wellcare Diagnostics</title>
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

    <!-- Left Side: Modern Medical / Diagnostic Branding -->
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
                <span>Enterprise LIS Cloud Ecosystem</span>
            </div>
            
            <h1 class="text-3xl lg:text-4xl xl:text-5xl font-extrabold text-slate-900 tracking-tight leading-[1.15] mb-5">
                Intelligence at the <br>
                <span class="bg-gradient-to-r from-teal-800 via-teal-700 to-emerald-700 bg-clip-text text-transparent">
                    Core of Diagnostics.
                </span>
            </h1>
            
            <p class="text-slate-700 text-sm lg:text-base leading-relaxed mb-8 font-normal max-w-md">
                Securely manage laboratory sample workflows, verified patient diagnostics, and automated LIS integration in one unified cloud portal.
            </p>

            <div class="flex items-center gap-4 text-xs font-semibold text-slate-700">
                <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-1.5 rounded-xl border border-teal-600/10">
                    <i class="fas fa-shield-halved text-emerald-600"></i>
                    <span>256-Bit HIPAA Compliant</span>
                </div>
                <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-1.5 rounded-xl border border-teal-600/10">
                    <i class="fas fa-bolt text-amber-600"></i>
                    <span>Real-time Sync</span>
                </div>
            </div>
        </div>

        {{-- Bottom Footer Stats (Removed as requested)
        <div class="relative z-10 flex flex-wrap gap-12 lg:gap-16 border-t border-teal-800/10 pt-8">
            <div>
                <h4 class="text-slate-900 font-extrabold text-2xl lg:text-3xl tracking-tight mb-0.5">500+</h4>
                <p class="text-teal-900/80 text-[11px] font-bold uppercase tracking-wider">Labs Connected</p>
            </div>
            
            <div>
                <h4 class="text-slate-900 font-extrabold text-2xl lg:text-3xl tracking-tight mb-0.5">1M+</h4>
                <p class="text-teal-900/80 text-[11px] font-bold uppercase tracking-wider">Reports Monthly</p>
            </div>

            <div>
                <h4 class="text-slate-900 font-extrabold text-2xl lg:text-3xl tracking-tight mb-0.5">99.9%</h4>
                <p class="text-teal-900/80 text-[11px] font-bold uppercase tracking-wider">System Uptime</p>
            </div>
        </div>
        --}}
    </div>

    <!-- Right Side: Clean Modern Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center p-6 sm:p-12 lg:p-20 relative min-h-screen bg-white">
        
        <!-- Top Navigation Bar -->
        <div class="absolute top-6 right-6 sm:top-8 sm:right-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-teal-700 bg-slate-100 hover:bg-teal-50 px-4 py-2 rounded-xl transition border border-slate-200/80">
                <i class="fas fa-arrow-left text-[10px]"></i> Back to Home
            </a>
        </div>

        <!-- Mobile Logo -->
        <div class="md:hidden flex justify-center items-center gap-2 mb-8 mt-12">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-12 w-auto">
        </div>

        <div class="max-w-md w-full mx-auto">
            <!-- Form Header -->
            <div class="mb-8">
                <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-md border border-teal-100 inline-block mb-3">
                    Patient Portal SSO Access
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Welcome Back</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Enter your Patient ID or Bill Number and registered mobile number to seamlessly access your laboratory dashboard and reports.
                </p>
            </div>

            <!-- Error Banner -->
            <div id="loginAlertBox" class="hidden mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 text-xs font-semibold flex items-center gap-3 animate-fade-in">
                <i class="fas fa-circle-exclamation text-base text-rose-500 flex-shrink-0"></i>
                <span id="loginAlertMessage">Invalid credentials. Please try again.</span>
            </div>

            <!-- Success Banner -->
            <div id="loginSuccessBox" class="hidden mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 text-xs font-semibold flex items-center gap-3 animate-fade-in">
                <i class="fas fa-circle-check text-base text-emerald-500 flex-shrink-0"></i>
                <span>Authentication verified! Launching your Patient Dashboard...</span>
            </div>

            <!-- Login Form -->
            <form id="lisLoginForm" class="space-y-5">
                @csrf
                
                <!-- Patient ID / Bill Number -->
                <div>
                    <label for="patientIdInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Patient ID or Bill Number
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-id-card text-sm"></i>
                        </div>
                        <input 
                            type="text" 
                            id="patientIdInput" 
                            name="patient_id" 
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm uppercase tracking-wide" 
                            placeholder="e.g. PAT-1002 or INV-2609-0012" 
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <!-- Mobile Number -->
                <div>
                    <label for="phoneInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Registered Mobile Number
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-phone-alt text-sm"></i>
                        </div>
                        <input 
                            type="tel" 
                            id="phoneInput" 
                            name="phone" 
                            maxlength="10" 
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm" 
                            placeholder="e.g. 9876543210" 
                            required
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="submitLoginBtn" 
                    class="w-full mt-3 flex justify-center items-center gap-2 py-3.5 px-6 rounded-2xl shadow-lg shadow-teal-800/20 text-sm font-bold text-white bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 hover:shadow-teal-800/30 active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-teal-600/30 transition-all cursor-pointer"
                >
                    <span id="btnText">Login & Open Dashboard</span>
                    <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1" id="btnIcon"></i>
                </button>
            </form>
            
            <!-- Alternate Portals -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                <a href="{{ route('download.report') }}" class="flex-1 inline-flex justify-center items-center gap-2 py-3 px-3.5 border border-slate-200/90 rounded-2xl text-xs font-bold text-slate-700 hover:text-teal-800 hover:bg-teal-50/50 hover:border-teal-200 transition shadow-sm">
                    <i class="fas fa-file-medical text-teal-600 text-sm"></i>
                    <span>Track Report Status</span>
                </a>
                <a href="{{ route('agent.login') }}" class="flex-1 inline-flex justify-center items-center gap-2 py-3 px-3.5 border border-slate-200/90 rounded-2xl text-xs font-bold text-slate-700 hover:text-teal-800 hover:bg-teal-50/50 hover:border-teal-200 transition shadow-sm">
                    <i class="fas fa-vial text-emerald-600 text-sm"></i>
                    <span>Field Agent Portal</span>
                </a>
            </div>
            
            <!-- Notice Footer -->
            <div class="mt-8 text-center">
                <p class="text-xs text-slate-400 font-normal leading-relaxed">
                    Powered by Pathology LIS Cloud. Secured with 256-Bit SSL Encryption.
                </p>
            </div>
        </div>
    </div>

    <!-- AJAX Script -->
    <script>
        const form = document.getElementById('lisLoginForm');
        const alertBox = document.getElementById('loginAlertBox');
        const alertMsg = document.getElementById('loginAlertMessage');
        const successBox = document.getElementById('loginSuccessBox');
        const submitBtn = document.getElementById('submitLoginBtn');
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            alertBox.classList.add('hidden');
            successBox.classList.add('hidden');
            
            const patientId = document.getElementById('patientIdInput').value.trim();
            const phone = document.getElementById('phoneInput').value.trim();

            if (!patientId || !phone) {
                showAlert('Please enter both Patient ID / Bill Number and Mobile Number.');
                return;
            }

            // Button loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80');
            btnText.textContent = 'Verifying Credentials...';
            btnIcon.className = 'fas fa-circle-notch fa-spin text-xs';

            try {
                const res = await fetch('{{ route("lis.login.authenticate") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        patient_id: patientId,
                        phone: phone
                    })
                });

                const data = await res.json();

                if (data.success && data.data && data.data.redirect_url) {
                    successBox.classList.remove('hidden');
                    btnText.textContent = 'Redirecting...';
                    btnIcon.className = 'fas fa-check text-xs';
                    // Seamless redirect to authenticated dashboard
                    window.location.href = data.data.redirect_url;
                } else {
                    showAlert(data.message || 'Invalid details. Please verify your ID and Mobile.');
                    resetBtn();
                }
            } catch (err) {
                showAlert('Server connection error. Please try again later.');
                resetBtn();
            }
        });

        function showAlert(msg) {
            alertMsg.textContent = msg;
            alertBox.classList.remove('hidden');
        }

        function resetBtn() {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-80');
            btnText.textContent = 'Login & Open Dashboard';
            btnIcon.className = 'fas fa-arrow-right text-xs';
        }
    </script>

</body>
</html>
