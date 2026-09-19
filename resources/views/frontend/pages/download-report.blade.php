<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Download Diagnostic Report | Av Wellcare Diagnostics</title>
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
                Securely access your verified laboratory reports, diagnostic history, and doctor test certificates anytime, anywhere.
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

    <!-- Right Side: Clean Form -->
    <div class="w-full md:w-1/2 flex flex-col justify-center p-6 sm:p-12 lg:p-20 relative min-h-screen bg-white">
        
        <!-- Top Back Link -->
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
            <div class="mb-8">
                <span class="text-[11px] font-bold uppercase tracking-wider text-teal-700 bg-teal-50 px-3 py-1 rounded-md border border-teal-100 inline-block mb-3">
                    Fast Report Access
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight mb-2">Download Report</h2>
                <p class="text-slate-500 text-sm leading-relaxed">
                    Enter your booking reference or medical ID and registered mobile number to fetch your report.
                </p>
            </div>

            <form action="{{ route('home') }}" method="GET" class="space-y-5">
                
                <!-- Booking ID / Medical ID -->
                <div>
                    <label for="booking_ref" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">
                        Booking Reference / Medical ID
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
                            placeholder="e.g. BK-7F9A1B or PAT0032" 
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
                            placeholder="e.g. 9876543210" 
                            required
                        >
                    </div>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full mt-3 flex justify-center items-center gap-2 py-3.5 px-6 rounded-2xl shadow-lg shadow-teal-800/20 text-sm font-bold text-white bg-gradient-to-r from-teal-700 via-teal-800 to-emerald-800 hover:from-teal-800 hover:to-emerald-900 hover:shadow-teal-800/30 active:scale-[0.99] focus:outline-none focus:ring-4 focus:ring-teal-600/30 transition-all cursor-pointer"
                >
                    <span>View & Download Report</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </form>
            
            <!-- Quick Assistance -->
            <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                <a href="{{ route('home') }}#enquiry" class="hover:text-teal-700 transition flex items-center gap-1.5 font-semibold">
                    <i class="fas fa-headset text-teal-600"></i> Need Help with Reports?
                </a>
                <a href="{{ route('lis.login') }}" class="hover:text-teal-700 transition flex items-center gap-1.5 font-semibold">
                    <i class="fas fa-user-shield text-amber-600"></i> Staff LIS Login
                </a>
            </div>
        </div>
    </div>

</body>
</html>
