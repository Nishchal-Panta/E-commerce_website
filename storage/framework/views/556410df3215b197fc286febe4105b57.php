<!DOCTYPE html>
<html lang="en" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" :class="{ 'dark': darkMode }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo $__env->yieldContent('title', 'E-Commerce Platform'); ?></title>
    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen">
    <!-- Header -->
    <header class="bg-white dark:bg-gray-800 shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <!-- Top Bar -->
            <div class="flex items-center justify-between py-4">
                <!-- Logo -->
                <a href="<?php echo e(route('home')); ?>" class="text-2xl font-bold text-indigo-600 dark:text-indigo-400">
                    <i class="fas fa-shopping-bag"></i> E-Shop
                </a>
                
                <!-- Search Bar -->
                <form action="<?php echo e(route('products.index')); ?>" method="GET" class="flex-1 max-w-2xl mx-8">
                    <div class="relative">
                        <input type="text" name="search" placeholder="Search products..." 
                            value="<?php echo e(request('search')); ?>"
                            class="w-full px-4 py-2 pr-10 rounded-lg border border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-2 focus:ring-indigo-500 focus:border-transparent">
                        <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-indigo-600">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
                
                <!-- Right Icons -->
                <div class="flex items-center space-x-6">
                    <!-- Cart -->
                    <?php if(auth()->guard()->check()): ?>
                        <?php if(auth()->user()->isBuyer()): ?>
                        <a href="<?php echo e(route('cart.index')); ?>" class="relative text-gray-700 dark:text-gray-300 hover:text-indigo-600">
                            <i class="fas fa-shopping-cart text-2xl"></i>
                            <?php if($cartCount > 0): ?>
                            <span class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-5 w-5 flex items-center justify-center">
                                <?php echo e($cartCount); ?>

                            </span>
                            <?php endif; ?>
                        </a>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                    <!-- User Menu -->
                    <?php if(auth()->guard()->check()): ?>
                    <div x-data="{ open: false }" class="relative">
                        <button @click="open = !open" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-indigo-600">
                            <?php if(auth()->user()->profile_photo): ?>
                            <img src="<?php echo e(asset('storage/' . auth()->user()->profile_photo)); ?>" class="w-8 h-8 rounded-full object-cover" alt="Profile">
                            <?php else: ?>
                            <div class="w-8 h-8 rounded-full bg-indigo-600 flex items-center justify-center text-white">
                                <?php echo e(substr(auth()->user()->username, 0, 1)); ?>

                            </div>
                            <?php endif; ?>
                            <span class="font-medium"><?php echo e(auth()->user()->username); ?></span>
                            <i class="fas fa-chevron-down text-sm"></i>
                        </button>
                        
                        <div x-show="open" @click.away="open = false" 
                            class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg py-2 z-50">
                            <?php if(auth()->user()->isBuyer()): ?>
                            <a href="<?php echo e(route('account.edit')); ?>" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-user mr-2"></i> Account Settings
                            </a>
                            <a href="<?php echo e(route('orders.index')); ?>" class="block px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-box mr-2"></i> My Orders
                            </a>
                            <?php endif; ?>
                            <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" 
                                class="w-full text-left px-4 py-2 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <i class="fas fa-moon mr-2"></i> <span x-text="darkMode ? 'Light Mode' : 'Dark Mode'"></span>
                            </button>
                            <hr class="my-2 border-gray-200 dark:border-gray-700">
                            <form action="<?php echo e(route('logout')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100 dark:hover:bg-gray-700">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <?php else: ?>
                    <a href="<?php echo e(route('login')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">
                        <i class="fas fa-sign-in-alt mr-1"></i> Login
                    </a>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="border-t border-gray-200 dark:border-gray-700 py-3">
                <ul class="flex space-x-8">
                    <li><a href="<?php echo e(route('home')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">Home</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">Products</a></li>
                    <li><a href="<?php echo e(route('faq.index')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">FAQ</a></li>
                    <?php if(auth()->guard()->check()): ?>
                    <li><a href="<?php echo e(route('report.create')); ?>" class="text-gray-700 dark:text-gray-300 hover:text-indigo-600">Report Issue</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <!-- Flash Messages -->
    <?php if(session('success')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
        class="fixed top-20 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <i class="fas fa-check-circle mr-2"></i> <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
        class="fixed top-20 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <i class="fas fa-exclamation-circle mr-2"></i> <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>
    
    <!-- Main Content -->
    <main class="container mx-auto px-4 py-8">
        <?php echo $__env->yieldContent('content'); ?>
    </main>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white mt-16">
        <div class="container mx-auto px-4 py-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Company Info -->
                <div>
                    <h3 class="text-xl font-bold mb-4">E-Shop</h3>
                    <p class="text-gray-400">Your trusted online shopping platform</p>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-bold mb-4">Contact Us</h4>
                    <ul class="space-y-2 text-gray-400">
                        <?php if($siteSettings->phone_number): ?>
                        <li><a href="tel:<?php echo e($siteSettings->phone_number); ?>" class="hover:text-white">
                            <i class="fas fa-phone mr-2"></i><?php echo e($siteSettings->phone_number); ?>

                        </a></li>
                        <?php endif; ?>
                        <?php if($siteSettings->admin_email): ?>
                        <li><a href="mailto:<?php echo e($siteSettings->admin_email); ?>" class="hover:text-white">
                            <i class="fas fa-envelope mr-2"></i><?php echo e($siteSettings->admin_email); ?>

                        </a></li>
                        <?php endif; ?>
                        <?php if($siteSettings->location): ?>
                        <li><i class="fas fa-map-marker-alt mr-2"></i><?php echo e($siteSettings->location); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-gray-400">
                        <li><a href="<?php echo e(route('faq.index')); ?>" class="hover:text-white">FAQ</a></li>
                        <li><a href="<?php echo e(route('report.create')); ?>" class="hover:text-white">Report Issue</a></li>
                        <li><a href="#" class="hover:text-white">Terms & Conditions</a></li>
                        <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
                    </ul>
                </div>
                
                <!-- Social Media -->
                <div>
                    <h4 class="font-bold mb-4">Follow Us</h4>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white text-2xl"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            
            <div class="border-t border-gray-700 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; <?php echo e(date('Y')); ?> E-Shop. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\LENOVO\Downloads\laravel_project\resources\views/layouts/app.blade.php ENDPATH**/ ?>