<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class ReviewController extends Controller
{
    public function store(Request $request, $productId)
    {
        // Rate limit: max 5 reviews per IP per minute
        $key = 'review:' . $request->ip();
        if (RateLimiter::tooManyAttempts($key, 5)) {
            $seconds = RateLimiter::availableIn($key);
            return back()->with('error', 'Terlalu banyak percobaan. Coba lagi dalam ' . $seconds . ' detik.');
        }
        RateLimiter::hit($key, 60);

        $request->validate([
            'name'    => 'required|string|max:255',
            'rating'  => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
            'photo'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240'
        ], [
            'photo.max' => 'Ukuran foto maksimal adalah 10MB.'
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('reviews', 'public');
        }

        \App\Models\Review::create([
            'product_id' => $productId,
            'name'       => $request->name,
            'rating'     => $request->rating,
            'comment'    => $request->comment,
            'photo'      => $photoPath,
            'is_visible' => false // Default hidden — admin must approve
        ]);

        return back()->with('success', 'Terima kasih! Review Anda sedang menunggu moderasi.');
    }
}
