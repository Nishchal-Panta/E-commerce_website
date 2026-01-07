@extends('layouts.admin')

@section('title', 'Order Details')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.orders.index') }}" class="text-primary-600 dark:text-primary-400 hover:underline flex items-center">
        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back to Orders
    </a>
</div>

@if(session('success'))
    <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-4 py-3 rounded-lg">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
    <!-- Order Details -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Order Header -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <div class="flex justify-between items-start mb-6">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">
                        Order #{{ $order->id }}
                    </h1>
                    <p class="text-gray-600 dark:text-gray-400">
                        Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                    </p>
                </div>
            </div>

            <!-- Update Status Form -->
            <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="mb-6">
                @csrf
                @method('PATCH')
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Order Status
                        </label>
                        <select id="status" name="status" 
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                            <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                            <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" 
                                class="bg-primary-600 hover:bg-primary-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                            Update Status
                        </button>
                    </div>
                </div>
            </form>

            <!-- Current Status Badge -->
            <div class="flex items-center justify-center py-4">
                <span class="px-6 py-3 rounded-full text-lg font-semibold {{ $order->getStatusBadgeClass() }}">
                    Current Status: {{ ucfirst($order->status) }}
                </span>
            </div>
        </div>

        <!-- Customer Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Customer Information</h2>
            <div class="flex items-center mb-4">
                @if($order->buyer->profile_photo)
                    <img src="{{ asset('storage/' . $order->buyer->profile_photo) }}" 
                         alt="{{ $order->buyer->username }}" 
                         class="w-16 h-16 rounded-full mr-4">
                @else
                    <div class="w-16 h-16 rounded-full bg-gray-300 dark:bg-gray-600 flex items-center justify-center mr-4">
                        <span class="text-xl font-medium text-gray-600 dark:text-gray-300">
                            {{ strtoupper(substr($order->buyer->username, 0, 2)) }}
                        </span>
                    </div>
                @endif
                <div>
                    <h3 class="font-semibold text-gray-900 dark:text-white">{{ $order->buyer->username }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-400">{{ $order->buyer->email }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">
                        Customer since {{ $order->buyer->created_at->format('M Y') }}
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4 mt-4 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Orders</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $order->buyer->orders->count() }}</p>
                </div>
                <div>
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total Spent</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">
                        ${{ number_format($order->buyer->orders->sum('total_amount'), 2) }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Order Items -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Order Items</h2>
            <div class="space-y-4">
                @foreach($order->orderItems as $item)
                    <div class="flex items-center gap-4 pb-4 border-b border-gray-200 dark:border-gray-700 last:border-0">
                        @if($item->product->primaryImage)
                            <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" 
                                 alt="{{ $item->product->name }}" 
                                 class="w-24 h-24 object-cover rounded-lg">
                        @else
                            <div class="w-24 h-24 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h3 class="font-semibold text-gray-900 dark:text-white">{{ $item->product->name }}</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                Quantity: {{ $item->quantity }} × ${{ number_format($item->price_at_purchase, 2) }}
                            </p>
                            @if($item->product->brand)
                                <p class="text-xs text-gray-500 dark:text-gray-500 mt-1">Brand: {{ $item->product->brand }}</p>
                            @endif
                        </div>
                        
                        <div class="text-right">
                            <p class="font-bold text-gray-900 dark:text-white">
                                ${{ number_format($item->getSubtotal(), 2) }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Order Summary Sidebar -->
    <div class="space-y-6">
        <!-- Order Summary -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Order Summary</h2>
            
            <div class="space-y-3 mb-6">
                @php
                    $subtotal = $order->orderItems->sum(function($item) {
                        return $item->getSubtotal();
                    });
                    $tax = $subtotal * 0.10;
                    $shipping = $subtotal >= 100 ? 0 : 10;
                @endphp
                
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
                    <span>{{ $shipping === 0 ? 'FREE' : '$' . number_format($shipping, 2) }}</span>
                </div>
                <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="flex justify-between text-lg font-bold text-gray-900 dark:text-white">
                        <span>Total</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Shipping Address</h2>
            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $order->shipping_address }}</p>
        </div>

        <!-- Payment Information -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Payment Details</h2>
            <div class="space-y-3">
                <div class="flex justify-between text-gray-700 dark:text-gray-300">
                    <span>Method:</span>
                    <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                </div>
                <div class="flex justify-between text-gray-700 dark:text-gray-300">
                    <span>Status:</span>
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        {{ $order->payment_status === 'paid' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' }}">
                        {{ ucfirst($order->payment_status) }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Order Actions -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
            <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Actions</h2>
            <div class="space-y-3">
                <button onclick="window.print()" 
                        class="w-full bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                    </svg>
                    Print Order
                </button>
            </div>
        </div>
    </div>
</div>
@endsection
