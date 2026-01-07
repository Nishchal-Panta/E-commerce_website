<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
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

        return view('buyer.products', compact('products', 'categories', 'brands', 'colors', 'sizes'));
    }

    public function show($id)
    {
        $product = Product::with(['images', 'reviews.buyer', 'reviews.photos', 'seller'])
            ->findOrFail($id);

        $relatedProducts = Product::where('category', $product->category)
            ->where('id', '!=', $product->id)
            ->where('inventory_quantity', '>', 0)
            ->with(['images'])
            ->take(4)
            ->get();

        $canReview = false;
        if (auth()->check() && auth()->user()->isBuyer()) {
            $canReview = auth()->user()->hasPurchased($product->id) 
                && !$product->reviews()->where('buyer_id', auth()->id())->exists();
        }

        return view('buyer.product-detail', compact('product', 'relatedProducts', 'canReview'));
    }
}
