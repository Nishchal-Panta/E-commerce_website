<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewPhoto;
use App\Models\Product;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function create(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Check if user has purchased this product
        if (!auth()->user()->hasPurchased($request->product_id)) {
            return redirect()->back()->with('error', 'You can only review products you have purchased.');
        }

        // Check if user has already reviewed this product
        if (Review::where('product_id', $request->product_id)
            ->where('buyer_id', auth()->id())
            ->exists()) {
            return redirect()->back()->with('error', 'You have already reviewed this product.');
        }

        return view('buyer.review-create', compact('product'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Check if user has purchased this product
        if (!auth()->user()->hasPurchased($request->product_id)) {
            return back()->with('error', 'You can only review products you have purchased.');
        }

        // Check if user has already reviewed this product
        if (Review::where('product_id', $request->product_id)
            ->where('buyer_id', auth()->id())
            ->exists()) {
            return back()->with('error', 'You have already reviewed this product.');
        }

        $review = Review::create([
            'product_id' => $request->product_id,
            'buyer_id' => auth()->id(),
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Handle photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('review_photos', 'public');
                ReviewPhoto::create([
                    'review_id' => $review->id,
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('buyer.orders.index')
        ->with('success', 'Review submitted successfully!');
    }

    public function edit($id)
    {
        $review = Review::with(['photos', 'product'])->findOrFail($id);

        // Check if the authenticated user is the owner of the review
        if ($review->buyer_id !== auth()->id()) {
            return redirect()->back()->with('error', 'You can only edit your own reviews.');
        }

        return view('buyer.review-edit', compact('review'));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        // Check if the authenticated user is the owner of the review
        if ($review->buyer_id !== auth()->id()) {
            return back()->with('error', 'You can only edit your own reviews.');
        }

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'delete_photos' => 'nullable|array',
            'delete_photos.*' => 'exists:review_photos,id',
        ]);

        $review->update([
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        // Delete selected photos
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                $photo = ReviewPhoto::find($photoId);
                if ($photo && $photo->review_id === $review->id) {
                    \Storage::disk('public')->delete($photo->photo_path);
                    $photo->delete();
                }
            }
        }

        // Handle new photo uploads
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                $path = $photo->store('review_photos', 'public');
                ReviewPhoto::create([
                    'review_id' => $review->id,
                    'photo_path' => $path,
                ]);
            }
        }

        return redirect()->route('products.show', $review->product_id)
            ->with('success', 'Review updated successfully!');
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        // Check if the authenticated user is the owner of the review
        if ($review->buyer_id !== auth()->id()) {
            return back()->with('error', 'You can only delete your own reviews.');
        }

        // Delete associated photos from storage
        foreach ($review->photos as $photo) {
            \Storage::disk('public')->delete($photo->photo_path);
            $photo->delete();
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully!');
    }
}
