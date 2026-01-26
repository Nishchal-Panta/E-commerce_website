

<?php $__env->startSection('content'); ?>
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="<?php echo e(route('buyer.orders.show', $orderItem->order->id)); ?>" class="text-blue-600 dark:text-blue-400 hover:text-blue-900 dark:hover:text-blue-300 mb-4 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Order
            </a>
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Request Return</h1>
            <p class="text-gray-600 dark:text-gray-300 mt-2">Let us know why you'd like to return this item</p>
        </div>

        <!-- Product Info Card -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden mb-6">
            <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Product Information</h2>
                <div class="flex items-start gap-4">
                    <?php if($orderItem->product->images && $orderItem->product->images->first()): ?>
                        <img src="<?php echo e(asset('storage/' . $orderItem->product->images->first()->image_path)); ?>" 
                             alt="<?php echo e($orderItem->product->name); ?>"
                             class="w-24 h-24 object-cover rounded-lg">
                    <?php else: ?>
                        <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    <?php endif; ?>
                    <div class="flex-1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white"><?php echo e($orderItem->product->name); ?></h3>
                        <p class="text-gray-600 dark:text-gray-400 text-sm mt-1">Order #<?php echo e($orderItem->order->id); ?></p>
                        <p class="text-gray-900 dark:text-white font-medium mt-2">
                            Quantity: <?php echo e($orderItem->quantity); ?> × $<?php echo e(number_format($orderItem->price, 2)); ?>

                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Return Form -->
        <form action="<?php echo e(route('buyer.returns.store')); ?>" method="POST" class="bg-white dark:bg-gray-800 rounded-lg shadow overflow-hidden">
            <?php echo csrf_field(); ?>

            <input type="hidden" name="order_item_id" value="<?php echo e($orderItem->id); ?>">

            <!-- Predefined Reasons -->
            <div class="px-6 py-6 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Select Return Reason</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">Choose one of our predefined reasons:</p>

                <div class="space-y-3">
                    <?php $__empty_1 = true; $__currentLoopData = $returnReasons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reason): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <label class="flex items-start p-4 border border-gray-200 dark:border-gray-600 rounded-lg cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                            <input type="radio" name="return_reason_id" value="<?php echo e($reason->id); ?>" 
                                   class="mt-1 h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 dark:border-gray-600"
                                   <?php echo e(old('return_reason_id') == $reason->id ? 'checked' : ''); ?>>
                            <div class="ml-3 flex-1">
                                <span class="font-medium text-gray-900 dark:text-white"><?php echo e($reason->name); ?></span>
                                <?php if($reason->description): ?>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 mt-1"><?php echo e($reason->description); ?></p>
                                <?php endif; ?>
                            </div>
                        </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <p class="text-gray-600 dark:text-gray-400">No predefined reasons available</p>
                    <?php endif; ?>
                </div>

                <?php $__errorArgs = ['return_reason_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 text-sm mt-2"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- Custom Reason -->
            <div class="px-6 py-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Additional Details</h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    Tell us more about why you're returning this item (optional). This helps us improve our products and service.
                </p>

                <textarea name="custom_reason" 
                          rows="6"
                          placeholder="Please provide any additional details about your return..."
                          class="w-full px-4 py-3 border border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none <?php $__errorArgs = ['custom_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                          <?php echo e(old('custom_reason')); ?>><?php echo e(old('custom_reason')); ?></textarea>

                <?php $__errorArgs = ['custom_reason'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="text-red-600 dark:text-red-400 text-sm mt-2"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Maximum 1000 characters</p>
            </div>

            <!-- Info Box -->
            <div class="px-6 py-6 border-t border-gray-200 dark:border-gray-700">
                <div class="flex items-start gap-3">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                    </svg>
                    <div class="text-sm">
                        <p class="font-semibold text-gray-900 dark:text-white">Return Policy Information</p>
                        <ul class="list-disc list-inside mt-2 space-y-1 text-gray-700 dark:text-gray-300">
                            <li>Orders must be returned within 30 days of delivery</li>
                            <li>Items must be unused and in original condition</li>
                            <li>Admin approval is required before processing returns</li>
                            <li>A refund will be issued once we receive and inspect your return</li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-6 bg-gray-100 dark:bg-gray-700 border-t border-gray-200 dark:border-gray-700 flex gap-3">
                <a href="<?php echo e(route('buyer.orders.show', $orderItem->order->id)); ?>" 
                   class="flex-1 px-4 py-3 bg-red-600 hover:bg-red-700 dark:bg-red-600 dark:hover:bg-red-700 rounded-lg text-white font-semibold shadow-md hover:shadow-lg text-center transition-all duration-200">
                    Cancel
                </a>
                <button type="submit" 
                        class="flex-1 px-4 py-3 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 dark:from-indigo-600 dark:to-purple-600 dark:hover:from-indigo-700 dark:hover:to-purple-700 text-white rounded-lg font-semibold shadow-lg hover:shadow-xl transition-all duration-200">
                    Submit Return Request
                </button>
            </div>
        </form>

        <?php if($errors->any()): ?>
            <div class="mt-6 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 rounded-lg p-4">
                <p class="text-red-800 dark:text-red-200 font-semibold mb-2">Please fix the following errors:</p>
                <ul class="list-disc list-inside space-y-1 text-red-700 dark:text-red-300">
                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li><?php echo e($error); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/buyer/returns/create.blade.php ENDPATH**/ ?>