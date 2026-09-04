    <!-- Top Header -->
    <div class="bg-white py-2 px-4 border-b">
        <div class="container mx-auto flex justify-between items-center text-sm">
            <div class="flex items-center space-x-4">
                <img src="{{ asset('logo.jpeg') }}" alt="Logo" class="h-8">
                <div class="flex items-center ml-2">
                    <span class="text-brand-primary font-extrabold text-xl tracking-tight">Wellcare</span>
                    <span class="text-brand-secondary font-extrabold text-xl tracking-tight ml-1">Diagnostics</span>
                </div>
            </div>
            <div class="flex items-center space-x-6">
                <button class="flex items-center font-semibold border rounded-full px-4 py-1.5 shadow-sm hover:bg-gray-50"><i class="fas fa-shopping-cart text-gray-500 mr-2"></i> Cart <span class="bg-gray-200 text-xs rounded-full px-1.5 ml-1">0</span></button>
                <button class="flex items-center font-semibold border rounded-full px-4 py-1.5 shadow-sm hover:bg-gray-50"><i class="far fa-user text-gray-500 mr-2"></i> Profile</button>
            </div>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="container mx-auto px-4 py-3 flex justify-between items-center relative">
            <!-- Left: Menu -->
            <div class="flex-none">
                <button class="text-gray-700 font-bold flex items-center"><i class="fas fa-bars mr-2 text-lg"></i> Menu</button>
            </div>
            
            <!-- Center: Links -->
            <div class="hidden md:flex absolute left-1/2 transform -translate-x-1/2 items-center space-x-24">
                <a href="#" class="text-brand-secondary font-extrabold flex items-center text-base hover:text-brand-primary transition"><i class="fas fa-home mr-2"></i> Home</a>
                <a href="#" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="far fa-calendar-check mr-2"></i> My Bookings</a>
                <a href="#" class="text-brand-dark font-extrabold flex items-center text-base hover:text-brand-secondary transition"><i class="far fa-file-alt mr-2"></i> My Reports</a>
            </div>

            <!-- Right: Phone -->
            <div class="font-bold text-brand-dark flex items-center text-lg flex-none">
                <i class="fas fa-phone-alt text-brand-secondary mr-2"></i> 898 898 8787
            </div>
        </div>
    </nav>

