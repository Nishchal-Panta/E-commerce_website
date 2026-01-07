@extends('layouts.app')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">Shopping Cart</h1>
    
    @if($cartItems->count() > 0)
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Cart Items -->
        <div class="lg:col-span-2 space-y-4">
            @foreach($cartItems as $item)
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-4 flex items-center space-x-4">
                @if($item->product->getPrimaryImage())
                <img src="{{ asset('storage/' . $item->product->getPrimaryImage()->image_path) }}" 
                    class="w-24 h-24 object-cover rounded-lg" alt="{{ $item->product->name }}">
                @endif
                
                <div class="flex-1">
                    <a href="{{ route('products.show', $item->product->id) }}" 
                        class="text-lg font-semibold text-gray-900 dark:text-white hover:text-indigo-600">
                        {{ $item->product->name }}
                    </a>
                    <p class="text-indigo-600 dark:text-indigo-400 font-bold mt-1">
                        ${{ number_format($item->product->price, 2) }}
                    </p>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
                        Stock: {{ $item->product->inventory_quantity }}
                    </p>
                </div>
                
                <div class="flex items-center space-x-2">
                    <form action="{{ route('cart.update', $item->id) }}" method="POST" class="flex items-center space-x-2">
                        @csrf
                        @method('PATCH')
                        <button type="button" onclick="this.nextElementSibling.stepDown(); this.form.submit();"
                            class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300">
                            <i class="fas fa-minus text-sm"></i>
                        </button>
                        <input type="number" name="quantity" value="{{ $item->quantity }}" 
                            min="1" max="{{ $item->product->inventory_quantity }}"
                            class="w-16 text-center border border-gray-300 dark:border-gray-600 dark:bg-gray-700 rounded-lg">
                        <button type="button" onclick="this.previousElementSibling.stepUp(); this.form.submit();"
                            class="w-8 h-8 bg-gray-200 dark:bg-gray-700 rounded-full hover:bg-gray-300">
                            <i class="fas fa-plus text-sm"></i>
                        </button>
                    </form>
                </div>
                
                <div class="text-right">
                    <p class="text-lg font-bold text-gray-900 dark:text-white">
                        ${{ number_format($item->getSubtotal(), 2) }}
                    </p>
                    <form action="{{ route('cart.destroy', $item->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-700">
                            <i class="fas fa-trash"></i> Remove
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
        
        <!-- Order Summary -->
        <div class="lg:col-span-1">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 sticky top-20">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Order Summary</h2>
                
                <div class="space-y-3 mb-6">
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Subtotal</span>
                        <span>${{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Tax (10%)</span>
                        <span>${{ number_format($tax, 2) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Shipping</span>
                        <span>{{ $shipping == 0 ? 'FREE' : '$' . number_format($shipping, 2) }}</span>
                    </div>
                    <hr class="border-gray-300 dark:border-gray-600">
                    <div class="flex justify-between text-xl font-bold text-gray-900 dark:text-white">
                        <span>Total</span>
                        <span>${{ number_format($total, 2) }}</span>
                    </div>
                </div>
                
                @if($subtotal < 100)
                <p class="text-sm text-green-600 dark:text-green-400 mb-4">
                    <i class="fas fa-info-circle"></i> Add ${{ number_format(100 - $subtotal, 2) }} more for free shipping!
                </p>
                @endif
                
                <a href="{{ route('checkout') }}" class="block w-full btn-primary text-center mb-3">
                    Proceed to Checkout
                </a>
                <a href="{{ route('products.index') }}" class="block w-full btn-secondary text-center">
                    Continue Shopping
                </a>
            </div>
        </div>
    </div>
    @else
    <div class="text-center py-16">
        <i class="fas fa-shopping-cart text-6xl text-gray-400 mb-4"></i>
        <h2 class="text-2xl font-bold text-gray-700 dark:text-gray-300 mb-4">Your cart is empty</h2>
        <a href="{{ route('products.index') }}" class="btn-primary">
            <i class="fas fa-shopping-bag mr-2"></i> Start Shopping
        </a>
    </div>
    @endif
</div>
@endsection
