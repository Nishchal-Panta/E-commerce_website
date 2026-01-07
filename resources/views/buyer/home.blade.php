@extends('layouts.app')

@section('title', 'Home - E-Commerce Platform')

@section('content')
<!-- Trending Products Carousel -->
<div class="mb-12" x-data="carousel()">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Trending Products</h2>
    
    <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
        @if($trendingProducts->count() > 0)
        <div class="relative h-96">
            @foreach($trendingProducts as $index => $product)
            <div x-show="currentSlide === {{ $index }}" 
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                class="absolute inset-0 flex items-center justify-center p-8">
                <a href="{{ route('products.show', $product->id) }}" class="flex flex-col md:flex-row items-center space-x-8">
                    @if($product->primaryImage)
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                        class="w-64 h-64 object-cover rounded-lg shadow-md" alt="{{ $product->name }}">
                    @endif
                    <div class="text-center md:text-left">
                        <h3 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">{{ $product->name }}</h3>
                        <p class="text-xl text-indigo-600 dark:text-indigo-400 font-semibold mb-4">${{ number_format($product->price, 2) }}</p>
                        <div class="flex items-center justify-center md:justify-start mb-4">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star {{ $i < $product->getAverageRating() ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                            @endfor
                            <span class="ml-2 text-gray-600 dark:text-gray-400">({{ $product->getReviewCount() }} reviews)</span>
                        </div>
                        <button class="btn-primary">View Details</button>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        
        <!-- Navigation Arrows -->
        <button @click="prevSlide" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-700 rounded-full p-3 shadow-lg hover:bg-gray-100">
            <i class="fas fa-chevron-left text-gray-600 dark:text-gray-300"></i>
        </button>
        <button @click="nextSlide" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white dark:bg-gray-700 rounded-full p-3 shadow-lg hover:bg-gray-100">
            <i class="fas fa-chevron-right text-gray-600 dark:text-gray-300"></i>
        </button>
        
        <!-- Dots -->
        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex space-x-2">
            @foreach($trendingProducts as $index => $product)
            <button @click="currentSlide = {{ $index }}" 
                :class="currentSlide === {{ $index }} ? 'bg-indigo-600' : 'bg-gray-400'"
                class="w-3 h-3 rounded-full"></button>
            @endforeach
        </div>
        @else
        <div class="h-96 flex items-center justify-center">
            <p class="text-gray-500">No trending products available</p>
        </div>
        @endif
    </div>
</div>

<!-- Filters -->
<div class="mb-8">
    <form method="GET" action="{{ route('products.index') }}" class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Category</label>
                <select name="category" class="input-field">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                    <option value="{{ $category }}" {{ request('category') == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                    @endforeach
                </select>
            </div>
            
            <!-- Brand -->
            <div x-data="{ open: false }" class="relative">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Brand</label>
                <button @click="open = !open" type="button"
                        class="w-full px-4 py-2 text-left border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white flex justify-between items-center">
                    <span class="text-sm">{{ count((array)request('brand')) > 0 ? count((array)request('brand')) . ' selected' : 'Select brands' }}</span>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>
                <div x-show="open" @click.away="open = false" x-cloak
                     class="absolute z-10 w-full mt-1 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto">
                    @foreach($brands as $brand)
                    <label class="flex items-center px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 cursor-pointer">
                        <input type="checkbox" name="brand[]" value="{{ $brand }}" 
                               {{ in_array($brand, (array)request('brand')) ? 'checked' : '' }}
                               class="mr-2 rounded text-primary-600 focus:ring-primary-500">
                        <span class="text-sm text-gray-700 dark:text-gray-300">{{ $brand }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            
            <!-- Price Range -->
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Min Price</label>
                <input type="number" name="min_price" value="{{ request('min_price') }}" placeholder="$0" class="input-field">
            </div>
            
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Max Price</label>
                <input type="number" name="max_price" value="{{ request('max_price') }}" placeholder="$1000" class="input-field">
            </div>
            
            <!-- Actions -->
            <div class="flex items-end space-x-2">
                <button type="submit" class="btn-primary flex-1">Apply</button>
                <a href="{{ route('products.index') }}" class="btn-secondary">Clear</a>
            </div>
        </div>
    </form>
</div>

<!-- Product Grid -->
<div>
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">All Products</h2>
    
    @if($products->count() > 0)
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8" x-data="{ showModal: false, modalImage: '', scale: 1 }">
        @foreach($products as $product)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
            <div class="relative group">
                @if($product->primaryImage)
                <a href="{{ route('products.show', $product->id) }}" class="block relative">
                    <img src="{{ asset('storage/' . $product->primaryImage->image_path) }}" 
                        class="w-full h-48 object-cover" alt="{{ $product->name }}">
                    <button type="button"
                            @click.prevent="showModal = true; modalImage = '{{ asset('storage/' . $product->primaryImage->image_path) }}'; scale = 1"
                            class="absolute top-2 right-2 bg-white dark:bg-gray-800 bg-opacity-90 dark:bg-opacity-90 text-gray-700 dark:text-gray-300 p-2 rounded-full opacity-0 group-hover:opacity-100 transition-opacity duration-200 z-10 hover:scale-110 transform">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path>
                        </svg>
                    </button>
                </a>
                @else
                <a href="{{ route('products.show', $product->id) }}">
                    <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-image text-gray-400 text-4xl"></i>
                    </div>
                </a>
                @endif
            </div>
                
                <div class="p-4">
                    <h3 class="font-semibold text-gray-900 dark:text-white mb-2 truncate">{{ $product->name }}</h3>
                    <p class="text-xl text-indigo-600 dark:text-indigo-400 font-bold mb-2">${{ number_format($product->price, 2) }}</p>
                    
                    <div class="flex items-center mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <i class="fas fa-star text-sm {{ $i < $product->getAverageRating() ? 'text-yellow-400' : 'text-gray-300' }}"></i>
                        @endfor
                        <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">({{ $product->getReviewCount() }})</span>
                    </div>
                    
                    @auth
                        @if(auth()->user()->isBuyer())
                        <form action="{{ route('buyer.cart.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="w-full btn-primary text-sm" {{ !$product->isInStock() ? 'disabled' : '' }}>
                                @if($product->isInStock())
                                    <i class="fas fa-cart-plus mr-1"></i> Add to Cart
                                @else
                                    Out of Stock
                                @endif
                            </button>
                        </form>
                        @endif
                    @endauth
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
    @else
    <div class="text-center py-12">
        <i class="fas fa-box-open text-6xl text-gray-400 mb-4"></i>
        <p class="text-xl text-gray-600 dark:text-gray-400">No products found</p>
    </div>
    @endif
</div>

<script>
function carousel() {
    return {
        currentSlide: 0,
        totalSlides: {{ $trendingProducts->count() }},
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        },
        init() {
            setInterval(() => {
                this.nextSlide();
            }, 5000);
        }
    }
}
</script>
@endsection
