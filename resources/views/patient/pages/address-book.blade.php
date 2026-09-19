@extends('frontend.layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.layouts.sidebar')

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4 space-y-6">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-2xl font-black text-brand-dark flex items-center gap-2">
                        <i class="fas fa-map-marked-alt text-brand-primary"></i>
                        <span>Saved Address Book</span>
                    </h2>
                    <p class="text-xs text-gray-500 font-medium mt-1">Manage delivery & sample collection addresses for your diagnostic bookings.</p>
                </div>
                <button onclick="window.openAddAddressModal()" class="inline-flex items-center justify-center gap-2 bg-brand-dark hover:bg-teal-800 text-white px-5 py-2.5 rounded-xl font-extrabold text-xs transition shadow-sm hover:shadow-md flex-shrink-0">
                    <i class="fas fa-plus"></i>
                    <span>Add New Address</span>
                </button>
            </div>
            
            <div class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 shadow-sm">
                @if($profile->addresses->isEmpty())
                    <!-- Empty State -->
                    <div class="text-center py-14 px-4 bg-gray-50/60 rounded-2xl border border-dashed border-gray-200">
                        <div class="w-16 h-16 rounded-full bg-teal-50 text-brand-primary flex items-center justify-center text-2xl mx-auto mb-3 shadow-inner">
                            <i class="fas fa-map-marker-alt text-gray-300"></i>
                        </div>
                        <h4 class="text-base font-extrabold text-gray-800 mb-1">No Saved Addresses Found</h4>
                        <p class="text-xs text-gray-500 max-w-md mx-auto mb-5 font-medium">Add your home, office, or village address for easy phlebotomist sample collection during test checkout.</p>
                        <button onclick="window.openAddAddressModal()" class="inline-flex items-center gap-2 px-6 py-2.5 bg-brand-dark hover:bg-teal-800 text-white text-xs font-extrabold rounded-xl shadow-sm transition">
                            <i class="fas fa-plus-circle"></i>
                            <span>Add Your First Address</span>
                        </button>
                    </div>
                @else
                    <div id="addressBookList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($profile->addresses as $address)
                            @php
                                $lowerTitle = strtolower($address->title);
                                $isHome = str_contains($lowerTitle, 'home');
                                $isOffice = str_contains($lowerTitle, 'office');
                                $icon = $isHome ? 'fa-home' : ($isOffice ? 'fa-building' : 'fa-map-pin');
                                $badgeColor = $isHome ? 'bg-teal-50 text-brand-dark border-teal-200' : ($isOffice ? 'bg-blue-50 text-blue-800 border-blue-200' : 'bg-amber-50 text-amber-800 border-amber-200');
                            @endphp
                            <div class="border-2 border-gray-200 hover:border-teal-300 bg-white rounded-2xl p-5 relative transition shadow-sm hover:shadow-md flex flex-col justify-between group">
                                <div>
                                    <div class="flex items-center justify-between gap-2 mb-3">
                                        <span class="border {{ $badgeColor }} text-[10px] font-black px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                                            {{ $address->title ?: 'Home' }}
                                        </span>
                                        <span class="text-[11px] font-mono font-bold text-gray-400">PIN: {{ $address->pincode }}</span>
                                    </div>

                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 rounded-xl bg-teal-50 border border-teal-100 text-brand-dark flex items-center justify-center font-bold text-sm flex-shrink-0 mt-0.5">
                                            <i class="fas {{ $icon }}"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-extrabold text-gray-900 text-sm mb-1">{{ $address->title ?: 'Delivery Address' }}</h4>
                                            <p class="text-xs text-gray-600 font-medium leading-relaxed break-words">{{ $address->full_address }}</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-4 pt-3.5 border-t border-gray-100 flex items-center justify-between text-xs font-extrabold">
                                    <button 
                                        type="button" 
                                        onclick="editAddressItem({{ json_encode($address) }})" 
                                        class="text-gray-500 hover:text-brand-primary transition flex items-center gap-1.5"
                                    >
                                        <i class="far fa-edit"></i>
                                        <span>Edit Details</span>
                                    </button>
                                    <button 
                                        type="button" 
                                        onclick="deleteAddressItem({{ $address->id }})" 
                                        class="text-rose-500 hover:text-rose-700 transition flex items-center gap-1.5"
                                    >
                                        <i class="far fa-trash-alt"></i>
                                        <span>Remove</span>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function editAddressItem(address) {
        if (typeof window.openAddAddressModal === 'function') {
            window.openAddAddressModal({
                id: address.id,
                title: address.title,
                address: address.full_address,
                pincode: address.pincode
            });
        }
    }

    function deleteAddressItem(id) {
        if (!confirm('Are you sure you want to remove this address?')) {
            return;
        }

        fetch(`/patient/address-book/${id}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                window.location.reload();
            } else {
                alert(data.message || 'Error deleting address.');
            }
        })
        .catch(err => {
            alert('A network error occurred. Please try again.');
        });
    }
</script>
@endsection
