

<?php $__env->startSection('title', 'Admin Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-3xl font-bold text-gray-900 mb-8">Dashboard</h1>

<!-- Statistics Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Products</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_products']); ?></p>
            </div>
            <div class="bg-indigo-100 rounded-full p-3">
                <i class="fas fa-box text-indigo-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Orders</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['total_orders']); ?></p>
            </div>
            <div class="bg-blue-100 rounded-full p-3">
                <i class="fas fa-shopping-cart text-blue-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Total Revenue</p>
                <p class="text-3xl font-bold text-gray-900">$<?php echo e(number_format($stats['total_revenue'], 2)); ?></p>
            </div>
            <div class="bg-green-100 rounded-full p-3">
                <i class="fas fa-dollar-sign text-green-600 text-2xl"></i>
            </div>
        </div>
    </div>
    
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-gray-500 text-sm">Pending Orders</p>
                <p class="text-3xl font-bold text-gray-900"><?php echo e($stats['pending_orders']); ?></p>
            </div>
            <div class="bg-yellow-100 rounded-full p-3">
                <i class="fas fa-clock text-yellow-600 text-2xl"></i>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
    <!-- Best Selling Products Chart -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-bold text-gray-900 mb-4">Best Selling Products</h2>
        <canvas id="bestSellingChart"></canvas>
    </div>
    
    <!-- Low Stock Alert -->
    <div class="bg-white rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Low Stock Alert</h2>
            <?php if($lowStockCount > 0): ?>
            <span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">
                <?php echo e($lowStockCount); ?> items
            </span>
            <?php endif; ?>
        </div>
        <a href="<?php echo e(route('admin.inventory.index')); ?>" class="btn-primary">
            <i class="fas fa-warehouse mr-2"></i> View Inventory
        </a>
    </div>
</div>

<!-- Recent Orders -->
<div class="bg-white rounded-lg shadow-md p-6 mb-8">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Recent Orders</h2>
        <a href="<?php echo e(route('admin.orders.index')); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
            View All Orders <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Order ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Customer</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Items</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $recentOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <a href="<?php echo e(route('admin.orders.show', $order->id)); ?>" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                            #<?php echo e($order->id); ?>

                        </a>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap"><?php echo e($order->buyer->username); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?php echo e($order->items->count()); ?> items</td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">$<?php echo e(number_format($order->total_amount, 2)); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 py-1 text-xs rounded-full <?php echo e($order->getStatusBadgeClass()); ?>">
                            <?php echo e(ucfirst($order->status)); ?>

                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?php echo e($order->created_at->format('M d, Y H:i')); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-inbox text-4xl mb-2"></i>
                        <p>No orders yet</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Recent Restocks -->
<div class="bg-white rounded-lg shadow-md p-6">
    <div class="flex items-center justify-between mb-4">
        <h2 class="text-xl font-bold text-gray-900">Recent Restocks (Last 7 Days)</h2>
        <a href="<?php echo e(route('admin.inventory.index')); ?>" class="text-indigo-600 hover:text-indigo-800 text-sm font-semibold">
            View Inventory <i class="fas fa-arrow-right ml-1"></i>
        </a>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Product</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Current Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Last Updated</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__empty_1 = true; $__currentLoopData = $recentRestocks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">
                        <div class="flex items-center">
                            <?php if($product->images->count() > 0): ?>
                            <img src="<?php echo e(Storage::url($product->images->first()->image_path)); ?>" 
                                 alt="<?php echo e($product->name); ?>" 
                                 class="w-12 h-12 object-cover rounded-lg mr-3">
                            <?php else: ?>
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center mr-3">
                                <i class="fas fa-image text-gray-400"></i>
                            </div>
                            <?php endif; ?>
                            <span class="font-medium text-gray-900"><?php echo e($product->name); ?></span>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?php echo e($product->category); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap font-semibold text-gray-900">$<?php echo e(number_format($product->price, 2)); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="font-bold text-green-600"><?php echo e($product->inventory_quantity); ?></span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-500"><?php echo e($product->updated_at->diffForHumans()); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                        <i class="fas fa-box-open text-4xl mb-2"></i>
                        <p>No recent restocks in the last 7 days</p>
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<script>
const ctx = document.getElementById('bestSellingChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php $__currentLoopData = $bestSelling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>'<?php echo e($item->product->name); ?>',<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
        datasets: [{
            label: 'Units Sold',
            data: [<?php $__currentLoopData = $bestSelling; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($item->total_sold); ?>,<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>],
            backgroundColor: 'rgba(79, 70, 229, 0.8)',
            borderColor: 'rgba(79, 70, 229, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/admin/dashboard.blade.php ENDPATH**/ ?>