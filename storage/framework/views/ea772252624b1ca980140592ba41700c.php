

<?php $__env->startSection('title', 'User Management'); ?>

<?php $__env->startSection('content'); ?>
<div class="mb-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">User Management</h1>
    <p class="text-gray-600 dark:text-gray-400 mt-2">Manage platform users and their access</p>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Users</p>
                <p class="text-3xl font-bold text-gray-900 dark:text-white mt-2"><?php echo e($totalUsers); ?></p>
            </div>
            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Buyers</p>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mt-2"><?php echo e($buyersCount); ?></p>
            </div>
            <div class="p-3 bg-green-100 dark:bg-green-900 rounded-lg">
                <svg class="h-8 w-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Active Users</p>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-2"><?php echo e($activeUsers); ?></p>
            </div>
            <div class="p-3 bg-blue-100 dark:bg-blue-900 rounded-lg">
                <svg class="h-8 w-8 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">Blocked Users</p>
                <p class="text-3xl font-bold text-red-600 dark:text-red-400 mt-2"><?php echo e($blockedUsers); ?></p>
            </div>
            <div class="p-3 bg-red-100 dark:bg-red-900 rounded-lg">
                <svg class="h-8 w-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                </svg>
            </div>
        </div>
    </div>
</div>

<!-- Filters -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
    <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <label for="role" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Role</label>
            <select id="role" name="role" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                <option value="">All Roles</option>
                <option value="buyer" <?php echo e(request('role') == 'buyer' ? 'selected' : ''); ?>>Buyer</option>
                <option value="admin" <?php echo e(request('role') == 'admin' ? 'selected' : ''); ?>>Admin</option>
            </select>
        </div>

        <div>
            <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Status</label>
            <select id="status" name="status" 
                    class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                <option value="">All Status</option>
                <option value="active" <?php echo e(request('status') == 'active' ? 'selected' : ''); ?>>Active</option>
                <option value="blocked" <?php echo e(request('status') == 'blocked' ? 'selected' : ''); ?>>Blocked</option>
            </select>
        </div>

        <div>
            <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
            <input type="text" id="search" name="search" value="<?php echo e(request('search')); ?>" 
                   placeholder="Username or email..." 
                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
        </div>

        <div class="flex items-end">
            <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                Apply Filters
            </button>
        </div>
    </form>
</div>

<!-- Users Table -->
<div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
    <?php if(session('success')): ?>
        <div class="m-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="w-full">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Joined</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Orders</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                        <td class="px-6 py-4">
                            <div class="flex items-center">
                                <?php if($user->profile_photo): ?>
                                    <img src="<?php echo e(asset('storage/' . $user->profile_photo)); ?>" 
                                         alt="<?php echo e($user->username); ?>" 
                                         class="w-10 h-10 rounded-full mr-3">
                                <?php else: ?>
                                    <div class="w-10 h-10 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mr-3">
                                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300">
                                            <?php echo e(strtoupper(substr($user->username, 0, 2))); ?>

                                        </span>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white"><?php echo e($user->username); ?></p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">ID: <?php echo e($user->id); ?></p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                            <?php echo e($user->email); ?>

                        </td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                <?php echo e($user->role === 'admin' ? 'bg-purple-100 dark:bg-purple-900 text-purple-800 dark:text-purple-200' : 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200'); ?>">
                                <?php echo e(ucfirst($user->role)); ?>

                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700 dark:text-gray-300">
                            <?php echo e($user->created_at->format('M d, Y')); ?>

                        </td>
                        <td class="px-6 py-4 text-sm font-semibold text-gray-900 dark:text-white">
                            <?php if($user->role === 'buyer'): ?>
                                <?php echo e($user->orders->count()); ?>

                            <?php else: ?>
                                <span class="text-gray-400">N/A</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4">
                            <?php if($user->is_blocked): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200">
                                    Blocked
                                </span>
                            <?php elseif($user->is_active): ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200">
                                    Active
                                </span>
                            <?php else: ?>
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200">
                                    Inactive
                                </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            <?php if($user->id !== auth()->id() && $user->role !== 'admin'): ?>
                                <div class="flex gap-3">
                                    <?php if($user->is_blocked): ?>
                                        <form action="<?php echo e(route('admin.users.block', $user->id)); ?>" method="POST" class="inline">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="text-green-600 dark:text-green-400 hover:underline">
                                                Unblock
                                            </button>
                                        </form>
                                    <?php else: ?>
                                        <form action="<?php echo e(route('admin.users.block', $user->id)); ?>" method="POST" 
                                              class="inline" onsubmit="return confirm('Are you sure you want to block this user?')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PATCH'); ?>
                                            <button type="submit" class="text-yellow-600 dark:text-yellow-400 hover:underline">
                                                Block
                                            </button>
                                        </form>
                                    <?php endif; ?>
                                    
                                    <form action="<?php echo e(route('admin.users.destroy', $user->id)); ?>" method="POST" 
                                          class="inline" onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 dark:text-red-400 hover:underline">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            <?php else: ?>
                                <span class="text-gray-400">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="mt-4 text-gray-500 dark:text-gray-400">No users found</p>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <?php if($users->hasPages()): ?>
        <div class="px-6 py-4 border-t border-gray-200 dark:border-gray-700">
            <?php echo e($users->links()); ?>

        </div>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /app/resources/views/admin/users.blade.php ENDPATH**/ ?>