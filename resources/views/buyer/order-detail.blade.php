@extends('layouts.app')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('buyer.orders.index') }}" class="text-primary-600 dark:text-primary-400 hover:underline flex items-center">
            <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Orders
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
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
                    <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->getStatusBadgeClass() }}">
                        {{ ucfirst($order->status) }}
                    </span>
                </div>

                <!-- Order Timeline -->
                <div class="relative">
                    <div class="absolute left-4 top-0 h-full w-0.5 bg-gray-300 dark:bg-gray-600"></div>
                    
                    <div class="space-y-6">
                        @php
                            $statuses = [
                                'pending' => ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Order Placed', 'active' => true],
                                'processing' => ['icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15', 'label' => 'Processing', 'active' => in_array($order->status, ['processing', 'shipped', 'delivered'])],
                                'shipped' => ['icon' => 'M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0', 'label' => 'Shipped', 'active' => in_array($order->status, ['shipped', 'delivered'])],
                                'delivered' => ['icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Delivered', 'active' => $order->status === 'delivered'],
                            ];

                            if ($order->status === 'cancelled') {
                                $statuses = [
                                    'pending' => ['icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Order Placed', 'active' => true],
                                    'cancelled' => ['icon' => 'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z', 'label' => 'Cancelled', 'active' => true, 'color' => 'red'],
                                ];
                            }
                        @endphp

                        @foreach($statuses as $key => $status)
                            <div class="relative flex items-start pl-10">
                                <div class="absolute left-0 flex items-center justify-center w-8 h-8 rounded-full {{ $status['active'] ? 'bg-primary-600' : 'bg-gray-300 dark:bg-gray-600' }} {{ isset($status['color']) && $status['color'] === 'red' ? 'bg-red-600' : '' }}">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $status['icon'] }}"></path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="font-semibold {{ $status['active'] ? 'text-gray-900 dark:text-white' : 'text-gray-500 dark:text-gray-400' }}">
                                        {{ $status['label'] }}
                                    </h3>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Order Items -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Order Items</h2>
                <div class="space-y-4">
                    @foreach($order->items as $item)
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
                                <a href="{{ route('buyer.products.show', $item->product->id) }}" 
                                   class="font-semibold text-gray-900 dark:text-white hover:text-primary-600 dark:hover:text-primary-400">
                                    {{ $item->product->name }}
                                </a>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Quantity: {{ $item->quantity }} × ${{ number_format($item->price_at_purchase, 2) }}
                                </p>
                                
                                @if($order->status === 'delivered' && !auth()->user()->reviews()->where('product_id', $item->product_id)->exists())
                                    <a href="{{ route('buyer.reviews.create', ['product_id' => $item->product_id]) }}" 
                                       class="inline-block mt-2 text-sm text-primary-600 dark:text-primary-400 hover:underline">
                                        Write a Review
                                    </a>
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

        <!-- Order Summary -->
        <div class="space-y-6">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Order Summary</h2>
                
                <div class="space-y-3 mb-6">
                    @php
                        $subtotal = $order->items->sum(function($item) {
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

                @if($order->canBeCancelled())
                    <form action="{{ route('buyer.orders.cancel', $order->id) }}" method="POST" 
                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" 
                                class="w-full bg-red-600 hover:bg-red-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200">
                            Cancel Order
                        </button>
                    </form>
                @endif
            </div>

            <!-- Shipping Address -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Shipping Address</h2>
                <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">{{ $order->shipping_address }}</p>
            </div>

            <!-- Payment Information -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Payment Information</h2>
                <div class="space-y-2">
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Payment Method:</span>
                        <span class="font-medium">{{ ucfirst(str_replace('_', ' ', $order->payment_method)) }}</span>
                    </div>
                    <div class="flex justify-between text-gray-700 dark:text-gray-300">
                        <span>Payment Status:</span>
                        <span class="font-medium px-3 py-1 rounded-full text-xs {{ $order->payment_status === 'paid' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' }}">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
