<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — WellCare Diagnostics</title>
    @include('partials.favicon')

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50:  '#f0fdfa',
                            100: '#ccfbf1',
                            200: '#99f6e4',
                            400: '#2dd4bf',
                            500: '#14b8a6',
                            600: '#0d9488',
                            700: '#0f766e',
                            800: '#115e59',
                            900: '#134e4a',
                        }
                    },
                    animation: {
                        'float': 'float 6s ease-in-out infinite',
                        'float-delay': 'float 6s ease-in-out 2s infinite',
                        'spin-slow': 'spin 20s linear infinite',
                    },
                    keyframes: {
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-20px)' },
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
            background: #020c0b;
        }
        .glass-panel {
            background: rgba(15, 25, 23, 0.80);
            backdrop-filter: blur(24px);
            -webkit-backdrop-filter: blur(24px);
            border: 1px solid rgba(45, 212, 191, 0.12);
            box-shadow: 0 25px 60px -12px rgba(0, 0, 0, 0.8), inset 0 1px 0 rgba(255,255,255,0.04);
        }
        .input-field {
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(255,255,255,0.08);
            transition: all 0.2s ease;
        }
        .input-field:focus {
            background: rgba(45, 212, 191, 0.06);
            border-color: rgba(45, 212, 191, 0.45);
            box-shadow: 0 0 0 3px rgba(45, 212, 191, 0.10);
        }
        .btn-teal {
            background: linear-gradient(135deg, #0d9488 0%, #0f766e 50%, #115e59 100%);
            box-shadow: 0 8px 30px -6px rgba(13,148,136,0.55);
            transition: all 0.2s ease;
        }
        .btn-teal:hover {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 50%, #0f766e 100%);
            box-shadow: 0 12px 35px -6px rgba(13,148,136,0.70);
            transform: translateY(-1px);
        }
        .btn-teal:active { transform: scale(0.98); }

        /* Animated grid pattern */
        .grid-bg {
            background-image:
                linear-gradient(rgba(45,212,191,0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(45,212,191,0.04) 1px, transparent 1px);
            background-size: 50px 50px;
        }
        /* Floating orb animations */
        @keyframes float {
            0%, 100% { transform: translateY(0px) scale(1); }
            50% { transform: translateY(-30px) scale(1.05); }
        }
        @keyframes float2 {
            0%, 100% { transform: translateY(0px) scale(1) rotate(0deg); }
            50% { transform: translateY(-20px) scale(1.03) rotate(5deg); }
        }
        .orb1 { animation: float 8s ease-in-out infinite; }
        .orb2 { animation: float2 10s ease-in-out 1.5s infinite; }
        .orb3 { animation: float 12s ease-in-out 3s infinite; }

        /* Logo pulse */
        @keyframes logo-glow {
            0%, 100% { box-shadow: 0 0 20px rgba(13,148,136,0.4), 0 0 40px rgba(13,148,136,0.2); }
            50% { box-shadow: 0 0 30px rgba(13,148,136,0.7), 0 0 60px rgba(13,148,136,0.3); }
        }
        .logo-icon { animation: logo-glow 3s ease-in-out infinite; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-slate-100 grid-bg selection:bg-teal-500 selection:text-white">

    <!-- Ambient Orbs -->
    <div class="orb1 absolute top-[-80px] left-[-80px] w-[420px] h-[420px] bg-teal-600/10 rounded-full blur-3xl pointer-events-none"></div>
    <div class="orb2 absolute bottom-[-100px] right-[-60px] w-[380px] h-[380px] bg-teal-800/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="orb3 absolute top-1/2 right-1/4 w-[220px] h-[220px] bg-emerald-600/8 rounded-full blur-2xl pointer-events-none"></div>

    <div class="max-w-[420px] w-full relative z-10">

        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="logo-icon inline-flex items-center justify-center w-[68px] h-[68px] rounded-[20px] bg-gradient-to-br from-teal-500 via-teal-600 to-emerald-700 text-white text-2xl mb-5">
                <i class="fas fa-flask-vial"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">WellCare Admin</h1>
            <p class="text-xs sm:text-sm text-teal-400/80 mt-1.5 font-medium">Diagnostic Laboratory Management Studio</p>

            <div class="flex items-center justify-center gap-2 mt-3">
                <span class="h-px w-12 bg-teal-800/60"></span>
                <span class="text-[10px] font-bold uppercase tracking-widest text-teal-600 px-2">Secure Access</span>
                <span class="h-px w-12 bg-teal-800/60"></span>
            </div>
        </div>

        <!-- Glass Login Card -->
        <div class="glass-panel rounded-[28px] p-8 relative overflow-hidden">

            <!-- Top badge -->
            <div class="flex items-center justify-between pb-5 mb-6 border-b border-white/[0.06]">
                <div>
                    <h2 class="text-base font-bold text-white">Sign In to Dashboard</h2>
                    <p class="text-xs text-slate-400 mt-0.5">Enter your administrator credentials</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-teal-500/15 text-teal-400 border border-teal-500/25">
                    <i class="fas fa-shield-halved mr-1"></i>Admin
                </span>
            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5" autocomplete="off">
                @csrf

                <!-- Error Display -->
                @if($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-3.5 rounded-xl text-xs font-medium flex items-center gap-2.5">
                    <i class="fas fa-circle-exclamation flex-shrink-0 text-sm"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 mb-2">Email Address</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-teal-500 text-xs">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            autocomplete="new-password"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none"
                            placeholder="Enter admin email address"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password Field -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 mb-2">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-teal-500 text-xs">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="new-password"
                            class="input-field w-full pl-11 pr-11 py-3 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" onclick="togglePassword()" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-500 hover:text-teal-400 transition-colors text-xs focus:outline-none">
                            <i id="passwordEyeIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-400 cursor-pointer group">
                        <div class="relative">
                            <input id="remember" name="remember" type="checkbox" class="peer sr-only">
                            <div class="w-4 h-4 rounded border border-white/15 bg-white/[0.04] peer-checked:bg-teal-600 peer-checked:border-teal-600 transition-all flex items-center justify-center">
                                <i class="fas fa-check text-[8px] text-white opacity-0 peer-checked:opacity-100 transition-opacity"></i>
                            </div>
                        </div>
                        <span class="group-hover:text-slate-300 transition-colors">Keep me signed in</span>
                    </label>
                    <span class="text-teal-500/70 text-[10px] flex items-center gap-1">
                        <i class="fas fa-shield-alt"></i> SSL Secured
                    </span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-teal w-full flex justify-center items-center gap-2.5 py-3.5 px-4 rounded-xl text-white text-sm font-bold">
                    <i class="fas fa-right-to-bracket text-xs"></i>
                    <span>Access Dashboard</span>
                </button>
            </form>

            <!-- Bottom security info -->
            <div class="mt-5 pt-4 border-t border-white/[0.05] flex items-center justify-between text-[11px] text-slate-500">
                <span class="flex items-center gap-1.5">
                    <i class="fas fa-circle text-teal-500 text-[6px] animate-pulse"></i>
                    System Online
                </span>
                <span>WellCare v2.0</span>
            </div>
        </div>

        <div class="text-center mt-6 text-xs text-slate-600">
            &copy; {{ date('Y') }} WellCare Diagnostic Labs. Authorized access only.
        </div>
    </div>

    <script>
        function togglePassword() {
            const pwInput = document.getElementById('password');
            const eyeIcon = document.getElementById('passwordEyeIcon');
            if (pwInput.type === 'password') {
                pwInput.type = 'text';
                eyeIcon.className = 'fas fa-eye-slash';
            } else {
                pwInput.type = 'password';
                eyeIcon.className = 'fas fa-eye';
            }
        }
    </script>
</body>
</html>
