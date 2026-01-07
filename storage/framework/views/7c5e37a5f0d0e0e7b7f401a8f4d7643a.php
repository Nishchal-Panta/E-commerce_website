

<?php $__env->startSection('title', 'Home - E-Commerce Platform'); ?>

<?php $__env->startSection('content'); ?>
<!-- Trending Products Carousel -->
<div class="mb-12" x-data="carousel()">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Trending Products</h2>
    
    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        <?php if($trendingProducts->count() > 0): ?>
        <div class="relative h-96">
            <?php $__currentLoopData = $trendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div x-show="currentSlide === <?php echo e($index); ?>" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                class="absolute inset-0 flex items-center justify-center p-8">
                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="flex flex-col md:flex-row items-center space-x-8">
                    <?php if($product->getPrimaryImage()): ?>
                    <img src="<?php echo e(asset('storage/' . $product->getPrimaryImage()->image_path)); ?>" 
                        class="w-64 h-64 object-cover rounded-lg shadow-md" alt="<?php echo e($product->name); ?>">
                    <?php endif; ?>
                    <div class="text-center md:text-left">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2"><?php echo e($product->name); ?></h3>
                        <p class="text-xl text-indigo-600 dark:text-indigo-400 font-semibold mb-4">$<?php echo e(number_format($product->price, 2)); ?></p>
                        <div class="flex items-center justify-center md:justify-start mb-4">
                            <?php for($i = 0; $i < 5; $i++): ?>
                                <i class="fas fa-star <?php echo e($i < $product->getAverageRating() ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
                            <?php endfor; ?>
                            <span class="ml-2 text-gray-600 dark:text-gray-400">(<?php echo e($product->getReviewCount()); ?> reviews)</span>
                        </div>
                        <button class="btn-primary">View Details</button>
                    </div>
                </a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        
        <!-- Navigation Arrows -->
        <button @click="prevSlide" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-700 rounded-full p-3 shadow-lg hover:bg-gray-100">
            <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300"></i>
        </button>
        <button @click="nextSlide" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-700 rounded-full p-3 shadow-lg hover:bg-gray-100">
            <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300"></i>
        </button>
        
        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            <?php $__currentLoopData = $trendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button @click="currentSlide = <?php echo e($index); ?>" 
                :class="currentSlide === <?php echo e($index); ?> ? 'bg-indigo-600' : 'bg-gray-400'"
                class="w-3 h-3 rounded-full"></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php else: ?>
        <div class="h-96 flex items-center justify-center">
            <p class="text-gray-500">No trending products available</p>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Filters -->
<div class="mb-8">
    <form method="GET" action="<?php echo e(route('products.index')); ?>" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category); ?>" <?php echo e(request('category') == $category ? 'selected' : ''); ?>>
                        <?php echo e($category); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <!-- Brand -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Brand</label>
                <select name="brand[]" multiple class="input-field h-20">
                    <?php $__currentLoopData = $brands; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($brand); ?>" <?php echo e(in_array($brand, (array)request('brand')) ? 'selected' : ''); ?>>
                        <?php echo e($brand); ?>

                    </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            
            <!-- Price Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Min Price</label>
                <input type="number" name="min_price" value="<?php echo e(request('min_price')); ?>" placeholder="$0" class="input-field">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Price</label>
                <input type="number" name="max_price" value="<?php echo e(request('max_price')); ?>" placeholder="$1000" class="input-field">
            </div>
            
            <!-- Actions -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="btn-primary flex-1">Apply</button>
                <a href="<?php echo e(route('products.index')); ?>" class="btn-secondary">Clear</a>
            </div>
        </div>
    </form>
</div>

<!-- Product Grid -->
<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">All Products</h2>
    
    <?php if($products->count() > 0): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
            <a href="<?php echo e(route('products.show', $product->id)); ?>">
                <?php if($product->getPrimaryImage()): ?>
                <img src="<?php echo e(asset('storage/' . $product->getPrimaryImage()->image_path)); ?>" 
                    class="w-full h-48 object-cover" alt="<?php echo e($product->name); ?>">
                <?php else: ?>
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                </div>
                <?php endif; ?>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 truncate"><?php echo e($product->name); ?></h3>
                    <p class="text-xl text-indigo-600 dark:text-indigo-400 font-bold mb-2">$<?php echo e(number_format($product->price, 2)); ?></p>
                    
                    <div class="flex items-center mb-3">
                        <?php for($i = 0; $i < 5; $i++): ?>
                            <i class="fas fa-star text-sm <?php echo e($i < $product->getAverageRating() ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
                        <?php endfor; ?>
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">(<?php echo e($product->getReviewCount()); ?>)</span>
                    </div>
                    
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isBuyer()): ?>
                        <form action="<?php echo e(route('cart.add')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full btn-primary text-sm" <?php echo e(!$product->isInStock() ? 'disabled' : ''); ?>>
                                <?php if($product->isInStock()): ?>
                                    <i class="fas fa-cart-plus mr-1"></i> Add to Cart
                                <?php else: ?>
                                    Out of Stock
                                <?php endif; ?>
                            </button>
                        </form>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </a>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    
    <!-- Pagination -->
    <div class="mt-8">
        <?php echo e($products->links()); ?>

    </div>
    <?php else: ?>
    <div class="text-center py-12">
        <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
        <p class="text-xl text-gray-600 dark:text-gray-400">No products found</p>
    </div>
    <?php endif; ?>
</div>

<script>
function carousel() {
    return {
        currentSlide: 0,
        totalSlides: <?php echo e($trendingProducts->count()); ?>,
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        init() {
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        }
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\laravel_project\resources\views/buyer/home.blade.php ENDPATH**/ ?>