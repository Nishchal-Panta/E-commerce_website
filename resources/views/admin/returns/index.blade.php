@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="mb-8 flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Return Management</h1>
                <p class="text-gray-600 mt-2">Review and manage product return requests</p>
            </div>
            <a href="{{ route('admin.returns.reasons') }}" 
               class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Manage Reasons
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Pending</div>
                <div class="text-2xl font-bold text-yellow-600 mt-1">{{ $stats['pending'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Approved</div>
                <div class="text-2xl font-bold text-green-600 mt-1">{{ $stats['approved'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Rejected</div>
                <div class="text-2xl font-bold text-red-600 mt-1">{{ $stats['rejected'] }}</div>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <div class="text-sm font-medium text-gray-600">Completed</div>
                <div class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['completed'] }}</div>
            </div>
        </div>

        <!-- Returns List -->
        @if($returns->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Return ID
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Customer
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Product
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Requested
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
                                    <span class="text-sm font-medium text-gray-900">#{{ $return->id }}</span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $return->user->name }}</p>
                                        <p class="text-sm text-gray-500">{{ $return->user->email }}</p>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            {{ $return->orderItem->product->name }}
                                        </p>
                                        <p class="text-sm text-gray-500">Order #{{ $return->order->id }}</p>
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
                                    <a href="{{ route('admin.returns.show', $return->id) }}" 
                                       class="text-blue-600 hover:text-blue-900">
                                        Review
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
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Return Requests</h3>
                <p class="text-gray-600">There are no return requests to review at this time.</p>
            </div>
        @endif
    </div>
</div>
@endsection
