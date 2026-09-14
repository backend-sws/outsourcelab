@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        @include('patient.partials.sidebar')

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
