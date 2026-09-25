@extends('admin.layouts.app')

@section('title', 'Tests Management')
@section('header', 'Tests Management')

@section('content')
<div class="flex flex-col sm:flex-row sm:items-center justify-between w-full mb-6 gap-3">
    <div>
        <h2 class="text-xl font-bold text-gray-800 dark:text-white">Tests Management</h2>
        <p class="text-xs text-gray-500 mt-0.5">Manage commercial pricing, offers{{ config('pathology.admin_sync_enabled', false) ? ', and synchronize tests with Pathology LIS' : '' }}.</p>
    </div>
    <div class="flex items-center gap-2.5">
        @if(config('pathology.admin_sync_enabled', false))
        <button type="button" id="testSyncBtn" onclick="syncWithLis(this)" class="bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-2">
            <i class="fas fa-rotate text-xs"></i> <span>Sync from LIS</span>
        </button>
        @endif
        <a href="{{ route('admin.tests.create') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold py-2.5 px-4 rounded-xl transition-all shadow-sm flex items-center gap-1.5">
            <i class="fas fa-plus text-xs"></i> <span>Add New Test</span>
        </a>
    </div>
</div>

<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Name & Code</th>
                    <th class="px-6 py-4 font-semibold">Department</th>
                    <th class="px-6 py-4 font-semibold">Parameters</th>
                    <th class="px-6 py-4 font-semibold">Pricing & Offer</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($tests as $test)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 font-medium text-gray-800">
                        <div class="flex items-center gap-2">
                            <span>{{ $test->name }}</span>
                            @if($test->test_code)
                                <span class="bg-slate-100 text-slate-700 font-mono text-[10px] px-1.5 py-0.5 rounded border">{{ $test->test_code }}</span>
                            @endif
                        </div>
                        <div class="flex items-center gap-1.5 mt-1">
                            @if($test->is_featured)
                            <span class="bg-amber-100 text-amber-700 text-[10px] px-2 py-0.5 rounded-full font-bold">FEATURED</span>
                            @endif
                            @if(config('pathology.admin_sync_enabled', false) && $test->lock_pricing)
                            <span class="bg-purple-100 text-purple-700 text-[10px] px-2 py-0.5 rounded-full font-bold" title="Price protected from LIS overwrites">PRICE LOCKED</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 text-xs">{{ $test->category->name ?? 'Uncategorized' }}</td>
                    <td class="px-6 py-4">
                        @php
                            $params = is_array($test->parameters) ? array_filter($test->parameters) : [];
                        @endphp
                        @if(count($params) > 0)
                            <div class="flex flex-wrap gap-1 max-w-xs">
                                @foreach(array_slice($params, 0, 3) as $p)
                                    <span class="bg-teal-50 text-teal-700 border border-teal-200 text-[10px] px-1.5 py-0.5 rounded font-medium">{{ $p }}</span>
                                @endforeach
                                @if(count($params) > 3)
                                    <span class="text-[10px] text-slate-400 font-semibold">+{{ count($params) - 3 }} more</span>
                                @endif
                            </div>
                        @else
                            <span class="text-xs text-slate-400 italic">No parameters</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">₹{{ number_format($test->price, 2) }}</div>
                        @if($test->original_price && $test->original_price > $test->price)
                            <div class="text-[11px] text-gray-400 line-through">MRP: ₹{{ number_format($test->original_price, 2) }}</div>
                        @endif
                        @if(config('pathology.admin_sync_enabled', false) && $test->lis_price)
                            <div class="text-[10px] text-teal-600 font-semibold">LIS Cost: ₹{{ number_format($test->lis_price, 2) }}</div>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $test->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $test->is_active ? 'Active' : 'Disabled' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        <a href="{{ route('admin.tests.edit', $test->id) }}" class="text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.tests.destroy', $test->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this test?');">
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
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No tests found. Add some tests to get started.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($tests->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        {{ $tests->links() }}
    </div>
    @endif
</div>

<script>
    async function syncWithLis(btn) {
        if (!confirm('Fetch latest tests and laboratory specifications from Pathology LIS?')) {
            return;
        }

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

