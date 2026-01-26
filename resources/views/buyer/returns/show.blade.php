@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-2xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('buyer.returns.index') }}" class="text-blue-600 hover:text-blue-900 mb-4 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Returns
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Return Request Details</h1>
        </div>

        <div class="bg-white rounded-lg shadow overflow-hidden">
            <!-- Order and Product Info -->
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Product Name</label>
                        <p class="text-gray-900">{{ $return->orderItem->product->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Quantity</label>
                        <p class="text-gray-900">{{ $return->orderItem->quantity }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Order ID</label>
                        <p class="text-gray-900">#{{ $return->order->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Order Status</label>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                            {{ ucfirst($return->order->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Return Reason -->
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Reason</h2>
                <div class="space-y-4">
                    @if($return->returnReason)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Predefined Reason</label>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="font-medium text-gray-900">{{ $return->returnReason->name }}</p>
                                @if($return->returnReason->description)
                                    <p class="text-sm text-gray-600 mt-1">{{ $return->returnReason->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if($return->custom_reason)
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Additional Details</label>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <p class="text-gray-900 whitespace-pre-wrap">{{ $return->custom_reason }}</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Return Status -->
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Status</h2>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-600">Current Status</span>
                        <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $return->getStatusBadgeClass() }}">
                            {{ ucfirst($return->status) }}
                        </span>
                    </div>

                    @if($return->status === 'pending')
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-4">
                            <p class="text-sm text-yellow-800">
                                Your return request is pending review. We will examine your request and get back to you within 3-5 business days.
                            </p>
                        </div>
                    @elseif($return->status === 'approved')
                        <div class="bg-green-50 border border-green-200 rounded-lg p-4 mt-4">
                            <p class="text-sm text-green-800">
                                Your return request has been approved! Please package the item securely and prepare it for shipment.
                            </p>
                        </div>
                    @elseif($return->status === 'rejected')
                        <div class="bg-red-50 border border-red-200 rounded-lg p-4 mt-4">
                            <p class="text-sm text-red-800">
                                Your return request has been rejected. Please contact our customer support for more information.
                            </p>
                        </div>
                    @elseif($return->status === 'completed')
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mt-4">
                            <p class="text-sm text-blue-800">
                                Your return has been completed successfully. Thank you for shopping with us!
                            </p>
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Requested At</label>
                            <p class="text-gray-900">{{ $return->requested_at->format('M d, Y H:i A') }}</p>
                        </div>
                        @if($return->approved_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Approved At</label>
                                <p class="text-gray-900">{{ $return->approved_at->format('M d, Y H:i A') }}</p>
                            </div>
                        @endif
                        @if($return->completed_at)
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Completed At</label>
                                <p class="text-gray-900">{{ $return->completed_at->format('M d, Y H:i A') }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="px-6 py-6 bg-gray-50 border-t border-gray-200 flex gap-3">
                <a href="{{ route('buyer.returns.index') }}" 
                   class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-100 text-center">
                    Back to Returns
                </a>
                <a href="{{ route('buyer.orders.show', $return->order->id) }}" 
                   class="flex-1 px-4 py-2 border border-blue-600 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 text-center">
                    View Order
                </a>
            </div>
        </div>

        <!-- Contact Support -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <h3 class="text-lg font-semibold text-blue-900 mb-2">Need Help?</h3>
            <p class="text-blue-800">
                If you have any questions about your return or need assistance, please 
                <a href="{{ route('report.create') }}" class="font-medium underline hover:text-blue-700">
                    contact our support team
                </a>.
            </p>
        </div>
    </div>
</div>
@endsection
