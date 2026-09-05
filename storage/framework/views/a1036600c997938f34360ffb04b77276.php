<div class="w-full md:w-1/3 lg:w-1/4 space-y-4">
    <!-- User Info -->
    <div class="bg-white rounded-xl border border-gray-200 p-4 shadow-sm flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-blue-50 text-brand-dark rounded-full flex items-center justify-center font-bold text-lg border border-blue-100">
                <i class="far fa-user"></i>
            </div>
            <div>
                <h4 class="font-extrabold text-brand-dark"><?php echo e($profile['name']); ?></h4>
                <p class="text-xs text-gray-500 font-medium">+91 <?php echo e($profile['mobile']); ?></p>
            </div>
        </div>
        <a href="<?php echo e(route('patient.profile.edit')); ?>" class="text-gray-400 hover:text-brand-secondary transition p-2">
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
            <li><a href="<?php echo e(route('patient.family_members')); ?>" class="flex justify-between items-center p-4 hover:bg-gray-50 transition <?php echo e(request()->routeIs('patient.family_members') ? 'text-brand-secondary bg-gray-50' : ''); ?>"><span class="flex items-center"><i class="fas fa-users w-6 <?php echo e(request()->routeIs('patient.family_members') ? 'text-brand-secondary' : 'text-gray-400'); ?>"></i> Family Members</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="<?php echo e(route('patient.prescriptions')); ?>" class="flex justify-between items-center p-4 hover:bg-gray-50 transition <?php echo e(request()->routeIs('patient.prescriptions') ? 'text-brand-secondary bg-gray-50' : ''); ?>"><span class="flex items-center"><i class="fas fa-file-medical w-6 <?php echo e(request()->routeIs('patient.prescriptions') ? 'text-brand-secondary' : 'text-gray-400'); ?>"></i> Prescription</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
            <li><a href="<?php echo e(route('patient.address_book')); ?>" class="flex justify-between items-center p-4 hover:bg-gray-50 transition <?php echo e(request()->routeIs('patient.address_book') ? 'text-brand-secondary bg-gray-50' : ''); ?>"><span class="flex items-center"><i class="fas fa-map-marker-alt w-6 <?php echo e(request()->routeIs('patient.address_book') ? 'text-brand-secondary' : 'text-gray-400'); ?>"></i> Address book</span> <i class="fas fa-chevron-right text-gray-300 text-xs"></i></a></li>
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
    <a href="<?php echo e(route('patient.logout')); ?>" class="inline-block bg-white border border-gray-200 rounded-lg py-2 px-4 text-sm font-bold text-gray-500 hover:text-red-500 hover:border-red-200 transition shadow-sm mt-2">
        <i class="fas fa-sign-out-alt mr-2 transform rotate-180"></i> Logout
    </a>
</div>
<?php /**PATH D:\lab\lab\resources\views/patient/partials/sidebar.blade.php ENDPATH**/ ?>