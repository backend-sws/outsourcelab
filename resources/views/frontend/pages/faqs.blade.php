@extends('frontend.layouts.app')

@section('title', 'Frequently Asked Questions (FAQs) | Av Wellcare Diagnostics')

@section('content')
<!-- Ambient Background Elements -->
<div class="fixed inset-0 z-[-1] pointer-events-none overflow-hidden bg-slate-50/60">
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-teal-200/30 rounded-full blur-3xl"></div>
    <div class="absolute top-96 -right-32 w-96 h-96 bg-cyan-200/20 rounded-full blur-3xl"></div>
</div>

<div class="container mx-auto px-4 py-8 max-w-5xl">
    <!-- Breadcrumbs -->
    <nav class="flex items-center gap-2 text-xs font-semibold text-gray-500 mb-6" aria-label="Breadcrumb">
        <a href="{{ route('home') }}" class="hover:text-teal-700 transition flex items-center gap-1.5">
            <i class="fas fa-home text-gray-400"></i>
            <span>Home</span>
        </a>
        <i class="fas fa-chevron-right text-[9px] text-gray-300"></i>
        <span class="text-teal-800 font-bold">Frequently Asked Questions</span>
    </nav>

    <!-- Hero Section -->
    <div class="bg-gradient-to-br from-brand-dark via-teal-950 to-slate-900 rounded-3xl p-8 sm:p-12 text-white shadow-2xl relative overflow-hidden mb-10 text-center">
        <div class="absolute top-0 right-0 w-80 h-80 bg-teal-500/20 rounded-full blur-3xl pointer-events-none"></div>
        <div class="relative z-10 max-w-2xl mx-auto">
            <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-teal-500/20 text-teal-300 border border-teal-500/30 inline-flex items-center gap-1.5 mb-4">
                <i class="fas fa-circle-question text-amber-400"></i> Help Center
            </span>
            <h1 class="text-3xl sm:text-4xl font-black tracking-tight text-white leading-tight mb-4">
                How Can We Help You Today?
            </h1>
            <p class="text-gray-200 text-xs sm:text-sm leading-relaxed mb-6 font-normal">
                Find clear, authoritative answers regarding sample preparation, fasting protocols, home collection scheduling, and digital report delivery.
            </p>

            <!-- Instant Filter Input -->
            <div class="relative max-w-lg mx-auto">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 text-sm"></i>
                <input type="text" id="faqSearchInput" onkeyup="filterFaqs()" placeholder="Search questions (e.g. fasting, download report, refund)..."
                       class="w-full pl-11 pr-4 py-3 bg-white/10 backdrop-blur-md border border-white/20 rounded-2xl text-white placeholder-gray-400 text-xs font-semibold focus:outline-none focus:bg-white focus:text-gray-900 focus:placeholder-gray-500 transition">
            </div>
        </div>
    </div>

    <!-- Category Pills -->
    <div class="flex flex-wrap items-center justify-center gap-2 mb-8">
        <button type="button" onclick="filterCategory('all')" class="faq-cat-btn active px-4 py-2 rounded-xl text-xs font-bold bg-teal-700 text-white transition">All Topics</button>
        <button type="button" onclick="filterCategory('fasting')" class="faq-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Fasting & Prep</button>
        <button type="button" onclick="filterCategory('collection')" class="faq-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Home Collection</button>
        <button type="button" onclick="filterCategory('reports')" class="faq-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Reports & TAT</button>
        <button type="button" onclick="filterCategory('billing')" class="faq-cat-btn px-4 py-2 rounded-xl text-xs font-bold bg-white text-gray-600 hover:bg-gray-100 border border-gray-200 transition">Billing & Refunds</button>
    </div>

    <!-- Accordion Container -->
    <div class="space-y-3.5 mb-16" id="faqList">

        <!-- FAQ 1 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="fasting">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>What does "10 to 12 hours overnight fasting" mean for blood tests?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                Overnight fasting means you should consume no food, tea, coffee, milk, or juices for 10 to 12 hours prior to your blood collection. However, drinking plain water is actively encouraged, as hydration makes veins easier to locate and ensures blood viscosity is normal. Avoid heavy meals and alcohol on the previous evening.
            </div>
        </div>

        <!-- FAQ 2 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="fasting">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>Can I take my regular prescription medications before a fasting test?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                Blood pressure and thyroid medications can usually be taken with a small sip of water early in the morning unless your physician specifically instructed otherwise. Diabetic medicines and insulin should generally be taken only AFTER your fasting blood sample has been drawn and you have eaten breakfast.
            </div>
        </div>

        <!-- FAQ 3 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="collection">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>How does home sample collection work? Is it hygienic?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                Our DMLT/BMLT-certified phlebotomist visits your doorstep at your selected time slot. They carry a single-use sterile BD Vacutainer kit, fresh nitrile gloves, and alcohol disinfectant swabs. The sample is drawn in sealed vacuum tubes and barcoded immediately in front of you, then transferred into an insulated 2°C to 8°C cold-chain transport carrier.
            </div>
        </div>

        <!-- FAQ 4 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="collection">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>Can I reschedule or cancel my home collection booking?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                Yes, absolutely. You can reschedule your slot at zero charge up to 2 hours before the scheduled phlebotomist arrival by calling our 24x7 customer support helpline at {{ \App\Models\Setting::get('helpline_primary', '898 898 8787') }} or chatting with us on WhatsApp.
            </div>
        </div>

        <!-- FAQ 5 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="reports">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>How will I receive my diagnostic test reports?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                As soon as your samples are processed and signed off by our MD Pathologists, you will receive an instant SMS and WhatsApp message with a secure link. You can also download your report anytime directly on our website by navigating to the <a href="{{ route('download.report') }}" class="text-teal-700 font-bold underline">Download Report</a> page and entering your registered phone number.
            </div>
        </div>

        <!-- FAQ 6 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="reports">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>What is the standard turnaround time (TAT) for test reports?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                Standard routine blood tests (CBC, Lipid Profile, Liver Function, Kidney Function, Thyroid Profile) are delivered within 6 to 12 hours from sample accession. Advanced specialized tests like Vitamin D, Vitamin B12, and specialized hormonal assays take 12 to 24 hours. Esoteric or genetic tests may take 48 to 72 hours.
            </div>
        </div>

        <!-- FAQ 7 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="billing">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>What payment methods are supported? Can I pay cash on sample collection?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                We support 100% secure online payments (UPI, Google Pay, PhonePe, Debit Cards, Credit Cards, Net Banking) via Cashfree / Razorpay gateways. You may also select Pay on Sample Collection (Cash or QR Scan on phlebotomist app).
            </div>
        </div>

        <!-- FAQ 8 -->
        <div class="faq-item bg-white rounded-2xl border border-gray-100 shadow-xs overflow-hidden transition" data-category="billing">
            <button type="button" onclick="toggleFaq(this)" class="w-full p-5 text-left flex items-center justify-between gap-4 font-bold text-gray-900 text-sm hover:text-teal-700 transition">
                <span>What is the refund policy if I cancel my prepaid booking?</span>
                <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform duration-200 flex-shrink-0"></i>
            </button>
            <div class="faq-answer hidden px-5 pb-5 text-xs text-gray-600 leading-relaxed border-t border-gray-50 pt-3">
                If you cancel an order before the sample has been collected by the phlebotomist, 100% of the amount is automatically refunded back to your original source of payment within 3 to 5 banking days. No cancellation fees apply.
            </div>
        </div>
    </div>

    <!-- Still Have Questions Contact Box -->
    <div class="bg-teal-50 rounded-3xl p-8 border border-teal-100 flex flex-col sm:flex-row items-center justify-between gap-6 mb-16">
        <div>
            <h3 class="text-base sm:text-lg font-black text-gray-900 mb-1">Didn't find what you were looking for?</h3>
            <p class="text-xs text-gray-600">Our patient care desk is available 24/7 to assist with your medical queries and test preparations.</p>
        </div>
        <div class="flex items-center gap-3 flex-shrink-0">
            <a href="tel:{{ preg_replace('/[^0-9]/', '', \App\Models\Setting::get('helpline_primary', '8988988787')) }}" class="px-5 py-2.5 bg-teal-700 hover:bg-teal-800 text-white text-xs font-bold rounded-xl transition shadow">
                <i class="fas fa-phone-alt mr-1.5"></i> Call Helpline
            </a>
            <a href="{{ route('home') }}#contact-enquiry" class="px-5 py-2.5 bg-white hover:bg-gray-100 text-teal-800 text-xs font-bold rounded-xl transition border border-teal-200">
                Submit Enquiry
            </a>
        </div>
    </div>
</div>

<script>
    function toggleFaq(btn) {
        const item = btn.closest('.faq-item');
        const answer = item.querySelector('.faq-answer');
        const icon = btn.querySelector('i');
        const isHidden = answer.classList.contains('hidden');

        // Close all other faqs in the list
        document.querySelectorAll('.faq-answer').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.faq-item i').forEach(el => el.classList.remove('rotate-180'));

        if (isHidden) {
            answer.classList.remove('hidden');
            icon.classList.add('rotate-180');
        }
    }

    function filterCategory(category) {
        document.querySelectorAll('.faq-cat-btn').forEach(btn => {
            btn.classList.remove('bg-teal-700', 'text-white');
            btn.classList.add('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        });
        event.target.classList.remove('bg-white', 'text-gray-600', 'border', 'border-gray-200');
        event.target.classList.add('bg-teal-700', 'text-white');

        const items = document.querySelectorAll('.faq-item');
        items.forEach(item => {
            if (category === 'all' || item.dataset.category === category) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }

    function filterFaqs() {
        const query = document.getElementById('faqSearchInput').value.toLowerCase();
        const items = document.querySelectorAll('.faq-item');

        items.forEach(item => {
            const text = item.textContent.toLowerCase();
            if (text.includes(query)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    }
</script>
@endsection
