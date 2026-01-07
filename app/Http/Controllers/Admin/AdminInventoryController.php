<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminInventoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'low_stock') {
                $query->whereColumn('inventory_quantity', '<=', 'low_stock_threshold');
            } elseif ($request->status === 'out_of_stock') {
                $query->where('inventory_quantity', 0);
            } elseif ($request->status === 'in_stock') {
                $query->where('inventory_quantity', '>', 0);
            }
        }

        $products = $query->with('images')->paginate(20);

        $lowStockProducts = Product::whereColumn('inventory_quantity', '<=', 'low_stock_threshold')
            ->orderBy('inventory_quantity')
            ->take(10)
            ->get();

        $lowStockCount = Product::whereColumn('inventory_quantity', '<=', 'low_stock_threshold')->count();

        return view('admin.inventory', compact('products', 'lowStockProducts', 'lowStockCount'));
    }
}
