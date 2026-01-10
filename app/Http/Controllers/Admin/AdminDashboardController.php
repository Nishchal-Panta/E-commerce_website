<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_products' => Product::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Order::where('payment_status', 'completed')->sum('total_amount'),
            'pending_orders' => Order::where('status', 'pending')->count(),
        ];

        // Best selling products
        $bestSelling = OrderItem::select('product_id', DB::raw('SUM(quantity) as total_sold'))
            ->groupBy('product_id')
            ->orderBy('total_sold', 'desc')
            ->take(10)
            ->with('product')
            ->get();

        // Low stock products
        $lowStockCount = Product::whereColumn('inventory_quantity', '<=', 'low_stock_threshold')->count();

        // Recent orders (more detailed)
        $recentOrders = Order::with(['buyer', 'items.product'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Recent restock activities
        $recentRestocks = Product::where('updated_at', '>=', now()->subDays(7))
            ->where('inventory_quantity', '>', DB::raw('low_stock_threshold'))
            ->with('images')
            ->orderBy('updated_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.dashboard', compact('stats', 'bestSelling', 'lowStockCount', 'recentOrders', 'recentRestocks'));
    }

    public function toggleCustomerView(Request $request)
    {
        // Verify user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized.');
        }
        
        $currentMode = session('view_as_customer', false);
        $newMode = !$currentMode;
        
        if ($newMode) {
            session(['view_as_customer' => true]);
            return redirect()->route('home')->with('success', 'Now viewing as customer');
        } else {
            // Clear the session first, then redirect
            session()->forget('view_as_customer');
            return redirect()->route('admin.dashboard')->with('success', 'Back to admin view');
        }
    }
}
