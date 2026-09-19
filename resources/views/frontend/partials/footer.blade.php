    <!-- Footer -->
    <footer class="bg-brand-dark text-white pt-16 pb-8 border-t-[8px] border-brand-secondary">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-12">
                <!-- Brand Info -->
                <div class="col-span-1 md:col-span-1 pr-4">
                    <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="h-10 mb-6 bg-white/10 p-2 rounded">
                    <p class="text-xs text-gray-300 leading-relaxed mb-6">Av Wellcare Diagnostics is an impact-driven, fast-growing diagnostic healthcare partner redefining healthcare access with the purpose of Adding Healthy Years to Lives. Having served 1+ crore customers, the company operates with a preventive-first approach across 220+ cities through 80+ advanced labs, offering 3,600+ tests powered by clinical expertise and AI-led innovation. With home sample collection, every test delivers 4X benefits for earlier risk detection and better health everyday.</p>
                    
                    <div class="flex items-center space-x-3 bg-white/5 p-3 rounded-xl border border-white/10 shadow-xs">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-amber-500 via-yellow-400 to-amber-300 flex items-center justify-center text-slate-900 shadow-md flex-shrink-0">
                            <i class="fas fa-award text-lg"></i>
                        </div>
                        <p class="text-[10px] font-bold text-gray-300 leading-tight">We are committed to deliver<br><span class="text-amber-400 font-extrabold">highest quality standards</span> and<br>exceptional customer service</p>
                    </div>
                    <p class="text-[10px] text-gray-500 mt-4 border-t border-gray-700 pt-2">The Content on this website is DMCA protected</p>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm">Quick Links</h4>
                    <ul class="space-y-3 text-xs text-gray-300">
                        <li><a href="/#reviews" class="hover:text-brand-secondary transition">Patient Reviews & Feedback</a></li>
                        <li><a href="/#contact-enquiry" class="hover:text-brand-secondary transition">Have a Query / Enquiry</a></li>
                        <li><a href="{{ route('agent.login') }}" class="text-teal-300 hover:text-white font-semibold transition flex items-center gap-1.5"><i class="fas fa-motorcycle text-[10px]"></i> Phlebotomist / Agent Portal</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">Partner With Us</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">Franchise Opportunity</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">FAQs</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">About Us</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">Our Labs</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">Career</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">Statutory Compliance</a></li>
                        <li><a href="#" class="hover:text-brand-secondary transition">Membership Subscription</a></li>
                    </ul>
                </div>
                
                <!-- Social -->
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
                    <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm">Follow us on</h4>
                    <div class="flex space-x-4 mb-8">
                        <a href="{{ $insta }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary transition text-sm"><i class="fab fa-instagram"></i></a>
                        <a href="{{ $fb }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary transition text-sm"><i class="fab fa-facebook-f"></i></a>
                        <a href="{{ $twitter }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary transition text-sm"><i class="fab fa-twitter"></i></a>
                        <a href="{{ $linkedin }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary transition text-sm"><i class="fab fa-linkedin-in"></i></a>
                        <a href="{{ $yt }}" target="_blank" rel="noopener" class="w-8 h-8 rounded-full bg-white/10 flex items-center justify-center hover:bg-brand-secondary transition text-sm"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-white mb-6 uppercase tracking-wider text-sm">Connect with us</h4>
                    <ul class="space-y-4 text-xs text-gray-300">
                        <li class="flex items-start">
                            <i class="far fa-envelope mt-1 mr-3 text-brand-secondary flex-shrink-0"></i>
                            <a href="mailto:{{ $footerEmail }}" class="hover:text-white transition break-all">{{ $footerEmail }}</a>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-phone-alt mt-1 mr-3 text-brand-secondary"></i>
                            <a href="tel:{{ $footerPhoneClean }}" class="hover:text-white transition font-bold text-white">{{ $footerPhone }}</a>
                        </li>
                        <li class="flex items-start">
                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-brand-secondary"></i>
                            <div>
                                <strong class="text-white block mb-1">{{ $companyName }}</strong>
                                <p class="mb-2"><strong>Registered Address:</strong><br>{{ $registeredAddr }}</p>
                                <p><strong>National Reference Lab:</strong><br>{{ $nationalRefLab }}</p>
                            </div>
                        </li>
                    </ul>
                    
                    <button class="mt-6 w-full bg-white text-brand-dark font-bold py-2 px-4 rounded-full flex justify-between items-center hover:bg-gray-100 transition shadow">
                        <span class="flex items-center text-xs"><i class="fas fa-location-arrow text-brand-secondary mr-2"></i> Find a lab near me</span>
                        <span class="bg-brand-dark text-white text-[10px] px-2 py-1 rounded-full uppercase">Locate Now</span>
                    </button>
                </div>
            </div>
            
            <div class="border-t border-gray-700 pt-6 flex flex-col md:flex-row justify-between items-center text-[10px] text-gray-400">
                <p>{{ $copyrightText }}</p>
                <p>CIN: {{ $cinNumber }}</p>
                <div class="flex space-x-4 mt-2 md:mt-0">
                    <a href="#" class="hover:text-white border-b border-gray-500 pb-0.5">Privacy Policy</a>
                    <span class="text-gray-600">|</span>
                    <a href="#" class="hover:text-white border-b border-gray-500 pb-0.5">Terms & Condition</a>
                </div>
            </div>
        </div>
    </footer>

