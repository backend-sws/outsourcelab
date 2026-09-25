@extends('admin.layouts.app')

@section('title', 'Contact Enquiries')
@section('header', 'Contact Enquiries')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider">
                    <th class="px-6 py-4 font-semibold">Date</th>
                    <th class="px-6 py-4 font-semibold">Name</th>
                    <th class="px-6 py-4 font-semibold">Mobile</th>
                    <th class="px-6 py-4 font-semibold">Email</th>
                    <th class="px-6 py-4 font-semibold">Subject</th>
                    <th class="px-6 py-4 font-semibold text-center">Status</th>
                    <th class="px-6 py-4 font-semibold text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                @forelse($enquiries as $enquiry)
                <tr class="hover:bg-gray-50/50 transition-colors {{ $enquiry->status == 'Unread' ? 'bg-indigo-50/30' : '' }}">
                    <td class="px-6 py-4 text-gray-600">{{ $enquiry->created_at->format('M d, Y') }}</td>
                    <td class="px-6 py-4 font-medium {{ $enquiry->status == 'Unread' ? 'text-gray-900 font-bold' : 'text-gray-800' }}">{{ $enquiry->name }}</td>
                    <td class="px-6 py-4 text-gray-600 font-mono text-xs">{{ $enquiry->phone ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600">{{ $enquiry->email ?? '-' }}</td>
                    <td class="px-6 py-4 text-gray-600 max-w-xs">
                        <div class="flex items-center gap-2">
                            <span class="truncate font-medium">{{ $enquiry->subject }}</span>
                            @if($enquiry->prescription_url)
                                <span class="inline-flex items-center gap-1 text-[11px] font-bold px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 border border-teal-200 flex-shrink-0" title="Prescription document attached">
                                    <i class="fas {{ $enquiry->is_pdf ? 'fa-file-pdf text-red-500' : 'fa-file-medical text-teal-600' }}"></i> Slip
                                </span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $enquiry->status == 'Unread' ? 'bg-indigo-100 text-indigo-800' : 'bg-gray-100 text-gray-800' }}">
                            {{ $enquiry->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right space-x-1.5 whitespace-nowrap">
                        @if($enquiry->prescription_url)
                            <a href="{{ asset($enquiry->prescription_url) }}" target="_blank" rel="noopener noreferrer" class="text-teal-700 hover:text-teal-900 bg-teal-50 hover:bg-teal-100 px-2.5 py-1.5 rounded-lg transition-colors inline-flex items-center text-xs font-bold border border-teal-200" title="Open Prescription in New Tab">
                                <i class="fas {{ $enquiry->is_pdf ? 'fa-file-pdf text-red-500' : 'fa-file-medical text-teal-600' }} mr-1"></i> Slip
                            </a>
                        @endif
                        <a href="{{ route('admin.enquiries.show', $enquiry->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 px-3 py-1.5 rounded-lg transition-colors inline-flex items-center text-xs font-bold">
                            <i class="fas fa-eye mr-1.5"></i> View
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="px-6 py-8 text-center text-gray-500">No contact enquiries found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($enquiries->hasPages())
    <div class="p-4 border-t border-gray-100 bg-gray-50/50">
        {{ $enquiries->links() }}
    </div>
    @endif
</div>
@endsection
