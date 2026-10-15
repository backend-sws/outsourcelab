@php
    $floatingVideo = \App\Models\Setting::getFloatingVideoDetails();
@endphp

@if($floatingVideo && $floatingVideo['enabled'] && (!$floatingVideo['homepage_only'] || request()->routeIs('home')))
<div id="floatingVideoWidget" 
    class="fixed right-4 sm:right-6 z-40 select-none transition-all duration-300"
    style="bottom: 20px;">
    <style>
        @keyframes videoPulseGlow {
            0%, 100% {
                box-shadow: 0 0 0 0 rgba(244, 63, 94, 0.6), 0 10px 25px -5px rgba(0, 0, 0, 0.4);
            }
            50% {
                box-shadow: 0 0 0 14px rgba(244, 63, 94, 0), 0 15px 30px -5px rgba(244, 63, 94, 0.4);
            }
        }

        .animate-video-glow {
            animation: videoPulseGlow 2.5s infinite cubic-bezier(0.4, 0, 0.6, 1);
        }

        .floating-video-pill {
            background: rgba(15, 23, 42, 0.90);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.20);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .floating-video-pill:hover {
            transform: translateY(-4px) scale(1.03);
            background: rgba(15, 23, 42, 0.98);
            border-color: rgba(244, 63, 94, 0.5);
            box-shadow: 0 15px 35px -5px rgba(244, 63, 94, 0.45);
        }
    </style>

    <!-- Main Interactive Pill Button (Cut / Close option permanently removed as requested) -->
    <button type="button" 
        onclick="openFloatingVideoModal()"
        id="floatingVideoOpenBtn"
        class="floating-video-pill animate-video-glow rounded-full p-1.5 sm:pr-4 flex items-center gap-2.5 sm:gap-3 text-white cursor-pointer shadow-2xl focus:outline-none focus:ring-2 focus:ring-rose-500/50">
        
        <!-- Pulsating Play Button Icon -->
        <div class="relative flex items-center justify-center w-11 h-11 sm:w-12 sm:h-12 rounded-full bg-gradient-to-tr from-rose-600 via-rose-500 to-pink-500 text-white shadow-lg flex-shrink-0">
            <!-- Ping Ripple -->
            <span class="absolute inset-0 rounded-full bg-rose-500 opacity-75 animate-ping pointer-events-none"></span>
            <i class="fas fa-play text-xs sm:text-sm ml-0.5 relative z-10 drop-shadow"></i>
        </div>

        <!-- Text & Subtitle Info (Full on desktop, compact on mobile) -->
        <div class="hidden sm:flex flex-col text-left py-0.5">
            <div class="flex items-center gap-1.5">
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-rose-400 animate-pulse"></span>
                <span class="text-[10px] font-black uppercase tracking-wider text-rose-300">{{ $floatingVideo['badge'] }}</span>
            </div>
            <span class="text-xs font-bold text-white tracking-wide truncate max-w-[160px] drop-shadow-sm">
                {{ $floatingVideo['button_text'] }}
            </span>
        </div>

        <!-- Mobile Only Mini-Label -->
        <span class="sm:hidden text-xs font-bold text-white pr-2">
            {{ $floatingVideo['button_text'] }}
        </span>
    </button>
</div>

<!-- High-End Responsive Video Pop-Up Lightbox Modal -->
<div id="floatingVideoModal" 
    class="fixed inset-0 z-[10000] flex items-center justify-center p-3 sm:p-6 bg-slate-950/80 backdrop-blur-md hidden opacity-0 transition-all duration-300"
    onclick="handleVideoBackdropClick(event)">
    
    <div id="floatingVideoModalCard" 
        class="relative w-full max-w-4xl bg-slate-900 border border-white/15 rounded-2xl sm:rounded-3xl shadow-[0_25px_50px_-12px_rgba(0,0,0,0.8)] overflow-hidden flex flex-col transform scale-95 transition-all duration-300">
        
        <!-- Modal Top Bar -->
        <div class="flex items-center justify-between px-4 sm:px-6 py-3.5 bg-slate-900/90 border-b border-white/10 backdrop-blur-sm z-10">
            <div class="flex items-center gap-2.5 min-w-0 pr-4">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-rose-500/20 border border-rose-500/30 text-[10px] font-black uppercase tracking-wider text-rose-300 flex-shrink-0">
                    <i class="fas fa-circle-play text-rose-400"></i>
                    <span>{{ $floatingVideo['badge'] }}</span>
                </span>
                <h3 class="text-sm sm:text-base font-bold text-white truncate drop-shadow-sm">
                    {{ $floatingVideo['title'] }}
                </h3>
            </div>

            <!-- Modal Close Button (Only inside the popup so user can close video window after watching) -->
            <button type="button" 
                onclick="closeFloatingVideoModal()"
                class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/10 hover:bg-rose-600 text-white flex items-center justify-center transition-all flex-shrink-0 cursor-pointer hover:rotate-90"
                title="Close video (Esc)">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        <!-- Video Player Frame Area -->
        <div class="relative w-full aspect-video bg-black overflow-hidden flex items-center justify-center">
            @if($floatingVideo['type'] === 'html5')
                <video id="floatingVideoHtml5Player" 
                    class="w-full h-full object-contain" 
                    controls 
                    playsinline
                    preload="metadata"
                    @if(!empty($floatingVideo['thumbnail_url'])) poster="{{ $floatingVideo['thumbnail_url'] }}" @endif
                    data-video-src="{{ $floatingVideo['embed_url'] }}">
                    <source src="" type="video/mp4">
                    Your browser does not support HTML5 video.
                </video>
            @else
                <iframe id="floatingVideoIframe" 
                    class="w-full h-full border-0" 
                    src="" 
                    data-embed-url="{{ $floatingVideo['embed_url'] }}"
                    title="{{ $floatingVideo['title'] }}"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                    allowfullscreen>
                </iframe>
            @endif

            <!-- Loading Spinner Placeholder -->
            <div id="floatingVideoSpinner" class="absolute inset-0 flex items-center justify-center bg-black/60 pointer-events-none transition-opacity duration-300">
                <div class="w-10 h-10 border-4 border-rose-500/30 border-t-rose-500 rounded-full animate-spin"></div>
            </div>
        </div>

        <!-- Modal Bottom Footer / Caption & Quick Action -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 px-4 sm:px-6 py-3.5 bg-slate-900 border-t border-white/10">
            <p class="text-xs text-slate-300/90 leading-relaxed max-w-xl">
                {{ $floatingVideo['description'] }}
            </p>
            <div class="flex items-center gap-2 flex-shrink-0">
                <a href="{{ route('home') }}#packages-section" 
                    onclick="closeFloatingVideoModal()"
                    class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-gradient-to-r from-teal-600 to-emerald-600 hover:from-teal-500 hover:to-emerald-500 text-white text-xs font-bold shadow-md transition-all hover:scale-105">
                    <i class="fas fa-microscope text-xs"></i>
                    <span>Explore Health Packages</span>
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    (function() {
        const widget = document.getElementById('floatingVideoWidget');
        const modal = document.getElementById('floatingVideoModal');
        const modalCard = document.getElementById('floatingVideoModalCard');
        const iframe = document.getElementById('floatingVideoIframe');
        const html5Player = document.getElementById('floatingVideoHtml5Player');
        const spinner = document.getElementById('floatingVideoSpinner');

        // Dynamic Right-Side Positioning to coordinate seamlessly with Welcome Ticket (if present)
        function updateRightSidePosition() {
            if (!widget) return;
            const ticketWrapper = document.getElementById('floatingWelcomeTicketWrapper');
            const ticketCard = document.getElementById('welcomeTicketCard');
            const miniPill = document.getElementById('welcomeTicketMiniPill');

            if (ticketWrapper && ticketCard && !ticketCard.classList.contains('hidden') && ticketCard.offsetHeight > 0) {
                // Sit above full ticket card
                widget.style.bottom = (ticketCard.offsetHeight + 28) + 'px';
            } else if (miniPill && !miniPill.classList.contains('hidden')) {
                // Sit above mini pill
                widget.style.bottom = '75px';
            } else {
                // Default bottom position on right side
                widget.style.bottom = '20px';
            }
        }

        // Initialize position on load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', updateRightSidePosition);
        } else {
            updateRightSidePosition();
        }

        // Observe changes to Welcome Ticket so floating video transitions smoothly
        const ticketWrapper = document.getElementById('floatingWelcomeTicketWrapper');
        if (ticketWrapper && window.MutationObserver) {
            const observer = new MutationObserver(function() {
                updateRightSidePosition();
            });
            observer.observe(ticketWrapper, { attributes: true, childList: true, subtree: true });
        }

        window.openFloatingVideoModal = function() {
            if (!modal) return;

            // Show modal
            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                if (modalCard) {
                    modalCard.classList.remove('scale-95');
                    modalCard.classList.add('scale-100');
                }
            }, 10);

            // Prevent background scrolling
            document.body.style.overflow = 'hidden';

            // Start Video
            if (iframe) {
                const embedUrl = iframe.getAttribute('data-embed-url');
                if (embedUrl) {
                    const separator = embedUrl.includes('?') ? '&' : '?';
                    const targetSrc = embedUrl.includes('autoplay') ? embedUrl : `${embedUrl}${separator}autoplay=1`;
                    iframe.src = targetSrc;
                    iframe.onload = () => {
                        if (spinner) spinner.style.opacity = '0';
                    };
                }
            } else if (html5Player) {
                const videoSrc = html5Player.getAttribute('data-video-src');
                if (videoSrc && (!html5Player.src || html5Player.src === window.location.href)) {
                    html5Player.src = videoSrc;
                    html5Player.load();
                }
                const playPromise = html5Player.play();
                if (playPromise !== undefined) {
                    playPromise.then(() => {
                        if (spinner) spinner.style.opacity = '0';
                    }).catch(() => {
                        if (spinner) spinner.style.opacity = '0';
                    });
                }
            }
        };

        window.closeFloatingVideoModal = function() {
            if (!modal) return;

            modal.classList.add('opacity-0');
            if (modalCard) {
                modalCard.classList.remove('scale-100');
                modalCard.classList.add('scale-95');
            }

            // Immediately stop video playback
            if (iframe) {
                iframe.src = '';
                if (spinner) spinner.style.opacity = '1';
            } else if (html5Player) {
                html5Player.pause();
                html5Player.currentTime = 0;
            }

            setTimeout(() => {
                modal.classList.add('hidden');
                document.body.style.overflow = '';
            }, 300);
        };

        window.handleVideoBackdropClick = function(event) {
            if (event.target === modal) {
                closeFloatingVideoModal();
            }
        };

        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeFloatingVideoModal();
            }
        });
    })();
</script>
@endif
