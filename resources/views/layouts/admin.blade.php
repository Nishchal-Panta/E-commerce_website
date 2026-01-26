<!DOCTYPE html>
<html lang="en" x-data="{ sidebarOpen: false }">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-100 dark:bg-gray-900 transition-colors duration-300">
    <!-- Overlay for mobile sidebar -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-gray-600 bg-opacity-75 z-40 lg:hidden"
         style="display: none;"></div>
    
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-gray-800 dark:bg-gray-950 text-white transform transition-all duration-300 ease-in-out lg:translate-x-0 lg:static lg:inset-0 overflow-y-auto shadow-xl">
            <div class="flex items-center justify-between h-16 px-4 sm:px-6 bg-gray-900 dark:bg-black flex-shrink-0">
                <span class="text-lg sm:text-xl font-bold truncate"><i class="fas fa-shield-alt mr-2 text-indigo-400"></i>Admin Panel</span>
                <button @click="sidebarOpen = false" class="lg:hidden text-gray-400 hover:text-white focus:outline-none">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            
            <nav class="mt-6 pb-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 sm:px-6 py-3 text-gray-300 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-white transition duration-150 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-700 dark:bg-gray-800 text-white border-l-4 border-indigo-500' : '' }}">
                    <i class="fas fa-tachometer-alt mr-3 w-5 text-center"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center px-4 sm:px-6 py-3 text-gray-300 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-white transition duration-150 {{ request()->routeIs('admin.orders.*') ? 'bg-gray-700 dark:bg-gray-800 text-white border-l-4 border-indigo-500' : '' }}">
                    <i class="fas fa-shopping-cart mr-3 w-5 text-center"></i>
                    <span>Orders</span>
                </a>
                <a href="{{ route('admin.returns.index') }}" class="flex items-center px-4 sm:px-6 py-3 text-gray-300 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-white transition duration-150 {{ request()->routeIs('admin.returns.*') ? 'bg-gray-700 dark:bg-gray-800 text-white border-l-4 border-indigo-500' : '' }}">
                    <i class="fas fa-undo mr-3 w-5 text-center"></i>
                    <span>Returns</span>
                </a>
                <a href="{{ route('admin.inventory.index') }}" class="flex items-center px-4 sm:px-6 py-3 text-gray-300 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-white transition duration-150 {{ request()->routeIs('admin.inventory.*') ? 'bg-gray-700 dark:bg-gray-800 text-white border-l-4 border-indigo-500' : '' }}">
                    <i class="fas fa-warehouse mr-3 w-5 text-center"></i>
                    <span>Inventory</span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="flex items-center px-4 sm:px-6 py-3 text-gray-300 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-white transition duration-150 {{ request()->routeIs('admin.users.*') ? 'bg-gray-700 dark:bg-gray-800 text-white border-l-4 border-indigo-500' : '' }}">
                    <i class="fas fa-users mr-3 w-5 text-center"></i>
                    <span>Users</span>
                </a>
                <a href="{{ route('admin.reports.index') }}" class="flex items-center px-4 sm:px-6 py-3 text-gray-300 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-white transition duration-150 {{ request()->routeIs('admin.reports.*') ? 'bg-gray-700 dark:bg-gray-800 text-white border-l-4 border-indigo-500' : '' }}">
                    <i class="fas fa-bug mr-3 w-5 text-center"></i>
                    <span>Reports</span>
                </a>
                <a href="{{ route('admin.settings.edit') }}" class="flex items-center px-4 sm:px-6 py-3 text-gray-300 hover:bg-gray-700 dark:hover:bg-gray-800 hover:text-white transition duration-150 {{ request()->routeIs('admin.settings.*') ? 'bg-gray-700 dark:bg-gray-800 text-white border-l-4 border-indigo-500' : '' }}">
                    <i class="fas fa-cog mr-3 w-5 text-center"></i>
                    <span>Settings</span>
                </a>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden w-full min-w-0">
            <!-- Top Bar -->
            <header class="flex items-center justify-between h-16 bg-white dark:bg-gray-800 shadow-md px-4 sm:px-6 transition-colors duration-300">
                <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 focus:outline-none lg:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <div class="flex-1"></div>
                
                <!-- Dark Mode Toggle -->
                <div x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }" class="mr-3">
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode); document.documentElement.classList.toggle('dark', darkMode)"
                            class="touch-target bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 rounded-lg transition-all shadow-sm hover:shadow-md">
                        <i :class="darkMode ? 'fas fa-sun text-yellow-400' : 'fas fa-moon text-indigo-600'"></i>
                    </button>
                </div>
                
                <!-- User Dropdown -->
                <div x-data="{ userMenuOpen: false }" class="relative">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center space-x-2 text-gray-700 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white focus:outline-none px-3 py-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition duration-200">
                        @if(auth()->user()->profile_photo)
                            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                                 class="w-8 h-8 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600" 
                                 alt="Profile">
                        @else
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-indigo-600 to-purple-600 flex items-center justify-center text-white font-semibold shadow-md">
                                {{ strtoupper(substr(auth()->user()->username, 0, 1)) }}
                            </div>
                        @endif
                        <span class="font-medium hidden sm:inline">{{ auth()->user()->username }}</span>
                        <i class="fas fa-chevron-down text-sm"></i>
                    </button>
                    
                    <!-- Dropdown Menu -->
                    <div x-show="userMenuOpen" 
                         @click.away="userMenuOpen = false"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="transform opacity-0 scale-95"
                         x-transition:enter-end="transform opacity-100 scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="transform opacity-100 scale-100"
                         x-transition:leave-end="transform opacity-0 scale-95"
                         class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 rounded-lg shadow-xl py-2 z-50 border border-gray-200 dark:border-gray-700"
                         style="display: none;">
                        
                        <div class="px-4 py-2 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ auth()->user()->username }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                        </div>
                        
                        <form action="{{ route('admin.toggle-customer-view') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:text-blue-600 dark:hover:text-blue-400 transition duration-150 flex items-center">
                                <i class="fas fa-user mr-3 w-4"></i>
                                <span>View as Customer</span>
                            </button>
                        </form>
                        
                        <hr class="my-2 border-gray-200 dark:border-gray-700">
                        
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 dark:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/20 transition duration-150 flex items-center">
                                <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>
            
            <!-- Flash Messages -->
            @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                class="fixed top-20 right-4 bg-green-500 text-white px-4 sm:px-6 py-3 rounded-lg shadow-lg z-50 max-w-xs sm:max-w-sm">
                <i class="fas fa-check-circle mr-2"></i> 
                <span class="text-sm sm:text-base">{{ session('success') }}</span>
            </div>
            @endif
            
            @if(session('error'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)" 
                class="fixed top-20 right-4 bg-red-500 text-white px-4 sm:px-6 py-3 rounded-lg shadow-lg z-50 max-w-xs sm:max-w-sm">
                <i class="fas fa-exclamation-circle mr-2"></i> 
                <span class="text-sm sm:text-base">{{ session('error') }}</span>
            </div>
            @endif
            
            <!-- Main Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 dark:bg-gray-900 p-4 sm:p-6 lg:p-8 transition-colors duration-300">
                @yield('content')
            </main>
        </div>
    </div>
    
    <script>
        // Initialize dark mode on page load
        if (localStorage.getItem('darkMode') === 'true' || (!localStorage.getItem('darkMode') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
    
    @stack('scripts')
</body>
</html>
