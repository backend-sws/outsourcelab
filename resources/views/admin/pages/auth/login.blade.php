<!DOCTYPE html>
<html lang="en" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Admin Login - WellCare Studio</title>
    
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
            background: #0a0b1c;
        }
        .glass-panel {
            background: rgba(22, 24, 56, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 20px 50px -10px rgba(0, 0, 0, 0.7);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative overflow-hidden text-slate-100 selection:bg-indigo-500 selection:text-white">

    <!-- Ambient Glowing Backdrops matching screenshot colors -->
    <div class="absolute top-1/4 -left-20 w-96 h-96 bg-purple-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/4 -right-20 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute top-10 right-1/3 w-64 h-64 bg-cyan-500/10 rounded-full blur-2xl pointer-events-none"></div>

    <div class="max-w-md w-full relative z-10">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-indigo-600 via-purple-600 to-cyan-400 text-white text-2xl shadow-xl shadow-indigo-600/30 mb-4 animate-bounce-subtle">
                <i class="fas fa-cubes"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-white tracking-tight">WellCare Admin</h1>
            <p class="text-xs sm:text-sm text-slate-400 mt-1">Diagnostic Laboratory Management Studio</p>
        </div>

        <!-- Glass Login Card -->
        <div class="glass-panel rounded-3xl p-8 relative overflow-hidden">
            <div class="flex items-center justify-between pb-6 mb-6 border-b border-white/[0.06]">
                <div>
                    <h2 class="text-base font-bold text-white">Sign In to Dashboard</h2>
                    <p class="text-xs text-slate-400">Enter authorized admin credentials</p>
                </div>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold tracking-wider uppercase bg-indigo-500/20 text-indigo-400 border border-indigo-500/30">
                    Admin Portal
                </span>
            </div>

            <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
                @csrf
                
                @if($errors->any())
                <div class="bg-rose-500/10 border border-rose-500/30 text-rose-400 p-4 rounded-xl text-xs font-medium flex items-center gap-2">
                    <i class="fas fa-circle-exclamation flex-shrink-0"></i>
                    <span>{{ $errors->first() }}</span>
                </div>
                @endif
                
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-300 mb-1.5">Email Address</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="fas fa-envelope"></i></span>
                        <input type="email" name="email" id="email" value="{{ old('email', 'admin@wellcare.com') }}" class="w-full pl-11 pr-4 py-3 bg-white/[0.04] border border-white/[0.08] rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition text-sm text-white placeholder-slate-500" placeholder="admin@wellcare.com" required autofocus>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-xs font-semibold text-slate-300 mb-1.5">Password</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"><i class="fas fa-lock"></i></span>
                        <input type="password" name="password" id="password" value="password123" class="w-full pl-11 pr-11 py-3 bg-white/[0.04] border border-white/[0.08] rounded-xl focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition text-sm text-white placeholder-slate-500 outline-none" placeholder="••••••••" required>
                        <button type="button" onclick="const p = document.getElementById('password'); const isP = p.type === 'password'; p.type = isP ? 'text' : 'password'; this.querySelector('i').className = isP ? 'far fa-eye-slash text-xs text-slate-400' : 'far fa-eye text-xs text-slate-500';" class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition">
                            <i class="far fa-eye text-xs"></i>
                        </button>
                    </div>
                </div>

                <div class="flex items-center justify-between text-xs">
                    <label class="flex items-center space-x-2 text-slate-400 cursor-pointer">
                        <input id="remember" name="remember" type="checkbox" class="w-4 h-4 rounded border-white/[0.1] bg-white/[0.05] text-indigo-600 focus:ring-0 focus:ring-offset-0">
                        <span>Keep me signed in</span>
                    </label>
                </div>

                <button type="submit" class="w-full flex justify-center items-center gap-2 py-3 px-4 rounded-xl bg-gradient-to-r from-indigo-600 via-indigo-500 to-purple-600 hover:from-indigo-500 hover:to-purple-500 text-white text-sm font-bold shadow-lg shadow-indigo-600/30 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    <span>Access Dashboard</span>
                    <i class="fas fa-arrow-right text-xs"></i>
                </button>
            </form>
        </div>
        
        <div class="text-center mt-6 text-xs text-slate-500">
            &copy; {{ date('Y') }} WellCare Diagnostic Labs. All rights reserved.
        </div>
    </div>

</body>
</html>
