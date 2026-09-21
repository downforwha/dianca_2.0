<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = \App\Models\Review::with('product')->latest()->get();
        return view('admin.reviews.index', compact('reviews'));
    }

    public function toggleVisibility($id)
    {
        $review = \App\Models\Review::findOrFail($id);
        $review->is_visible = !$review->is_visible;
        $review->save();

        $status = $review->is_visible ? 'ditampilkan' : 'disembunyikan';
        return back()->with('success', "Review berhasil {$status}.");
    }
}
