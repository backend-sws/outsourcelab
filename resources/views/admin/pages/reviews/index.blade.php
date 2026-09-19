@extends('admin.layouts.app')

@section('title', 'Reviews Management')
@section('header', 'Reviews Management')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Author</th>
                    <th class="px-6 py-4 font-semibold">Rating</th>
                    <th class="px-6 py-4 font-semibold w-1/3">Comment</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($reviews as $review)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4 text-gray-600">{{ $review->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 font-medium text-gray-800">{{ $review->author_name }}</td>
                    <td class="px-6 py-4">
                        <div class="flex text-amber-400 text-xs">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star {{ $i <= $review->rating ? 'text-amber-400' : 'text-gray-300' }}"></i>
                            @endfor
                        </div>
                    </td>
                    <td class="px-6 py-4 text-gray-600 italic">"{{ Str::limit($review->comment, 60) }}"</td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $review->status == 'Approved' ? 'bg-green-100 text-green-800' : 
                              ($review->status == 'Rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                            {{ $review->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-2">
                        @if($review->status == 'Pending')
                        <form action="{{ route('admin.reviews.approve', $review->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="text-green-600 hover:text-green-900 bg-green-50 hover:bg-green-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center" title="Approve">
                                <i class="fas fa-check"></i>
                            </button>
                        </form>
                        <form action="{{ route('admin.reviews.reject', $review->id) }}" method="POST" class="inline-block">
                            @csrf
                            <button type="submit" class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-md transition-colors inline-flex items-center" title="Reject">
                                <i class="fas fa-times"></i>
                            </button>
                        </form>
                        @else
                            <span class="text-gray-400 text-xs uppercase">Processed</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">No reviews found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($reviews->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        {{ $reviews->links() }}
    </div>
    @endif
</div>
@endsection
