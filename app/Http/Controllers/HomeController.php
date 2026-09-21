<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Setting;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Product::featured()->with('category')->orderBy('sort_order')->limit(8)->get();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->withCount('activeProducts')->get();
        $wishlisted = \App\Models\Wishlist::where('session_id', \Illuminate\Support\Facades\Session::getId())->pluck('product_id')->toArray();
        return view('konsumen.home', compact('featured', 'categories', 'wishlisted'));
    }

    public function koleksi(Request $request)
    {
        $query = Product::active()->with('category');

        if ($request->filled('kategori')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->kategori));
        }

        if ($request->filled('search')) {
            $keyword = $request->search;
            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('sort')) {
            match($request->sort) {
                'price_asc'  => $query->orderBy('price', 'asc'),
                'price_desc' => $query->orderBy('price', 'desc'),
                'newest'     => $query->orderBy('created_at', 'desc'),
                default      => $query->orderBy('sort_order'),
            };
        } else {
            $query->orderBy('sort_order');
        }

        $products = $query->paginate(12)->withQueryString();
        $categories = Category::where('is_active', true)->orderBy('sort_order')->get();
        $activeCategory = $request->kategori;
        $wishlisted = \App\Models\Wishlist::where('session_id', \Illuminate\Support\Facades\Session::getId())->pluck('product_id')->toArray();

        if ($request->ajax()) {
            return view('konsumen.partials.product-grid', compact('products', 'wishlisted'))->render();
        }

        return view('konsumen.koleksi', compact('products', 'categories', 'activeCategory', 'wishlisted'));
    }

    public function detail(string $slug)
    {
        $product = Product::active()->where('slug', $slug)
            ->with(['category', 'reviews' => function($q) {
                $q->where('is_visible', true)->latest();
            }])->firstOrFail();
        $related = Product::active()
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit(4)->get();
        return view('konsumen.detail', compact('product', 'related'));
    }

    public function portfolio()
    {
        // For the portfolio, we'll fetch some featured/premium products
        // Alternatively, if there were a specific portfolio model, we'd use it.
        // We will just pass premium items for showcase.
        $portfolioItems = Product::active()->where('is_featured', true)->inRandomOrder()->limit(12)->get();
        return view('konsumen.portfolio', compact('portfolioItems'));
    }

    public function about()
    {
        return view('konsumen.about');
    }

    public function sizeGuide()
    {
        return view('konsumen.size-guide');
    }

    public function kontak()
    {
        $products = Product::active()->orderBy('name')->get(['id', 'name', 'price', 'sizes']);
        return view('konsumen.kontak', compact('products'));
    }
}
