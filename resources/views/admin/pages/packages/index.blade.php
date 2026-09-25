@extends('admin.layouts.app')

@section('title', 'Packages Management')
@section('header', 'Packages Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between w-full mb-6 gap-3">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Packages Management</h2>
        <p class="text-xs text-gray-500 mt-0.5">Manage health checkup packages, promotional offers{{ config('pathology.admin_sync_enabled', false) ? ', and LIS synchronization' : '' }}.</p>
    </div>
    <div class="flex items-center gap-2.5">
        @if(config('pathology.admin_sync_enabled', false))
        <button type="button" id="pkgSyncBtn" onclick="syncPackagesWithLis(this)" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-2">
            <i class="fas fa-rotate text-xs"></i> <span>Sync from LIS</span>
        </button>
        @endif
        <a href="{{ route('admin.packages.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-1.5">
            <i class="fas fa-plus text-xs"></i> <span>Add New Package</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Image</th>
                    <th class="px-6 py-4 font-semibold">Name & Code</th>
                    <th class="px-6 py-4 font-semibold">Details</th>
                    <th class="px-6 py-4 font-semibold">Pricing & Offer</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($packages as $package)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        @if($package->image)
                        <img src="{{ Storage::url($package->image) }}" class="w-10 h-10 rounded-lg object-cover border border-gray-200">
                        @else
                        <div class="w-10 h-10 rounded-lg bg-gray-100 flex items-center justify-center text-gray-400">
                            <i class="fas fa-image"></i>
                        </div>
                        @endif
                    </td>
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <div class="flex items-center gap-2">
                            <span>{{ $package->name }}</span>
                            @if($package->package_code)
                                <span class="bg-slate-100 text-slate-700 font-mono text-[10px] px-1.5 py-0.5 rounded border">{{ $package->package_code }}</span>
                            @endif
                        </div>
                        
                        <div class="flex items-center gap-1.5 mt-1.5 flex-wrap">
                            @if($package->is_featured)
                            <span class="bg-amber-100 text-amber-700 text-[10px] px-2 py-0.5 rounded-full font-bold">FEATURED</span>
                            @endif
                            @if(config('pathology.admin_sync_enabled', false) && $package->lock_pricing)
                            <span class="bg-purple-100 text-purple-700 text-[10px] px-2 py-0.5 rounded-full font-bold" title="Price protected from LIS overwrites">PRICE LOCKED</span>
                            @endif
                            @if($package->hasDiscount())
                            <span class="bg-emerald-100 text-emerald-800 text-[10px] px-2 py-0.5 rounded-full font-bold">{{ $package->effective_discount_percentage }}% OFF</span>
                            @endif
                            @if($package->type === 'habit')
                                <span class="bg-teal-50 text-teal-700 text-[10px] font-bold px-2 py-0.5 rounded border border-teal-100">HABIT</span>
                            @elseif($package->type === 'femcliffe')
                                <span class="bg-pink-50 text-pink-700 text-[10px] font-bold px-2 py-0.5 rounded border border-pink-100">FEMCLIFFE</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-500 text-xs">
                        @if(($package->total_parameters ?? 0) > 0)
                            <span class="bg-indigo-50 text-indigo-700 px-2.5 py-1 rounded-md border border-indigo-100 font-semibold text-xs">
                                {{ $package->total_parameters }} Parameters
                            </span>
                        @else
                            <span class="text-gray-400 italic">No parameters</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900 text-sm">₹{{ number_format($package->price, 2) }}</div>
                        @if($package->original_price && $package->original_price > $package->price)
                            <div class="text-[11px] text-gray-400 line-through">MRP: ₹{{ number_format($package->original_price, 2) }}</div>
                        @endif
                        @if(config('pathology.admin_sync_enabled', false) && $package->lis_price)
                            <div class="text-[10px] text-teal-600 font-semibold">LIS Cost: ₹{{ number_format($package->lis_price, 2) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $package->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $package->is_active ? 'Active' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.packages.edit', $package->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.packages.destroy', $package->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this package?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No packages found. Add some packages to get started.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($packages->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        {{ $packages->links() }}
    </div>
    @endif
</div>

<script>
    async function syncPackagesWithLis(btn) {
        if (!confirm('Sync packages with Pathology LIS? Existing selling prices will be preserved.')) return;
        
        const originalText = btn.innerHTML;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-xs"></i> <span>Syncing...</span>';

        try {
            const res = await fetch('{{ route("admin.pathology.sync") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ overwrite_pricing: false })
            });

            const data = await res.json();
            if (data.success) {
                alert('🎉 ' + data.message);
                window.location.reload();
            } else {
                alert('❌ ' + (data.message || 'Sync failed.'));
            }
        } catch (err) {
            alert('❌ Network connection error while syncing with LIS.');
        } finally {
            btn.disabled = false;
            btn.innerHTML = originalText;
        }
    }
</script>
@endsection

