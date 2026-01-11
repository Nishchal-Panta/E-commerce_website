

<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-md w-full">
    <!-- Card Container with Backdrop Blur -->
    <div class="card-responsive backdrop-blur-xl bg-white/80 dark:bg-gray-800/80 shadow-2xl border border-gray-200/50 dark:border-gray-700/50 p-6 sm:p-8 lg:p-10">
        <!-- Logo/Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-2xl p-4 shadow-lg">
                <i class="fas fa-shopping-bag text-white text-4xl"></i>
            </div>
        </div>
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="heading-2 text-gray-900 dark:text-white mb-2">
                Welcome Back
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Sign in to continue shopping</p>
        </div>
    
        <!-- Login Form -->
        <form class="space-y-6" action="<?php echo e(route('login')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            
            <div class="space-y-4">
                <!-- Email Field -->
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-envelope text-indigo-600 dark:text-indigo-400 mr-2"></i>Email Address
                    </label>
                    <input id="email" name="email" type="email" required 
                        value="<?php echo e(old('email')); ?>"
                        class="block w-full px-4 py-3 bg-white dark:bg-gray-900/50 border-2 <?php echo e($errors->has('email') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600'); ?> text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all" 
                        placeholder="your.email@example.com">
                    <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                    </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                
                <!-- Password Field -->
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock text-indigo-600 dark:text-indigo-400 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required 
                            class="block w-full px-4 py-3 pr-12 bg-white dark:bg-gray-900/50 border-2 <?php echo e($errors->has('password') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600'); ?> text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all" 
                            placeholder="Enter your password">
                        <button type="button" @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-2 text-sm text-red-600 dark:text-red-400 flex items-center">
                        <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

                    </p>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" 
                    class="h-5 w-5 text-indigo-600 dark:text-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 border-gray-300 dark:border-gray-600 rounded-lg bg-white dark:bg-gray-900/50">
                <label for="remember" class="ml-3 block text-sm font-medium text-gray-700 dark:text-gray-300">
                    Keep me signed in
                </label>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit" 
                    class="btn-primary w-full py-3 sm:py-4 text-base font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0">
                    <span class="flex items-center justify-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Sign In
                    </span>
                </button>
            </div>
        </form>
        
        <!-- Divider -->
        <div class="relative my-6">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
            </div>
            <div class="relative flex justify-center text-sm">
                <span class="px-4 bg-white/80 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 font-medium">New to our platform?</span>
            </div>
        </div>
        
        <!-- Register Link -->
        <div class="text-center">
            <a href="<?php echo e(route('register')); ?>" 
               class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-xl transition-all">
                <i class="fas fa-user-plus mr-2"></i>
                Create Your Account
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/auth/login.blade.php ENDPATH**/ ?>