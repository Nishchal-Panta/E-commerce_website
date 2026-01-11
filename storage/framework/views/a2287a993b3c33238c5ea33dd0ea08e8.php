

<?php $__env->startSection('title', 'Home - E-Commerce Platform'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
    <!-- Trending Products Carousel -->
    <div class="mb-8 lg:mb-12" x-data="carousel()">
        <h2 class="heading-2 text-gray-900 dark:text-white mb-4 lg:mb-6">Trending Products</h2>
        
        <div class="relative bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <?php if($trendingProducts->count() > 0): ?>
            <div class="relative h-[400px] sm:h-[450px] lg:h-[500px]">
                <?php $__currentLoopData = $trendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div x-show="currentSlide === <?php echo e($index); ?>" 
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform translate-x-full"
                    x-transition:enter-end="opacity-100 transform translate-x-0"
                    class="absolute inset-0 flex items-center justify-center p-6 lg:p-12">
                    <a href="<?php echo e(route('products.show', $product->id)); ?>" class="flex flex-col lg:flex-row items-center gap-6 lg:gap-12 w-full max-w-5xl">
                        <?php if($product->primaryImage): ?>
                        <div class="w-48 h-48 sm:w-56 sm:h-56 lg:w-72 lg:h-72 flex-shrink-0">
                            <img src="<?php echo e(asset('storage/' . $product->primaryImage->image_path)); ?>" 
                                class="w-full h-full object-cover rounded-xl shadow-xl" alt="<?php echo e($product->name); ?>">
                        </div>
                        <?php endif; ?>
                        <div class="text-center lg:text-left flex-1">
                            <h3 class="heading-2 text-gray-900 dark:text-white mb-3"><?php echo e($product->name); ?></h3>
                            <p class="text-2xl sm:text-3xl text-indigo-600 dark:text-indigo-400 font-bold mb-4">$<?php echo e(number_format($product->price, 2)); ?></p>
                            <div class="flex items-center justify-center lg:justify-start mb-6">
                                <?php for($i = 0; $i < 5; $i++): ?>
                                    <i class="fas fa-star text-lg <?php echo e($i < $product->getAverageRating() ? 'text-yellow-400' : 'text-gray-300'); ?>"></i>
                                <?php endfor; ?>
                                <span class="ml-3 text-gray-600 dark:text-gray-400">(<?php echo e($product->getReviewCount()); ?> reviews)</span>
                            </div>
                            <button class="btn-primary">View Details</button>
                        </div>
                    </a>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            
            <!-- Navigation Arrows -->
            <button @click="prevSlide" class="absolute left-2 sm:left-4 top-1/2 transform -translate-y-1/2 touch-target bg-white dark:bg-gray-700 rounded-full shadow-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all z-10">
                <i class="fas fa-chevron-left text-gray-700 dark:text-gray-300"></i>
            </button>
            <button @click="nextSlide" class="absolute right-2 sm:right-4 top-1/2 transform -translate-y-1/2 touch-target bg-white dark:bg-gray-700 rounded-full shadow-xl hover:bg-gray-50 dark:hover:bg-gray-600 transition-all z-10">
                <i class="fas fa-chevron-right text-gray-700 dark:text-gray-300"></i>
            </button>
            
            <!-- Dots -->
            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2">
                <?php $__currentLoopData = $trendingProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button @click="currentSlide = <?php echo e($index); ?>" 
                    :class="currentSlide === <?php echo e($index); ?> ? 'bg-indigo-600 w-8' : 'bg-gray-400 w-3'"
                    class="h-3 rounded-full transition-all duration-300"></button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
            <?php else: ?>
            <div class="h-[400px] flex items-center justify-center">
                <p class="text-gray-500 dark:text-gray-400">No trending products available</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Products by Category -->
    <div class="space-y-8">
        <h2 class="heading-2 text-gray-900 dark:text-white">Shop by Category</h2>
        
        <?php $__currentLoopData = $productsByCategory; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="card-responsive border-l-4 border-indigo-600 dark:border-indigo-400">
            <div class="p-4 sm:p-6">
                <!-- Category Header -->
                <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-6 gap-4">
                    <div class="flex items-center gap-4">
                        <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl p-3 sm:p-4">
                            <i class="fas fa-box text-white text-xl sm:text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="heading-3 text-gray-900 dark:text-white"><?php echo e(ucfirst($category)); ?></h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><?php echo e($data['count']); ?> <?php echo e(Str::plural('item', $data['count'])); ?></p>
                        </div>
                    </div>
                    <a href="<?php echo e(route('products.index', ['category' => $category])); ?>" 
                       class="btn-primary w-full sm:w-auto text-center">
                        View All <i class="fas fa-arrow-right ml-2"></i>
                    </a>
                </div>
                
                <!-- Products Carousel -->
                <div class="relative" x-data="{ scrollPosition: 0 }">
                    <button @click="$refs.productScroll<?php echo e($loop->index); ?>.scrollBy({ left: -280, behavior: 'smooth' })" 
                            class="hidden sm:flex absolute left-0 top-1/2 -translate-y-1/2 z-10 touch-target bg-white dark:bg-gray-700 rounded-full shadow-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                        <i class="fas fa-chevron-left text-gray-700 dark:text-white"></i>
                    </button>
                    
                    <div x-ref="productScroll<?php echo e($loop->index); ?>" 
                         class="flex gap-4 overflow-x-auto scroll-smooth scrollbar-hide pb-4 sm:px-12">
                        <?php $__currentLoopData = $data['products']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="flex-shrink-0 w-40 sm:w-48 lg:w-56">
                            <a href="<?php echo e(route('products.show', $product->id)); ?>" class="block group">
                                <div class="card-responsive p-3">
                                    <div class="product-image-container mb-3">
                                        <?php if($product->images->count() > 0): ?>
                                        <img src="<?php echo e(asset('storage/' . $product->images->first()->image_path)); ?>" 
                                             alt="<?php echo e($product->name); ?>" 
                                             class="product-image">
                                        <?php else: ?>
                                        <div class="absolute inset-0 flex items-center justify-center text-gray-400">
                                            <i class="fas fa-image text-3xl"></i>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white text-sm line-clamp-2 mb-2"><?php echo e($product->name); ?></h4>
                                    <div class="flex items-center justify-between">
                                        <p class="text-lg font-bold text-indigo-600 dark:text-indigo-400">$<?php echo e(number_format($product->price, 2)); ?></p>
                                        <?php if($product->getAverageRating() > 0): ?>
                                        <div class="flex items-center">
                                            <i class="fas fa-star text-yellow-400 text-xs"></i>
                                            <span class="text-xs text-gray-600 dark:text-gray-400 ml-1"><?php echo e(number_format($product->getAverageRating(), 1)); ?></span>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    
                    <button @click="$refs.productScroll<?php echo e($loop->index); ?>.scrollBy({ left: 280, behavior: 'smooth' })" 
                            class="hidden sm:flex absolute right-0 top-1/2 -translate-y-1/2 z-10 touch-target bg-white dark:bg-gray-700 rounded-full shadow-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-all">
                        <i class="fas fa-chevron-right text-gray-700 dark:text-white"></i>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/buyer/home.blade.php ENDPATH**/ ?>