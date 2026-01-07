@extends('layouts.app')

@section('title', 'FAQ - Frequently Asked Questions')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl font-bold text-gray-900 dark:text-white mb-4 text-center">Frequently Asked Questions</h1>
        <p class="text-center text-gray-600 dark:text-gray-400 mb-12">
            Find answers to common questions about our platform
        </p>

        <!-- Search -->
        <div class="mb-8" x-data="{ search: '' }">
            <div class="relative">
                <input type="text" x-model="search" placeholder="Search FAQs..." 
                       class="w-full px-6 py-4 pl-12 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-2 focus:ring-primary-500 dark:bg-gray-800 dark:text-white text-lg">
                <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 h-6 w-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
        </div>

        <!-- FAQ Accordion by Category -->
        @foreach($faqs as $category => $categoryFaqs)
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    @switch($category)
                        @case('Orders')
                            <svg class="h-6 w-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            @break
                        @case('Payments')
                            <svg class="h-6 w-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            @break
                        @case('Shipping')
                            <svg class="h-6 w-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path>
                            </svg>
                            @break
                        @default
                            <svg class="h-6 w-6 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                    @endswitch
                    {{ $category }}
                </h2>

                <div class="space-y-4" x-data="{ openFaq: null }">
                    @foreach($categoryFaqs->sortBy('display_order') as $faq)
                        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden">
                            <button @click="openFaq = openFaq === {{ $faq->id }} ? null : {{ $faq->id }}"
                                    class="w-full px-6 py-4 text-left flex justify-between items-center hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-200">
                                <span class="font-semibold text-gray-900 dark:text-white pr-8">
                                    {{ $faq->question }}
                                </span>
                                <svg class="h-5 w-5 text-gray-500 dark:text-gray-400 transform transition-transform duration-200"
                                     :class="{ 'rotate-180': openFaq === {{ $faq->id }} }"
                                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="openFaq === {{ $faq->id }}" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 transform -translate-y-2"
                                 x-transition:enter-end="opacity-100 transform translate-y-0"
                                 x-transition:leave="transition ease-in duration-150"
                                 x-transition:leave-start="opacity-100 transform translate-y-0"
                                 x-transition:leave-end="opacity-0 transform -translate-y-2"
                                 class="px-6 pb-4 text-gray-700 dark:text-gray-300"
                                 style="display: none;">
                                <div class="pt-2 border-t border-gray-200 dark:border-gray-700">
                                    {{ $faq->answer }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <!-- Contact Support -->
        <div class="mt-12 bg-gradient-to-r from-primary-600 to-primary-700 rounded-lg shadow-lg p-8 text-center">
            <h2 class="text-2xl font-bold text-white mb-4">Still have questions?</h2>
            <p class="text-primary-100 mb-6">
                Can't find what you're looking for? Our support team is here to help!
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('report.create') }}" 
                   class="inline-flex items-center justify-center bg-white text-primary-600 font-semibold py-3 px-6 rounded-lg hover:bg-primary-50 transition duration-200">
                    <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    Report an Issue
                </a>
                @php
                    $settings = \App\Models\Setting::first();
                @endphp
                @if($settings && $settings->admin_email)
                    <a href="mailto:{{ $settings->admin_email }}" 
                       class="inline-flex items-center justify-center bg-primary-800 text-white font-semibold py-3 px-6 rounded-lg hover:bg-primary-900 transition duration-200">
                        <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Email Support
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
