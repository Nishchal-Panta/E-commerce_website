@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <a href="{{ route('admin.returns.index') }}" class="text-blue-600 hover:text-blue-900 mb-4 inline-flex items-center">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
                Back to Returns
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Return Request Review</h1>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-6 border-b border-gray-200">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Request Status</h2>
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $return->getStatusBadgeClass() }}">
                                {{ ucfirst($return->status) }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600">
                            Requested: {{ $return->created_at->format('M d, Y H:i A') }}
                        </p>
                    </div>
                </div>

                <!-- Product Information -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Product Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Product Name</label>
                                <p class="text-gray-900 font-medium">{{ $return->orderItem->product->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Quantity Returning</label>
                                <p class="text-gray-900">{{ $return->orderItem->quantity }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Order ID</label>
                                <a href="{{ route('admin.orders.show', $return->order->id) }}" class="text-blue-600 hover:text-blue-900 font-medium">
                                    #{{ $return->order->id }}
                                </a>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Item Price</label>
                                <p class="text-gray-900">${{ number_format($return->orderItem->price, 2) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Customer Information -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-6 border-b border-gray-200">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Customer Information</h2>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Name</label>
                                <p class="text-gray-900">{{ $return->user->name }}</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
                                <a href="mailto:{{ $return->user->email }}" class="text-blue-600 hover:text-blue-900">
                                    {{ $return->user->email }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Return Reason -->
                <div class="bg-white rounded-lg shadow overflow-hidden">
                    <div class="px-6 py-6">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Return Reason</h2>
                        <div class="space-y-4">
                            @if($return->returnReason)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <p class="text-sm font-medium text-gray-600 mb-1">Predefined Reason:</p>
                                    <p class="font-medium text-gray-900">{{ $return->returnReason->name }}</p>
                                    @if($return->returnReason->description)
                                        <p class="text-sm text-gray-600 mt-2">{{ $return->returnReason->description }}</p>
                                    @endif
                                </div>
                            @endif

                            @if($return->custom_reason)
                                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                                    <p class="text-sm font-medium text-gray-600 mb-2">Customer Details:</p>
                                    <p class="text-gray-900 whitespace-pre-wrap text-sm">{{ $return->custom_reason }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar Actions -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                @if($return->status === 'pending')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                        <!-- Approve -->
                        <form action="{{ route('admin.returns.approve', $return->id) }}" method="POST" class="mb-3">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-3 bg-green-600 text-white rounded-lg font-medium hover:bg-green-700 transition">
                                Approve Return
                            </button>
                        </form>

                        <!-- Reject Modal Trigger -->
                        <button type="button"
                                onclick="document.getElementById('rejectModal').classList.remove('hidden')"
                                class="w-full px-4 py-3 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700 transition">
                            Reject Return
                        </button>
                    </div>

                    <!-- Reject Modal -->
                    <div id="rejectModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
                        <div class="bg-white rounded-lg max-w-sm w-full p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Reject Return Request</h3>

                            <form action="{{ route('admin.returns.reject', $return->id) }}" method="POST">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for Rejection</label>
                                    <textarea name="rejection_reason" 
                                              rows="4"
                                              placeholder="Explain why this return is being rejected..."
                                              class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                                              required></textarea>
                                </div>

                                <div class="flex gap-3">
                                    <button type="button"
                                            onclick="document.getElementById('rejectModal').classList.add('hidden')"
                                            class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                                        Cancel
                                    </button>
                                    <button type="submit" class="flex-1 px-4 py-2 bg-red-600 text-white rounded-lg font-medium hover:bg-red-700">
                                        Reject
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @elseif($return->status === 'approved')
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>

                        <form action="{{ route('admin.returns.complete', $return->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="w-full px-4 py-3 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                                Mark as Completed
                            </button>
                        </form>

                        <p class="text-sm text-gray-600 mt-4">
                            Once you mark this return as completed, the refund process will be initiated.
                        </p>
                    </div>
                @else
                    <div class="bg-gray-50 rounded-lg p-6 border border-gray-200">
                        <p class="text-sm text-gray-600">
                            This return request is {{ strtolower($return->status) }}. No further actions are needed.
                        </p>
                    </div>
                @endif

                <!-- Timeline -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Timeline</h3>
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="w-2 h-2 bg-blue-600 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">Return Requested</p>
                                <p class="text-xs text-gray-500">{{ $return->requested_at->format('M d, Y H:i A') }}</p>
                            </div>
                        </div>

                        @if($return->approved_at)
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-green-600 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Return Approved</p>
                                    <p class="text-xs text-gray-500">{{ $return->approved_at->format('M d, Y H:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($return->completed_at)
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-green-600 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Return Completed</p>
                                    <p class="text-xs text-gray-500">{{ $return->completed_at->format('M d, Y H:i A') }}</p>
                                </div>
                            </div>
                        @endif

                        @if($return->rejected_at)
                            <div class="flex items-start">
                                <div class="w-2 h-2 bg-red-600 rounded-full mt-2 mr-4 flex-shrink-0"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-900">Return Rejected</p>
                                    <p class="text-xs text-gray-500">{{ $return->rejected_at->format('M d, Y H:i A') }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
