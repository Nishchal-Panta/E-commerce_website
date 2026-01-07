@extends('layouts.app')

@section('title', 'My Orders')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-8">My Orders</h1>

    @if($orders->isEmpty())
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-24 w-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-xl font-medium text-gray-900 dark:text-white mb-2">No orders yet</h3>
            <p class="text-gray-500 dark:text-gray-400 mb-6">Start shopping and your orders will appear here</p>
            <a href="{{ route('products.index') }}" class="inline-block bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200">
                Start Shopping
            </a>
        </div>
    @else
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                    <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    Order #{{ $order->id }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                                    Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                </p>
                            </div>
                            <div class="flex items-center gap-4">
                                <span class="px-4 py-2 rounded-full text-sm font-semibold {{ $order->getStatusBadgeClass() }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                                <a href="{{ route('buyer.orders.show', $order->id) }}" 
                                   class="text-primary-600 dark:text-primary-400 hover:underline font-medium">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="p-6">
                        <div class="space-y-4">
                            @foreach($order->orderItems->take(3) as $item)
                                <div class="flex items-center gap-4">
                                    @if($item->product->primaryImage)
                                        <img src="{{ asset('storage/' . $item->product->primaryImage->image_path) }}" 
                                             alt="{{ $item->product->name }}" 
                                             class="w-20 h-20 object-cover rounded-lg">
                                    @else
                                        <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                        </div>
                                    @endif
                                    
                                    <div class="flex-1">
                                        <h4 class="font-medium text-gray-900 dark:text-white">{{ $item->product->name }}</h4>
                                        <p class="text-sm text-gray-600 dark:text-gray-400">Quantity: {{ $item->quantity }}</p>
                                    </div>
                                    
                                    <div class="text-right">
                                        <p class="font-semibold text-gray-900 dark:text-white">
                                            ${{ number_format($item->price_at_purchase, 2) }}
                                        </p>
                                    </div>
                                </div>
                            @endforeach

                            @if($order->orderItems->count() > 3)
                                <p class="text-sm text-gray-600 dark:text-gray-400 text-center">
                                    + {{ $order->orderItems->count() - 3 }} more {{ Str::plural('item', $order->orderItems->count() - 3) }}
                                </p>
                            @endif
                        </div>

                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700 flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-600 dark:text-gray-400">Total Amount</p>
                                <p class="text-2xl font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($order->total_amount, 2) }}
                                </p>
                            </div>
                            
                            @if($order->canBeCancelled())
                                <div x-data="{ showCancelForm: false }">
                                    <button @click="showCancelForm = !showCancelForm" 
                                            type="button"
                                            class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-6 rounded-lg transition duration-200">
                                        Cancel Order
                                    </button>
                                    
                                    <form x-show="showCancelForm" 
                                          x-cloak
                                          action="{{ route('buyer.orders.cancel', $order->id) }}" 
                                          method="POST" 
                                          class="mt-4 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg"
                                          onsubmit="return confirm('Are you sure you want to cancel this order?')">
                                        @csrf
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                            Reason for Cancellation <span class="text-red-600">*</span>
                                        </label>
                                        <textarea name="cancellation_reason" 
                                                  rows="3" 
                                                  required
                                                  maxlength="500"
                                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-blue-500 dark:bg-gray-700 dark:text-white mb-3"
                                                  placeholder="Please explain why you want to cancel..."></textarea>
                                        <div class="flex gap-2">
                                            <button type="submit" 
                                                    class="bg-red-600 hover:bg-red-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                                Confirm Cancel
                                            </button>
                                            <button @click="showCancelForm = false" 
                                                    type="button"
                                                    class="bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200">
                                                Close
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
