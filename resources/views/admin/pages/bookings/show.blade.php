@extends('admin.layouts.app')

@section('title', 'Booking Details')
@section('header')
<div class="flex items-center">
    <a href="{{ route('admin.bookings.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    Booking #{{ $booking->booking_reference }}
</div>
@endsection

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    
    <!-- Left Column: Details -->
    <div class="lg:col-span-2 space-y-6">
        
        <!-- Booking & Patient Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Patient & Appointment Details</h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Patient Name</p>
                    <p class="font-medium text-gray-800">{{ $booking->patient->name ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Collection Date</p>
                    <p class="font-bold text-gray-900 flex items-center gap-1.5">
                        <i class="far fa-calendar-alt text-teal-600"></i>
                        <span>{{ $booking->booking_date->format('F d, Y') }}</span>
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Scheduled Time Slot Window</p>
                    <div class="inline-flex items-center gap-1.5 font-bold text-xs px-3 py-1.5 rounded-xl bg-amber-50 text-amber-900 border border-amber-200 shadow-xs">
                        <i class="far fa-clock text-amber-600"></i>
                        <span>{{ $booking->display_slot }}</span>
                    </div>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Collection Type</p>
                    <p class="font-medium text-gray-800">{{ $booking->collection_type }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Assigned Field Agent</p>
                    @if($booking->agent)
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 rounded-lg bg-teal-500/10 text-teal-600 dark:text-teal-400 flex items-center justify-center font-bold text-xs">
                                <i class="fas fa-motorcycle"></i>
                            </div>
                            <div>
                                <p class="font-bold text-teal-700 dark:text-teal-400 text-sm">{{ $booking->agent->name }}</p>
                                <p class="text-[11px] text-gray-500">{{ $booking->agent->phone }}</p>
                            </div>
                        </div>
                    @else
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-semibold bg-amber-50 dark:bg-amber-500/10 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-500/20">
                            <i class="fas fa-user-slash text-[10px]"></i> No Agent Assigned Yet
                        </span>
                    @endif
                </div>
                @if($booking->collection_type == 'Home Collection' && $booking->address)
                <div class="md:col-span-2">
                    <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">Collection Address</p>
                    <p class="font-medium text-gray-800 bg-gray-50 p-3 rounded-lg border border-gray-100">
                        {{ $booking->address->full_address }}<br>
                        {{ $booking->address->city }}, {{ $booking->address->state }} {{ $booking->address->pincode }}
                    </p>
                </div>
                @endif
                
                @if($booking->family_member_id && $booking->familyMember)
                <div class="md:col-span-2 mt-2 pt-4 border-t">
                    <p class="text-xs text-indigo-500 uppercase tracking-wider mb-1 font-semibold">Booking for Family Member</p>
                    <p class="font-medium text-gray-800">{{ $booking->familyMember->name }} ({{ $booking->familyMember->relation }}) - {{ $booking->familyMember->gender }}, {{ $booking->familyMember->age }} Yrs</p>
                </div>
                @endif
            </div>
        </div>
        
        <!-- Tests Included -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Tests Included</h3>
            <ul class="space-y-3">
                @foreach($booking->test_details as $test)
                <li class="flex justify-between items-center bg-gray-50 p-3 rounded-lg border border-gray-100">
                    <span class="font-medium text-gray-800">{{ $test['name'] ?? 'Test' }}</span>
                    <span class="text-gray-600 font-semibold">₹{{ isset($test['price']) ? $test['price'] : 0 }}</span>
                </li>
                @endforeach
            </ul>
        </div>
        
    </div>
    
    <!-- Right Column: Status & Payment -->
    <div class="space-y-6">
        
        <!-- Actions / Workflow -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Update Status</h3>
            
            <form action="{{ route('admin.bookings.updateStatus', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Status</label>
                    <select name="status" class="w-full rounded-lg border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm px-4 py-2 border bg-gray-50">
                        @php
                            $statuses = ['Pending', 'Confirmed', 'Sample Collection Scheduled', 'Sample Collected', 'In Process', 'Report Ready', 'Completed', 'Cancelled'];
                        @endphp
                        @foreach($statuses as $status)
                            <option value="{{ $status }}" {{ $booking->status == $status ? 'selected' : '' }}>{{ $status }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl transition-colors shadow-sm">
                    <i class="fas fa-sync-alt mr-2"></i> Update Status
                </button>
            </form>
            
            <div class="mt-4 pt-4 border-t flex gap-2">
                <a href="{{ route('admin.bookings.print', $booking->id) }}" target="_blank" class="w-full flex-1 bg-white border-2 border-slate-200 hover:border-slate-800 hover:bg-slate-800 hover:text-white text-slate-700 font-bold py-2 px-4 rounded-xl transition-all text-center">
                    <i class="fas fa-print mr-2"></i> Print
                </a>
            </div>
        </div>

        <!-- Field Agent Assignment & Collection Status -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-motorcycle text-teal-600"></i> Field Agent / Sample
                </h3>
                @if($booking->agent)
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold
                        {{ $booking->sample_status == 'Delivered to Lab' ? 'bg-purple-100 text-purple-800' :
                          ($booking->sample_status == 'Sample Collected' ? 'bg-emerald-100 text-emerald-800' :
                          ($booking->sample_status == 'Out for Collection' ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800')) }}">
                        <i class="fas fa-circle text-[8px] mr-1.5 animate-pulse"></i>
                        {{ $booking->sample_status ?: 'Assigned' }}
                    </span>
                @else
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-600">
                        Unassigned
                    </span>
                @endif
            </div>

            @if($booking->agent)
                <div class="p-3.5 bg-teal-50/70 rounded-xl border border-teal-100 mb-4 space-y-2">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="font-bold text-teal-950 text-sm flex items-center gap-1.5">
                                <i class="fas fa-user-circle text-teal-600"></i> {{ $booking->agent->name }}
                            </p>
                            <p class="text-xs text-teal-700 mt-0.5">
                                <i class="fas fa-phone-alt text-[10px] mr-1"></i>
                                <a href="tel:{{ $booking->agent->phone }}" class="underline font-semibold">{{ $booking->agent->phone }}</a>
                            </p>
                        </div>
                        @if($booking->agent->vehicle_number)
                            <span class="text-[11px] font-mono font-bold bg-white px-2 py-0.5 rounded border border-teal-200 text-teal-800">
                                {{ $booking->agent->vehicle_number }}
                            </span>
                        @endif
                    </div>

                    @if($booking->sample_notes)
                        <div class="pt-2 border-t border-teal-200/60 text-xs text-teal-900">
                            <span class="font-bold">Agent Notes:</span> {{ $booking->sample_notes }}
                        </div>
                    @endif

                    @if($booking->sample_collected_at)
                        <div class="text-[11px] text-teal-700 flex items-center gap-1">
                            <i class="fas fa-vial text-teal-500"></i> Sample collected: {{ $booking->sample_collected_at->format('M d, Y • h:i A') }}
                        </div>
                    @endif
                </div>

                <!-- Doorstep Money Collection Status in Admin -->
                <div class="p-3 rounded-xl border mb-4 text-xs {{ $booking->payment_status == 'Paid' ? 'bg-emerald-50/60 border-emerald-100 text-emerald-900' : 'bg-amber-50/60 border-amber-100 text-amber-900' }}">
                    <div class="flex items-center justify-between font-bold">
                        <span>Doorstep Collection:</span>
                        @if($booking->payment_status == 'Paid')
                            @if($booking->money_collected_by)
                                <span class="text-emerald-700 font-black">₹{{ $booking->amount }} Collected (Cash)</span>
                            @else
                                <span class="text-emerald-700 font-black">Paid Online</span>
                            @endif
                        @else
                            <span class="text-amber-700 font-black">₹{{ $booking->amount }} Cash Due</span>
                        @endif
                    </div>
                    @if($booking->money_collected_at)
                        <p class="text-[11px] text-emerald-700 mt-1">
                            Collected by {{ $booking->agent->name }} on {{ $booking->money_collected_at->format('M d, h:i A') }}
                        </p>
                    @endif
                </div>
            @else
                <div class="p-3 bg-amber-50 border border-amber-200 rounded-xl mb-4 text-xs text-amber-800 flex items-start gap-2">
                    <i class="fas fa-exclamation-triangle text-amber-600 mt-0.5"></i>
                    <div>
                        <p class="font-bold">No Agent Assigned</p>
                        <p class="text-amber-700 mt-0.5">Assign a phlebotomist below so they can view this client's address, pick up samples, and collect cash.</p>
                    </div>
                </div>
            @endif

            <form action="{{ route('admin.bookings.assign_agent', $booking->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                        {{ $booking->agent ? 'Reassign / Change Agent' : 'Select Field Agent' }}
                    </label>
                    <select name="agent_id" class="w-full rounded-lg border-gray-300 focus:border-teal-500 focus:ring-teal-500 shadow-sm px-3 py-2 text-sm border bg-gray-50">
                        <option value="">-- Unassigned (None) --</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}" {{ (int)$booking->agent_id === (int)$agent->id ? 'selected' : '' }}>
                                {{ $agent->name }} ({{ $agent->phone }}) {{ $agent->city ? '• ' . $agent->city : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-2.5 px-4 rounded-xl transition-colors shadow-sm text-sm flex items-center justify-center gap-2">
                    <i class="fas fa-user-check"></i>
                    {{ $booking->agent ? 'Update Assigned Agent' : 'Assign Agent Now' }}
                </button>
            </form>
        </div>
        
        <!-- Payment Details -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <h3 class="text-lg font-bold text-gray-800 border-b pb-3 mb-4">Payment Summary</h3>
            
            <div class="space-y-3 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-500">Method</span>
                    <span class="font-medium text-gray-800">{{ $booking->payment_method }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">Status</span>
                    <span class="font-medium {{ $booking->payment_status == 'Paid' ? 'text-green-600' : 'text-orange-600' }}">{{ $booking->payment_status }}</span>
                </div>
                <div class="border-t pt-2 flex justify-between items-center">
                    <span class="font-bold text-gray-800">Total Amount</span>
                    <span class="text-xl font-black text-teal-600">₹{{ $booking->amount }}</span>
                </div>
            </div>
        </div>

        <!-- ═══════════════ REPORT MANAGEMENT CARD ═══════════════ -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
            <div class="flex items-center justify-between border-b pb-3 mb-4">
                <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                    <i class="fas fa-file-medical-alt text-emerald-600"></i>
                    Test Report
                </h3>
                @if($booking->report_file_path)
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 border border-emerald-200">
                        <i class="fas fa-check-circle text-xs"></i> Uploaded
                    </span>
                @else
                    <span class="inline-flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 border border-amber-200">
                        <i class="fas fa-clock text-xs"></i> Pending
                    </span>
                @endif
            </div>

            {{-- Current Report Display --}}
            @if($booking->report_file_path)
                <div class="mb-4 p-3.5 rounded-xl bg-emerald-50 border border-emerald-200">
                    <p class="text-xs font-bold text-emerald-800 mb-2 flex items-center gap-1.5">
                        <i class="fas fa-file-pdf"></i> Current Report
                    </p>
                    <div class="flex items-center gap-2 flex-wrap">
                        @if(str_starts_with($booking->report_file_path, 'http'))
                            {{-- External link --}}
                            <a href="{{ $booking->report_file_path }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                <i class="fas fa-external-link-alt"></i> Open Link
                            </a>
                        @else
                            {{-- Stored file --}}
                            <a href="{{ asset('storage/' . $booking->report_file_path) }}" target="_blank"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition">
                                <i class="fas fa-eye"></i> View Report
                            </a>
                            <a href="{{ asset('storage/' . $booking->report_file_path) }}" download
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-white hover:bg-gray-50 border border-emerald-300 text-emerald-800 text-xs font-bold transition">
                                <i class="fas fa-download"></i> Download
                            </a>
                        @endif
                        {{-- Remove report --}}
                        <form method="POST" action="{{ route('admin.bookings.report.delete', $booking->id) }}"
                              onsubmit="return confirm('Remove this report? The customer will no longer see it.')"
                              style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-rose-50 hover:bg-rose-100 border border-rose-200 text-rose-600 text-xs font-bold transition">
                                <i class="fas fa-trash-alt"></i> Remove
                            </button>
                        </form>
                    </div>
                    @if(!str_starts_with($booking->report_file_path, 'http'))
                        <p class="text-[10px] text-emerald-600 mt-2 font-mono truncate">
                            {{ basename($booking->report_file_path) }}
                        </p>
                    @endif
                </div>
                <p class="text-xs font-bold text-gray-600 mb-3">
                    <i class="fas fa-edit text-teal-500 mr-1"></i> Replace / Update Report:
                </p>
            @else
                <p class="text-xs text-gray-500 mb-4">
                    Upload the diagnostic PDF or paste an external report link. The patient will instantly see it in their portal.
                </p>
            @endif

            {{-- Upload / Link Form --}}
            <form action="{{ route('admin.bookings.report.upload', $booking->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="reportForm">
                @csrf

                {{-- Toggle: File vs Link --}}
                <div class="flex gap-2 mb-4" id="reportTypeTabs">
                    <button type="button" data-type="file"
                            class="report-tab flex-1 py-2 rounded-xl text-xs font-bold border transition active-tab
                                   bg-teal-600 text-white border-teal-600"
                            onclick="switchReportTab('file')">
                        <i class="fas fa-upload mr-1"></i> Upload PDF
                    </button>
                    <button type="button" data-type="link"
                            class="report-tab flex-1 py-2 rounded-xl text-xs font-bold border transition
                                   bg-white text-gray-600 border-gray-300 hover:border-teal-400"
                            onclick="switchReportTab('link')">
                        <i class="fas fa-link mr-1"></i> Paste Link
                    </button>
                </div>

                <input type="hidden" name="report_type" id="reportTypeInput" value="file">

                {{-- File Upload Panel --}}
                <div id="filePanel">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Select PDF / Image File</label>
                    <div class="border-2 border-dashed border-gray-300 hover:border-teal-400 rounded-xl p-4 text-center cursor-pointer transition bg-gray-50/60"
                         onclick="document.getElementById('reportFileInput').click()">
                        <i class="fas fa-cloud-upload-alt text-2xl text-teal-500 mb-1"></i>
                        <p class="text-xs font-bold text-gray-600">Click to browse</p>
                        <p class="text-[11px] text-gray-400 mt-0.5">PDF, JPG or PNG • Max 20 MB</p>
                        <p class="text-[11px] text-teal-600 font-semibold mt-1" id="selectedFileName">No file chosen</p>
                    </div>
                    <input type="file" name="report_file" id="reportFileInput" accept=".pdf,.jpg,.jpeg,.png" class="hidden"
                           onchange="document.getElementById('selectedFileName').textContent = this.files[0]?.name || 'No file chosen'">
                </div>

                {{-- Link Panel --}}
                <div id="linkPanel" class="hidden">
                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">Report URL / Drive Link</label>
                    <input type="url" name="report_link" id="reportLinkInput"
                           placeholder="https://drive.google.com/... or any PDF URL"
                           class="w-full px-3.5 py-2.5 rounded-xl border border-gray-300 focus:border-teal-500 focus:ring-2 focus:ring-teal-500/20 text-sm bg-white outline-none transition">
                    <p class="text-[11px] text-gray-400 mt-1.5">
                        <i class="fas fa-info-circle text-teal-500"></i>
                        Paste a Google Drive, Dropbox, or any direct PDF/report link.
                    </p>
                </div>

                @error('report_file')
                    <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror
                @error('report_link')
                    <p class="text-xs text-rose-500 mt-1.5 flex items-center gap-1"><i class="fas fa-exclamation-circle"></i> {{ $message }}</p>
                @enderror

                <button type="submit"
                        class="w-full mt-4 flex justify-center items-center gap-2 py-3 rounded-xl bg-gradient-to-r from-teal-600 to-teal-700 hover:from-teal-500 hover:to-teal-600 text-white text-sm font-bold shadow-sm transition">
                    <i class="fas fa-cloud-upload-alt"></i>
                    {{ $booking->report_file_path ? 'Update Report' : 'Upload Report' }}
                </button>
            </form>

            <p class="text-[11px] text-gray-400 text-center mt-3">
                <i class="fas fa-shield-alt text-teal-500"></i>
                Report will be instantly visible in the patient's portal.
            </p>
        </div>
        {{-- ══════════════════════════════════════════════════════ --}}

    </div>
</div>
@endsection

@section('scripts')
<script>
    function switchReportTab(type) {
        document.getElementById('reportTypeInput').value = type;
        document.getElementById('filePanel').classList.toggle('hidden', type !== 'file');
        document.getElementById('linkPanel').classList.toggle('hidden', type !== 'link');

        document.querySelectorAll('.report-tab').forEach(btn => {
            const isActive = btn.dataset.type === type;
            btn.classList.toggle('bg-teal-600',   isActive);
            btn.classList.toggle('text-white',     isActive);
            btn.classList.toggle('border-teal-600',isActive);
            btn.classList.toggle('bg-white',       !isActive);
            btn.classList.toggle('text-gray-600',  !isActive);
            btn.classList.toggle('border-gray-300',!isActive);
        });
    }
</script>
@endsection

