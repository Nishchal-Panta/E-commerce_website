

<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-xl w-full">
    <!-- Card Container with Backdrop Blur -->
    <div class="card-responsive backdrop-blur-xl bg-white/80 dark:bg-gray-800/80 shadow-2xl border border-gray-200/50 dark:border-gray-700/50 p-6 sm:p-8 lg:p-10" 
        x-data="{ 
            showPassword: false, 
            showConfirm: false,
            password: '',
            strength: 0,
            strengthText: '',
            previewImage: null,
            calculateStrength() {
                let score = 0;
                if (this.password.length >= 8) score++;
                if (/[a-z]/.test(this.password)) score++;
                if (/[A-Z]/.test(this.password)) score++;
                if (/[0-9]/.test(this.password)) score++;
                if (/[@$!%*?&]/.test(this.password)) score++;
                
                this.strength = score;
                if (score <= 2) this.strengthText = 'Weak';
                else if (score <= 4) this.strengthText = 'Medium';
                else this.strengthText = 'Strong';
            },
            handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.previewImage = e.target.result;
                    };
                    reader.readAsDataURL(file);
                }
            }
        }">
        <!-- Logo/Icon -->
        <div class="flex justify-center mb-6">
            <div class="bg-gradient-to-br from-purple-600 to-pink-600 rounded-2xl p-4 shadow-lg">
                <i class="fas fa-user-plus text-white text-4xl"></i>
            </div>
        </div>
        
        <!-- Header -->
        <div class="text-center mb-8">
            <h2 class="heading-2 text-gray-900 dark:text-white mb-2">
                Join Our Community
            </h2>
            <p class="text-gray-600 dark:text-gray-400 text-sm">Create your account to start shopping</p>
        </div>
    
        <!-- Registration Form -->
        <form class="space-y-6" action="<?php echo e(route('register')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            
            <!-- Profile Photo -->
            <div class="flex flex-col items-center">
                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                    <i class="fas fa-camera text-indigo-600 dark:text-indigo-400 mr-2"></i>Profile Photo (Optional)
                </label>
                <div class="relative group">
                    <div x-show="!previewImage" 
                         class="w-28 h-28 sm:w-32 sm:h-32 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/30 dark:to-purple-900/30 flex items-center justify-center border-4 border-white dark:border-gray-700 shadow-lg group-hover:shadow-xl transition-all">
                        <i class="fas fa-user text-gray-400 dark:text-gray-500 text-4xl sm:text-5xl"></i>
                    </div>
                    <img x-show="previewImage" :src="previewImage" 
                         class="w-28 h-28 sm:w-32 sm:h-32 rounded-full object-cover border-4 border-white dark:border-gray-700 shadow-lg group-hover:shadow-xl transition-all" 
                         alt="Preview">
                    <label for="profile_photo" 
                           class="absolute bottom-0 right-0 bg-gradient-to-br from-indigo-600 to-purple-600 text-white rounded-full p-3 cursor-pointer hover:scale-110 shadow-lg hover:shadow-xl transition-all">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input id="profile_photo" name="profile_photo" type="file" accept="image/*" 
                        @change="handleFileSelect" class="hidden">
                </div>
                <?php $__errorArgs = ['profile_photo'];
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
        
            <!-- Form Fields Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">
                <!-- Username -->
                <div class="sm:col-span-2">
                    <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-user text-indigo-600 dark:text-indigo-400 mr-2"></i>Username
                    </label>
                    <input id="username" name="username" type="text" required 
                        value="<?php echo e(old('username')); ?>"
                        class="block w-full px-4 py-3 bg-white dark:bg-gray-900/50 border-2 <?php echo e($errors->has('username') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600'); ?> text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all" 
                        placeholder="Choose a unique username">
                    <?php $__errorArgs = ['username'];
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
                
                <!-- Email -->
                <div class="sm:col-span-2">
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
                
                <!-- Password -->
                <div class="sm:col-span-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock text-indigo-600 dark:text-indigo-400 mr-2"></i>Password
                    </label>
                    <div class="relative">
                        <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required 
                            x-model="password" @input="calculateStrength"
                            class="block w-full px-4 py-3 pr-12 bg-white dark:bg-gray-900/50 border-2 <?php echo e($errors->has('password') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600'); ?> text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all" 
                            placeholder="Min 8 characters">
                        <button type="button" @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                    
                    <!-- Password Strength Indicator -->
                    <div x-show="password.length > 0" class="mt-3">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="flex-1 h-2.5 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                                <div class="h-full transition-all duration-300 rounded-full"
                                    :class="{
                                        'w-1/5 bg-red-500': strength === 1,
                                        'w-2/5 bg-orange-500': strength === 2,
                                        'w-3/5 bg-yellow-500': strength === 3,
                                        'w-4/5 bg-lime-500': strength === 4,
                                        'w-full bg-green-500': strength === 5
                                    }"></div>
                            </div>
                            <span class="text-xs font-bold min-w-[60px]" 
                                :class="{
                                    'text-red-600 dark:text-red-400': strength <= 2,
                                    'text-yellow-600 dark:text-yellow-400': strength === 3 || strength === 4,
                                    'text-green-600 dark:text-green-400': strength === 5
                                }"
                                x-text="strengthText"></span>
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 flex items-start">
                            <i class="fas fa-info-circle mr-1 mt-0.5"></i>
                            <span>Include uppercase, lowercase, number, and special character</span>
                        </p>
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
                
                <!-- Confirm Password -->
                <div class="sm:col-span-2">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                        <i class="fas fa-lock text-indigo-600 dark:text-indigo-400 mr-2"></i>Confirm Password
                    </label>
                    <div class="relative">
                        <input id="password_confirmation" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" required 
                            class="block w-full px-4 py-3 pr-12 bg-white dark:bg-gray-900/50 border-2 border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 focus:border-transparent transition-all" 
                            placeholder="Confirm your password">
                        <button type="button" @click="showConfirm = !showConfirm" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Terms & Conditions -->
            <div class="flex items-start">
                <input id="terms" name="terms" type="checkbox" required
                    class="h-5 w-5 mt-0.5 text-indigo-600 dark:text-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400 <?php echo e($errors->has('terms') ? 'border-red-500 dark:border-red-400' : 'border-gray-300 dark:border-gray-600'); ?> rounded-lg bg-white dark:bg-gray-900/50">
                <label for="terms" class="ml-3 block text-sm text-gray-700 dark:text-gray-300">
                    I agree to the <a href="#" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 underline">Terms & Conditions</a> and <a href="#" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 underline">Privacy Policy</a>
                </label>
            </div>
            <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-600 dark:text-red-400 flex items-center">
                <i class="fas fa-exclamation-circle mr-1"></i><?php echo e($message); ?>

            </p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

            <!-- Submit Button -->
            <div class="pt-2">
                <button type="submit" 
                    class="btn-primary w-full py-3 sm:py-4 text-base font-semibold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 active:translate-y-0">
                    <span class="flex items-center justify-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Create My Account
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
                <span class="px-4 bg-white/80 dark:bg-gray-800/80 text-gray-500 dark:text-gray-400 font-medium">Already have an account?</span>
            </div>
        </div>
        
        <!-- Login Link -->
        <div class="text-center">
            <a href="<?php echo e(route('login')); ?>" 
               class="inline-flex items-center justify-center px-6 py-3 text-sm font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-700 dark:hover:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/20 hover:bg-indigo-100 dark:hover:bg-indigo-900/30 rounded-xl transition-all">
                <i class="fas fa-sign-in-alt mr-2"></i>
                Sign In Instead
            </a>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/auth/register.blade.php ENDPATH**/ ?>