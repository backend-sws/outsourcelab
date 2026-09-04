<!-- Offcanvas Login Modal Overlay -->
<div id="loginModalOverlay" class="fixed inset-0 bg-black/50 z-[100] hidden opacity-0 transition-opacity duration-300"></div>

<!-- Offcanvas Login Modal Panel -->
<div id="loginModalPanel" class="fixed top-0 right-0 h-full w-full sm:w-[400px] bg-white z-[101] transform translate-x-full transition-transform duration-300 shadow-2xl flex flex-col">
    <!-- Header -->
    <div class="flex justify-between items-center p-6 border-b border-gray-100">
        <h3 class="text-xl font-extrabold text-brand-dark">Login / Sign Up</h3>
        <button id="closeLoginModalBtn" class="text-gray-400 hover:text-gray-600 transition">
            <i class="fas fa-times text-xl"></i>
        </button>
    </div>

    <!-- Body: Mobile Number State -->
    <div id="loginStateMobile" class="flex-grow p-6 flex flex-col justify-center bg-gray-50/50">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-brand-light/20 rounded-full flex items-center justify-center mx-auto mb-4 border border-brand-light">
                <i class="fas fa-mobile-alt text-2xl text-brand-secondary"></i>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Welcome to Av Wellcare!</h4>
            <p class="text-sm text-gray-500">Please enter your mobile number to proceed</p>
        </div>
        
        <form id="mobileForm" class="space-y-6">
            <div>
                <label for="mobileInput" class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-2">Mobile Number</label>
                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-bold border-r pr-3 border-gray-200">+91</span>
                    <input type="tel" id="mobileInput" class="w-full pl-16 pr-4 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary transition shadow-sm font-bold text-gray-800 text-lg placeholder-gray-300" placeholder="Enter 10 digit number" maxlength="10" required>
                </div>
            </div>
            <button type="submit" class="w-full bg-brand-dark text-white font-bold py-3.5 px-4 rounded-xl hover:bg-opacity-90 transition shadow-lg flex items-center justify-center">
                <span>Continue</span>
                <i class="fas fa-arrow-right ml-2 text-sm"></i>
            </button>
        </form>
        
        <p class="text-center text-xs text-gray-400 mt-6 mt-auto">
            By proceeding, you agree to our <a href="#" class="text-brand-secondary hover:underline">Terms & Conditions</a> & <a href="#" class="text-brand-secondary hover:underline">Privacy Policy</a>
        </p>
    </div>

    <!-- Body: OTP State (Hidden initially) -->
    <div id="loginStateOtp" class="flex-grow p-6 flex flex-col justify-center bg-gray-50/50 hidden">
        <div class="mb-8">
            <button id="backToMobileBtn" class="text-gray-400 hover:text-brand-secondary transition mb-4 flex items-center text-sm font-bold">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </button>
            <h4 class="text-lg font-bold text-gray-800 mb-2">Verify Mobile Number</h4>
            <p class="text-sm text-gray-500">OTP sent to <span id="displayMobileNumber" class="font-bold text-brand-dark">+91 XXXXX XXXXX</span></p>
        </div>
        
        <form id="otpForm" class="space-y-6">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-wide mb-4 text-center">Enter 4 Digit OTP</label>
                <div class="flex justify-center space-x-4">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                    <input type="text" class="otp-input w-14 h-14 text-center text-2xl font-bold border border-gray-200 rounded-xl focus:ring-2 focus:ring-brand-secondary focus:border-brand-secondary bg-white shadow-sm" maxlength="1">
                </div>
                <p class="text-center text-sm mt-6 text-gray-500">
                    Didn't receive OTP? <button type="button" class="text-brand-secondary font-bold hover:underline" id="resendOtpBtn">Resend in 30s</button>
                </p>
            </div>
            <button type="submit" class="w-full bg-brand-secondary text-white font-bold py-3.5 px-4 rounded-xl hover:bg-opacity-90 transition shadow-lg mt-8 flex items-center justify-center">
                <span>Verify & Login</span>
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
    
    const stateMobile = document.getElementById('loginStateMobile');
    const stateOtp = document.getElementById('loginStateOtp');
    const mobileForm = document.getElementById('mobileForm');
    const otpForm = document.getElementById('otpForm');
    const mobileInput = document.getElementById('mobileInput');
    const displayMobileNumber = document.getElementById('displayMobileNumber');
    const backBtn = document.getElementById('backToMobileBtn');
    
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

    // Global function to open modal (to be called from header)
    window.openLoginModal = function() {
        overlay.classList.remove('hidden');
        // Trigger reflow
        void overlay.offsetWidth;
        overlay.classList.remove('opacity-0');
        panel.classList.remove('translate-x-full');
        
        // Reset states
        stateMobile.classList.remove('hidden');
        stateOtp.classList.add('hidden');
        mobileInput.value = '';
        otpInputs.forEach(i => i.value = '');
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

    // Handle Mobile Submit
    mobileForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const num = mobileInput.value;
        if(num.length === 10) {
            displayMobileNumber.innerText = '+91 ' + num;
            stateMobile.classList.add('hidden');
            stateOtp.classList.remove('hidden');
            otpInputs[0].focus();
        }
    });

    // Back to mobile
    backBtn.addEventListener('click', function() {
        stateOtp.classList.add('hidden');
        stateMobile.classList.remove('hidden');
    });

    // Handle OTP Submit
    otpForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const num = mobileInput.value;
        const submitBtn = otpForm.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verifying...';
        submitBtn.disabled = true;

        fetch('{{ route("patient.login") ?? "/patient/login" }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ mobile: num })
        })
        .then(response => response.json())
        .then(data => {
            if(data.redirect) {
                closeLoginModal();
                window.location.href = data.redirect;
            } else {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
                alert('Verification failed. Please try again.');
            }
        })
        .catch(err => {
            console.error(err);
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
});
</script>
