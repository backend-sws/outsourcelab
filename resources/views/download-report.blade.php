<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Report | Wellcare Diagnostics</title>
    @include('partials.style')
</head>
<body class="bg-white text-gray-800 m-0 p-0 font-sans h-screen flex flex-col md:flex-row overflow-hidden">

    <!-- Left Side: Branding / Info (Light Theme) -->
    <div class="hidden md:flex flex-col justify-between w-1/2 p-10 lg:p-16 relative md:rounded-r-[3rem] shadow-2xl overflow-hidden" style="background-color: #C7F0DE;">
        
        <!-- Subtle background glow -->
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden z-0 opacity-20 pointer-events-none">
            <div class="absolute top-[-10%] left-[-10%] w-[50%] h-[50%] bg-brand-primary rounded-full blur-[100px]"></div>
            <div class="absolute bottom-[-10%] right-[-10%] w-[50%] h-[50%] bg-brand-secondary rounded-full blur-[100px]"></div>
        </div>

        <!-- Top Logo -->
        <div class="relative z-10 flex items-center gap-3">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-20 p-1 rounded">
            <!-- <div class="flex items-center">
                <span class="text-white font-extrabold text-xl tracking-tight leading-tight">Wellcare</span>
                <span class="text-brand-secondary font-extrabold text-xl tracking-tight ml-1 leading-tight">Diagnostics</span>
            </div> -->
        </div>

        <!-- Middle Content -->
        <div class="relative z-10 max-w-md mt-16">
            <div class="inline-block border border-brand-secondary/40 text-brand-secondary font-bold text-[10px] sm:text-xs px-3 py-1 rounded-full mb-6 uppercase tracking-widest bg-brand-secondary/10">
                Patient Portal
            </div>
            
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                Your Health Records, <br>
                <span class="text-brand-secondary">Instantly.</span>
            </h1>
            
            <p class="text-gray-700 text-sm lg:text-base leading-relaxed mb-8">
                Securely access your laboratory reports, track your diagnostic history, and stay connected with your healthcare providers.
            </p>
        </div>

        <!-- Bottom Footer Info -->
        <div class="relative z-10 flex flex-wrap gap-6 lg:gap-10 border-t border-gray-300/60 pt-8 pb-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-shield-alt text-brand-secondary mt-1"></i>
                <div>
                    <h4 class="text-gray-900 font-bold text-sm">Fully Secure</h4>
                    <p class="text-gray-600 text-xs font-semibold tracking-wider">256-BIT ENCRYPTED</p>
                </div>
            </div>
            
            <div class="flex items-start gap-3">
                <i class="fas fa-bolt text-brand-secondary mt-1"></i>
                <div>
                    <h4 class="text-gray-900 font-bold text-sm">Instant Access</h4>
                    <p class="text-gray-600 text-xs font-semibold tracking-wider">ZERO WAIT TIME</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Form / Input (Light Theme) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center p-8 lg:p-20 relative h-full overflow-y-auto">
        
        <!-- Mobile Logo (visible only on small screens) -->
        <div class="md:hidden flex justify-center items-center gap-2 mb-10">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-16">
            <!-- <div class="flex items-center">
                <span class="text-brand-primary font-extrabold text-xl tracking-tight leading-tight">Wellcare</span>
                <span class="text-brand-secondary font-extrabold text-xl tracking-tight ml-1 leading-tight">Diagnostics</span>
            </div> -->
        </div>

        <div class="max-w-md w-full mx-auto">
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Access Reports</h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Please enter your medical ID and registered mobile number to securely download your reports.
                </p>
            </div>

            <form action="#" method="POST" class="space-y-6">
                @csrf
                
                <!-- Medical ID Input -->
                <div>
                    <label for="medical_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Medical ID</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="far fa-user text-gray-400"></i>
                        </div>
                        <input type="text" id="medical_id" name="medical_id" class="block w-full pl-11 pr-4 py-3.5 border-2 border-brand-secondary/40 rounded-xl focus:ring-0 focus:border-brand-secondary bg-white text-gray-900 font-semibold shadow-sm transition outline-none" placeholder="e.g. PAT0032" required>
                    </div>
                </div>

                <!-- Mobile Number Input -->
                <div>
                    <label for="mobile_number" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Registered Mobile Number</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-phone-alt text-gray-400"></i>
                        </div>
                        <input type="tel" id="mobile_number" name="mobile_number" class="block w-full pl-11 pr-4 py-3.5 border-2 border-gray-200 rounded-xl focus:ring-0 focus:border-gray-400 hover:border-gray-300 bg-white text-gray-900 font-semibold shadow-sm transition outline-none" placeholder="Enter 10-digit number" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="button" class="w-full flex justify-center items-center py-4 px-4 border border-transparent rounded-xl shadow-md text-sm font-bold text-white bg-brand-secondary hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-secondary transition">
                    View My Reports &nbsp;<i class="fas fa-arrow-right"></i>
                </button>
            </form>
            
            <div class="mt-8 text-center text-sm font-semibold text-gray-500 hover:text-brand-primary transition">
                <a href="{{ route('home') }}"><i class="fas fa-arrow-left mr-1"></i> Back to Home</a>
            </div>
        </div>

        <!-- Right Side Footer -->
        <div class="absolute bottom-4 left-4 right-4 md:bottom-8 md:left-8 md:right-8 lg:left-20 lg:right-20 flex justify-between items-center text-[10px] sm:text-xs font-bold text-gray-400">
            <a href="#" class="hover:text-gray-600 transition flex items-center gap-1.5"><i class="fas fa-headset text-sm sm:text-lg"></i> Help Desk</a>
            <div class="flex items-center gap-1.5 text-emerald-600"><i class="fas fa-lock"></i> Secure</div>
        </div>

    </div>

</body>
</html>
