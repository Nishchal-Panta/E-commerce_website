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
                Back
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Return Reasons</h1>
            <p class="text-gray-600 mt-2">Manage predefined return reasons</p>
        </div>

        <!-- Create New Reason Form -->
        <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
            <div class="px-6 py-6 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Add New Return Reason</h2>

                <form action="{{ route('admin.returns.reasons.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Reason Name</label>
                        <input type="text" name="name" 
                               placeholder="e.g., Damaged Item, Wrong Size, etc."
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                               value="{{ old('name') }}"
                               required>
                        @error('name')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                        <textarea name="description" rows="2"
                                  placeholder="Brief description of this return reason..."
                                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700 transition">
                            Add Reason
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Reasons List -->
        @if($reasons->count() > 0)
            <div class="bg-white rounded-lg shadow overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Reason
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($reasons as $reason)
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <p class="font-medium text-gray-900">{{ $reason->name }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-gray-600 text-sm">
                                        {{ $reason->description ?? 'No description' }}
                                    </p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full {{ $reason->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ $reason->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                    <button type="button"
                                            onclick="openEditModal({{ $reason->id }}, '{{ addslashes($reason->name) }}', '{{ addslashes($reason->description ?? '') }}', {{ $reason->is_active ? 'true' : 'false' }})"
                                            class="text-blue-600 hover:text-blue-900">
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.returns.reasons.destroy', $reason->id) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" 
                                                onclick="return confirm('Are you sure? This action cannot be undone.')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($reasons->hasPages())
                <div class="mt-8">
                    {{ $reasons->links() }}
                </div>
            @endif
        @else
            <div class="bg-white rounded-lg shadow p-12 text-center">
                <svg class="w-12 h-12 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Return Reasons</h3>
                <p class="text-gray-600">Create your first return reason using the form above.</p>
            </div>
        @endif
    </div>
</div>

<!-- Edit Modal -->
<div id="editModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-lg max-w-md w-full p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Edit Return Reason</h3>

        <form id="editForm" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Reason Name</label>
                <input type="text" id="editName" name="name" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                       required>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea id="editDescription" name="description" rows="2"
                          class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"></textarea>
            </div>

            <div>
                <label class="flex items-center">
                    <input type="checkbox" id="editIsActive" name="is_active" value="1" class="rounded border-gray-300">
                    <span class="ml-2 text-sm text-gray-700">Active</span>
                </label>
            </div>

            <div class="flex gap-3">
                <button type="button" 
                        onclick="closeEditModal()"
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 font-medium hover:bg-gray-50">
                    Cancel
                </button>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg font-medium hover:bg-blue-700">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function openEditModal(id, name, description, isActive) {
    document.getElementById('editName').value = name;
    document.getElementById('editDescription').value = description;
    document.getElementById('editIsActive').checked = isActive;
    document.getElementById('editForm').action = `/admin/returns-reasons/${id}`;
    document.getElementById('editModal').classList.remove('hidden');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
}
</script>
@endsection
