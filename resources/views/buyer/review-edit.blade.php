@extends('layouts.app')

@section('title', 'Edit Your Review')

@section('content')
<style>
    [x-cloak] { display: none !important; }
</style>

<div class="container mx-auto px-4 py-8 max-w-3xl" 
     x-data="{
        rating: {{ $review->rating }},
        hoverRating: 0,
        comment: '{{ addslashes($review->comment ?? '') }}',
        photoPreviews: [],
        photoFiles: [],
        showModal: false,
        currentImage: '',
        existingPhotos: {{ $review->photos->pluck('id')->toJson() }},
        deletePhotos: [],
        
        setRating(value) {
            this.rating = value;
        },
        
        getRatingText() {
            const texts = ['', 'Poor', 'Fair', 'Good', 'Very Good', 'Excellent'];
            return texts[this.rating];
        },
        
        handlePhotos(event) {
            const files = Array.from(event.target.files);
            const remainingSlots = 5 - this.photoFiles.length - (this.existingPhotos.length - this.deletePhotos.length);
            const filesToAdd = files.slice(0, remainingSlots);
            
            filesToAdd.forEach(file => {
                if (file && file.type.startsWith('image/')) {
                    if (file.size > 2048 * 1024) {
                        alert(file.name + ' is too large. Max size is 2MB.');
                        return;
                    }
                    
                    this.photoFiles.push(file);
                    const reader = new FileReader();
                    reader.onload = (e) => {
                        this.photoPreviews.push(e.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
            
            event.target.value = '';
            this.updateFileInput(event.target);
        },
        
        removePhoto(index) {
            this.photoPreviews.splice(index, 1);
            this.photoFiles.splice(index, 1);
            const fileInput = document.querySelector('input[name=photos\\[\\]]');
            this.updateFileInput(fileInput);
        },
        
        markExistingForDelete(photoId) {
            const index = this.deletePhotos.indexOf(photoId);
            if (index > -1) {
                this.deletePhotos.splice(index, 1);
            } else {
                this.deletePhotos.push(photoId);
            }
        },
        
        isMarkedForDelete(photoId) {
            return this.deletePhotos.includes(photoId);
        },
        
        updateFileInput(input) {
            const dt = new DataTransfer();
            this.photoFiles.forEach(file => {
                dt.items.add(file);
            });
            input.files = dt.files;
        },
        
        previewImage(imageSrc) {
            this.currentImage = imageSrc;
            this.showModal = true;
        }
     }" 
     @keydown.escape.window="showModal = false">
    <!-- Breadcrumb -->
    <nav class="text-sm mb-6">
        <ol class="flex items-center space-x-2 text-gray-600 dark:text-gray-400">
            <li><a href="{{ route('home') }}" class="hover:text-primary-600">Home</a></li>
            <li><span class="mx-2">/</span></li>
            <li><a href="{{ route('products.show', $review->product_id) }}" class="hover:text-primary-600">{{ $review->product->name }}</a></li>
            <li><span class="mx-2">/</span></li>
            <li class="text-gray-900 dark:text-white font-medium">Edit Review</li>
        </ol>
    </nav>

    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold mb-6 text-gray-900 dark:text-white">Edit Your Review</h1>

        <!-- Product Info -->
        <div class="mb-8 pb-6 border-b border-gray-200 dark:border-gray-700">
            <div class="flex items-center space-x-4">
                @if($review->product->images->count() > 0)
                    <img src="{{ asset('storage/' . $review->product->images->first()->image_path) }}" 
                         alt="{{ $review->product->name }}" 
                         class="w-20 h-20 object-cover rounded-lg">
                @else
                    <div class="w-20 h-20 bg-gray-200 dark:bg-gray-700 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                @endif
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $review->product->name }}</h2>
                    <p class="text-gray-600 dark:text-gray-400">${{ number_format($review->product->price, 2) }}</p>
                </div>
            </div>
        </div>

        <!-- Review Form -->
        <form action="{{ route('buyer.reviews.update', $review->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Rating -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Rating <span class="text-red-500">*</span>
                </label>
                <div class="flex items-center space-x-1">
                    <template x-for="star in 5" :key="star">
                        <button type="button"
                                @click="setRating(star)"
                                @mouseenter="hoverRating = star"
                                @mouseleave="hoverRating = 0"
                                class="focus:outline-none transition-colors duration-150">
                            <svg class="w-10 h-10" 
                                 :class="star <= (hoverRating || rating) ? 'text-yellow-400' : 'text-gray-300 dark:text-gray-600'"
                                 fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="rating" x-model="rating" required>
                @error('rating')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-show="rating > 0" x-text="getRatingText()"></p>
            </div>

            <!-- Comment -->
            <div class="mb-6">
                <label for="comment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Your Review
                </label>
                <textarea name="comment" 
                          id="comment" 
                          rows="5" 
                          x-model="comment"
                          class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-primary-500 focus:border-transparent"
                          placeholder="Share your thoughts about this product..."></textarea>
                @error('comment')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1" x-show="comment.length > 0">
                    <span x-text="comment.length"></span> / 1000 characters
                </p>
            </div>

            <!-- Existing Photos -->
            @if($review->photos->count() > 0)
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Current Photos
                    </label>
                    <div class="flex flex-wrap gap-4">
                        @foreach($review->photos as $photo)
                            <div class="relative w-24 h-24 sm:w-32 sm:h-32" :class="{ 'opacity-50': isMarkedForDelete({{ $photo->id }}) }">
                                <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                     @click="previewImage('{{ asset('storage/' . $photo->photo_path) }}')"
                                     class="w-full h-full object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                                <button type="button"
                                        @click="markExistingForDelete({{ $photo->id }})"
                                        class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none z-10">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="!isMarkedForDelete({{ $photo->id }})">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" x-show="isMarkedForDelete({{ $photo->id }})" x-cloak>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                </button>
                                <input type="hidden" :name="isMarkedForDelete({{ $photo->id }}) ? 'delete_photos[]' : ''" value="{{ $photo->id }}">
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Add New Photos -->
            <div class="mb-8">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                    Add More Photos (Optional)
                </label>
                <div class="flex flex-wrap items-center gap-4">
                    <label class="flex items-center justify-center w-24 h-24 sm:w-32 sm:h-32 border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-lg cursor-pointer hover:border-primary-500 dark:hover:border-primary-400 transition-colors">
                        <input type="file" 
                               name="photos[]" 
                               multiple 
                               accept="image/*"
                               @change="handlePhotos($event)"
                               class="hidden">
                        <div class="text-center">
                            <svg class="mx-auto h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-1">Add Photo</span>
                        </div>
                    </label>
                    
                    <template x-for="(photo, index) in photoPreviews" :key="index">
                        <div class="relative w-24 h-24 sm:w-32 sm:h-32">
                            <img :src="photo" 
                                 @click="previewImage(photo)"
                                 class="w-full h-full object-cover rounded-lg cursor-pointer hover:opacity-80 transition-opacity">
                            <button type="button"
                                    @click="removePhoto(index)"
                                    class="absolute -top-2 -right-2 bg-red-500 text-white rounded-full p-1 hover:bg-red-600 focus:outline-none z-10">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
                @error('photos.*')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">
                    JPG, JPEG, or PNG. Max 2MB per photo.
                </p>
            </div>

            <!-- Submit Buttons -->
            <div class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
                <a href="{{ route('products.show', $review->product_id) }}" 
                   class="px-6 py-3 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors text-center">
                    Cancel
                </a>
                <button type="submit"
                        :disabled="rating === 0"
                        :class="rating === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-primary-700'"
                        class="px-8 py-3 bg-primary-600 text-white rounded-lg transition-colors font-medium">
                    Update Review
                </button>
            </div>
        </form>
    </div>

    <!-- Image Preview Modal -->
    <div x-show="showModal"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         @click="showModal = false">
        <div class="fixed inset-0 bg-black bg-opacity-75 transition-opacity"></div>
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="relative max-w-5xl w-full" @click.stop>
                <button @click="showModal = false"
                        type="button"
                        class="absolute -top-10 right-0 text-white hover:text-gray-300 focus:outline-none z-10">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
                <img :src="currentImage" 
                     class="w-full h-auto rounded-lg shadow-2xl"
                     alt="Preview">
            </div>
        </div>
    </div>
</div>
@endsection
