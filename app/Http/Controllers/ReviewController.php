<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240' // 10MB max limit as per requirement
        ], [
            'photo.max' => 'Ukuran foto maksimal adalah 10MB.'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reviews', 'public');
        }

        \App\Models\Review::create([
            'product_id' => $productId,
            'name' => $request->name,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'photo' => $photoPath,
            'is_visible' => true // Default visible
        ]);

        return back()->with('success', 'Terima kasih! Review Anda telah berhasil dikirim.');
    }
}
