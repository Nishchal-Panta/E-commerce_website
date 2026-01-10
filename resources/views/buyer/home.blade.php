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

<!-- Products by Category Sidebars -->
<div class="mb-12 space-y-6">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Shop by Category</h2>
    
    @foreach($productsByCategory as $category => $data)
    <!-- Category Strip -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden border-l-4 border-indigo-600 dark:border-indigo-400">
        <div class="p-6">
            <!-- Category Header -->
            <div class="flex items-center justify-between mb-4">
                <div class="flex items-center space-x-4">
                    <div class="bg-gradient-to-br from-indigo-600 to-purple-600 rounded-lg p-3">
                        <i class="fas fa-box text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white">{{ ucfirst($category) }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $data['count'] }} {{ Str::plural('item', $data['count']) }}</p>
                    </div>
                </div>
                <a href="{{ route('products.index', ['category' => $category]) }}" 
                   class="px-4 py-2 text-indigo-600 dark:text-indigo-400 hover:bg-indigo-50 dark:hover:bg-gray-700 rounded-lg font-semibold text-sm transition-colors duration-200 border border-indigo-600 dark:border-indigo-400">
                    <i class="fas fa-arrow-right mr-2"></i>View All
                </a>
            </div>
            
            <!-- Horizontal Products Carousel -->
            <div class="relative" x-data="{ scrollPosition: 0 }">
                <!-- Left Arrow -->
                <button @click="$refs.productScroll{{ $loop->index }}.scrollBy({ left: -280, behavior: 'smooth' })" 
                        class="absolute left-0 top-1/2 -translate-y-1/2 z-10 bg-white dark:bg-gray-700 rounded-full p-2 shadow-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-all border border-gray-200 dark:border-gray-600">
                    <i class="fas fa-chevron-left text-gray-700 dark:text-white"></i>
                </button>
                
                <!-- Products Container -->
                <div x-ref="productScroll{{ $loop->index }}" 
                     class="flex space-x-4 overflow-x-auto scroll-smooth pb-2 px-10"
                     style="scrollbar-width: none; -ms-overflow-style: none;">
                    @foreach($data['products'] as $product)
                    <div class="flex-shrink-0 w-48">
                        <a href="{{ route('products.show', $product->id) }}" class="block">
                            <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-3 hover:shadow-md transition-all duration-200 border border-gray-200 dark:border-gray-600 h-full">
                                <div class="flex flex-col space-y-2">
                                    <div class="w-full h-32 rounded-md overflow-hidden bg-gray-100 dark:bg-gray-900 border border-gray-200 dark:border-gray-600">
                                        @if($product->images->count() > 0)
                                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                                             alt="{{ $product->name }}" 
                                             class="w-full h-full object-cover">
                                        @else
                                        <div class="w-full h-full flex items-center justify-center text-gray-400">
                                            <i class="fas fa-image text-2xl"></i>
                                        </div>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white truncate mb-1">{{ $product->name }}</p>
                                        <div class="flex items-center justify-between">
                                            <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">${{ number_format($product->price, 2) }}</p>
                                            @if($product->getAverageRating() > 0)
                                            <div class="flex items-center">
                                                <i class="fas fa-star text-yellow-400 text-xs"></i>
                                                <span class="text-xs text-gray-600 dark:text-gray-400 ml-1">{{ number_format($product->getAverageRating(), 1) }}</span>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
                
                <!-- Right Arrow -->
                <button @click="$refs.productScroll{{ $loop->index }}.scrollBy({ left: 280, behavior: 'smooth' }}" 
                        class="absolute right-0 top-1/2 -translate-y-1/2 z-10 bg-white dark:bg-gray-700 rounded-full p-2 shadow-lg hover:bg-gray-100 dark:hover:bg-gray-600 transition-all border border-gray-200 dark:border-gray-600">
                    <i class="fas fa-chevron-right text-gray-700 dark:text-white"></i>
                </button>
            </div>
        </div>
    </div>
    @endforeach
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
