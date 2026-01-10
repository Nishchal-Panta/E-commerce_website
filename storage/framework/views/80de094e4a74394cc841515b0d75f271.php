

<?php $__env->startSection('title', 'Manage Products'); ?>

<?php $__env->startSection('content'); ?>
<h1 class="text-3xl font-bold text-gray-900 mb-8">Manage Products</h1>

<!-- Search -->
<div class="bg-white rounded-lg shadow-md p-4 mb-6">
    <form method="GET" action="<?php echo e(route('admin.products.index')); ?>" class="flex space-x-4">
        <input type="text" name="search" value="<?php echo e(request('search')); ?>" 
            placeholder="Search products..." class="input-field flex-1">
        <button type="submit" class="btn-primary">Search</button>
    </form>
</div>

<!-- Products Table -->
<div class="bg-white rounded-lg shadow-md overflow-hidden">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Image</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Price</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Stock</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Category</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="px-6 py-4 whitespace-nowrap">
                    <?php if($product->getPrimaryImage()): ?>
                    <img src="<?php echo e(asset('storage/' . $product->getPrimaryImage()->image_path)); ?>" 
                        class="w-12 h-12 object-cover rounded" alt="<?php echo e($product->name); ?>">
                    <?php endif; ?>
                </td>
                <td class="px-6 py-4"><?php echo e($product->name); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">$<?php echo e(number_format($product->price, 2)); ?></td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-2 py-1 text-xs rounded-full <?php echo e($product->isLowStock() ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800'); ?>">
                        <?php echo e($product->inventory_quantity); ?>

                    </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap"><?php echo e($product->category); ?></td>
                <td class="px-6 py-4 whitespace-nowrap space-x-2">
                    <a href="<?php echo e(route('admin.products.edit', $product->id)); ?>" class="text-indigo-600 hover:text-indigo-900">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="<?php echo e(route('admin.products.destroy', $product->id)); ?>" method="POST" class="inline" 
                        onsubmit="return confirm('Are you sure you want to delete this product?');">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-red-600 hover:text-red-900">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>

<div class="mt-6">
    <?php echo e($products->links()); ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\laravel_project\resources\views/admin/products.blade.php ENDPATH**/ ?>