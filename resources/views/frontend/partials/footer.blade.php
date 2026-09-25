    <!-- Footer -->
    <footer class="bg-brand-dark text-white pt-16 pb-8 border-t-[8px] border-brand-secondary w-full">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 mb-12">
                <!-- Brand Info -->
                <div class="col-span-1 pr-2">
                    <div class="bg-white/95 px-3 py-2 rounded-xl inline-block mb-6 shadow-sm">
                        <img src="{{ asset('logo.png') }}" alt="Av Wellcare Diagnostics" class="h-10 w-auto object-contain">
                    </div>
                    <p class="text-xs text-gray-300 leading-relaxed mb-6">
                        Av Wellcare Diagnostics is an impact-driven, fast-growing diagnostic healthcare partner redefining healthcare access with the purpose of Adding Healthy Years to Lives. Having served 1+ crore customers, the company operates with a preventive-first approach across 220+ cities through 80+ advanced labs, offering 3,600+ tests powered by clinical expertise and AI-led innovation.
                    </p>
                    
                    <div class="flex items-center space-x-3 bg-white/5 p-3 rounded-xl border border-white/10 shadow-xs">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 via-yellow-400 to-amber-300 flex items-center justify-center text-slate-900 shadow-md flex-shrink-0">
                            <i class="fas fa-award text-lg"></i>
                        </div>
                        <p class="text-[10px] font-bold text-gray-300 leading-tight">We are committed to deliver<br><span class="text-amber-400 font-extrabold">highest quality standards</span> and<br>exceptional customer service</p>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-4 border-t border-white/10 pt-2">The Content on this website is DMCA protected</p>
                </div>
                
                <!-- Patient Care & Quick Links -->
                <div>
                    <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm flex items-center gap-2">
                        <i class="fas fa-hand-holding-medical text-brand-secondary text-xs"></i> Patient Care
                    </h4>
                    <ul class="space-y-3 text-xs text-gray-300">
                        <li><a href="{{ route('home') }}#reviews" class="hover:text-brand-secondary transition">Patient Reviews & Feedback</a></li>
                        <li><a href="{{ route('home') }}#contact-enquiry" class="hover:text-brand-secondary transition">Have a Query / Enquiry</a></li>
                        <li><a href="{{ route('download.report') }}" class="hover:text-brand-secondary transition">Download Patient Report</a></li>
                        <li><a href="{{ route('faqs') }}" class="hover:text-brand-secondary transition">Frequently Asked Questions (FAQs)</a></li>
                        <li><a href="{{ route('calculators.index') }}" class="hover:text-brand-secondary transition">Health Risk Calculators</a></li>
                        <li><a href="{{ route('agent.login') }}" class="text-teal-300 hover:text-white font-semibold transition flex items-center gap-1.5"><i class="fas fa-motorcycle text-[10px]"></i> Phlebotomist / Agent Portal</a></li>
                        @if(config('pathology.sso_enabled', true))
                        <li><a href="{{ route('lis.login') }}" class="hover:text-brand-secondary transition flex items-center gap-1.5"><i class="fas fa-microchip text-[10px]"></i> Laboratory LIS Access</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Corporate & Network -->
                <div>
                    <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm flex items-center gap-2">
                        <i class="fas fa-building-shield text-brand-secondary text-xs"></i> Corporate & Network
                    </h4>
                    <ul class="space-y-3 text-xs text-gray-300">
                        <li><a href="{{ route('about') }}" class="hover:text-brand-secondary transition">About Us (Our Story & Team)</a></li>
                        <li><a href="{{ route('labs') }}" class="hover:text-brand-secondary transition">Our Labs & Pincode Network</a></li>
                        <li><a href="{{ route('partner') }}" class="hover:text-brand-secondary transition">Partner With Us (Doctors & B2B)</a></li>
                        <li><a href="{{ route('franchise') }}" class="hover:text-brand-secondary transition">Franchise Opportunity (DCC Hub)</a></li>
                        <li><a href="{{ route('careers') }}" class="hover:text-brand-secondary transition">Careers / Job Openings</a></li>
                        <li><a href="{{ route('compliance') }}" class="hover:text-brand-secondary transition">Statutory Compliance (BMWM, PCPNDT)</a></li>
                        <li><a href="{{ route('membership') }}" class="hover:text-brand-secondary transition">Care+ Health Membership Plans</a></li>
                        <li><a href="{{ route('sitemap') }}" class="hover:text-brand-secondary transition">Website Directory / Sitemap</a></li>
                    </ul>
                </div>
                
                <!-- Social & Contact -->
                @php
                    $footerEmail = \App\Models\Setting::get('contact_email', 'care@avwellcarediagnostics.com');
                    $footerPhone = \App\Models\Setting::get('helpline_primary', '898 898 8787');
                    $footerPhoneClean = preg_replace('/[^0-9]/', '', $footerPhone);
                    $registeredAddr = \App\Models\Setting::get('registered_address', 'H-21, 2nd Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301');
                    $nationalRefLab = \App\Models\Setting::get('reference_lab_address', 'H-21, 4th Floor, Electronic City, H Block, Sector 63, Noida, Uttar Pradesh 201301');
                    $companyName = \App\Models\Setting::get('company_legal_name', 'Av Wellcare Lifetech Pvt. Ltd.');
                    $cinNumber = \App\Models\Setting::get('cin_number', 'U85190UP2021PTC149892');
                    $copyrightText = \App\Models\Setting::get('copyright_text', 'Av Wellcare Diagnostics © ' . date('Y') . '. All rights reserved.');
                    $insta = \App\Models\Setting::get('social_instagram', '#');
                    $fb = \App\Models\Setting::get('social_facebook', '#');
                    $twitter = \App\Models\Setting::get('social_twitter', '#');
                    $linkedin = \App\Models\Setting::get('social_linkedin', '#');
                    $yt = \App\Models\Setting::get('social_youtube', '#');
                @endphp
                <div>
                    <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm flex items-center gap-2">
                        <i class="fas fa-headset text-brand-secondary text-xs"></i> Connect with us
                    </h4>
                    <ul class="space-y-3 text-xs text-gray-300 mb-6">
                        <li class="flex items-start">
                            <i class="far fa-envelope mt-1 mr-2.5 text-brand-secondary flex-shrink-0"></i>
                            <a href="mailto:{{ $footerEmail }}" class="hover:text-white transition break-all">{{ $footerEmail }}</a>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-2.5 text-brand-secondary flex-shrink-0"></i>
                            <a href="tel:{{ $footerPhoneClean }}" class="hover:text-white transition font-bold text-white">{{ $footerPhone }}</a>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-2.5 text-brand-secondary flex-shrink-0"></i>
                            <div>
                                <strong class="text-white block mb-0.5">{{ $companyName }}</strong>
                                <p class="text-[11px] text-gray-300 mb-1 leading-snug">{{ $registeredAddr }}</p>
                            </div>
                        </li>
                    </ul>
                    
                    <a href="{{ route('labs') }}" class="w-full bg-white text-brand-dark font-bold py-2.5 px-4 rounded-full flex justify-between items-center hover:bg-gray-100 transition shadow mb-6">
                        <span class="flex items-center text-xs"><i class="fas fa-location-arrow text-brand-secondary mr-2"></i> Find a lab near me</span>
                        <span class="bg-brand-dark text-white text-[10px] px-2.5 py-1 rounded-full uppercase font-extrabold">Locate Now</span>
                    </a>

                    <!-- Follow Us Social Icons -->
                    <div class="border-t border-white/10 pt-4">
                        <span class="text-[11px] font-bold text-gray-400 block mb-2 uppercase tracking-wider">Follow Us</span>
                        <div class="flex space-x-3">
                            <a href="{{ ($insta && $insta !== '#') ? $insta : 'javascript:void(0)' }}" target="{{ ($insta && $insta !== '#') ? '_blank' : '_self' }}" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary hover:text-slate-950 transition text-xs"><i class="fab fa-instagram"></i></a>
                            <a href="{{ ($fb && $fb !== '#') ? $fb : 'javascript:void(0)' }}" target="{{ ($fb && $fb !== '#') ? '_blank' : '_self' }}" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary hover:text-slate-950 transition text-xs"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ ($twitter && $twitter !== '#') ? $twitter : 'javascript:void(0)' }}" target="{{ ($twitter && $twitter !== '#') ? '_blank' : '_self' }}" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary hover:text-slate-950 transition text-xs"><i class="fab fa-twitter"></i></a>
                            <a href="{{ ($linkedin && $linkedin !== '#') ? $linkedin : 'javascript:void(0)' }}" target="{{ ($linkedin && $linkedin !== '#') ? '_blank' : '_self' }}" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary hover:text-slate-950 transition text-xs"><i class="fab fa-linkedin-in"></i></a>
                            <a href="{{ ($yt && $yt !== '#') ? $yt : 'javascript:void(0)' }}" target="{{ ($yt && $yt !== '#') ? '_blank' : '_self' }}" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary hover:text-slate-950 transition text-xs"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center text-[10px] text-gray-400 gap-3">
                <p>{{ $copyrightText }}</p>
                <p class="font-mono">CIN: {{ $cinNumber }}</p>
                <div class="flex flex-wrap items-center space-x-3 mt-2 md:mt-0">
                    <a href="{{ route('privacy') }}" class="hover:text-white border-b border-gray-500 pb-0.5 transition">Privacy Policy</a>
                    <span class="text-gray-600">|</span>
                    <a href="{{ route('terms') }}" class="hover:text-white border-b border-gray-500 pb-0.5 transition">Terms & Conditions</a>
                    <span class="text-gray-600">|</span>
                    <a href="{{ route('sitemap') }}" class="hover:text-white border-b border-gray-500 pb-0.5 transition">HTML Sitemap</a>
                    <span class="text-gray-600">|</span>
                    <a href="{{ route('sitemap.xml') }}" target="_blank" class="hover:text-white border-b border-gray-500 pb-0.5 transition">XML Sitemap</a>
                </div>
            </div>

            <!-- Developer Credit -->
            <div class="mt-4 pt-3 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between text-[11px] text-gray-400 gap-2">
                <p class="flex items-center gap-1.5 text-[10px] text-gray-400">
                    <span>Crafted with</span>
                    <i class="fas fa-heart text-rose-500 text-[10px] animate-pulse"></i>
                    <span>for certified pathology care</span>
                </p>
                <p class="text-[11px] text-gray-300">
                    Designed and Developed by 
                    <a href="https://startupwebsupport.com" target="_blank" rel="noopener noreferrer" class="font-bold text-teal-400 hover:text-amber-300 transition inline-flex items-center gap-1 ml-1 underline decoration-teal-500/50 underline-offset-2 hover:decoration-amber-300">
                        <span>StartupWebSupport</span>
                        <i class="fas fa-arrow-up-right-from-square text-[9px]"></i>
                    </a>
                </p>
            </div>
        </div>
    </footer>
