@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50 min-h-screen">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.partials.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
                <div>
                    <h2 class="text-2xl font-extrabold text-brand-dark flex items-center gap-2.5">
                        <span class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-lg shadow-sm border border-indigo-100">
                            <i class="fas fa-ticket-alt"></i>
                        </span>
                        My Coupons & Offers
                    </h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">
                        Use your exclusive welcome discount and promotional coupons during test checkout.
                    </p>
                </div>

                <a href="/" class="inline-flex items-center px-4 py-2 bg-brand-dark hover:bg-brand-secondary text-white text-xs font-bold rounded-xl shadow-sm transition">
                    <i class="fas fa-flask mr-1.5"></i> Browse Tests & Packages
                </a>
            </div>

            <!-- Welcome Coupon Highlight (If present) -->
            @php
                $welcomeRecord = $myCoupons->first(function($pc) {
                    return $pc->coupon && $pc->coupon->coupon_type === 'welcome';
                });
            @endphp

            @if($welcomeRecord && $welcomeRecord->coupon)
                @php
                    $welcomeCoupon = $welcomeRecord->coupon;
                @endphp
                <div class="mb-8 rounded-2xl bg-gradient-to-br from-indigo-600 via-purple-600 to-brand-secondary text-white p-6 sm:p-8 shadow-xl relative overflow-hidden">
                    <div class="absolute -right-10 -bottom-10 w-48 h-48 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
                    <div class="absolute right-6 top-6 text-white/10 text-8xl font-black select-none pointer-events-none">
                        <i class="fas fa-gift"></i>
                    </div>

                    <div class="relative z-10 max-w-xl">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/20 backdrop-blur-md text-[11px] font-black uppercase tracking-wider text-white mb-3">
                            <i class="fas fa-sparkles text-amber-300"></i>
                            <span>First-Time Login Welcome Reward</span>
                        </div>

                        <h3 class="text-2xl sm:text-3xl font-black leading-tight">
                            @if($welcomeCoupon->discount_type === 'percentage')
                                Get {{ $welcomeCoupon->discount_value }}% OFF on Your First Order!
                            @else
                                Flat ₹{{ number_format($welcomeCoupon->discount_value, 2) }} OFF on Your First Order!
                            @endif
                        </h3>
                        <p class="text-white/80 text-xs sm:text-sm mt-2 leading-relaxed">
                            {{ $welcomeCoupon->description ?: 'Thank you for joining Wellcare Diagnostics! Apply your welcome coupon at checkout and save on all health packages and blood tests.' }}
                        </p>

                        <div class="mt-6 flex flex-wrap items-center gap-4">
                            <!-- Coupon Code Pill -->
                            <div class="flex items-center bg-white rounded-xl p-1.5 pl-4 shadow-lg">
                                <span class="font-mono font-black text-brand-dark text-base tracking-widest mr-3">{{ $welcomeCoupon->code }}</span>
                                <button onclick="copyCoupon('{{ $welcomeCoupon->code }}')" class="bg-indigo-600 hover:bg-indigo-700 text-white px-3.5 py-1.5 rounded-lg text-xs font-bold transition flex items-center gap-1.5">
                                    <i class="far fa-copy"></i>
                                    <span>Copy</span>
                                </button>
                            </div>

                            @if($welcomeRecord->is_used)
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                                    <i class="fas fa-check-circle mr-1.5 text-emerald-300"></i> Redeemed on {{ $welcomeRecord->used_at ? $welcomeRecord->used_at->format('d M, Y') : 'previous booking' }}
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1.5 rounded-xl text-xs font-bold bg-emerald-400/20 text-emerald-200 border border-emerald-300/30 backdrop-blur-sm">
                                    <span class="w-2 h-2 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span> Available to Redeem
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Section 1: Assigned Coupons for this Patient -->
            <div class="mb-8">
                <h3 class="text-lg font-black text-brand-dark mb-4 flex items-center gap-2">
                    <i class="fas fa-user-check text-indigo-600"></i>
                    <span>My Available Coupons</span>
                </h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    @forelse($myCoupons as $patientCoupon)
                        @php
                            $c = $patientCoupon->coupon;
                        @endphp
                        @if($c)
                            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow relative flex flex-col justify-between {{ $patientCoupon->is_used ? 'opacity-70 bg-gray-50' : '' }}">
                                <div>
                                    <div class="flex items-start justify-between gap-2 mb-3">
                                        <div>
                                            <span class="font-mono font-black text-sm px-3 py-1 rounded-lg bg-indigo-50 text-indigo-700 border border-indigo-100 tracking-wider">
                                                {{ $c->code }}
                                            </span>
                                            <h4 class="font-bold text-gray-800 text-sm mt-2.5">{{ $c->title }}</h4>
                                        </div>
                                        @if($patientCoupon->is_used)
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gray-200 text-gray-600">
                                                Redeemed
                                            </span>
                                        @else
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                                Active
                                            </span>
                                        @endif
                                    </div>

                                    <p class="text-xs text-gray-500 line-clamp-2">{{ $c->description ?: 'Apply this coupon at checkout to receive discounts on your diagnostic bookings.' }}</p>

                                    <div class="mt-4 pt-3 border-t border-gray-100 text-xs space-y-1">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Discount:</span>
                                            <span class="font-bold text-indigo-600">
                                                {{ $c->discount_type === 'percentage' ? $c->discount_value . '% OFF' : '₹' . number_format($c->discount_value, 2) . ' FLAT OFF' }}
                                            </span>
                                        </div>
                                        @if($c->min_order_amount > 0)
                                            <div class="flex justify-between text-gray-600">
                                                <span>Minimum Order:</span>
                                                <span class="font-bold text-gray-800">₹{{ number_format($c->min_order_amount, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 flex items-center justify-between">
                                    <span class="text-[10px] text-gray-400">
                                        {{ $c->valid_until ? 'Expires ' . $c->valid_until->format('d M, Y') : 'No expiry date' }}
                                    </span>

                                    @if(!$patientCoupon->is_used)
                                        <button onclick="copyCoupon('{{ $c->code }}')" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                            <i class="far fa-copy"></i>
                                            <span>Copy Code</span>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @empty
                        <div class="col-span-2 bg-white rounded-2xl border border-dashed border-gray-300 p-8 text-center">
                            <i class="fas fa-ticket-alt text-3xl text-gray-300 mb-2"></i>
                            <p class="text-sm font-bold text-gray-600">No personal coupons assigned right now.</p>
                            <p class="text-xs text-gray-400 mt-1">Check out our general promotional deals below!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Section 2: Banner & Promotional Offers -->
            @if($publicCoupons->count() > 0)
                <div>
                    <h3 class="text-lg font-black text-brand-dark mb-4 flex items-center gap-2">
                        <i class="fas fa-bullhorn text-amber-500"></i>
                        <span>Promotional & Spend-Based Offers</span>
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($publicCoupons as $pc)
                            <div class="bg-white rounded-2xl border border-gray-200 p-5 shadow-sm hover:shadow-md transition-shadow relative flex flex-col justify-between">
                                <div>
                                    <div class="flex items-start justify-between gap-2 mb-2">
                                        <span class="font-mono font-black text-sm px-3 py-1 rounded-lg bg-amber-50 text-amber-800 border border-amber-200 tracking-wider">
                                            {{ $pc->code }}
                                        </span>
                                        @if($pc->min_order_amount > 0)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">
                                                Above ₹{{ number_format($pc->min_order_amount) }}
                                            </span>
                                        @endif
                                    </div>

                                    <h4 class="font-bold text-gray-800 text-sm mt-2">{{ $pc->title }}</h4>
                                    <p class="text-xs text-gray-500 mt-1">{{ $pc->description ?: ($pc->banner_text ?: 'Available for all registered patients.') }}</p>

                                    <div class="mt-4 pt-3 border-t border-gray-100 text-xs space-y-1">
                                        <div class="flex justify-between text-gray-600">
                                            <span>Offer:</span>
                                            <span class="font-bold text-emerald-600">
                                                {{ $pc->discount_type === 'percentage' ? $pc->discount_value . '% Discount' : '₹' . number_format($pc->discount_value, 2) . ' Flat OFF' }}
                                            </span>
                                        </div>
                                        @if($pc->min_order_amount > 0)
                                            <div class="flex justify-between text-gray-600">
                                                <span>Cart Requirement:</span>
                                                <span class="font-bold text-gray-800">Spend ≥ ₹{{ number_format($pc->min_order_amount, 2) }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-4 pt-3 flex items-center justify-between">
                                    <span class="text-[10px] text-gray-400">
                                        {{ $pc->valid_until ? 'Valid till ' . $pc->valid_until->format('d M, Y') : 'Ongoing offer' }}
                                    </span>
                                    <button onclick="copyCoupon('{{ $pc->code }}')" class="text-xs font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                                        <i class="far fa-copy"></i>
                                        <span>Copy Code</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- How to Redeem Steps -->
            <div class="mt-8 p-6 rounded-2xl bg-white border border-gray-200 shadow-sm">
                <h4 class="text-sm font-extrabold text-brand-dark mb-4 flex items-center gap-2">
                    <i class="fas fa-lightbulb text-amber-400"></i>
                    <span>How to Redeem Your Coupons</span>
                </h4>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-xs">
                    <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="w-6 h-6 rounded-full bg-brand-dark text-white font-bold flex items-center justify-center text-xs mb-2">1</span>
                        <h5 class="font-bold text-gray-800 mb-1">Copy or Select Code</h5>
                        <p class="text-gray-500">Copy your desired coupon code or click it during checkout.</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="w-6 h-6 rounded-full bg-brand-dark text-white font-bold flex items-center justify-center text-xs mb-2">2</span>
                        <h5 class="font-bold text-gray-800 mb-1">Add Tests to Cart</h5>
                        <p class="text-gray-500">Choose required lab tests or health checkup packages.</p>
                    </div>
                    <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="w-6 h-6 rounded-full bg-brand-dark text-white font-bold flex items-center justify-center text-xs mb-2">3</span>
                        <h5 class="font-bold text-gray-800 mb-1">Instant Price Deduction</h5>
                        <p class="text-gray-500">Apply the coupon and the percentage/flat discount will be automatically deducted.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function copyCoupon(code) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(code).then(() => {
                alert('Coupon code ' + code + ' copied to clipboard! You can paste it at checkout.');
            });
        } else {
            prompt('Copy coupon code:', code);
        }
    }
</script>
@endsection
