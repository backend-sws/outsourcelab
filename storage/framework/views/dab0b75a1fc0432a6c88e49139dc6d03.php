<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIS Staff & Doctor Login | Av Wellcare Diagnostics</title>
    <?php echo $__env->make('partials.favicon', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
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
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-3 group">
                <img src="<?php echo e(asset('logo.png')); ?>" alt="Av Wellcare Logo" class="h-16 w-auto p-1 object-contain drop-shadow-sm transition-transform duration-300 group-hover:scale-105">
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
                Securely manage laboratory sample workflows, test approvals, pathologist digital signatures, and automated LIS integration in one unified cloud portal.
            </p>

            <div class="flex items-center gap-4 text-xs font-semibold text-slate-700">
                <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-1.5 rounded-xl border border-teal-600/10">
                    <i class="fas fa-shield-halved text-emerald-600"></i>
                    <span>256-Bit HIPAA Compliant</span>
                </div>
                <div class="flex items-center gap-2 bg-white/60 backdrop-blur px-3 py-1.5 rounded-xl border border-teal-600/10">
                    <i class="fas fa-bolt text-amber-600"></i>
                    <span>Real-time LIS Sync</span>
                </div>
            </div>
        </div>

        <!-- Bottom Notice -->
        <div class="relative z-10 border-t border-teal-800/10 pt-6 flex items-center justify-between text-xs text-slate-600">
            <span>Hospital & Diagnostic Network</span>
            <span class="flex items-center gap-1.5 text-emerald-700 font-semibold"><i class="fas fa-circle-check text-xs"></i> LIS Cloud Connected</span>
        </div>
    </div>

    <!-- Right Side: Clean Modern Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center p-6 sm:p-12 lg:p-20 relative min-h-screen bg-white">
        
        <!-- Top Navigation Bar -->
        <div class="absolute top-6 right-6 sm:top-8 sm:right-8 flex items-center gap-3">
            <a href="<?php echo e(route('download.report')); ?>" class="hidden sm:inline-flex items-center gap-2 text-xs font-bold text-teal-700 hover:text-teal-800 bg-teal-50 hover:bg-teal-100/70 px-3.5 py-2 rounded-xl transition border border-teal-200/60">
                <i class="fas fa-file-medical text-[11px]"></i> Patient Report Login
            </a>
            <a href="<?php echo e(route('home')); ?>" class="inline-flex items-center gap-2 text-xs font-bold text-slate-600 hover:text-teal-700 bg-slate-100 hover:bg-teal-50 px-4 py-2 rounded-xl transition border border-slate-200/80">
                <i class="fas fa-arrow-left text-[10px]"></i> Back to Home
            </a>
        </div>

        <!-- Mobile Logo -->
        <div class="md:hidden flex justify-center items-center gap-2 mb-8 mt-12">
            <img src="<?php echo e(asset('logo.png')); ?>" alt="Logo" class="h-12 w-auto">
        </div>

        <div class="max-w-md w-full mx-auto">
            <!-- Form Header -->
            <div class="mb-8">
                <div class="inline-flex items-center gap-1.5 text-[11px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-md border border-teal-100 mb-3">
                    <i class="fas fa-user-md text-xs"></i>
                    <span>Staff & Doctor LIS Portal</span>
                </div>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Staff & Doctor Login</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Enter your registered email or mobile number and password to access the laboratory software dashboard.
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
                <span>Authentication verified! Launching your LIS Dashboard...</span>
            </div>

            <!-- Login Form (Supports both AJAX and Direct Form Post) -->
            <form id="lisLoginForm" method="POST" action="<?php echo e($directLoginUrl); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="api_key" value="<?php echo e($apiKey); ?>">
                
                <!-- Email or Mobile -->
                <div>
                    <label for="loginInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Email or Mobile Number
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-user-tie text-sm"></i>
                        </div>
                        <input 
                            type="text" 
                            id="loginInput" 
                            name="login" 
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm" 
                            placeholder="e.g. doctor@ojaselab.com or 9876543210" 
                            required 
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password with Show/Hide toggle -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="passwordInput" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">
                            Account Password
                        </label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fas fa-lock text-sm"></i>
                        </div>
                        <input 
                            type="password" 
                            id="passwordInput" 
                            name="password" 
                            class="block w-full pl-11 pr-12 py-3.5 bg-slate-50/90 border border-slate-200 rounded-2xl text-slate-900 text-sm font-medium placeholder:text-slate-400 focus:bg-white focus:border-teal-600 focus:ring-4 focus:ring-teal-600/15 transition-all outline-none shadow-sm" 
                            placeholder="Enter your account password" 
                            required
                        >
                        <button 
                            type="button" 
                            id="togglePasswordBtn" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600 transition focus:outline-none"
                            aria-label="Toggle password visibility"
                        >
                            <i class="fas fa-eye text-sm" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    id="submitLoginBtn" 
                    class="w-full mt-3 flex justify-center items-center gap-2 py-3.5 px-6 rounded-2xl shadow-lg shadow-teal-800/20 text-sm font-bold text-white bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 hover:shadow-teal-800/30 active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-teal-600/30 transition-all cursor-pointer"
                >
                    <span id="btnText">Staff Login & Open Dashboard</span>
                    <i class="fas fa-arrow-right text-xs transition-transform group-hover:translate-x-1" id="btnIcon"></i>
                </button>
            </form>
            
            <!-- Patient Notice Banner -->
            <div class="mt-6 p-4 rounded-2xl bg-amber-50/70 border border-amber-200/80 flex items-start gap-3">
                <i class="fas fa-circle-info text-amber-600 text-sm mt-0.5 flex-shrink-0"></i>
                <div class="text-xs text-amber-900">
                    <span class="font-bold">Are you a patient?</span>
                    <p class="text-amber-800/90 mt-0.5">
                        This login is strictly for laboratory doctors, technicians, and partners. To view test status or download signed reports, please visit the 
                        <a href="<?php echo e(route('download.report')); ?>" class="font-bold underline text-amber-900 hover:text-teal-800">Download Report & Patient Portal</a>.
                    </p>
                </div>
            </div>

            <!-- Alternate Portals -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex flex-col sm:flex-row gap-3">
                <a href="<?php echo e(route('download.report')); ?>" class="flex-1 inline-flex justify-center items-center gap-2 py-3 px-3.5 border border-slate-200/90 rounded-2xl text-xs font-bold text-slate-700 hover:text-teal-800 hover:bg-teal-50/50 hover:border-teal-200 transition shadow-sm">
                    <i class="fas fa-file-medical text-teal-600 text-sm"></i>
                    <span>Patient Report Portal</span>
                </a>
                <a href="<?php echo e(route('agent.login')); ?>" class="flex-1 inline-flex justify-center items-center gap-2 py-3 px-3.5 border border-slate-200/90 rounded-2xl text-xs font-bold text-slate-700 hover:text-teal-800 hover:bg-teal-50/50 hover:border-teal-200 transition shadow-sm">
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

    <!-- AJAX & UI Script -->
    <script>
        const form = document.getElementById('lisLoginForm');
        const alertBox = document.getElementById('loginAlertBox');
        const alertMsg = document.getElementById('loginAlertMessage');
        const successBox = document.getElementById('loginSuccessBox');
        const submitBtn = document.getElementById('submitLoginBtn');
        const btnText = document.getElementById('btnText');
        const btnIcon = document.getElementById('btnIcon');
        const passwordInput = document.getElementById('passwordInput');
        const togglePasswordBtn = document.getElementById('togglePasswordBtn');
        const eyeIcon = document.getElementById('eyeIcon');

        // Toggle password visibility
        if (togglePasswordBtn && passwordInput) {
            togglePasswordBtn.addEventListener('click', () => {
                const isPassword = passwordInput.getAttribute('type') === 'password';
                passwordInput.setAttribute('type', isPassword ? 'text' : 'password');
                eyeIcon.className = isPassword ? 'fas fa-eye-slash text-sm text-teal-600' : 'fas fa-eye text-sm text-slate-400';
            });
        }

        form.addEventListener('submit', async (e) => {
            e.preventDefault();
            alertBox.classList.add('hidden');
            successBox.classList.add('hidden');
            
            const login = document.getElementById('loginInput').value.trim();
            const password = passwordInput.value;

            if (!login || !password) {
                showAlert('Please enter both Email/Mobile and Password.');
                return;
            }

            // Button loading state
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80');
            btnText.textContent = 'Verifying Credentials...';
            btnIcon.className = 'fas fa-circle-notch fa-spin text-xs';

            try {
                const res = await fetch('<?php echo e(route("lis.login.authenticate")); ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ login, password })
                });

                const data = await res.json();

                if (data.success && data.data && data.data.redirect_url) {
                    successBox.classList.remove('hidden');
                    btnText.textContent = 'Launching Dashboard...';
                    btnIcon.className = 'fas fa-check text-xs';
                    // Seamless redirect to authenticated dashboard via SSO token
                    window.location.href = data.data.redirect_url;
                } else {
                    showAlert(data.message || 'Invalid login credentials. Please verify and try again.');
                    resetBtn();
                }
            } catch (err) {
                // If AJAX fails, ask user if they want to submit directly via HTML form
                showAlert('Network issue connecting to API. Retrying via direct login...');
                form.submit();
            }
        });

        function showAlert(msg) {
            alertMsg.textContent = msg;
            alertBox.classList.remove('hidden');
        }

        function resetBtn() {
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-80');
            btnText.textContent = 'Staff Login & Open Dashboard';
            btnIcon.className = 'fas fa-arrow-right text-xs';
        }
    </script>

</body>
</html>
<?php /**PATH C:\Users\Employee\Desktop\outsourcelab\resources\views/frontend/pages/lis-login.blade.php ENDPATH**/ ?>