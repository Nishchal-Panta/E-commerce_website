@extends('layouts.admin')

@section('title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">{{ isset($product) ? 'Edit Product' : 'Add New Product' }}</h1>
    
    <form action="{{ isset($product) ? route('admin.products.update', $product->id) : route('admin.products.store') }}" 
        method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6">
        @csrf
        @if(isset($product))
            @method('PUT')
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Name -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" required
                    class="input-field @error('name') border-red-500 @enderror">
                @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Description -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
                <textarea name="description" rows="4" required
                    class="input-field @error('description') border-red-500 @enderror">{{ old('description', $product->description ?? '') }}</textarea>
                @error('description')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Price -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Price ($) *</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price ?? '') }}" required
                    class="input-field @error('price') border-red-500 @enderror">
                @error('price')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Category -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                <input type="text" name="category" value="{{ old('category', $product->category ?? '') }}" required
                    class="input-field @error('category') border-red-500 @enderror" list="categories">
                <datalist id="categories">
                    @foreach($categories as $cat)
                    <option value="{{ $cat }}">
                    @endforeach
                </datalist>
                @error('category')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Brand -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Brand</label>
                <input type="text" name="brand" value="{{ old('brand', $product->brand ?? '') }}"
                    class="input-field @error('brand') border-red-500 @enderror">
                @error('brand')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Color -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Color</label>
                <input type="text" name="color" value="{{ old('color', $product->color ?? '') }}"
                    class="input-field @error('color') border-red-500 @enderror">
                @error('color')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Size -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Size</label>
                <input type="text" name="size" value="{{ old('size', $product->size ?? '') }}"
                    class="input-field @error('size') border-red-500 @enderror">
                @error('size')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Inventory Quantity -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Inventory Quantity *</label>
                <input type="number" name="inventory_quantity" value="{{ old('inventory_quantity', $product->inventory_quantity ?? 0) }}" required
                    class="input-field @error('inventory_quantity') border-red-500 @enderror">
                @error('inventory_quantity')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Low Stock Threshold -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Low Stock Threshold *</label>
                <input type="number" name="low_stock_threshold" value="{{ old('low_stock_threshold', $product->low_stock_threshold ?? 10) }}" required
                    class="input-field @error('low_stock_threshold') border-red-500 @enderror">
                @error('low_stock_threshold')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            <!-- Is Trending -->
            <div class="md:col-span-2">
                <label class="flex items-center">
                    <input type="checkbox" name="is_trending" value="1" 
                        {{ old('is_trending', $product->is_trending ?? false) ? 'checked' : '' }}
                        class="mr-2">
                    <span class="text-sm font-medium text-gray-700">Mark as Trending Product</span>
                </label>
            </div>
            
            <!-- Product Images -->
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Product Images {{ !isset($product) ? '*' : '' }}
                </label>
                <input type="file" name="images[]" multiple accept="image/*" 
                    {{ !isset($product) ? 'required' : '' }}
                    class="input-field @error('images.*') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">You can select multiple images</p>
                @error('images.*')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>
            
            @if(isset($product) && $product->images->count() > 0)
            <div class="md:col-span-2">
                <label class="block text-sm font-medium text-gray-700 mb-2">Current Images</label>
                <div class="flex flex-wrap gap-4">
                    @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" 
                        class="w-24 h-24 object-cover rounded-lg" alt="Product image">
                    @endforeach
                </div>
            </div>
            @endif
        </div>
        
        <div class="flex space-x-4 mt-6">
            <button type="submit" class="btn-primary">
                <i class="fas fa-save mr-2"></i> {{ isset($product) ? 'Update' : 'Create' }} Product
            </button>
            <a href="{{ route('admin.products.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
