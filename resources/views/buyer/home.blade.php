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
                    @if($product->getPrimaryImage())
                    <img src="{{ asset('storage/' . $product->getPrimaryImage()->image_path) }}" 
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
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Brand</label>
                <select name="brand[]" multiple class="input-field h-20">
                    @foreach($brands as $brand)
                    <option value="{{ $brand }}" {{ in_array($brand, (array)request('brand')) ? 'selected' : '' }}>
                        {{ $brand }}
                    </option>
                    @endforeach
                </select>
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
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($products as $product)
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition duration-300">
            <a href="{{ route('products.show', $product->id) }}">
                @if($product->getPrimaryImage())
                <img src="{{ asset('storage/' . $product->getPrimaryImage()->image_path) }}" 
                    class="w-full h-48 object-cover" alt="{{ $product->name }}">
                @else
                <div class="w-full h-48 bg-gray-200 flex items-center justify-center">
                    <i class="fas fa-image text-gray-400 text-4xl"></i>
                </div>
                @endif
                
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
                        <form action="{{ route('cart.add') }}" method="POST">
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
            </a>
        </div>
        @endforeach
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
