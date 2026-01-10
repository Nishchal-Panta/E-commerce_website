<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $trendingProducts = Product::where('is_trending', true)
            ->where('inventory_quantity', '>', 0)
            ->with(['images', 'reviews'])
            ->take(7)
            ->get();

        $query = Product::query()->where('inventory_quantity', '>', 0);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('description', 'LIKE', "%{$search}%");
            });
        }

        // Filters
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('brand')) {
            $query->whereIn('brand', (array) $request->brand);
        }

        if ($request->filled('color')) {
            $query->whereIn('color', (array) $request->color);
        }

        if ($request->filled('size')) {
            $query->whereIn('size', (array) $request->size);
        }

        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->with(['images', 'reviews'])->paginate(20);

        // Get filter options
        $categories = Product::distinct()->pluck('category');
        $brands = Product::distinct()->whereNotNull('brand')->pluck('brand');
        $colors = Product::distinct()->whereNotNull('color')->pluck('color');
        $sizes = Product::distinct()->whereNotNull('size')->pluck('size');

        // Products grouped by category (for sidebar display)
        $productsByCategory = Product::select('category', \DB::raw('COUNT(*) as product_count'))
            ->where('inventory_quantity', '>', 0)
            ->groupBy('category')
            ->get()
            ->mapWithKeys(function ($item) {
                return [
                    $item->category => [
                        'count' => $item->product_count,
                        'products' => Product::where('category', $item->category)
                            ->where('inventory_quantity', '>', 0)
                            ->with('images')
                            ->take(5)
                            ->get()
                    ]
                ];
            });

        return view('buyer.home', compact('trendingProducts', 'products', 'categories', 'brands', 'colors', 'sizes', 'productsByCategory'));
    }
}
