@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900">Return Requests</h1>
            <p class="text-gray-600 mt-2">View and manage your product returns</p>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Pending</div>
                <div class="text-2xl font-bold text-yellow-600 mt-1">
                    {{ $returns->where('status', 'pending')->count() }}
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Approved</div>
                <div class="text-2xl font-bold text-green-600 mt-1">
                    {{ $returns->where('status', 'approved')->count() }}
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Rejected</div>
                <div class="text-2xl font-bold text-red-600 mt-1">
                    {{ $returns->where('status', 'rejected')->count() }}
                </div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Completed</div>
                <div class="text-2xl font-bold text-blue-600 mt-1">
                    {{ $returns->where('status', 'completed')->count() }}
                </div>
            </div>
        </div>

        <!-- Returns List -->
        @if($returns->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reason
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Date
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($returns as $return)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $return->orderItem->product->name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                Order #{{ $return->order->id }}
                                            </p>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($return->returnReason)
                                            {{ $return->returnReason->name }}
                                        @else
                                            Custom Reason
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $return->getStatusBadgeClass() }}">
                                        {{ ucfirst($return->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                    {{ $return->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('buyer.returns.show', $return->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($returns->hasPages())
                <div class="mt-8">
                    {{ $returns->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <div class="inline-flex items-center justify-center w-12 h-12 mx-auto bg-gray-100 rounded-full mb-4">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Return Requests</h3>
                <p class="text-gray-600 mb-6">You haven't submitted any return requests yet.</p>
                <a href="{{ route('buyer.orders.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700">
                    View Your Orders
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
