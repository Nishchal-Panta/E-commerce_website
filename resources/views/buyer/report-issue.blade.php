@extends('layouts.app')

@section('title', 'Report an Issue')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-3xl mx-auto">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Report an Issue</h1>
        <p class="text-gray-600 dark:text-gray-400 mb-8">
            Help us improve by reporting bugs, technical issues, or suggesting features
        </p>

        @if(session('success'))
            <div class="mb-6 bg-green-100 dark:bg-green-900 border border-green-400 dark:border-green-700 text-green-700 dark:text-green-200 px-6 py-4 rounded-lg flex items-start">
                <svg class="h-6 w-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                </svg>
                <div>
                    <h3 class="font-semibold mb-1">Thank you for your report!</h3>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-8">
            <form action="{{ route('buyer.bug_reports.store') }}" method="POST">
                @csrf

                <!-- Report Type -->
                <div class="mb-6">
                    <label for="report_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Issue Type <span class="text-red-500">*</span>
                    </label>
                    <select id="report_type" name="report_type" required
                            class="w-full px-4 py-2 border {{ $errors->has('report_type') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                        <option value="">Select issue type...</option>
                        <option value="bug" {{ old('report_type') == 'bug' ? 'selected' : '' }}>🐛 Bug Report</option>
                        <option value="technical_issue" {{ old('report_type') == 'technical_issue' ? 'selected' : '' }}>⚙️ Technical Issue</option>
                        <option value="feature_request" {{ old('report_type') == 'feature_request' ? 'selected' : '' }}>💡 Feature Request</option>
                        <option value="improvement" {{ old('report_type') == 'improvement' ? 'selected' : '' }}>🚀 Improvement Suggestion</option>
                        <option value="other" {{ old('report_type') == 'other' ? 'selected' : '' }}>📝 Other</option>
                    </select>
                    @error('report_type')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Title -->
                <div class="mb-6">
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Issue Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="title" name="title" value="{{ old('title') }}" required
                           placeholder="Brief summary of the issue..."
                           class="w-full px-4 py-2 border {{ $errors->has('title') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">
                    @error('title')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Detailed Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="8" required
                              placeholder="Please provide as much detail as possible:&#10;&#10;- What were you trying to do?&#10;- What happened instead?&#10;- Steps to reproduce (if applicable)&#10;- Any error messages you saw"
                              class="w-full px-4 py-2 border {{ $errors->has('description') ? 'border-red-500' : 'border-gray-300 dark:border-gray-600' }} rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-700 dark:text-white">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        The more details you provide, the faster we can help you!
                    </p>
                </div>

                <!-- Info Box -->
                <div class="mb-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="h-5 w-5 text-blue-600 dark:text-blue-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <div class="text-sm text-blue-800 dark:text-blue-300">
                            <p class="font-semibold mb-1">Your report helps us improve!</p>
                            <ul class="list-disc list-inside space-y-1">
                                <li>Our team reviews all reports within 24-48 hours</li>
                                <li>You'll receive updates via email at {{ auth()->user()->email }}</li>
                                <li>For urgent issues, please contact support directly</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit" 
                            class="flex-1 bg-primary-600 hover:bg-primary-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center justify-center">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                        </svg>
                        Submit Report
                    </button>
                    <a href="{{ route('buyer.home') }}" 
                       class="flex-1 bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-800 dark:text-white font-semibold py-3 px-6 rounded-lg transition duration-200 text-center">
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Previous Reports (Optional) -->
        @if(auth()->user()->bugReports->isNotEmpty())
            <div class="mt-8 bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
                <h2 class="text-xl font-bold text-gray-900 dark:text-white mb-4">Your Recent Reports</h2>
                <div class="space-y-3">
                    @foreach(auth()->user()->bugReports->take(5) as $report)
                        <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-900 dark:text-white">{{ $report->title }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $report->created_at->format('M d, Y') }} • 
                                    <span class="px-2 py-0.5 rounded text-xs font-semibold
                                        {{ $report->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200' : '' }}
                                        {{ $report->status === 'in_progress' ? 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200' : '' }}
                                        {{ $report->status === 'resolved' ? 'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200' : '' }}">
                                        {{ ucfirst(str_replace('_', ' ', $report->status)) }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
