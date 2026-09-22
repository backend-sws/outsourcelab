@extends('frontend.layouts.app')

@section('title', 'My Notifications — AV Wellcare Diagnostics')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">

            <!-- Success Alert -->
            @if(session('success'))
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                        <i class="fas fa-check-circle text-lg"></i>
                    </div>
                    <div>
                        <p class="font-bold text-sm">{{ session('success') }}</p>
                    </div>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 text-lg font-bold p-1">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            @endif

            <!-- Header Card -->
            <div class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-2xl font-black text-brand-dark">My Notifications</h2>
                        @if($unreadCount > 0)
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-black bg-rose-500 text-white animate-pulse">
                                {{ $unreadCount }} Unread
                            </span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-500 font-medium mt-1">
                        Real-time updates regarding your lab bookings, phlebotomist arrival, test reports, and invoices.
                    </p>
                </div>

                <!-- Mark All As Read Button -->
                <div class="flex items-center gap-2">
                    <form action="{{ route('patient.notifications.markRead') }}" method="POST">
                        @csrf
                        <button type="submit" class="px-4 py-2 rounded-xl bg-teal-50 hover:bg-teal-100 text-teal-700 font-bold text-xs border border-teal-200 transition flex items-center gap-1.5 shadow-xs">
                            <i class="fas fa-check-double"></i>
                            <span>Mark all as read</span>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Filter Tabs -->
            <div class="flex items-center gap-2">
                <a href="{{ route('patient.notifications') }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ !request()->filled('filter') ? 'bg-brand-dark text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    All Alerts
                </a>
                <a href="{{ route('patient.notifications', ['filter' => 'unread']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request()->get('filter') === 'unread' ? 'bg-brand-dark text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    Unread Only
                </a>
                <a href="{{ route('patient.notifications', ['filter' => 'read']) }}" class="px-4 py-2 rounded-xl text-xs font-bold transition {{ request()->get('filter') === 'read' ? 'bg-brand-dark text-white shadow-sm' : 'bg-white text-gray-600 hover:bg-gray-100 border border-gray-200' }}">
                    Read History
                </a>
            </div>

            <!-- Notifications Feed Card -->
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden divide-y divide-gray-100">
                @forelse($notifications as $item)
                    <div class="p-5 flex items-start gap-4 transition hover:bg-gray-50/80 {{ $item->isRead() ? 'opacity-85' : 'bg-teal-50/25 border-l-4 border-l-teal-600' }}">
                        <!-- Icon -->
                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center flex-shrink-0 {{ \App\Models\NotificationLog::eventBadgeClass($item->event) }} shadow-xs">
                            <i class="{{ \App\Models\NotificationLog::eventIcon($item->event) }} text-sm"></i>
                        </div>

                        <!-- Content -->
                        <div class="flex-1 min-w-0">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
                                <h4 class="text-sm font-extrabold text-gray-900 {{ $item->isRead() ? '' : 'text-teal-900' }}">
                                    {{ $item->subject ?: \App\Models\NotificationLog::eventLabel($item->event) }}
                                </h4>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <span class="text-[11px] font-medium text-gray-400">
                                        <i class="far fa-clock mr-1"></i>{{ $item->created_at->diffForHumans() }}
                                    </span>
                                    @if(! $item->isRead())
                                        <form action="{{ route('patient.notifications.markRead', $item->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" title="Mark as read" class="text-teal-600 hover:text-teal-800 text-xs font-bold px-2 py-0.5 rounded bg-teal-100/60 hover:bg-teal-100 transition">
                                                Mark Read
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                                {{ $item->body ?: 'Your diagnostic test update.' }}
                            </p>

                            @if(!empty($item->action_url))
                                <div class="mt-3">
                                    <a href="{{ $item->action_url }}" class="inline-flex items-center gap-1.5 text-xs font-extrabold text-teal-700 hover:text-teal-900 transition underline underline-offset-2">
                                        <span>View Related Details</span>
                                        <i class="fas fa-arrow-right text-[10px]"></i>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 rounded-full bg-teal-50 text-teal-600 mx-auto flex items-center justify-center text-2xl mb-3 shadow-inner">
                            <i class="far fa-bell-slash"></i>
                        </div>
                        <h4 class="font-extrabold text-gray-800 text-base">No notifications found</h4>
                        <p class="text-xs text-gray-400 max-w-sm mx-auto mt-1">
                            You're completely caught up! We will send you updates whenever your bookings or test reports change status.
                        </p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="pt-2">
                    {{ $notifications->links() }}
                </div>
            @endif

        </div>
    </div>
</div>
@endsection
