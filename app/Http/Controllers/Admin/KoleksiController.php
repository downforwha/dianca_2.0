<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class KoleksiController extends Controller
{
    // ─── PRODUCTS ─────────────────────────────────────────────

    public function index(Request $request)
    {
        $query = Product::with('category')->withCount('wishlists');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('kategori')) {
            $query->where('category_id', $request->kategori);
        }
        if ($request->filled('status')) {
            match ($request->status) {
                'active'    => $query->where('is_active', true),
                'inactive'  => $query->where('is_active', false),
                'low_stock' => $query->where('stock', '<=', 5),
                default     => null,
            };
        }

        $products   = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $categories = Category::orderBy('sort_order')->withCount('products')->get();

        return view('admin.koleksi.index', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'sale_price'   => 'nullable|numeric|min:0',
            'sizes'        => 'nullable|array',
            'material'     => 'nullable|string|max:100',
            'color'        => 'nullable|string|max:100',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'gallery.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $data['description'] = $data['description'] ? strip_tags($data['description'], '<b><i><u><strong><em><p><br><ul><ol><li>') : null;
        $data['slug']        = Str::slug($data['name']) . '-' . Str::random(4);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        Product::create($data);
        return redirect()->route('admin.koleksi.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id'  => 'required|exists:categories,id',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'sale_price'   => 'nullable|numeric|min:0',
            'sizes'        => 'nullable|array',
            'material'     => 'nullable|string|max:100',
            'color'        => 'nullable|string|max:100',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
            'gallery.*'    => 'nullable|image|mimes:jpeg,png,jpg,webp|max:10240',
        ]);

        $data['description'] = $data['description'] ? strip_tags($data['description'], '<b><i><u><strong><em><p><br><ul><ol><li>') : null;
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_active']   = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            if ($product->image) Storage::disk('public')->delete($product->image);
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        if ($request->hasFile('gallery')) {
            if ($product->gallery) {
                foreach ($product->gallery as $old) {
                    Storage::disk('public')->delete($old);
                }
            }
            $gallery = [];
            foreach ($request->file('gallery') as $file) {
                $gallery[] = $file->store('products/gallery', 'public');
            }
            $data['gallery'] = $gallery;
        }

        $product->update($data);
        return redirect()->route('admin.koleksi.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) Storage::disk('public')->delete($product->image);
        if ($product->gallery) {
            foreach ($product->gallery as $img) {
                Storage::disk('public')->delete($img);
            }
        }
        $product->delete();
        return redirect()->route('admin.koleksi.index')->with('success', 'Produk berhasil dihapus!');
    }

    public function toggle(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);
        return back()->with('success', 'Status produk diperbarui!');
    }

    // ─── CATEGORIES ────────────────────────────────────────────

    public function storeCategory(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'icon'        => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

        Category::create($data);
        return redirect()->route('admin.koleksi.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function updateCategory(Request $request, Category $category)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'icon'        => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'is_active'   => 'boolean',
        ]);
        $data['slug']      = Str::slug($data['name']);
        $data['is_active'] = $request->boolean('is_active', true);

        $category->update($data);
        return redirect()->route('admin.koleksi.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroyCategory(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang masih memiliki produk.');
        }
        $category->delete();
        return redirect()->route('admin.koleksi.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
