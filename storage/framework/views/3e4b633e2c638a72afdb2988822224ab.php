

<?php $__env->startSection('title', 'Checkout'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Checkout</h1>
    
    <form action="<?php echo e(route('buyer.orders.store')); ?>" method="POST">
        <?php echo csrf_field(); ?>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Checkout Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Shipping Address -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6" x-data="shippingLocationPicker()">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Shipping Address</h2>
                    
                    <div class="mb-4">
                        <div id="shipping-map" class="h-64 rounded-lg border border-gray-300 dark:border-gray-600 mb-2"></div>
                        <button @click="getCurrentLocation()" type="button"
                                class="text-sm text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                            </svg>
                            Use my current location
                        </button>
                    </div>
                    
                    <input type="hidden" id="latitude" name="latitude" x-model="latitude">
                    <input type="hidden" id="longitude" name="longitude" x-model="longitude">
                    
                    <textarea name="shipping_address" rows="3" x-model="address" required
                        class="input-field <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                        placeholder="Click on map or type your complete shipping address"><?php echo e(old('shipping_address')); ?></textarea>
                    <?php $__errorArgs = ['shipping_address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">Click on the map to select your delivery location</p>
                </div>
                
                <!-- Payment Method -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Payment Method</h2>
                    
                    <div class="space-y-3">
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <input type="radio" name="payment_method" value="card" required class="mr-3">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Credit/Debit Card</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Pay securely with your card</p>
                            </div>
                        </label>
                        
                        <label class="flex items-center p-4 border border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700">
                            <input type="radio" name="payment_method" value="cash_on_delivery" required class="mr-3">
                            <div>
                                <p class="font-semibold text-gray-900 dark:text-white">Cash on Delivery</p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Pay when you receive</p>
                            </div>
                        </label>
                    </div>
                    <?php $__errorArgs = ['payment_method'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Order Items -->
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Items</h2>
                    <div class="space-y-4">
                        <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex items-center space-x-4 pb-4 border-b border-gray-200 dark:border-gray-700">
                            <?php if($item->product->getPrimaryImage()): ?>
                            <img src="<?php echo e(asset('storage/' . $item->product->getPrimaryImage()->image_path)); ?>" 
                                class="w-16 h-16 object-cover rounded-lg" alt="<?php echo e($item->product->name); ?>">
                            <?php endif; ?>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 dark:text-white"><?php echo e($item->product->name); ?></p>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: <?php echo e($item->quantity); ?></p>
                            </div>
                            <p class="font-bold text-gray-900 dark:text-white">$<?php echo e(number_format($item->getSubtotal(), 2)); ?></p>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
            
            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-20">
                    <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Summary</h2>
                    
                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Subtotal</span>
                            <span>$<?php echo e(number_format($subtotal, 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Tax (10%)</span>
                            <span>$<?php echo e(number_format($tax, 2)); ?></span>
                        </div>
                        <div class="flex justify-between text-gray-700 dark:text-gray-300">
                            <span>Shipping</span>
                            <span><?php echo e($shipping == 0 ? 'FREE' : '$' . number_format($shipping, 2)); ?></span>
                        </div>
                        <hr class="border-gray-300 dark:border-gray-600">
                        <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-white">
                            <span>Total</span>
                            <span>$<?php echo e(number_format($total, 2)); ?></span>
                        </div>
                    </div>
                    
                    <button type="submit" class="w-full btn-primary mb-3">
                        <i class="fas fa-lock mr-2"></i> Place Order
                    </button>
                    <a href="<?php echo e(route('buyer.cart.index')); ?>" class="block w-full btn-secondary text-center">
                        Back to Cart
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('shippingLocationPicker', () => ({
        latitude: 27.7172,
        longitude: 85.3240,
        address: '<?php echo e(old("shipping_address")); ?>',
        map: null,
        marker: null,
        
        init() {
            setTimeout(() => {
                this.initMap();
            }, 100);
        },
        
        initMap() {
            if (typeof L === 'undefined') {
                console.error('Leaflet not loaded');
                return;
            }
            
            this.map = L.map('shipping-map').setView([this.latitude, this.longitude], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(this.map);
            
            this.marker = L.marker([this.latitude, this.longitude], {
                draggable: true
            }).addTo(this.map);
            
            this.map.on('click', (e) => {
                this.updateLocation(e.latlng.lat, e.latlng.lng);
            });
            
            this.marker.on('dragend', (e) => {
                const pos = e.target.getLatLng();
                this.updateLocation(pos.lat, pos.lng);
            });
        },
        
        updateLocation(lat, lng) {
            this.latitude = lat.toFixed(6);
            this.longitude = lng.toFixed(6);
            this.marker.setLatLng([lat, lng]);
            this.getAddress(lat, lng);
        },
        
        async getAddress(lat, lng) {
            try {
                const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                const data = await response.json();
                if (data.display_name) {
                    this.address = data.display_name;
                }
            } catch (error) {
                console.error('Error fetching address:', error);
            }
        },
        
        getCurrentLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition((position) => {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    this.map.setView([lat, lng], 15);
                    this.updateLocation(lat, lng);
                }, (error) => {
                    alert('Unable to get your location: ' + error.message);
                });
            } else {
                alert('Geolocation is not supported by your browser');
            }
        }
    }));
});
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\laravel_project\resources\views/buyer/checkout.blade.php ENDPATH**/ ?>