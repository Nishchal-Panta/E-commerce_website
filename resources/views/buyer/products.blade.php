@extends('layouts.app')

@section('title', 'All Products')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        
        <!-- Sidebar Filters -->
        <aside class="lg:w-1/4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-24">
                <h2 class="text-xl font-bold text-gray-800 dark:text-white mb-6">Filters</h2>
                
                <form method="GET" action="{{ route('products.index') }}">
                    <!-- Search -->
                    <div class="mb-6">
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Search</label>
                        <input type="text" id="search" name="search" value="{{ request('search') }}" 
                               placeholder="Search products..." 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Category -->
                    <div class="mb-6">
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                        <select id="category" name="category" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="">All Categories</option>
                            <option value="Electronics" {{ request('category') == 'Electronics' ? 'selected' : '' }}>Electronics</option>
                            <option value="Clothing" {{ request('category') == 'Clothing' ? 'selected' : '' }}>Clothing</option>
                            <option value="Footwear" {{ request('category') == 'Footwear' ? 'selected' : '' }}>Footwear</option>
                            <option value="Bags" {{ request('category') == 'Bags' ? 'selected' : '' }}>Bags</option>
                            <option value="Sports" {{ request('category') == 'Sports' ? 'selected' : '' }}>Sports</option>
                            <option value="Home" {{ request('category') == 'Home' ? 'selected' : '' }}>Home</option>
                            <option value="Beauty" {{ request('category') == 'Beauty' ? 'selected' : '' }}>Beauty</option>
                            <option value="Books" {{ request('category') == 'Books' ? 'selected' : '' }}>Books</option>
                        </select>
                    </div>

                    <!-- Brand -->
                    <div class="mb-6">
                        <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Brand</label>
                        <input type="text" id="brand" name="brand" value="{{ is_array(request('brand')) ? implode(', ', request('brand')) : request('brand') }}" 
                               placeholder="Enter brand..." 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Color -->
                    <div class="mb-6">
                        <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Color</label>
                        <input type="text" id="color" name="color" value="{{ is_array(request('color')) ? implode(', ', request('color')) : request('color') }}" 
                               placeholder="Enter color..." 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Size -->
                    <div class="mb-6">
                        <label for="size" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Size</label>
                        <input type="text" id="size" name="size" value="{{ is_array(request('size')) ? implode(', ', request('size')) : request('size') }}" 
                               placeholder="Enter size..." 
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    </div>

                    <!-- Price Range -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Price Range</label>
                        <div class="grid grid-cols-2 gap-3">
                            <input type="number" name="min_price" value="{{ request('min_price') }}" 
                                   placeholder="Min" 
                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                            <input type="number" name="max_price" value="{{ request('max_price') }}" 
                                   placeholder="Max" 
                                   class="px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        </div>
                    </div>

                    <!-- Sort By -->
                    <div class="mb-6">
                        <label for="sort" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Sort By</label>
                        <select id="sort" name="sort" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                        </select>
                    </div>

                    <!-- Buttons -->
                    <div class="flex gap-3">
                        <button type="submit" class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                            Apply Filters
                        </button>
                        <a href="{{ route('products.index') }}" class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded-lg transition duration-200 text-center">
                            Clear
                        </a>
                    </div>
                </form>
            </div>
        </aside>

        <!-- Products Grid -->
        <main class="lg:w-3/4">
            <div class="mb-6 flex justify-between items-center">
                <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                    @if(request('search'))
                        Search Results for "{{ request('search') }}"
                    @elseif(request('category'))
                        {{ request('category') }} Products
                    @else
                        All Products
                    @endif
                </h1>
                <p class="text-gray-600 dark:text-gray-400">
                    {{ $products->total() }} {{ Str::plural('product', $products->total()) }}
                </p>
            </div>

            @if($products->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                    <svg class="mx-auto h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                    </svg>
                    <h3 class="mt-4 text-xl font-medium text-gray-900 dark:text-white">No products found</h3>
                    <p class="mt-2 text-gray-500 dark:text-gray-400">Try adjusting your filters or search query</p>
                    <a href="{{ route('products.index') }}" class="mt-6 inline-block bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                        View All Products
                    </a>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6" x-data="{ showModal: false, modalImage: '', scale: 1 }">
                    @foreach($products as $product)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                            <div class="relative group">
                                @if($product->primaryImage)
                                    <a href="{{ route('products.show', $product->id) }}" class="block relative">
                                        <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-64 object-cover">
                                        <!-- Zoom icon overlay -->
                                        <button type="button"
                                                @click.prevent="showModal = true; modalImage = '{{ asset('storage/' . $product->primaryImage->image_path) }}'; scale = 1"
                                                class="absolute top-3 right-3 bg-white dark:bg-gray-800 bg-opacity-90 dark:bg-opacity-90 text-gray-700 dark:text-gray-300 p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10 hover:scale-110 transform">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                            </svg>
                                        </button>
                                    </a>
                                @else
                                    <a href="{{ route('products.show', $product->id) }}">
                                        <div class="w-full h-64 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                            <svg class="h-24 w-24 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    </a>
                                @endif
                                
                                @if($product->is_trending)
                                    <span class="absolute top-3 left-3 bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
                                        TRENDING
                                    </span>
                                @endif
                                
                                @if($product->isLowStock())
                                    <span class="absolute top-3 {{ $product->primaryImage ? 'right-16' : 'right-3' }} bg-yellow-500 text-white text-xs font-bold px-3 py-1 rounded-full group-hover:right-3 transition-all duration-200">
                                        LOW STOCK
                                    </span>
                                @endif
                            </div>
                            
                            <div class="p-5">
                                <a href="{{ route('products.show', $product->id) }}" class="block">
                                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-2 hover:text-primary-600 dark:hover:text-primary-400 transition duration-200">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-3 line-clamp-2">
                                    {{ Str::limit($product->description, 100) }}
                                </p>

                                <div class="flex items-center mb-3">
                                    @if($product->getAverageRating() > 0)
                                        <div class="flex items-center">
                                            @for($i = 1; $i <= 5; $i++)
                                                @if($i <= floor($product->getAverageRating()))
                                                    <svg class="h-4 w-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @else
                                                    <svg class="h-4 w-4 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                    </svg>
                                                @endif
                                            @endfor
                                            <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">
                                                {{ number_format($product->getAverageRating(), 1) }} ({{ $product->reviews->count() }})
                                            </span>
                                        </div>
                                    @else
                                        <span class="text-sm text-gray-500 dark:text-gray-400">No reviews yet</span>
                                    @endif
                                </div>

                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-2xl font-bold text-primary-600 dark:text-primary-400">
                                        ${{ number_format($product->price, 2) }}
                                    </span>
                                    <span class="text-sm text-gray-500 dark:text-gray-400">
                                        Stock: {{ $product->inventory_quantity }}
                                    </span>
                                </div>

                                <form action="{{ route('buyer.cart.add') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <input type="hidden" name="quantity" value="1">
                                    
                                    @if($product->inventory_quantity > 0)
                                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                                            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Add to Cart
                                        </button>
                                    @else
                                        <button disabled class="w-full bg-gray-400 text-white font-semibold py-2 px-4 rounded-lg cursor-not-allowed">
                                            Out of Stock
                                        </button>
                                    @endif
                                </form>
                            </div>
                        </div>
                    @endforeach

                    <!-- Image Zoom Modal -->
                    <div x-show="showModal" 
                         x-cloak
                         @click.self="showModal = false; scale = 1"
                         class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-90 p-4"
                         style="display: none;">
                        <div class="relative max-w-7xl max-h-screen w-full h-full flex flex-col items-center justify-center">
                            <!-- Close Button -->
                            <button @click="showModal = false; scale = 1" 
                                    class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors z-10">
                                <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>

                            <!-- Zoom Controls -->
                            <div class="absolute top-4 left-4 flex gap-2 z-10">
                                <button @click="scale = Math.min(scale + 0.5, 5)" 
                                        class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                                    </svg>
                                </button>
                                <button @click="scale = Math.max(scale - 0.5, 0.5)" 
                                        class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM13 10H7"></path>
                                    </svg>
                                </button>
                                <button @click="scale = 1" 
                                        class="bg-white bg-opacity-20 hover:bg-opacity-30 text-white px-4 py-2 rounded-lg transition-colors">
                                    Reset
                                </button>
                            </div>

                            <!-- Zoom Level Indicator -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-20 text-white px-4 py-2 rounded-lg z-10">
                                <span x-text="`${Math.round(scale * 100)}%`"></span>
                            </div>

                            <!-- Zoomable Image -->
                            <div class="overflow-auto w-full h-full flex items-center justify-center">
                                <img :src="modalImage" 
                                     alt="Product Image" 
                                     :style="`transform: scale(${scale}); transition: transform 0.2s ease;`"
                                     class="max-w-none cursor-move select-none"
                                     draggable="false">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @endif
        </main>
    </div>
</div>
@endsection
