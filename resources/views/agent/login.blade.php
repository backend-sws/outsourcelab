<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agent Portal Login - WellCare Diagnostics</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-slate-950 text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden selection:bg-teal-500 selection:text-white">
    <!-- Ambient background gradients -->
    <div class="fixed inset-0 pointer-events-none z-0">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-teal-500/10 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-indigo-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-md">
        <!-- Logo & Header -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-tr from-teal-500 to-emerald-400 text-slate-950 text-2xl font-black shadow-xl shadow-teal-500/20 mb-4">
                <i class="fas fa-vial"></i>
            </div>
            <h1 class="text-2xl font-black text-white tracking-tight">WellCare Collector Portal</h1>
            <p class="text-xs text-slate-400 mt-1 font-medium">Field Agent & Phlebotomist Sign In</p>
        </div>

        <!-- Login Card -->
        <div class="bg-slate-900/90 backdrop-blur-xl border border-white/10 rounded-3xl p-6 sm:p-8 shadow-2xl">
            <!-- Flash Errors -->
            @if(session('error'))
                <div class="mb-5 p-3.5 rounded-xl bg-rose-500/10 border border-rose-500/30 text-rose-300 text-xs font-semibold flex items-center gap-2">
                    <i class="fas fa-circle-exclamation text-rose-400 text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            @if(session('success'))
                <div class="mb-5 p-3.5 rounded-xl bg-emerald-500/10 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2">
                    <i class="fas fa-circle-check text-emerald-400 text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('agent.login.submit') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Agent Email Address</label>
                    <div class="relative">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                        <input type="email" name="email" id="agentEmail" required value="{{ old('email', 'ramesh.collector@wellcare.com') }}" class="w-full pl-10 pr-4 py-3 bg-slate-800/80 border border-white/10 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/60 focus:border-teal-500 transition" placeholder="agent@wellcare.com">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-400 mb-1.5">Password</label>
                    <div class="relative">
                        <i class="fas fa-lock absolute left-4 top-1/2 -translate-y-1/2 text-slate-500 text-xs"></i>
                        <input type="password" name="password" id="agentPassword" required value="password123" class="w-full pl-10 pr-4 py-3 bg-slate-800/80 border border-white/10 rounded-xl text-sm text-white placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-teal-500/60 focus:border-teal-500 transition" placeholder="••••••••">
                    </div>
                </div>

                <button type="submit" class="w-full mt-2 py-3 px-4 rounded-xl bg-gradient-to-r from-teal-500 to-emerald-400 hover:from-teal-400 hover:to-emerald-300 text-slate-950 font-black text-sm shadow-lg shadow-teal-500/25 transition-all flex items-center justify-center gap-2">
                    <i class="fas fa-arrow-right-to-bracket"></i>
                    <span>Sign In to Agent Portal</span>
                </button>
            </form>

            @if(isset($agents) && $agents->count())
            <!-- Quick Agent Selector (Convenient for Testing) -->
            <div class="mt-6 pt-5 border-t border-white/10">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider mb-2">Registered Agents:</p>
                <div class="space-y-1.5">
                    @foreach($agents as $ag)
                        <button type="button" onclick="fillCreds('{{ $ag->email }}')" class="w-full text-left p-2 rounded-xl bg-white/[0.04] hover:bg-white/[0.08] border border-white/5 transition flex items-center justify-between text-xs">
                            <span class="font-bold text-slate-200">{{ $ag->name }}</span>
                            <span class="text-[11px] font-mono text-teal-400">{{ $ag->email }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Footer Links -->
        <div class="mt-6 text-center text-xs text-slate-500 space-x-4">
            <a href="{{ route('home') }}" class="hover:text-white transition">
                <i class="fas fa-arrow-left mr-1"></i> Back to Website
            </a>
            <span>•</span>
            <a href="{{ route('admin.login') }}" class="hover:text-white transition">
                <i class="fas fa-shield-alt mr-1"></i> Admin Login
            </a>
        </div>
    </div>

    <script>
        function fillCreds(email) {
            document.getElementById('agentEmail').value = email;
            document.getElementById('agentPassword').focus();
        }
    </script>
</body>
</html>
