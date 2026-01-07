

<?php $__env->startSection('title', 'Register'); ?>

<?php $__env->startSection('content'); ?>
<div class="max-w-md w-full space-y-8 bg-white p-8 rounded-lg shadow-md" 
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
    <div>
        <h2 class="text-center text-3xl font-extrabold text-gray-900">
            Create your account
        </h2>
    </div>
    
    <form class="mt-8 space-y-6" action="<?php echo e(route('register')); ?>" method="POST" enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        
        <!-- Profile Photo -->
        <div class="flex flex-col items-center">
            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Photo (Optional)</label>
            <div class="relative">
                <div x-show="!previewImage" class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-user text-gray-400 text-3xl"></i>
                </div>
                <img x-show="previewImage" :src="previewImage" class="w-24 h-24 rounded-full object-cover" alt="Preview">
                <label for="profile_photo" class="absolute bottom-0 right-0 bg-indigo-600 text-white rounded-full p-2 cursor-pointer hover:bg-indigo-700">
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
            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        
        <div class="space-y-4">
            <!-- Username -->
            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input id="username" name="username" type="text" required 
                    value="<?php echo e(old('username')); ?>"
                    class="mt-1 block w-full px-3 py-2 border <?php echo e($errors->has('username') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Username (3-20 characters, alphanumeric)">
                <?php $__errorArgs = ['username'];
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
            
            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email address</label>
                <input id="email" name="email" type="email" required 
                    value="<?php echo e(old('email')); ?>"
                    class="mt-1 block w-full px-3 py-2 border <?php echo e($errors->has('email') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                    placeholder="Email address">
                <?php $__errorArgs = ['email'];
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
            
            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <div class="mt-1 relative">
                    <input id="password" name="password" :type="showPassword ? 'text' : 'password'" required 
                        x-model="password" @input="calculateStrength"
                        class="block w-full px-3 py-2 border <?php echo e($errors->has('password') ? 'border-red-500' : 'border-gray-300'); ?> rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="Min 8 characters">
                    <button type="button" @click="showPassword = !showPassword" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-500"></i>
                    </button>
                </div>
                
                <!-- Password Strength Indicator -->
                <div x-show="password.length > 0" class="mt-2">
                    <div class="flex items-center space-x-2">
                        <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                            <div class="h-full transition-all duration-300"
                                :class="{
                                    'w-1/5 bg-red-500': strength === 1,
                                    'w-2/5 bg-orange-500': strength === 2,
                                    'w-3/5 bg-yellow-500': strength === 3,
                                    'w-4/5 bg-lime-500': strength === 4,
                                    'w-full bg-green-500': strength === 5
                                }"></div>
                        </div>
                        <span class="text-xs font-medium" 
                            :class="{
                                'text-red-600': strength <= 2,
                                'text-yellow-600': strength === 3 || strength === 4,
                                'text-green-600': strength === 5
                            }"
                            x-text="strengthText"></span>
                    </div>
                    <p class="mt-1 text-xs text-gray-500">
                        Password must contain uppercase, lowercase, number, and special character
                    </p>
                </div>
                <?php $__errorArgs = ['password'];
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
            
            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <div class="mt-1 relative">
                    <input id="password_confirmation" name="password_confirmation" :type="showConfirm ? 'text' : 'password'" required 
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" 
                        placeholder="Confirm password">
                    <button type="button" @click="showConfirm = !showConfirm" 
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-sm leading-5">
                        <i :class="showConfirm ? 'fas fa-eye-slash' : 'fas fa-eye'" class="text-gray-500"></i>
                    </button>
                </div>
            </div>
            
            <!-- Terms & Conditions -->
            <div class="flex items-center">
                <input id="terms" name="terms" type="checkbox" required
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 <?php echo e($errors->has('terms') ? 'border-red-500' : 'border-gray-300'); ?> rounded">
                <label for="terms" class="ml-2 block text-sm text-gray-900">
                    I agree to the <a href="#" class="text-indigo-600 hover:text-indigo-500">Terms & Conditions</a>
                </label>
            </div>
            <?php $__errorArgs = ['terms'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <p class="text-sm text-red-600"><?php echo e($message); ?></p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <div>
            <button type="submit" 
                class="w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-150">
                Create Account
            </button>
        </div>
        
        <div class="text-center">
            <p class="text-sm text-gray-600">
                Already have an account? 
                <a href="<?php echo e(route('login')); ?>" class="font-medium text-indigo-600 hover:text-indigo-500">
                    Login here
                </a>
            </p>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.guest', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\LENOVO\Downloads\laravel_project\resources\views/auth/register.blade.php ENDPATH**/ ?>