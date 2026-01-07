@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6">
        <ol class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
            <li><a href="{{ route('buyer.home') }}" class="hover:text-primary-600">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('buyer.products.index') }}" class="hover:text-primary-600">Products</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 dark:text-white font-medium">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 mb-12">
        <!-- Product Images -->
        <div x-data="{ activeImage: '{{ $product->primaryImage ? asset('storage/' . $product->primaryImage->image_path) : '' }}' }">
            <div class="mb-4">
                <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-96 object-cover rounded-lg shadow-lg">
            </div>
            
            @if($product->images->count() > 1)
                <div class="grid grid-cols-4 gap-4">
                    @foreach($product->images as $image)
                        <img src="{{ asset('storage/' . $image->image_path) }}" 
                             alt="{{ $product->name }}"
                             @click="activeImage = '{{ asset('storage/' . $image->image_path) }}'"
                             :class="activeImage === '{{ asset('storage/' . $image->image_path) }}' ? 'ring-2 ring-primary-500' : ''"
                             class="w-full h-24 object-cover rounded-lg cursor-pointer hover:opacity-75 transition duration-200">
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Product Details -->
        <div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ $product->name }}</h1>
            
            <!-- Rating -->
            <div class="flex items-center mb-6">
                @if($product->getAverageRating() > 0)
                    <div class="flex items-center">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= floor($product->getAverageRating()))
                                <svg class="h-6 w-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @else
                                <svg class="h-6 w-6 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                </svg>
                            @endif
                        @endfor
                        <span class="ml-3 text-lg text-gray-600 dark:text-gray-400">
                            {{ number_format($product->getAverageRating(), 1) }} ({{ $product->reviews->count() }} {{ Str::plural('review', $product->reviews->count()) }})
                        </span>
                    </div>
                @else
                    <span class="text-gray-500 dark:text-gray-400">No reviews yet - Be the first to review!</span>
                @endif
            </div>

            <!-- Price -->
            <div class="mb-6">
                <span class="text-4xl font-bold text-primary-600 dark:text-primary-400">
                    ${{ number_format($product->price, 2) }}
                </span>
            </div>

            <!-- Stock Status -->
            <div class="mb-6">
                @if($product->inventory_quantity > 0)
                    @if($product->isLowStock())
                        <span class="inline-flex items-center px-4 py-2 bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200 rounded-full">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                            </svg>
                            Only {{ $product->inventory_quantity }} left in stock!
                        </span>
                    @else
                        <span class="inline-flex items-center px-4 py-2 bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200 rounded-full">
                            <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            In Stock ({{ $product->inventory_quantity }} available)
                        </span>
                    @endif
                @else
                    <span class="inline-flex items-center px-4 py-2 bg-red-100 dark:bg-red-900 text-red-800 dark:text-red-200 rounded-full">
                        <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                        </svg>
                        Out of Stock
                    </span>
                @endif
            </div>

            <!-- Product Info -->
            <div class="mb-6 space-y-3">
                @if($product->brand)
                    <p class="text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Brand:</span> {{ $product->brand }}
                    </p>
                @endif
                @if($product->category)
                    <p class="text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Category:</span> {{ $product->category }}
                    </p>
                @endif
                @if($product->color)
                    <p class="text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Color:</span> {{ $product->color }}
                    </p>
                @endif
                @if($product->size)
                    <p class="text-gray-700 dark:text-gray-300">
                        <span class="font-semibold">Size:</span> {{ $product->size }}
                    </p>
                @endif
            </div>

            <!-- Description -->
            <div class="mb-8">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-3">Description</h2>
                <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $product->description }}</p>
            </div>

            <!-- Add to Cart Form -->
            @auth
                <form action="{{ route('buyer.cart.add') }}" method="POST" x-data="{ quantity: 1 }" class="mb-6">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    
                    <div class="flex items-center space-x-4 mb-4">
                        <label class="text-gray-700 dark:text-gray-300 font-semibold">Quantity:</label>
                        <div class="flex items-center border border-gray-300 dark:border-gray-600 rounded-lg">
                            <button type="button" @click="quantity = Math.max(1, quantity - 1)" 
                                    class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <input type="number" name="quantity" x-model="quantity" min="1" max="{{ $product->inventory_quantity }}"
                                   class="w-20 text-center border-x border-gray-300 dark:border-gray-600 py-2 dark:bg-gray-800 dark:text-white">
                            <button type="button" @click="quantity = Math.min({{ $product->inventory_quantity }}, quantity + 1)" 
                                    class="px-4 py-2 text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                </svg>
                            </button>
                        </div>
                    </div>

                    @if($product->inventory_quantity > 0)
                        <button type="submit" class="w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 flex items-center justify-center text-lg">
                            <svg class="h-6 w-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            Add to Cart
                        </button>
                    @else
                        <button disabled class="w-full bg-gray-400 text-white font-bold py-4 px-6 rounded-lg cursor-not-allowed text-lg">
                            Out of Stock
                        </button>
                    @endif
                </form>
            @else
                <a href="{{ route('auth.login') }}" class="block w-full bg-primary-600 hover:bg-primary-700 text-white font-bold py-4 px-6 rounded-lg transition duration-200 text-center text-lg">
                    Login to Purchase
                </a>
            @endauth

            <!-- Seller Info -->
            <div class="bg-gray-100 dark:bg-gray-800 rounded-lg p-4">
                <h3 class="font-semibold text-gray-900 dark:text-white mb-2">Seller Information</h3>
                <p class="text-gray-700 dark:text-gray-300">{{ $product->seller->username }}</p>
            </div>
        </div>
    </div>

    <!-- Reviews Section -->
    <div class="mb-12">
        <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">Customer Reviews</h2>

        @if($product->reviews->isNotEmpty())
            <!-- Rating Breakdown -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="text-center">
                        <div class="text-6xl font-bold text-gray-900 dark:text-white mb-2">
                            {{ number_format($product->getAverageRating(), 1) }}
                        </div>
                        <div class="flex justify-center mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($product->getAverageRating()))
                                    <svg class="h-6 w-6 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="h-6 w-6 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <p class="text-gray-600 dark:text-gray-400">Based on {{ $product->reviews->count() }} {{ Str::plural('review', $product->reviews->count()) }}</p>
                    </div>

                    <div>
                        @php $breakdown = $product->getRatingBreakdown(); @endphp
                        @foreach([5,4,3,2,1] as $star)
                            <div class="flex items-center mb-2">
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 w-12">{{ $star }} star</span>
                                <div class="flex-1 mx-4">
                                    <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-yellow-400 h-2 rounded-full" style="width: {{ $breakdown[$star] }}%"></div>
                                    </div>
                                </div>
                                <span class="text-sm font-medium text-gray-700 dark:text-gray-300 w-12 text-right">{{ $breakdown[$star] }}%</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Individual Reviews -->
            <div class="space-y-6">
                @foreach($product->reviews as $review)
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">{{ $review->buyer->username }}</h4>
                                <div class="flex items-center mt-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->rating)
                                            <svg class="h-4 w-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @else
                                            <svg class="h-4 w-4 text-gray-300 dark:text-gray-600 fill-current" viewBox="0 0 20 20">
                                                <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                            </svg>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">{{ $review->created_at->format('M d, Y') }}</span>
                        </div>
                        
                        @if($review->comment)
                            <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $review->comment }}</p>
                        @endif

                        @if($review->photos->isNotEmpty())
                            <div class="grid grid-cols-4 gap-2">
                                @foreach($review->photos as $photo)
                                    <img src="{{ asset('storage/' . $photo->photo_path) }}" alt="Review photo" class="w-full h-24 object-cover rounded-lg">
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No reviews yet</h3>
                <p class="text-gray-500 dark:text-gray-400">Be the first to review this product!</p>
            </div>
        @endif

        <!-- Write Review (only if purchased) -->
        @auth
            @if(auth()->user()->hasPurchased($product->id) && !auth()->user()->reviews()->where('product_id', $product->id)->exists())
                <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Write a Review</h3>
                    <a href="{{ route('buyer.reviews.create', ['product_id' => $product->id]) }}" 
                       class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                        Write Your Review
                    </a>
                </div>
            @endif
        @endauth
    </div>
</div>
@endsection
