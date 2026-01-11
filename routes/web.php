<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\FaqController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReviewController;
use Illuminate\Support\Facades\Route;

// Debug test endpoint
Route::get('/api/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'Laravel is working! ',
        'timestamp' => now()->toDateTimeString(),
        'server_ip' => request()->server('SERVER_ADDR'),
        'client_ip' => request()->ip(),
        'app_url' => config('app.url'),
        'environment' => config('app.env'),
    ]);
});

// Guest Routes
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{id}', [ProductController::class, 'show'])->name('products.show');
Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');

// Authenticated Routes
Route::middleware(['auth', 'check.blocked'])->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    // Bug Reports (accessible to all authenticated users)
    Route::get('/report-issue', [BugReportController::class, 'create'])->name('report.create');
    Route::post('/report-issue', [BugReportController::class, 'store'])->name('report.store');
});

// Buyer Routes
Route::middleware(['auth', 'buyer', 'check.blocked'])->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('buyer.cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('buyer.cart.add');
    Route::patch('/cart/{id}', [CartController::class, 'update'])->name('buyer.cart.update');
    Route::delete('/cart/{id}', [CartController::class, 'destroy'])->name('buyer.cart.destroy');
    
    // Orders
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('buyer.checkout');
    Route::post('/orders', [OrderController::class, 'store'])->name('buyer.orders.store');
    Route::get('/orders', [OrderController::class, 'index'])->name('buyer.orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('buyer.orders.show');
    Route::post('/orders/{id}/cancel', [OrderController::class, 'cancel'])->name('buyer.orders.cancel');
    
    // Reviews
    Route::post('/reviews', [ReviewController::class, 'store'])->name('buyer.reviews.store');
    Route::get('/reviews/create', [ReviewController::class, 'create'])->name('buyer.reviews.create');
    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('buyer.reviews.edit');
    Route::put('/reviews/{id}', [ReviewController::class, 'update'])->name('buyer.reviews.update');
    Route::delete('/reviews/{id}', [ReviewController::class, 'destroy'])->name('buyer.reviews.destroy');
    
    // Account
    Route::get('/account', [AccountController::class, 'edit'])->name('buyer.account.edit');
    Route::put('/account', [AccountController::class, 'update'])->name('buyer.account.update');
    Route::put('/account/password', [AccountController::class, 'updatePassword'])->name('buyer.account.password');
    Route::delete('/account', [AccountController::class, 'destroy'])->name('buyer.account.destroy');
});

// Admin Routes
// Toggle Customer View (must be outside admin middleware to work when exiting)
Route::middleware(['auth'])->post('/admin/toggle-customer-view', [AdminDashboardController::class, 'toggleCustomerView'])->name('admin.toggle-customer-view');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Products - moved to inventory
    Route::get('/products/create', [AdminProductController::class, 'create'])->name('products.create');
    Route::post('/products', [AdminProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}/edit', [AdminProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}', [AdminProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{id}', [AdminProductController::class, 'destroy'])->name('products.destroy');
    
    // Orders
    Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::patch('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])->name('orders.status');
    
    // Inventory
    Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('inventory.index');
    
    // Users
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::patch('/users/{id}/block', [AdminUserController::class, 'toggleBlock'])->name('users.block');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Reports
    Route::get('/reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::patch('/reports/{id}/status', [AdminReportController::class, 'updateStatus'])->name('reports.status');
    Route::delete('/reports/{id}', [AdminReportController::class, 'destroy'])->name('reports.destroy');
    
    // Settings
    Route::get('/settings', [AdminSettingController::class, 'edit'])->name('settings.edit');
    Route::put('/settings', [AdminSettingController::class, 'update'])->name('settings.update');
});
