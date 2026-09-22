<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — AV Wellcare Diagnostics</title>
    @include('partials.favicon')

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
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
        * { font-family: 'Plus Jakarta Sans', 'Inter', sans-serif; }

        body {
            background: linear-gradient(135deg, #f0fdfa 0%, #e6f7f5 40%, #f8fafc 100%);
            min-height: 100vh;
        }

        /* Decorative pattern */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(13,148,136,0.05) 1px, transparent 1px),
                linear-gradient(90deg, rgba(13,148,136,0.05) 1px, transparent 1px);
            background-size: 48px 48px;
            pointer-events: none;
        }

        .login-card {
            background: #ffffff;
            border: 1px solid rgba(13,148,136,0.15);
            box-shadow:
                0 4px 6px -1px rgba(0,0,0,0.05),
                0 20px 60px -12px rgba(13,148,136,0.15),
                0 0 0 1px rgba(255,255,255,0.8) inset;
        }

        .input-field {
            background: #f8fffe;
            border: 1.5px solid #d1faf4;
            color: #0f172a;
            transition: all 0.2s ease;
        }
        .input-field:focus {
            background: #ffffff;
            border-color: #0d9488;
            box-shadow: 0 0 0 3px rgba(13,148,136,0.12);
            outline: none;
        }
        .input-field::placeholder { color: #94a3b8; }

        .btn-primary {
            background: linear-gradient(135deg, #0d9488, #0f766e);
            box-shadow: 0 6px 20px -4px rgba(13,148,136,0.45);
            transition: all 0.2s ease;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #14b8a6, #0d9488);
            box-shadow: 0 10px 28px -4px rgba(13,148,136,0.55);
            transform: translateY(-1px);
        }
        .btn-primary:active { transform: scale(0.98); }

        /* Orb decorations */
        @keyframes float { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-20px)} }
        .orb { animation: float 8s ease-in-out infinite; }
        .orb2 { animation: float 11s ease-in-out 2s infinite; }

        .divider-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(to right, transparent, #d1faf4, transparent);
        }

        .right-panel {
            background: linear-gradient(160deg, #0d9488 0%, #0f766e 60%, #134e4a 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden selection:bg-teal-500 selection:text-white">

    <!-- Decorative orbs -->
    <div class="orb  absolute top-[-60px] right-[-60px] w-[320px] h-[320px] bg-teal-200/40 rounded-full blur-3xl pointer-events-none"></div>
    <div class="orb2 absolute bottom-[-80px] left-[-40px] w-[280px] h-[280px] bg-amber-100/50 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Login Container -->
    <div class="w-full max-w-4xl relative z-10 flex rounded-3xl overflow-hidden login-card">

        <!-- ── Left: Form Panel ── -->
        <div class="flex-1 p-10 flex flex-col justify-center">

            <!-- Logo -->
            <div class="mb-8">
                <img src="{{ asset('logo.png') }}" alt="AV Wellcare Diagnostics" class="h-12 w-auto object-contain">
                <div class="flex items-center gap-2 mt-3">
                    <div class="divider-line"></div>
                    <span class="text-[11px] font-bold uppercase tracking-widest text-teal-600 whitespace-nowrap px-1">Admin Portal</span>
                    <div class="divider-line"></div>
                </div>
            </div>

            <!-- Heading -->
            <div class="mb-7">
                <h1 class="text-2xl font-extrabold text-slate-800 tracking-tight">Welcome back 👋</h1>
                <p class="text-sm text-slate-400 mt-1">Sign in to the management dashboard</p>
            </div>

            <!-- Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5" autocomplete="off">
                @csrf

                @if($errors->any())
                <div class="bg-rose-50 border border-rose-200 text-rose-600 p-3.5 rounded-xl text-xs font-medium flex items-center gap-2.5">
                    <i class="fas fa-circle-exclamation flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif

                <!-- Email -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-teal-500 text-xs pointer-events-none">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            value="{{ old('email') }}"
                            autocomplete="new-password"
                            class="input-field w-full pl-11 pr-4 py-3 rounded-xl text-sm"
                            placeholder="Enter your admin email"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-teal-500 text-xs pointer-events-none">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            autocomplete="new-password"
                            class="input-field w-full pl-11 pr-11 py-3 rounded-xl text-sm"
                            placeholder="••••••••"
                            required
                        >
                        <button type="button" id="togglePwBtn" class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-teal-600 transition-colors focus:outline-none">
                            <i class="fas fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember -->
                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center gap-2 text-slate-500 cursor-pointer group">
                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded border-slate-300 accent-teal-600 focus:ring-0">
                        <span class="group-hover:text-slate-700 transition-colors">Keep me signed in</span>
                    </label>
                    <span class="text-teal-600 text-[10px] flex items-center gap-1 font-semibold">
                        <i class="fas fa-shield-alt"></i> SSL Secured
                    </span>
                </div>

                <!-- Submit -->
                <button type="submit" class="btn-primary w-full flex justify-center items-center gap-2.5 py-3.5 px-4 rounded-xl text-white text-sm font-bold">
                    <i class="fas fa-right-to-bracket text-xs"></i>
                    <span>Access Dashboard</span>
                </button>
            </form>

            <p class="text-center text-xs text-slate-400 mt-6">
                &copy; {{ date('Y') }} AV Wellcare Diagnostics. Authorized access only.
            </p>
        </div>

        <!-- ── Right: Decorative Panel ── -->
        <div class="hidden md:flex right-panel w-[340px] flex-col items-center justify-center p-10 relative overflow-hidden">
            <!-- Decorative circles -->
            <div class="absolute top-[-60px] right-[-60px] w-48 h-48 bg-white/8 rounded-full"></div>
            <div class="absolute bottom-[-40px] left-[-40px] w-36 h-36 bg-white/6 rounded-full"></div>
            <div class="absolute top-1/2 right-[-30px] w-24 h-24 bg-white/5 rounded-full"></div>

            <!-- Content -->
            <div class="relative z-10 text-center text-white">
                <div class="w-20 h-20 bg-white/15 rounded-3xl flex items-center justify-center mb-6 mx-auto border border-white/20 backdrop-blur-sm">
                    <i class="fas fa-flask-vial text-3xl text-white"></i>
                </div>
                <h2 class="text-xl font-extrabold mb-2 tracking-tight">Diagnostic Lab Studio</h2>
                <p class="text-sm text-teal-100/80 leading-relaxed mb-8">
                    Manage bookings, tests, patients and operations from one powerful dashboard.
                </p>

                <div class="space-y-3 text-left">
                    <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3 border border-white/15">
                        <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-calendar-check text-sm text-amber-300"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">Live Bookings</div>
                            <div class="text-[11px] text-teal-200/70">Real-time appointment management</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3 border border-white/15">
                        <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-file-medical text-sm text-teal-200"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">Test & Package Catalog</div>
                            <div class="text-[11px] text-teal-200/70">Manage all diagnostic offerings</div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 bg-white/10 rounded-xl px-4 py-3 border border-white/15">
                        <div class="w-8 h-8 bg-white/15 rounded-lg flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-shield-halved text-sm text-green-300"></i>
                        </div>
                        <div>
                            <div class="text-xs font-bold text-white">HIPAA Compliant</div>
                            <div class="text-[11px] text-teal-200/70">Secured patient data protection</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const toggleBtn = document.getElementById('togglePwBtn');
        const pwInput   = document.getElementById('password');
        if (toggleBtn) {
            toggleBtn.addEventListener('click', function () {
                const isPass = pwInput.type === 'password';
                pwInput.type = isPass ? 'text' : 'password';
                this.querySelector('i').className = isPass ? 'fas fa-eye-slash text-xs' : 'fas fa-eye text-xs';
            });
        }
    </script>
</body>
</html>
