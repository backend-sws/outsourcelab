<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LIS Login | Wellcare Diagnostics</title>
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
        </div>

        <!-- Middle Content -->
        <div class="relative z-10 max-w-md mt-16">
            <div class="inline-block border border-brand-secondary/40 text-brand-secondary font-bold text-[10px] sm:text-xs px-3 py-1 rounded-full mb-6 uppercase tracking-widest bg-brand-secondary/10">
                Enterprise Ready
            </div>
            
            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight mb-4">
                Intelligence at the <br>
                <span class="text-brand-secondary">Core of Diagnostics.</span>
            </h1>
            
            <p class="text-gray-700 text-sm lg:text-base leading-relaxed mb-8">
                Securely manage laboratory reports, patient demographics, and partner settlements in one unified cloud ecosystem.
            </p>
        </div>

        <!-- Bottom Footer Info -->
        <div class="relative z-10 flex flex-wrap gap-12 lg:gap-16 border-t border-gray-300/60 pt-8 pb-4">
            <div>
                <h4 class="text-gray-900 font-black text-2xl mb-1">500+</h4>
                <p class="text-gray-600 text-[10px] font-bold uppercase tracking-widest">LABS INTEGRATED</p>
            </div>
            
            <div>
                <h4 class="text-gray-900 font-black text-2xl mb-1">1M+</h4>
                <p class="text-gray-600 text-[10px] font-bold uppercase tracking-widest">REPORTS MONTHLY</p>
            </div>
        </div>
    </div>

    <!-- Right Side: Form / Input (Light Theme) -->
    <div class="w-full md:w-1/2 flex flex-col justify-center p-8 lg:p-20 relative h-full overflow-y-auto">
        
        <!-- Mobile Logo (visible only on small screens) -->
        <div class="md:hidden flex justify-center items-center gap-2 mb-10">
            <img src="{{ asset('logo.png') }}" alt="Logo" class="h-10">
        </div>

        <div class="max-w-md w-full mx-auto">
            <div class="mb-10">
                <h2 class="text-3xl font-extrabold text-gray-900 mb-3">Welcome Back</h2>
                <p class="text-gray-500 text-sm leading-relaxed">
                    Please enter your credentials to access the laboratory dashboard.
                </p>
            </div>

            <form action="#" method="POST" class="space-y-5">
                @csrf
                
                <!-- Identity Input -->
                <div>
                    <label for="identity" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-2">Identity</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="far fa-envelope text-gray-400"></i>
                        </div>
                        <input type="text" id="identity" name="identity" class="block w-full pl-11 pr-4 py-3.5 border-2 border-transparent bg-brand-light/20 rounded-xl focus:ring-0 focus:border-brand-secondary text-gray-900 font-semibold shadow-inner transition outline-none" placeholder="e.g. admin@wellcare.com" required>
                    </div>
                </div>

                <!-- Secret Input -->
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label for="secret" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">Secret</label>
                        <a href="#" class="text-[10px] font-bold text-brand-secondary hover:text-brand-primary transition">Forgot Password?</a>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input type="password" id="secret" name="secret" class="block w-full pl-11 pr-4 py-3.5 border-2 border-transparent bg-brand-light/20 rounded-xl focus:ring-0 focus:border-brand-secondary text-gray-900 font-semibold shadow-inner transition outline-none" placeholder="••••••••" required>
                    </div>
                </div>
                
                <!-- Remember me -->
                <div class="flex items-center pt-1">
                    <input id="remember" name="remember" type="checkbox" class="h-4 w-4 text-brand-secondary focus:ring-brand-secondary border-gray-300 rounded">
                    <label for="remember" class="ml-2 block text-xs font-semibold text-gray-600">
                        Remember my account
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="button" class="w-full flex justify-center items-center py-4 px-4 mt-4 border border-transparent rounded-xl shadow-[0_8px_20px_-6px_rgba(234,179,8,0.5)] text-sm font-bold text-white bg-brand-secondary hover:bg-amber-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-secondary transition">
                    Sign into Dashboard &nbsp;<i class="fas fa-arrow-right"></i>
                </button>
            </form>
            
            <div class="my-6">
                <a href="{{ route('download.report') }}" class="w-full flex justify-center items-center py-3.5 px-4 border-2 border-gray-100 rounded-xl text-xs font-bold text-gray-600 hover:text-brand-dark hover:bg-gray-50 hover:border-gray-200 transition">
                    <i class="far fa-user text-brand-secondary mr-2 text-sm"></i> Patient Login / Download Report
                </a>
            </div>
            
            <div class="mt-8 text-center px-4">
                <p class="text-[10px] text-gray-400 leading-relaxed font-medium">
                    Staff login requires pre-authorized access. Please contact administration for support.
                </p>
            </div>
        </div>

        <div class="absolute top-6 right-6 hidden md:block text-sm font-semibold text-gray-500 hover:text-brand-primary transition">
            <a href="{{ route('home') }}"><i class="fas fa-arrow-left mr-1"></i> Back to Home</a>
        </div>
    </div>

</body>
</html>
