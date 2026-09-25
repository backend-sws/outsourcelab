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
        <div class="flex bg-gray-200 rounded-lg p-1 mb-5">
            <button class="flex-1 py-2 text-sm font-bold text-gray-500 hover:text-gray-700 transition" type="button" id="switchToLoginTabBtn">Login</button>
            <button class="flex-1 py-2 text-sm font-bold bg-white text-teal-900 rounded-md shadow-sm" type="button">Register</button>
        </div>
        
        <div class="text-center mb-5">
            <div id="regHeaderIcon" class="w-12 h-12 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-2 border border-teal-100">
                <i class="fas fa-user-plus text-xl text-teal-700"></i>
            </div>
            <h4 id="regHeaderTitle" class="text-base font-bold text-gray-800 mb-0.5">Create Patient Account</h4>
            <p id="regHeaderSubtitle" class="text-xs text-gray-500">Join us to book tests and manage your health records</p>
        </div>
        
        <form id="registerForm" class="space-y-3.5 flex-grow flex flex-col">
            <div>
                <label for="regNameInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Full Name <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-user text-sm"></i></span>
                    <input type="text" id="regNameInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="e.g. Ramesh Kumar" required>
                </div>
            </div>

            <div>
                <label for="regEmailInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Email Address <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-envelope text-sm"></i></span>
                    <input type="email" id="regEmailInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="e.g. yourname@example.com" required>
                </div>
            </div>

            <div>
                <label for="regMobileInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Mobile Number (Optional)</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-phone-alt text-sm"></i></span>
                    <input type="tel" id="regMobileInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="e.g. 9876543210" maxlength="15">
                </div>
            </div>

            <div>
                <label for="regPasswordInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Password <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-lock text-sm"></i></span>
                    <input type="password" id="regPasswordInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="Create a password (min. 6 chars)" required minlength="6">
                </div>
            </div>

            <div>
                <label for="regPasswordConfirmInput" class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-1.5">Confirm Password <span class="text-rose-500">*</span></label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"><i class="fas fa-check text-sm"></i></span>
                    <input type="password" id="regPasswordConfirmInput" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-4 focus:ring-teal-500/15 focus:border-teal-600 transition shadow-sm font-medium text-slate-800 text-sm placeholder:text-slate-400 outline-none" placeholder="Confirm your password" required minlength="6">
                </div>
            </div>
            
            <div class="mt-auto pt-4">
                <div id="registerError" class="text-rose-500 text-xs hidden font-bold text-center mb-3"></div>
                <button type="submit" id="regSubmitBtn" class="w-full bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-teal-800/20 active:scale-[0.99] transition flex items-center justify-center cursor-pointer">
                    <span id="regSubmitBtnText">Create Account</span>
                    <i class="fas fa-arrow-right ml-2 text-xs"></i>
                </button>
            </div>
        </form>
    </div>

    <!-- Body: Register OTP Verification State -->
    <div id="loginStateRegisterOtp" class="flex-grow p-6 flex flex-col justify-center bg-gray-50/50 hidden">
        <div class="text-center mb-6">
            <div class="w-16 h-16 bg-teal-50 rounded-full flex items-center justify-center mx-auto mb-3 border border-teal-100 shadow-sm">
                <i class="fas fa-envelope-circle-check text-2xl text-teal-700"></i>
            </div>
            <h4 class="text-lg font-extrabold text-gray-900 mb-1">Verify Your Email</h4>
            <p class="text-xs text-gray-500 leading-relaxed">Enter the 6-digit OTP code sent to<br><span id="displayRegEmail" class="font-bold text-teal-800"></span></p>
        </div>

        <form id="registerOtpForm" class="space-y-5">
            <div>
                <label class="block text-xs font-bold text-slate-600 uppercase tracking-wider mb-3 text-center">6-Digit Verification Code</label>
                <div class="flex justify-center gap-2" id="regOtpInputsContainer">
                    <input type="text" class="reg-otp-input w-10 h-12 text-center text-xl font-black border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-600 focus:border-teal-600 bg-white shadow-sm outline-none" maxlength="1" inputmode="numeric">
                    <input type="text" class="reg-otp-input w-10 h-12 text-center text-xl font-black border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-600 focus:border-teal-600 bg-white shadow-sm outline-none" maxlength="1" inputmode="numeric">
                    <input type="text" class="reg-otp-input w-10 h-12 text-center text-xl font-black border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-600 focus:border-teal-600 bg-white shadow-sm outline-none" maxlength="1" inputmode="numeric">
                    <input type="text" class="reg-otp-input w-10 h-12 text-center text-xl font-black border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-600 focus:border-teal-600 bg-white shadow-sm outline-none" maxlength="1" inputmode="numeric">
                    <input type="text" class="reg-otp-input w-10 h-12 text-center text-xl font-black border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-600 focus:border-teal-600 bg-white shadow-sm outline-none" maxlength="1" inputmode="numeric">
                    <input type="text" class="reg-otp-input w-10 h-12 text-center text-xl font-black border border-slate-200 rounded-xl focus:ring-2 focus:ring-teal-600 focus:border-teal-600 bg-white shadow-sm outline-none" maxlength="1" inputmode="numeric">
                </div>
            </div>

            <div id="registerOtpError" class="text-rose-500 text-xs hidden font-bold text-center"></div>
            <div id="registerOtpSuccess" class="text-emerald-600 text-xs hidden font-bold text-center"></div>
            <div id="devRegisterOtpMessage" class="text-teal-700 text-xs hidden font-bold text-center bg-teal-50 p-2 rounded-lg border border-teal-200"></div>

            <button type="submit" id="btnVerifyRegisterOtp" class="w-full bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 text-white font-bold py-3.5 px-4 rounded-xl shadow-lg shadow-teal-800/20 active:scale-[0.99] transition flex items-center justify-center cursor-pointer">
                <span>Verify & Activate Account</span>
                <i class="fas fa-check-circle ml-2 text-xs"></i>
            </button>

            <div class="flex items-center justify-between text-xs pt-2">
                <button type="button" id="backToRegisterBtn" class="text-slate-500 hover:text-teal-800 font-bold transition">
                    <i class="fas fa-arrow-left mr-1"></i> Edit Details
                </button>
                <button type="button" id="resendRegisterOtpBtn" class="text-teal-700 hover:underline font-bold transition">
                    Resend Code <span id="resendCountdown" class="text-slate-400 font-normal"></span>
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
    const stateRegisterOtp = document.getElementById('loginStateRegisterOtp');
    const stateForgot = document.getElementById('loginStateForgot');
    const stateReset = document.getElementById('loginStateReset');
    
    const emailForm = document.getElementById('emailForm');
    const registerForm = document.getElementById('registerForm');
    const registerOtpForm = document.getElementById('registerOtpForm');
    const forgotForm = document.getElementById('forgotForm');
    const resetForm = document.getElementById('resetForm');
    
    // Inputs
    const emailInput = document.getElementById('emailInput');
    const passwordInput = document.getElementById('passwordInput');
    
    const regNameInput = document.getElementById('regNameInput');
    const regEmailInput = document.getElementById('regEmailInput');
    const regMobileInput = document.getElementById('regMobileInput');
    const regPasswordInput = document.getElementById('regPasswordInput');
    const regPasswordConfirmInput = document.getElementById('regPasswordConfirmInput');
    const displayRegEmail = document.getElementById('displayRegEmail');
    
    const forgotEmailInput = document.getElementById('forgotEmailInput');
    const newPasswordInput = document.getElementById('newPasswordInput');
    const displayEmailNumber = document.getElementById('displayEmailNumber');
    
    // Links / Buttons
    const forgotPasswordLink = document.getElementById('forgotPasswordLink');
    const backToLoginBtn = document.getElementById('backToLoginBtn');
    const switchToRegisterTabBtn = document.getElementById('switchToRegisterTabBtn');
    const switchToLoginTabBtn = document.getElementById('switchToLoginTabBtn');
    const backToRegisterBtn = document.getElementById('backToRegisterBtn');
    const resendRegisterOtpBtn = document.getElementById('resendRegisterOtpBtn');
    
    // Errors
    const loginError = document.getElementById('loginError');
    const registerError = document.getElementById('registerError');
    const registerOtpError = document.getElementById('registerOtpError');
    const registerOtpSuccess = document.getElementById('registerOtpSuccess');
    const devRegisterOtpMessage = document.getElementById('devRegisterOtpMessage');
    const forgotError = document.getElementById('forgotError');
    const resetError = document.getElementById('resetError');
    const devOtpMessage = document.getElementById('devOtpMessage');
    
    // Auto-focus OTP inputs (Password reset)
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

    // Auto-focus OTP inputs (Register verification)
    const regOtpInputs = document.querySelectorAll('.reg-otp-input');
    regOtpInputs.forEach((input, index) => {
        input.addEventListener('keyup', (e) => {
            if (e.key >= 0 && e.key <= 9 && index < regOtpInputs.length - 1) {
                regOtpInputs[index + 1].focus();
            } else if (e.key === 'Backspace' && index > 0) {
                regOtpInputs[index - 1].focus();
            }
        });
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const text = (e.clipboardData || window.clipboardData).getData('text').trim();
            if (/^\d{6}$/.test(text)) {
                text.split('').forEach((digit, i) => {
                    if (regOtpInputs[i]) regOtpInputs[i].value = digit;
                });
                regOtpInputs[regOtpInputs.length - 1].focus();
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
        stateRegisterOtp.classList.add('hidden');
        
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
        if (regNameInput) regNameInput.value = '';
        regEmailInput.value = '';
        if (regMobileInput) regMobileInput.value = '';
        regPasswordInput.value = '';
        regPasswordConfirmInput.value = '';
        forgotEmailInput.value = '';
        newPasswordInput.value = '';
        otpInputs.forEach(i => i.value = '');
        regOtpInputs.forEach(i => i.value = '');
        
        // Clear all errors
        loginError.classList.add('hidden');
        registerError.classList.add('hidden');
        registerOtpError.classList.add('hidden');
        registerOtpSuccess.classList.add('hidden');
        devRegisterOtpMessage.classList.add('hidden');
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

    let resendTimerInterval = null;
    function startResendCountdown(seconds = 30) {
        let remaining = seconds;
        const countdownEl = document.getElementById('resendCountdown');
        if (resendRegisterOtpBtn) resendRegisterOtpBtn.disabled = true;
        if (countdownEl) countdownEl.innerText = `(${remaining}s)`;
        
        clearInterval(resendTimerInterval);
        resendTimerInterval = setInterval(() => {
            remaining--;
            if (remaining <= 0) {
                clearInterval(resendTimerInterval);
                if (countdownEl) countdownEl.innerText = '';
                if (resendRegisterOtpBtn) resendRegisterOtpBtn.disabled = false;
            } else {
                if (countdownEl) countdownEl.innerText = `(${remaining}s)`;
            }
        }, 1000);
    }

    if (backToRegisterBtn) {
        backToRegisterBtn.addEventListener('click', function() {
            stateRegisterOtp.classList.add('hidden');
            stateRegister.classList.remove('hidden');
        });
    }

    if (resendRegisterOtpBtn) {
        resendRegisterOtpBtn.addEventListener('click', function() {
            resendRegisterOtpBtn.disabled = true;
            registerOtpError.classList.add('hidden');
            registerOtpSuccess.innerText = 'Sending new code...';
            registerOtpSuccess.classList.remove('hidden');

            fetch('{{ route("patient.register.resend_otp") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    registerOtpSuccess.innerText = data.message || 'New code sent to your email!';
                    if (data.debug_otp) {
                        devRegisterOtpMessage.innerText = 'DEV OTP: ' + data.debug_otp;
                        devRegisterOtpMessage.classList.remove('hidden');
                    }
                    startResendCountdown(30);
                } else {
                    registerOtpSuccess.classList.add('hidden');
                    registerOtpError.innerText = data.message || 'Failed to resend code.';
                    registerOtpError.classList.remove('hidden');
                    resendRegisterOtpBtn.disabled = false;
                }
            })
            .catch(() => {
                registerOtpSuccess.classList.add('hidden');
                registerOtpError.innerText = 'Network error while resending OTP.';
                registerOtpError.classList.remove('hidden');
                resendRegisterOtpBtn.disabled = false;
            });
        });
    }

    // Handle Register Submit
    registerForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        if (regPasswordInput.value !== regPasswordConfirmInput.value) {
            registerError.innerText = "Passwords do not match!";
            registerError.classList.remove('hidden');
            return;
        }

        if (regPasswordInput.value.length < 6) {
            registerError.innerText = "Password must be at least 6 characters long.";
            registerError.classList.remove('hidden');
            return;
        }

        if (!regNameInput.value.trim()) {
            registerError.innerText = "Please enter your Full Name.";
            registerError.classList.remove('hidden');
            return;
        }
        
        const submitBtn = registerForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
        submitBtn.disabled = true;
        registerError.classList.add('hidden');

        fetch('{{ route("patient.register") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ 
                name: regNameInput.value.trim(),
                email: regEmailInput.value.trim(),
                mobile: regMobileInput ? regMobileInput.value.trim() : '',
                password: regPasswordInput.value
            })
        })
        .then(response => response.json())
        .then(data => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;

            if (data.success) {
                if (data.requires_otp) {
                    // Switch to Register OTP view
                    stateRegister.classList.add('hidden');
                    stateRegisterOtp.classList.remove('hidden');
                    if (displayRegEmail) displayRegEmail.innerText = data.email || regEmailInput.value;
                    regOtpInputs.forEach(i => i.value = '');
                    if (regOtpInputs[0]) regOtpInputs[0].focus();
                    if (data.debug_otp) {
                        devRegisterOtpMessage.innerText = 'DEV OTP: ' + data.debug_otp;
                        devRegisterOtpMessage.classList.remove('hidden');
                    } else {
                        devRegisterOtpMessage.classList.add('hidden');
                    }
                    startResendCountdown(30);
                } else {
                    handlePostAuthSuccess(data);
                }
            } else {
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

    // Handle Register OTP Verification Submit
    registerOtpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        let otp = '';
        regOtpInputs.forEach(i => otp += i.value);

        if (otp.length !== 6) {
            registerOtpError.innerText = 'Please enter the complete 6-digit OTP code.';
            registerOtpError.classList.remove('hidden');
            return;
        }

        const submitBtn = document.getElementById('btnVerifyRegisterOtp');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
        submitBtn.disabled = true;
        registerOtpError.classList.add('hidden');

        fetch('{{ route("patient.register.verify_otp") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ otp: otp })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                handlePostAuthSuccess(data);
            } else {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                registerOtpError.innerText = data.message || 'Invalid verification code.';
                registerOtpError.classList.remove('hidden');
            }
        })
        .catch(err => {
            console.error(err);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
            registerOtpError.innerText = 'An error occurred. Please try again.';
            registerOtpError.classList.remove('hidden');
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
