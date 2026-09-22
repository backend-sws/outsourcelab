@extends('admin.layouts.app')

@section('content')
<div class="space-y-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-teal-500 to-emerald-400 flex items-center justify-center text-white shadow-md shadow-teal-500/20">
                    <i class="fas fa-bell text-lg"></i>
                </div>
                <span>Notification Logs & Multi-Channel Center</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Audit trail of all Email, SMS, and WhatsApp notifications dispatched to customers, field phlebotomists, and admin.</p>
        </div>

        <div class="flex items-center gap-2">
            <button type="button" onclick="document.getElementById('testNotificationModal').classList.remove('hidden')" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold shadow-md shadow-teal-600/20 transition">
                <i class="fas fa-paper-plane"></i>
                <span>Send Test Notification</span>
            </button>
            <button onclick="window.location.reload()" class="inline-flex items-center gap-1.5 px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-slate-200 dark:hover:bg-white/15 text-slate-700 dark:text-white text-xs font-bold transition">
                <i class="fas fa-arrows-rotate"></i>
                <span>Refresh</span>
            </button>
        </div>
    </div>

    <!-- Channel Gateway Status Row -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <!-- Email Gateway Card -->
        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-teal-50 dark:bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center text-lg">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">Email Channel</h4>
                        <span class="text-[11px] text-slate-500 font-mono">{{ $channels['email']['from'] }}</span>
                    </div>
                </div>
                <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                    <i class="fas fa-circle-check text-[9px]"></i> Active
                </span>
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 dark:border-white/5 flex items-center justify-between text-xs text-slate-500">
                <span>Mailer: <strong class="text-slate-700 dark:text-slate-300 font-mono">{{ $channels['email']['mailer'] }}</strong></span>
                <span><strong>{{ number_format($totalEmail) }}</strong> logs</span>
            </div>
        </div>

        <!-- SMS Gateway Card -->
        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-sky-50 dark:bg-sky-500/10 text-sky-600 dark:text-sky-400 flex items-center justify-center text-lg">
                        <i class="fas fa-comment-sms"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">SMS Channel</h4>
                        <span class="text-[11px] text-slate-500">Provider: {{ strtoupper($channels['sms']['provider']) }}</span>
                    </div>
                </div>
                @if($channels['sms']['enabled'] && $channels['sms']['ready'])
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                        <i class="fas fa-circle-check text-[9px]"></i> Ready
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400" title="API credentials ready to activate via .env">
                        <i class="fas fa-plug text-[9px]"></i> Stub / Disabled
                    </span>
                @endif
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 dark:border-white/5 flex items-center justify-between text-xs text-slate-500">
                <span>To activate: <code class="bg-slate-100 dark:bg-white/10 px-1 py-0.5 rounded text-[10px]">SMS_ENABLED=true</code></span>
                <span><strong>{{ number_format($totalSms) }}</strong> logs</span>
            </div>
        </div>

        <!-- WhatsApp Gateway Card -->
        <div class="glass-card rounded-2xl p-5 border border-slate-200/80 dark:border-white/10 relative overflow-hidden">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg">
                        <i class="fab fa-whatsapp"></i>
                    </div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-900 dark:text-white">WhatsApp Channel</h4>
                        <span class="text-[11px] text-slate-500">Provider: {{ ucfirst($channels['whatsapp']['provider']) }}</span>
                    </div>
                </div>
                @if($channels['whatsapp']['enabled'] && $channels['whatsapp']['ready'])
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                        <i class="fas fa-circle-check text-[9px]"></i> Ready
                    </span>
                @else
                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400" title="API credentials ready to activate via .env">
                        <i class="fas fa-plug text-[9px]"></i> Stub / Disabled
                    </span>
                @endif
            </div>
            <div class="mt-3 pt-3 border-t border-slate-100 dark:border-white/5 flex items-center justify-between text-xs text-slate-500">
                <span>To activate: <code class="bg-slate-100 dark:bg-white/10 px-1 py-0.5 rounded text-[10px]">WHATSAPP_ENABLED=true</code></span>
                <span><strong>{{ number_format($totalWhatsapp) }}</strong> logs</span>
            </div>
        </div>
    </div>

    <!-- KPI Metric Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="glass-card rounded-2xl p-4 border border-slate-200/80 dark:border-white/10">
            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400 block mb-1">Total Logs</span>
            <h3 class="text-xl font-black text-slate-900 dark:text-white">{{ number_format($totalLogs) }}</h3>
            <span class="text-[10px] text-slate-400 mt-1 block">All notification events</span>
        </div>

        <div class="glass-card rounded-2xl p-4 border border-slate-200/80 dark:border-white/10">
            <span class="text-[11px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 block mb-1">Delivered / Sent</span>
            <h3 class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ number_format($totalSent) }}</h3>
            <span class="text-[10px] text-slate-400 mt-1 block">Successfully dispatched</span>
        </div>

        <div class="glass-card rounded-2xl p-4 border border-slate-200/80 dark:border-white/10">
            <span class="text-[11px] font-bold uppercase tracking-wider text-amber-500 block mb-1">Skipped (Stubbed)</span>
            <h3 class="text-xl font-black text-amber-500">{{ number_format($totalSkipped) }}</h3>
            <span class="text-[10px] text-slate-400 mt-1 block">Keys pending in .env</span>
        </div>

        <div class="glass-card rounded-2xl p-4 border border-slate-200/80 dark:border-white/10">
            <span class="text-[11px] font-bold uppercase tracking-wider text-rose-500 block mb-1">Failed</span>
            <h3 class="text-xl font-black text-rose-500">{{ number_format($totalFailed) }}</h3>
            <span class="text-[10px] text-slate-400 mt-1 block">Exceptions / Gateway errors</span>
        </div>
    </div>

    <!-- Filter & Search Card -->
    <div class="glass-card rounded-2xl p-4 border border-slate-200/80 dark:border-white/10">
        <form method="GET" action="{{ route('admin.notifications.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3 items-end">
            <!-- Search -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Search</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Recipient, email, phone..." class="w-full pl-8 pr-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 text-slate-800 dark:text-white">
                    <i class="fas fa-search absolute left-2.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>
            </div>

            <!-- Channel Filter -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Channel</label>
                <select name="channel" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 text-slate-800 dark:text-white">
                    <option value="">All Channels</option>
                    <option value="email" {{ request('channel') === 'email' ? 'selected' : '' }}>Email</option>
                    <option value="sms" {{ request('channel') === 'sms' ? 'selected' : '' }}>SMS</option>
                    <option value="whatsapp" {{ request('channel') === 'whatsapp' ? 'selected' : '' }}>WhatsApp</option>
                </select>
            </div>

            <!-- Status Filter -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Status</label>
                <select name="status" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 text-slate-800 dark:text-white">
                    <option value="">All Statuses</option>
                    <option value="sent" {{ request('status') === 'sent' ? 'selected' : '' }}>Sent</option>
                    <option value="skipped" {{ request('status') === 'skipped' ? 'selected' : '' }}>Skipped</option>
                    <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
            </div>

            <!-- Event Filter -->
            <div>
                <label class="block text-[11px] font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1">Event</label>
                <select name="event" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 text-slate-800 dark:text-white">
                    <option value="">All Events</option>
                    @foreach($uniqueEvents as $evt)
                        <option value="{{ $evt }}" {{ request('event') === $evt ? 'selected' : '' }}>
                            {{ \App\Models\NotificationLog::eventLabel($evt) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-2">
                <button type="submit" class="flex-1 px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold transition shadow-sm">
                    <i class="fas fa-filter mr-1"></i> Apply
                </button>
                @if(request()->hasAny(['search', 'channel', 'status', 'event']))
                    <a href="{{ route('admin.notifications.index') }}" class="px-3 py-2 rounded-xl bg-slate-100 dark:bg-white/10 hover:bg-slate-200 text-slate-600 dark:text-slate-300 text-xs font-bold transition" title="Reset Filters">
                        <i class="fas fa-xmark"></i>
                    </a>
                @endif
            </div>
        </form>
    </div>

    <!-- Logs Table -->
    <div class="glass-card rounded-2xl border border-slate-200/80 dark:border-white/10 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead class="bg-slate-50 dark:bg-white/5 border-b border-slate-200/80 dark:border-white/10 text-slate-500 uppercase font-bold text-[10px] tracking-wider">
                    <tr>
                        <th class="py-3 px-4">Channel</th>
                        <th class="py-3 px-4">Event</th>
                        <th class="py-3 px-4">Recipient</th>
                        <th class="py-3 px-4">Contact</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date / Sent</th>
                        <th class="py-3 px-4 text-right">Details</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/5 text-slate-700 dark:text-slate-300">
                    @forelse($logs as $log)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-white/[0.02] transition">
                            <!-- Channel -->
                            <td class="py-3 px-4 font-semibold">
                                @if($log->channel === 'email')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-teal-50 text-teal-700 dark:bg-teal-500/10 dark:text-teal-400">
                                        <i class="fas fa-envelope text-xs"></i> Email
                                    </span>
                                @elseif($log->channel === 'sms')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-sky-50 text-sky-700 dark:bg-sky-500/10 dark:text-sky-400">
                                        <i class="fas fa-comment-sms text-xs"></i> SMS
                                    </span>
                                @elseif($log->channel === 'whatsapp')
                                    <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400">
                                        <i class="fab fa-whatsapp text-xs"></i> WhatsApp
                                    </span>
                                @else
                                    <span class="px-2 py-1 rounded bg-slate-100 dark:bg-white/10 font-mono">{{ $log->channel }}</span>
                                @endif
                            </td>

                            <!-- Event -->
                            <td class="py-3 px-4">
                                <span class="font-bold text-slate-900 dark:text-white block">
                                    {{ \App\Models\NotificationLog::eventLabel($log->event) }}
                                </span>
                                <span class="text-[10px] text-slate-400 font-mono">{{ $log->event }}</span>
                            </td>

                            <!-- Recipient -->
                            <td class="py-3 px-4 font-medium">
                                {{ $log->recipient_name ?: ($log->notifiable?->name ?? 'System') }}
                            </td>

                            <!-- Contact -->
                            <td class="py-3 px-4 font-mono text-[11px]">
                                {{ $log->recipient_contact ?: '—' }}
                            </td>

                            <!-- Status -->
                            <td class="py-3 px-4">
                                @if($log->status === 'sent')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400">
                                        <i class="fas fa-check text-[9px]"></i> Sent
                                    </span>
                                @elseif($log->status === 'skipped')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-amber-100 text-amber-800 dark:bg-amber-500/20 dark:text-amber-400" title="{{ $log->error_message ?? 'Skipped (channel disabled)' }}">
                                        <i class="fas fa-forward text-[9px]"></i> Skipped
                                    </span>
                                @elseif($log->status === 'failed')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-[10px] font-black uppercase tracking-wider bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400" title="{{ $log->error_message }}">
                                        <i class="fas fa-triangle-exclamation text-[9px]"></i> Failed
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 rounded text-[10px] font-mono bg-slate-100">{{ $log->status }}</span>
                                @endif
                            </td>

                            <!-- Timestamp -->
                            <td class="py-3 px-4 text-slate-500 text-[11px] whitespace-nowrap">
                                <div>{{ $log->created_at->format('d M, Y') }}</div>
                                <div class="text-[10px] text-slate-400">{{ $log->created_at->format('h:i A') }}</div>
                            </td>

                            <!-- Details -->
                            <td class="py-3 px-4 text-right">
                                @if($log->error_message)
                                    <button type="button" onclick="alert('Log ID: {{ $log->id }}\n\nError:\n{{ addslashes($log->error_message) }}')" class="p-1.5 rounded-lg text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-500/10 transition" title="View Error">
                                        <i class="fas fa-circle-exclamation text-xs"></i>
                                    </button>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600 text-xs">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-white/5 mx-auto flex items-center justify-center text-slate-400 mb-3 text-xl">
                                    <i class="fas fa-bell-slash"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-600 dark:text-slate-300">No notification logs found</p>
                                <p class="text-xs text-slate-400 mt-1">Notifications dispatched across any channel will automatically appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($logs->hasPages())
            <div class="p-4 border-t border-slate-200/80 dark:border-white/10">
                {{ $logs->links() }}
            </div>
        @endif
    </div>

</div>

<!-- Send Test Notification Modal -->
<div id="testNotificationModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/50 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-white/10 shadow-2xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fas fa-paper-plane text-teal-500"></i>
                <span>Send Test Notification</span>
            </h3>
            <button type="button" onclick="document.getElementById('testNotificationModal').classList.add('hidden')" class="text-slate-400 hover:text-slate-600 dark:hover:text-white">
                <i class="fas fa-xmark"></i>
            </button>
        </div>

        <form method="POST" action="{{ route('admin.notifications.test') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1">Target Channel</label>
                <select name="channel" id="testChannelSelect" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 text-slate-800 dark:text-white" onchange="updateContactPlaceholder(this.value)">
                    <option value="email">Email</option>
                    <option value="sms">SMS</option>
                    <option value="whatsapp">WhatsApp</option>
                </select>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-600 dark:text-slate-300 mb-1" id="contactLabel">Recipient Email</label>
                <input type="text" name="contact" id="testContactInput" required placeholder="admin@avwellcare.com" class="w-full px-3 py-2 text-xs rounded-xl bg-slate-50 dark:bg-white/5 border border-slate-200 dark:border-white/10 focus:outline-none focus:ring-2 focus:ring-teal-500 text-slate-800 dark:text-white">
                <p class="text-[11px] text-slate-400 mt-1" id="contactHint">Enter your email address to receive a sample email.</p>
            </div>

            <div class="pt-2 flex items-center justify-end gap-2">
                <button type="button" onclick="document.getElementById('testNotificationModal').classList.add('hidden')" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-white/10 text-slate-600 dark:text-slate-300 text-xs font-bold hover:bg-slate-200 transition">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 rounded-xl bg-teal-600 hover:bg-teal-500 text-white text-xs font-bold transition shadow-md shadow-teal-600/20">
                    <i class="fas fa-paper-plane mr-1"></i> Send Now
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function updateContactPlaceholder(channel) {
    const label = document.getElementById('contactLabel');
    const input = document.getElementById('testContactInput');
    const hint  = document.getElementById('contactHint');

    if (channel === 'email') {
        label.textContent = 'Recipient Email';
        input.placeholder = 'admin@avwellcare.com';
        input.type = 'email';
        hint.textContent = 'Enter your email address to receive a sample email.';
    } else {
        label.textContent = 'Recipient Phone (with country code)';
        input.placeholder = '+919876543210';
        input.type = 'text';
        hint.textContent = 'Enter mobile number starting with +91 (e.g. +919876543210).';
    }
}
</script>
@endsection
