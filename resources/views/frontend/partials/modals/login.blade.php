<!-- Offcanvas Login Modal Overlay -->
<div id="loginModalOverlay" class="fixed inset-0 bg-black/50 z-[100] hidden opacity-0 transition-opacity duration-300"></div>

<!-- Offcanvas Login Modal Panel -->
<div id="loginModalPanel" class="fixed top-0 right-0 h-full w-full sm:w-[400px] bg-white z-[101] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col overflow-y-auto">
    <!-- Header -->
    <div class="flex justify-between items-center p-6 border-b border-gray-100 flex-shrink-0">
        <h3 class="text-xl font-extrabold text-brand-dark">Welcome</h3>
        <button id="closeLoginModalBtn" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Body: Login State -->
    <div id="loginStateEmail" class="flex-grow p-6 flex flex-col bg-gray-50/50">
        <div id="loginCustomNotice" class="hidden bg-amber-50 text-amber-900 border border-amber-200 text-xs font-bold p-3 rounded-xl mb-4 flex items-center gap-2 shadow-sm">
            <i class="fas fa-shopping-cart text-amber-600"></i>
            <span id="loginCustomNoticeText"></span>
        </div>
        <!-- Tabs -->
        <div class="flex bg-gray-200 rounded-lg p-1 mb-6">
            <button class="flex-1 py-2 text-sm font-bold bg-white text-brand-dark rounded-md shadow-sm" type="button">Login</button>
            <button class="flex-1 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 transition" type="button" id="switchToRegisterTabBtn">Register</button>
        </div>
        
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-brand-light/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-brand-light">
                <i class="fas fa-sign-in-alt text-2xl text-brand-secondary"></i>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Welcome Back!</h4>
            <p class="text-sm text-gray-500">Please enter your email and password to login</p>
        </div>
        
        <form id="emailForm" class="space-y-4 flex-grow flex flex-col">
            <div>
                <label for="emailInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-envelope text-sm"></i></span>
                    <input type="email" id="emailInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="e.g. yourname@example.com" required>
                </div>
            </div>
            <div>
                <label for="passwordInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-2">Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-lock text-sm"></i></span>
                    <input type="password" id="passwordInput" class="w-full pl-11 pr-11 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="Enter your password" required>
                    <button type="button" onclick="const p = document.getElementById('passwordInput'); const isP = p.type === 'password'; p.type = isP ? 'text' : 'password'; this.querySelector('i').className = isP ? 'far fa-eye-slash text-sm' : 'far fa-eye text-sm';" class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 hover:text-slate-600">
                        <i class="far fa-eye text-sm"></i>
                    </button>
                </div>
                <div class="text-right mt-2">
                    <button type="button" id="forgotPasswordLink" class="text-xs text-teal-700 font-bold hover:underline">Forgot Password?</button>
                </div>
            </div>
            
            <div class="mt-auto pt-6">
                <div id="loginError" class="text-rose-500 text-xs hidden font-bold text-center mb-4"></div>
                <button type="submit" class="w-full bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-teal-800/20 active:scale-[0.99] transition flex items-center justify-center cursor-pointer">
                    <span>Sign In</span>
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Body: Register State -->
    <div id="loginStateRegister" class="flex-grow p-6 flex flex-col bg-gray-50/50 hidden">
        <!-- Tabs -->
        <div class="flex bg-gray-200 rounded-lg p-1 mb-4">
            <button class="flex-1 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 transition" type="button" id="switchToLoginTabBtn">Login</button>
            <button class="flex-1 py-2 text-sm font-bold bg-white text-teal-900 rounded-md shadow-sm" type="button">Register</button>
        </div>

        <!-- Account Type Switcher: Patient vs Field Agent -->
        <div class="bg-gray-200/80 p-1 rounded-xl flex mb-4 border border-gray-200">
            <button type="button" id="regTypePatientBtn" class="flex-1 py-2 px-3 text-xs font-bold rounded-lg transition-all bg-white text-teal-900 shadow-sm flex items-center justify-center gap-1.5">
                <i class="fas fa-user text-teal-600"></i> Patient
            </button>
            <button type="button" id="regTypeAgentBtn" class="flex-1 py-2 px-3 text-xs font-bold rounded-lg transition-all text-gray-500 hover:text-gray-800 flex items-center justify-center gap-1.5">
                <i class="fas fa-id-badge text-teal-600"></i> Register as Agent
            </button>
        </div>
        
        <div class="text-center mb-4">
            <div id="regHeaderIcon" class="w-12 h-12 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-2 border border-teal-100">
                <i class="fas fa-user-plus text-xl text-teal-700"></i>
            </div>
            <h4 id="regHeaderTitle" class="text-base font-bold text-gray-800 mb-0.5">Create an Account</h4>
            <p id="regHeaderSubtitle" class="text-xs text-gray-500">Join us to manage your health easily</p>
        </div>
        
        <form id="registerForm" class="space-y-3.5 flex-grow flex flex-col">
            <!-- Agent Specific Fields -->
            <div id="agentExtraFields" class="space-y-3.5 hidden">
                <div>
                    <label for="regNameInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Full Name</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-user-tag text-sm"></i></span>
                        <input type="text" id="regNameInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="e.g. Ramesh Kumar">
                    </div>
                </div>
                <div>
                    <label for="regPhoneInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Mobile Number</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-phone-alt text-sm"></i></span>
                        <input type="tel" id="regPhoneInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="e.g. 9876543210">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-2.5">
                    <div>
                        <label for="regCityInput" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">City / Region</label>
                        <input type="text" id="regCityInput" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-teal-600 outline-none" placeholder="e.g. Patna">
                    </div>
                    <div>
                        <label for="regVehicleInput" class="block text-[11px] font-bold text-slate-600 uppercase tracking-wider mb-1">Vehicle No.</label>
                        <input type="text" id="regVehicleInput" class="w-full px-3.5 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-800 placeholder:text-slate-400 focus:bg-white focus:border-teal-600 outline-none" placeholder="e.g. BR-01-AB-1234">
                    </div>
                </div>
            </div>

            <div>
                <label for="regEmailInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Email Address</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-envelope text-sm"></i></span>
                    <input type="email" id="regEmailInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="e.g. yourname@example.com" required>
                </div>
            </div>
            <div>
                <label for="regPasswordInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-lock text-sm"></i></span>
                    <input type="password" id="regPasswordInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="Create a password (min. 6 chars)" required>
                </div>
            </div>
            <div>
                <label for="regPasswordConfirmInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Confirm Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-check text-sm"></i></span>
                    <input type="password" id="regPasswordConfirmInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="Confirm your password" required>
                </div>
            </div>
            
            <div class="mt-auto pt-4">
                <div id="registerError" class="text-red-500 text-xs hidden font-bold text-center mb-3"></div>
                <button type="submit" id="regSubmitBtn" class="w-full bg-brand-secondary text-white font-bold py-3 px-4 rounded-xl hover:bg-opacity-90 transition shadow-lg flex items-center justify-center">
                    <span id="regSubmitBtnText">Create Account</span>
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Body: Forgot Password State -->
    <div id="loginStateForgot" class="flex-grow p-6 flex flex-col justify-center bg-gray-50/50 hidden">
        <div class="mb-8">
            <button id="backToLoginBtn" class="text-gray-400 hover:text-brand-secondary transition mb-4 flex items-center text-sm font-bold">
                <i class="fas fa-arrow-left mr-2"></i> Back to Login
            </button>
            <div class="w-16 h-16 bg-brand-light/20 rounded-full flex items-center justify-center mb-4 border border-brand-light">
                <i class="fas fa-key text-2xl text-brand-secondary"></i>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Forgot Password</h4>
            <p class="text-sm text-gray-500">Enter your email to receive an OTP</p>
        </div>
        
        <form id="forgotForm" class="space-y-4">
            <div>
                <label for="forgotEmailInput" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Email Address</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-envelope"></i></span>
                    <input type="email" id="forgotEmailInput" class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary transition shadow-sm font-bold text-gray-800 text-lg placeholder-gray-300" placeholder="you@example.com" required>
                </div>
            </div>
            <div id="forgotError" class="text-red-500 text-sm hidden font-bold text-center"></div>
            <button type="submit" class="w-full bg-brand-secondary text-white font-bold py-3.5 px-4 rounded-xl hover:bg-opacity-90 transition shadow-lg mt-4 flex items-center justify-center">
                <span>Send OTP</span>
                <i class="fas fa-paper-plane ml-2"></i>
            </button>
        </form>
    </div>

    <!-- Body: Reset Password State -->
    <div id="loginStateReset" class="flex-grow p-6 flex flex-col justify-center bg-gray-50/50 hidden">
        <div class="mb-8">
            <h4 class="text-lg font-bold text-gray-800 mb-2">Reset Password</h4>
            <p class="text-sm text-gray-500">OTP sent to <span id="displayEmailNumber" class="font-bold text-brand-dark"></span></p>
        </div>
        
        <form id="resetForm" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-4 text-center">Enter 4 Digit OTP</label>
                <div class="flex justify-center space-x-4">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                </div>
            </div>
            <div>
                <label for="newPasswordInput" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">New Password</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"><i class="fas fa-lock"></i></span>
                    <input type="password" id="newPasswordInput" class="w-full pl-12 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary transition shadow-sm font-bold text-gray-800 text-lg placeholder-gray-300" placeholder="New password" required>
                </div>
            </div>
            <div id="resetError" class="text-red-500 text-sm hidden font-bold text-center"></div>
            <div id="devOtpMessage" class="text-green-600 text-sm hidden font-bold text-center bg-green-50 p-2 rounded"></div>
            <button type="submit" class="w-full bg-brand-dark text-white font-bold py-3.5 px-4 rounded-xl hover:bg-opacity-90 transition shadow-lg mt-8 flex items-center justify-center">
                <span>Reset & Login</span>
                <i class="fas fa-check-circle ml-2"></i>
            </button>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('loginModalOverlay');
    const panel = document.getElementById('loginModalPanel');
    const closeBtn = document.getElementById('closeLoginModalBtn');
    
    const stateEmail = document.getElementById('loginStateEmail');
    const stateRegister = document.getElementById('loginStateRegister');
    const stateForgot = document.getElementById('loginStateForgot');
    const stateReset = document.getElementById('loginStateReset');
    
    const emailForm = document.getElementById('emailForm');
    const registerForm = document.getElementById('registerForm');
    const forgotForm = document.getElementById('forgotForm');
    const resetForm = document.getElementById('resetForm');
    
    // Inputs
    const emailInput = document.getElementById('emailInput');
    const passwordInput = document.getElementById('passwordInput');
    
    const regEmailInput = document.getElementById('regEmailInput');
    const regPasswordInput = document.getElementById('regPasswordInput');
    const regPasswordConfirmInput = document.getElementById('regPasswordConfirmInput');
    
    const forgotEmailInput = document.getElementById('forgotEmailInput');
    const newPasswordInput = document.getElementById('newPasswordInput');
    const displayEmailNumber = document.getElementById('displayEmailNumber');
    
    // Links / Buttons
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const backToLoginBtn = document.getElementById('backToLoginBtn');
    const switchToRegisterTabBtn = document.getElementById('switchToRegisterTabBtn');
    const switchToLoginTabBtn = document.getElementById('switchToLoginTabBtn');
    
    // Errors
    const loginError = document.getElementById('loginError');
    const registerError = document.getElementById('registerError');
    const forgotError = document.getElementById('forgotError');
    const resetError = document.getElementById('resetError');
    const devOtpMessage = document.getElementById('devOtpMessage');
    
    // Auto-focus OTP inputs
    const otpInputs = document.querySelectorAll('.otp-input');
    otpInputs.forEach((input, index) => {
        input.addEventListener('keyup', (e) => {
            if (e.key >= 0 && e.key <= 9 && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            } else if (e.key === 'Backspace' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
    });

    // Global function to open modal (to be called from header or add-to-cart)
    window.openLoginModal = function(isRegister = false, customNotice = null) {
        overlay.classList.remove('hidden');
        // Trigger reflow
        void overlay.offsetWidth;
        overlay.classList.remove('opacity-0');
        panel.classList.remove('translate-x-full');
        
        // Reset states
        stateForgot.classList.add('hidden');
        stateReset.classList.add('hidden');
        
        if (isRegister) {
            stateEmail.classList.add('hidden');
            stateRegister.classList.remove('hidden');
        } else {
            stateEmail.classList.remove('hidden');
            stateRegister.classList.add('hidden');
        }

        // Custom notice
        const noticeEl = document.getElementById('loginCustomNotice');
        const noticeTextEl = document.getElementById('loginCustomNoticeText');
        if (noticeEl && noticeTextEl) {
            if (customNotice) {
                noticeTextEl.innerText = customNotice;
                noticeEl.classList.remove('hidden');
            } else {
                noticeEl.classList.add('hidden');
            }
        }
        
        // Clear all inputs
        emailInput.value = '';
        passwordInput.value = '';
        regEmailInput.value = '';
        regPasswordInput.value = '';
        regPasswordConfirmInput.value = '';
        forgotEmailInput.value = '';
        newPasswordInput.value = '';
        otpInputs.forEach(i => i.value = '');
        
        // Clear all errors
        loginError.classList.add('hidden');
        registerError.classList.add('hidden');
        forgotError.classList.add('hidden');
        resetError.classList.add('hidden');
        devOtpMessage.classList.add('hidden');
    }

    function handlePostAuthSuccess(data) {
        let pendingItemStr = sessionStorage.getItem('pending_cart_item');
        if (pendingItemStr) {
            try {
                let pendingItem = JSON.parse(pendingItemStr);
                let userCart = Array.isArray(data.cart) ? data.cart : [];
                if (!userCart.some(it => it.name === pendingItem.name)) {
                    userCart.push(pendingItem);
                }
                sessionStorage.removeItem('pending_cart_item');
                // Sync to database before reload/redirect
                fetch('{{ route("patient.cart.sync") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ cart: userCart })
                }).finally(() => {
                    closeLoginModal();
                    if (window.location.pathname === '/' || window.location.pathname === '') {
                        window.location.reload();
                    } else {
                        window.location.href = data.redirect || '/';
                    }
                });
                return;
            } catch(e) {}
        }

        closeLoginModal();
        if (data.redirect && (data.role === 'agent' || data.redirect.includes('/admin') || data.redirect.includes('/agent'))) {
            window.location.href = data.redirect;
            return;
        }

        if (window.location.pathname === '/' || window.location.pathname === '') {
            window.location.reload();
        } else {
            window.location.href = data.redirect || '/';
        }
    }

    function closeLoginModal() {
        overlay.classList.add('opacity-0');
        panel.classList.add('translate-x-full');
        setTimeout(() => {
            overlay.classList.add('hidden');
        }, 300); // Wait for transition
    }

    closeBtn.addEventListener('click', closeLoginModal);
    overlay.addEventListener('click', closeLoginModal);

    // Navigation between states
    switchToRegisterTabBtn.addEventListener('click', function() {
        stateEmail.classList.add('hidden');
        stateRegister.classList.remove('hidden');
        if (emailInput.value) regEmailInput.value = emailInput.value;
    });
    
    switchToLoginTabBtn.addEventListener('click', function() {
        stateRegister.classList.add('hidden');
        stateEmail.classList.remove('hidden');
        if (regEmailInput.value) emailInput.value = regEmailInput.value;
    });

    forgotPasswordLink.addEventListener('click', function() {
        stateEmail.classList.add('hidden');
        stateForgot.classList.remove('hidden');
        if (emailInput.value) {
            forgotEmailInput.value = emailInput.value;
        }
    });

    backToLoginBtn.addEventListener('click', function() {
        stateForgot.classList.add('hidden');
        stateEmail.classList.remove('hidden');
    });

    // Handle Login Submit
    emailForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = emailForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
        loginError.classList.add('hidden');

        fetch('{{ route("patient.login") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                email: emailInput.value,
                password: passwordInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                handlePostAuthSuccess(data);
            } else {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                loginError.innerText = data.message || 'Login failed.';
                loginError.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            loginError.innerText = 'An error occurred. Please try again.';
            loginError.classList.remove('hidden');
        });
    });

    // Account Type switcher
    let currentRegRole = 'patient';
    const regTypePatientBtn = document.getElementById('regTypePatientBtn');
    const regTypeAgentBtn = document.getElementById('regTypeAgentBtn');
    const agentExtraFields = document.getElementById('agentExtraFields');
    const regNameInput = document.getElementById('regNameInput');
    const regPhoneInput = document.getElementById('regPhoneInput');
    const regCityInput = document.getElementById('regCityInput');
    const regVehicleInput = document.getElementById('regVehicleInput');
    const regHeaderTitle = document.getElementById('regHeaderTitle');
    const regHeaderSubtitle = document.getElementById('regHeaderSubtitle');
    const regSubmitBtnText = document.getElementById('regSubmitBtnText');

    function setRegRole(role) {
        currentRegRole = role;
        if (role === 'agent') {
            regTypeAgentBtn.classList.add('bg-white', 'text-brand-dark', 'shadow-sm');
            regTypeAgentBtn.classList.remove('text-gray-500');
            regTypePatientBtn.classList.remove('bg-white', 'text-brand-dark', 'shadow-sm');
            regTypePatientBtn.classList.add('text-gray-500');
            agentExtraFields.classList.remove('hidden');
            regHeaderTitle.innerText = 'Register as Field Agent';
            regHeaderSubtitle.innerText = 'Join our sample collection & phlebotomy network';
            regSubmitBtnText.innerText = 'Register as Field Agent';
        } else {
            regTypePatientBtn.classList.add('bg-white', 'text-brand-dark', 'shadow-sm');
            regTypePatientBtn.classList.remove('text-gray-500');
            regTypeAgentBtn.classList.remove('bg-white', 'text-brand-dark', 'shadow-sm');
            regTypeAgentBtn.classList.add('text-gray-500');
            agentExtraFields.classList.add('hidden');
            regHeaderTitle.innerText = 'Create an Account';
            regHeaderSubtitle.innerText = 'Join us to manage your health easily';
            regSubmitBtnText.innerText = 'Create Account';
        }
    }

    if (regTypePatientBtn && regTypeAgentBtn) {
        regTypePatientBtn.addEventListener('click', () => setRegRole('patient'));
        regTypeAgentBtn.addEventListener('click', () => setRegRole('agent'));
    }

    // Handle Register Submit
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (regPasswordInput.value !== regPasswordConfirmInput.value) {
            registerError.innerText = "Passwords do not match!";
            registerError.classList.remove('hidden');
            return;
        }
        
        const submitBtn = registerForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
        registerError.classList.add('hidden');

        if (currentRegRole === 'agent') {
            if (!regNameInput.value.trim() || !regPhoneInput.value.trim()) {
                registerError.innerText = "Please enter your Full Name and Mobile Number.";
                registerError.classList.remove('hidden');
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                return;
            }

            fetch('{{ route("agent.register") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ 
                    name: regNameInput.value.trim(),
                    phone: regPhoneInput.value.trim(),
                    city: regCityInput.value.trim(),
                    vehicle_number: regVehicleInput.value.trim(),
                    email: regEmailInput.value.trim(),
                    password: regPasswordInput.value
                })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    closeLoginModal();
                    window.location.href = data.redirect || '{{ route("agent.dashboard") }}';
                } else {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                    registerError.innerText = data.message || 'Agent registration failed.';
                    registerError.classList.remove('hidden');
                }
            })
            .catch(err => {
                console.error(err);
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                registerError.innerText = 'An error occurred. Please try again.';
                registerError.classList.remove('hidden');
            });
            return;
        }

        fetch('{{ route("patient.register") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                email: regEmailInput.value,
                password: regPasswordInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                handlePostAuthSuccess(data);
            } else {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                registerError.innerText = data.message || 'Registration failed.';
                registerError.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            registerError.innerText = 'An error occurred. Please try again.';
            registerError.classList.remove('hidden');
        });
    });

    // Handle Forgot Password Submit
    forgotForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const submitBtn = forgotForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sending...';
        submitBtn.disabled = true;
        forgotError.classList.add('hidden');

        fetch('{{ route("patient.forgot_password") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ email: forgotEmailInput.value })
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            
            if(data.success) {
                stateForgot.classList.add('hidden');
                stateReset.classList.remove('hidden');
                displayEmailNumber.innerText = forgotEmailInput.value;
                if(data.debug_otp) {
                    devOtpMessage.innerText = "DEV MODE OTP: " + data.debug_otp;
                    devOtpMessage.classList.remove('hidden');
                }
                otpInputs[0].focus();
            } else {
                forgotError.innerText = data.message || 'Failed to send OTP.';
                forgotError.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            forgotError.innerText = 'An error occurred. Please try again.';
            forgotError.classList.remove('hidden');
        });
    });

    // Handle Reset Password Submit
    resetForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let otp = '';
        otpInputs.forEach(i => otp += i.value);
        
        if (otp.length !== 4) {
            resetError.innerText = 'Please enter a 4-digit OTP.';
            resetError.classList.remove('hidden');
            return;
        }

        const submitBtn = resetForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Resetting...';
        submitBtn.disabled = true;
        resetError.classList.add('hidden');

        fetch('{{ route("patient.reset_password") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                email: forgotEmailInput.value,
                otp: otp,
                password: newPasswordInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            if(data.success) {
                handlePostAuthSuccess(data);
            } else {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                resetError.innerText = data.message || 'Failed to reset password.';
                resetError.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            resetError.innerText = 'An error occurred. Please try again.';
            resetError.classList.remove('hidden');
        });
    });
});
</script>
