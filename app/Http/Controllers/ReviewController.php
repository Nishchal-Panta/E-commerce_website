<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewPhoto;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
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

        return back()->with('success', 'Review submitted successfully!');
    }
}
