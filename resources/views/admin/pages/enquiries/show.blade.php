@extends('admin.layouts.app')

@section('title', 'Enquiry Details')
@section('header')
<div class="flex items-center">
    <a href="{{ route('admin.enquiries.index') }}" class="text-indigo-600 hover:text-indigo-800 mr-4">
        <i class="fas fa-arrow-left"></i>
    </a>
    Enquiry Details
</div>
@endsection

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        
        <!-- Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 pb-6 border-b border-gray-100 gap-4">
            <div>
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <h2 class="text-2xl font-bold text-gray-900">{{ $enquiry->subject }}</h2>
                    @if($enquiry->prescription_url)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-teal-50 text-teal-700 border border-teal-200">
                            <i class="fas {{ $enquiry->is_pdf ? 'fa-file-pdf text-red-500' : 'fa-file-medical text-teal-600' }}"></i>
                            Prescription Attached
                        </span>
                    @endif
                </div>
                <p class="text-sm text-gray-500">Received on {{ $enquiry->created_at->format('F d, Y h:i A') }} ({{ $enquiry->created_at->diffForHumans() }})</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $enquiry->status == 'Unread' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-800' }}">
                    <i class="fas fa-circle text-[8px] mr-1.5 {{ $enquiry->status == 'Unread' ? 'text-amber-500' : 'text-emerald-500' }}"></i>
                    {{ $enquiry->status }}
                </span>
            </div>
        </div>
        
        <!-- Patient / Sender Info Card -->
        <div class="bg-gray-50/80 rounded-2xl p-5 mb-6 border border-gray-100 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center">
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-br from-indigo-500 to-teal-500 text-white flex items-center justify-center text-xl font-extrabold shadow-sm mr-4 flex-shrink-0">
                    {{ strtoupper(substr($enquiry->name, 0, 1)) }}
                </div>
                <div>
                    <p class="font-extrabold text-gray-900 text-lg leading-tight">{{ $enquiry->name }}</p>
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-1.5 text-sm text-gray-600 mt-1">
                        @if($enquiry->phone)
                            <span class="inline-flex items-center">
                                <i class="fas fa-phone-alt text-xs text-gray-400 mr-1.5"></i>
                                <a href="tel:{{ $enquiry->phone }}" class="text-indigo-600 font-mono font-bold hover:underline">{{ $enquiry->phone }}</a>
                            </span>
                        @endif
                        @if($enquiry->email && !str_starts_with($enquiry->email, 'phone:'))
                            <span class="inline-flex items-center">
                                <i class="fas fa-envelope text-xs text-gray-400 mr-1.5"></i>
                                <a href="mailto:{{ $enquiry->email }}" class="text-indigo-600 hover:underline">{{ $enquiry->email }}</a>
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Communication Badges -->
            <div class="flex items-center gap-2">
                @if($enquiry->phone)
                    <a href="tel:{{ $enquiry->phone }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-emerald-50 text-emerald-700 hover:bg-emerald-100 font-bold text-xs border border-emerald-200 transition">
                        <i class="fas fa-phone"></i> Call
                    </a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $enquiry->phone) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-teal-50 text-teal-700 hover:bg-teal-100 font-bold text-xs border border-teal-200 transition">
                        <i class="fab fa-whatsapp"></i> WhatsApp
                    </a>
                @endif
            </div>
        </div>
        
        <!-- Prescription Attachment Section (if available) -->
        @if($enquiry->prescription_url)
            <div class="mb-8 rounded-2xl border-2 border-teal-100 bg-gradient-to-b from-teal-50/40 to-white overflow-hidden shadow-sm">
                <!-- Attachment Header Bar -->
                <div class="px-5 py-4 bg-teal-50/80 border-b border-teal-100 flex flex-wrap items-center justify-between gap-3">
                    <div class="flex items-center gap-2.5">
                        <div class="w-8 h-8 rounded-lg bg-teal-600 text-white flex items-center justify-center text-sm shadow-xs">
                            <i class="fas {{ $enquiry->is_pdf ? 'fa-file-pdf' : 'fa-file-medical' }}"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-teal-950 text-sm">Uploaded Doctor Prescription</h3>
                            <p class="text-xs text-teal-700 font-mono truncate max-w-xs md:max-w-md">{{ $enquiry->attachment_filename }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ asset($enquiry->prescription_url) }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition shadow-xs">
                            <i class="fas fa-external-link-alt"></i> Open Full View
                        </a>
                        <a href="{{ asset($enquiry->prescription_url) }}" download="{{ $enquiry->attachment_filename }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-gray-800 hover:bg-gray-900 text-white text-xs font-bold transition shadow-xs">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>

                <!-- Attachment Preview Body -->
                <div class="p-6">
                    @if($enquiry->is_image)
                        <!-- Image Preview -->
                        <div class="relative group max-w-2xl mx-auto rounded-2xl overflow-hidden bg-slate-900/5 border border-gray-200/80 p-2 text-center shadow-inner">
                            <img id="prescriptionImageEl" 
                                 src="{{ asset($enquiry->prescription_url) }}" 
                                 alt="Doctor Prescription Slip" 
                                 class="max-h-[480px] w-auto mx-auto rounded-xl object-contain shadow-xs cursor-zoom-in transition duration-300 hover:brightness-105"
                                 onclick="openPrescriptionLightbox('{{ asset($enquiry->prescription_url) }}')">
                            
                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-slate-900/30 opacity-0 group-hover:opacity-100 transition flex items-center justify-center pointer-events-none rounded-2xl">
                                <span class="px-4 py-2 rounded-xl bg-white/95 text-gray-800 text-xs font-bold shadow-lg flex items-center gap-2">
                                    <i class="fas fa-search-plus text-teal-600"></i> Click to Zoom / Fullscreen
                                </span>
                            </div>
                        </div>
                        <p class="text-center text-xs text-gray-500 mt-2.5 flex items-center justify-center gap-1.5">
                            <i class="fas fa-info-circle text-teal-600"></i> Tip: Click on prescription image to zoom in, rotate, and read doctor notes clearly.
                        </p>
                    @elseif($enquiry->is_pdf)
                        <!-- PDF Embed -->
                        <div class="rounded-xl overflow-hidden border border-gray-200 bg-white">
                            <iframe src="{{ asset($enquiry->prescription_url) }}" class="w-full h-[520px] rounded-xl" frameborder="0"></iframe>
                        </div>
                    @else
                        <!-- Generic File Download -->
                        <div class="text-center py-8">
                            <i class="fas fa-file-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-sm font-semibold text-gray-700">Document available for download</p>
                            <a href="{{ asset($enquiry->prescription_url) }}" target="_blank" class="mt-3 inline-flex items-center gap-2 px-4 py-2 bg-teal-600 text-white rounded-xl text-xs font-bold">
                                <i class="fas fa-download"></i> View / Download Document
                            </a>
                        </div>
                    @endif

                    <!-- Patient Notes / Description -->
                    @if($enquiry->clean_notes)
                        <div class="mt-6 p-4 rounded-xl bg-amber-50/80 border border-amber-200/90 text-amber-950">
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-amber-800 mb-1.5 flex items-center gap-1.5">
                                <i class="fas fa-comment-medical text-amber-600"></i> Patient Notes / Callback Instructions
                            </h4>
                            <p class="text-sm leading-relaxed font-medium whitespace-pre-line text-amber-900">{{ $enquiry->clean_notes }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @else
            <!-- Standard Message Display (when no attachment) -->
            <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100 text-gray-800 leading-relaxed whitespace-pre-line text-sm">
                {{ $enquiry->message }}
            </div>
        @endif
        
        <!-- Bottom Action Buttons -->
        <div class="mt-8 pt-6 border-t border-gray-100 flex flex-wrap items-center gap-3">
            @if($enquiry->phone)
                <a href="tel:{{ $enquiry->phone }}" class="px-5 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center">
                    <i class="fas fa-phone mr-2"></i> Call Patient
                </a>
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $enquiry->phone) }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-teal-600 hover:bg-teal-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center">
                    <i class="fab fa-whatsapp mr-2"></i> WhatsApp
                </a>
            @endif
            @if($enquiry->prescription_url)
                <a href="{{ asset($enquiry->prescription_url) }}" target="_blank" rel="noopener noreferrer" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center">
                    <i class="fas fa-external-link-alt mr-2"></i> View Full Slip
                </a>
                <a href="{{ asset($enquiry->prescription_url) }}" download="{{ $enquiry->attachment_filename }}" class="px-5 py-2.5 bg-gray-800 hover:bg-gray-900 text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center">
                    <i class="fas fa-download mr-2"></i> Download Slip
                </a>
            @endif
            @if($enquiry->email && !str_starts_with($enquiry->email, 'phone:'))
                <a href="mailto:{{ $enquiry->email }}" class="px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-sm font-bold transition-colors shadow-sm inline-flex items-center">
                    <i class="fas fa-reply mr-2"></i> Reply via Email
                </a>
            @endif
            <a href="{{ route('admin.enquiries.index') }}" class="px-5 py-2.5 border border-gray-300 rounded-xl text-sm font-semibold text-gray-700 hover:bg-gray-50 transition-colors ml-auto">
                Back to List
            </a>
        </div>
    </div>
</div>

<!-- Lightbox Modal for Prescription Zoom & Rotate -->
<div id="prescriptionLightbox" class="fixed inset-0 z-50 bg-black/85 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300 flex flex-col items-center justify-center p-4">
    <!-- Top Bar Controls -->
    <div class="w-full max-w-5xl flex items-center justify-between pb-3 text-white">
        <div class="flex items-center gap-2">
            <span class="font-bold text-sm tracking-wide text-teal-300">
                <i class="fas fa-file-medical mr-1.5"></i> Doctor Prescription Slip
            </span>
            <span id="zoomPercentBadge" class="text-xs font-mono bg-white/20 px-2 py-0.5 rounded-md">100%</span>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="zoomIn()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition" title="Zoom In">
                <i class="fas fa-search-plus"></i>
            </button>
            <button type="button" onclick="zoomOut()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition" title="Zoom Out">
                <i class="fas fa-search-minus"></i>
            </button>
            <button type="button" onclick="rotateImage()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition" title="Rotate 90°">
                <i class="fas fa-redo"></i>
            </button>
            <button type="button" onclick="resetZoom()" class="w-9 h-9 rounded-xl bg-white/10 hover:bg-white/20 text-white flex items-center justify-center transition" title="Reset">
                <i class="fas fa-compress"></i>
            </button>
            @if($enquiry->prescription_url)
                <a href="{{ asset($enquiry->prescription_url) }}" target="_blank" class="w-9 h-9 rounded-xl bg-teal-600 hover:bg-teal-500 text-white flex items-center justify-center transition" title="Open Original in New Tab">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            @endif
            <button type="button" onclick="closePrescriptionLightbox()" class="w-9 h-9 rounded-xl bg-red-600 hover:bg-red-500 text-white flex items-center justify-center transition ml-2" title="Close (Esc)">
                <i class="fas fa-times text-base"></i>
            </button>
        </div>
    </div>

    <!-- Image Viewport -->
    <div class="relative w-full max-w-5xl h-[80vh] flex items-center justify-center overflow-auto rounded-2xl bg-black/40 border border-white/10 p-4" onclick="handleBackdropClick(event)">
        <img id="lightboxImage" src="" alt="Doctor Prescription Slip" class="max-h-full max-w-full object-contain transition-transform duration-200 select-none shadow-2xl">
    </div>
</div>

<script>
    let currentZoom = 1;
    let currentRotation = 0;

    function openPrescriptionLightbox(src) {
        const modal = document.getElementById('prescriptionLightbox');
        const img = document.getElementById('lightboxImage');
        img.src = src;
        currentZoom = 1;
        currentRotation = 0;
        applyTransform();
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closePrescriptionLightbox() {
        const modal = document.getElementById('prescriptionLightbox');
        modal.classList.add('opacity-0');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }, 300);
    }

    function zoomIn() {
        if (currentZoom < 3) {
            currentZoom += 0.25;
            applyTransform();
        }
    }

    function zoomOut() {
        if (currentZoom > 0.5) {
            currentZoom -= 0.25;
            applyTransform();
        }
    }

    function rotateImage() {
        currentRotation = (currentRotation + 90) % 360;
        applyTransform();
    }

    function resetZoom() {
        currentZoom = 1;
        currentRotation = 0;
        applyTransform();
    }

    function applyTransform() {
        const img = document.getElementById('lightboxImage');
        img.style.transform = `scale(${currentZoom}) rotate(${currentRotation}deg)`;
        const badge = document.getElementById('zoomPercentBadge');
        if (badge) {
            badge.textContent = Math.round(currentZoom * 100) + '%';
        }
    }

    function handleBackdropClick(event) {
        if (event.target.id !== 'lightboxImage') {
            closePrescriptionLightbox();
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closePrescriptionLightbox();
        }
    });
</script>
@endsection

