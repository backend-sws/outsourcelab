<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8 bg-gray-50/50">
    <div class="flex flex-col md:flex-row gap-8">
        <!-- Sidebar -->
        <?php echo $__env->make('patient.partials.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <!-- Main Content -->
        <div class="w-full md:w-2/3 lg:w-3/4">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-extrabold text-brand-dark">Address Book</h2>
                <button onclick="window.openAddAddressModal()" class="bg-brand-dark text-white px-5 py-2 rounded-xl font-bold text-sm hover:bg-brand-secondary transition shadow-sm">
                    <i class="fas fa-plus mr-2"></i> Add Address
                </button>
            </div>
            
            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">
                <div id="addressBookList" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__currentLoopData = $profile->addresses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $isHome = stripos($address->title, 'home') !== false;
                            $icon = $isHome ? 'fa-map-marker-alt' : 'fa-building';
                            $badgeColor = $isHome ? 'bg-brand-secondary' : 'bg-gray-100';
                            $badgeTextColor = $isHome ? 'text-white' : 'text-gray-500';
                        ?>
                        <div class="border border-gray-200 bg-white rounded-xl p-5 relative hover:border-brand-secondary transition">
                            <div class="absolute top-0 right-0 <?php echo e($badgeColor); ?> <?php echo e($badgeTextColor); ?> text-[10px] font-bold px-3 py-1 rounded-bl-xl uppercase tracking-wider"><?php echo e($address->title); ?></div>
                            <div class="flex items-start mt-2">
                                <i class="fas <?php echo e($icon); ?> text-gray-400 mt-1 mr-3 text-lg"></i>
                                <div>
                                    <h4 class="font-bold text-gray-800"><?php echo e($address->title); ?> Address</h4>
                                    <p class="text-sm text-gray-500 font-medium mt-1 leading-relaxed"><?php echo e($address->full_address); ?>, <?php echo e($address->pincode); ?></p>
                                </div>
                            </div>
                            <div class="mt-4 pt-4 border-t border-gray-100 flex gap-4">
                                <button onclick="editAddress(this)" class="text-sm font-bold text-gray-500 hover:text-brand-secondary"><i class="far fa-edit mr-1"></i> Edit</button>
                                <button onclick="deleteAddress(this)" class="text-sm font-bold text-red-500 hover:text-red-700"><i class="far fa-trash-alt mr-1"></i> Delete</button>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function saveNewAddress() {
        let title = document.getElementById('newAddressTitle').value.trim();
        let address = document.getElementById('newAddressText').value.trim();
        let pincode = document.getElementById('newAddressPincode').value.trim();

        if (!title || !address || !pincode) {
            alert('Please fill all fields.');
            return;
        }

        fetch("<?php echo e(route('patient.add_address')); ?>", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
            },
            body: JSON.stringify({ title, address, pincode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Reload to show new address
                window.location.reload();
            } else {
                alert('Error saving address');
            }
        });
    }

    function deleteAddress(btn) {
        if (confirm('Are you sure you want to delete this address?')) {
            btn.closest('.relative').remove();
        }
    }

    function editAddress(btn) {
        let card = btn.closest('.relative');
        let title = card.querySelector('h4').innerText.replace(' Address', '');
        let fullAddress = card.querySelector('p').innerText;
        let parts = fullAddress.split(', ');
        let pincode = parts.pop();
        let addressStr = parts.join(', ');

        document.getElementById('newAddressTitle').value = title;
        document.getElementById('newAddressText').value = addressStr;
        document.getElementById('newAddressPincode').value = pincode;
        
        window.openAddAddressModal();
        
        // Remove old one so saving adds it fresh (mock update)
        card.remove();
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH D:\lab\lab\resources\views/patient/address-book.blade.php ENDPATH**/ ?>