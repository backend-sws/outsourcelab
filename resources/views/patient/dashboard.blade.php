@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <div class="w-full md:w-1/3 lg:w-1/4 space-y-4">
            <!-- User Info -->
            <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm flex items-center justify-between">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-blue-50 text-brand-dark rounded-full flex items-center justify-center font-bold text-lg border border-blue-100">
                        <i class="far fa-user"></i>
                    </div>
                    <div>
                        <h4 class="font-extrabold text-brand-dark">{{ $profile['name'] }}</h4>
                        <p class="text-xs text-gray-500 font-medium">+91 {{ $profile['mobile'] }}</p>
                    </div>
                </div>
                <a href="{{ route('patient.profile.edit') }}" class="text-gray-400 hover:text-brand-secondary transition p-2">
                    <i class="far fa-edit"></i>
                </a>
            </div>
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-0 overflow-hidden">
                <a href="#" class="block p-3 text-sm font-semibold text-brand-secondary text-center hover:bg-gray-50 transition">Become a VIP Member ></a>
            </div>

            <!-- My Details -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <h5 class="font-extrabold text-brand-dark text-lg p-4 pb-2">My Details</h5>
                <ul class="text-sm font-semibold text-gray-700 divide-y divide-gray-100">
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-users w-6 text-gray-400"></i> Family Members</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-file-medical w-6 text-gray-400"></i> Prescription</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-map-marker-alt w-6 text-gray-400"></i> Address book</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="far fa-file-alt w-6 text-gray-400"></i> Reports</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="far fa-calendar-check w-6 text-gray-400"></i> Bookings</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                </ul>
            </div>

            <!-- My Benefits -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <h5 class="font-extrabold text-brand-dark text-lg p-4 pb-2">My Benefits</h5>
                <ul class="text-sm font-semibold text-gray-700 divide-y divide-gray-100">
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-gift w-6 text-gray-400"></i> My Gift Card</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-heartbeat w-6 text-gray-400"></i> One Health</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-crown w-6 text-gray-400"></i> Become a VIP</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-utensils w-6 text-gray-400"></i> Diet Plan</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-weight w-6 text-gray-400"></i> Measure Your Health</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="far fa-question-circle w-6 text-gray-400"></i> Queries & Tickets</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                </ul>
            </div>

            <!-- Legal & Privacy -->
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <h5 class="font-extrabold text-brand-dark text-lg p-4 pb-2">Legal & Privacy</h5>
                <ul class="text-sm font-semibold text-gray-700 divide-y divide-gray-100">
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-shield-alt w-6 text-gray-400"></i> Privacy Policy</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-cog w-6 text-gray-400"></i> Account Settings</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                    <li><a href="#" class="flex justify-between items-center p-4 hover:bg-gray-50 transition"><span class="flex items-center"><i class="fas fa-file-contract w-6 text-gray-400"></i> Terms & Conditions</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
                </ul>
            </div>

            <!-- Logout -->
            <a href="{{ route('patient.logout') }}" class="inline-block bg-white border border-gray-200 rounded-lg py-2 px-4 text-sm font-bold text-gray-500 hover:text-red-500 hover:border-red-200 transition shadow-sm mt-2">
                <i class="fas fa-sign-out-alt mr-2 transform rotate-180"></i> Logout
            </a>
        </div>

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4">
            <h2 class="text-2xl font-extrabold text-brand-dark mb-6">My Profile</h2>
            
            <div class="bg-white rounded-xl border border-gray-200 p-8 shadow-sm max-w-2xl">
                <div class="grid grid-cols-2 gap-y-6 gap-x-4 mb-8">
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Name</p>
                        <p class="text-sm font-medium text-gray-800">{{ $profile['name'] }}</p>
                    </div>
                    <div></div>
                    
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Gender</p>
                        <p class="text-sm font-medium text-gray-800">{{ $profile['gender'] }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Age</p>
                        <p class="text-sm font-medium text-gray-800">{{ $profile['age'] }}</p>
                    </div>
                    
                    <div>
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Mobile number</p>
                        <p class="text-sm font-bold text-brand-secondary">{{ $profile['mobile'] }}</p>
                    </div>
                    <div></div>

                    <div class="col-span-2">
                        <p class="text-xs text-brand-dark font-extrabold mb-1">Email Id</p>
                        <p class="text-sm font-medium text-gray-800">{{ $profile['email'] }}</p>
                    </div>
                </div>

                <a href="{{ route('patient.profile.edit') }}" class="w-full block text-center border-2 border-brand-dark text-brand-dark font-extrabold py-3 rounded-xl hover:bg-brand-dark hover:text-white transition shadow-sm">
                    <i class="far fa-edit mr-2"></i> Edit Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
