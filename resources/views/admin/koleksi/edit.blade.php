@extends('layouts.admin')
@section('title','Edit Produk')
@section('page_title','Edit Produk: '.$product->name)
@section('page_subtitle','Perbarui informasi produk')

@section('content')
<div class="admin-card" style="max-width:800px;">
  <div class="admin-card-body">
    <form action="{{ route('admin.koleksi.update', $product) }}" method="POST" enctype="multipart/form-data">
      @csrf @method('PUT')

      <div class="form-group">
        <label class="form-label">Nama Produk *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name', $product->name) }}" required>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Kategori *</label>
          <select name="category_id" class="form-control" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id', $product->category_id) == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Stok *</label>
          <input type="number" name="stock" class="form-control" value="{{ old('stock', $product->stock) }}" required min="0">
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Harga (Rp) *</label>
          <input type="number" name="price" class="form-control" value="{{ old('price', $product->price) }}" required min="0">
        </div>
        <div class="form-group">
          <label class="form-label">Harga Diskon (Opsional)</label>
          <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price', $product->sale_price) }}" min="0">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Produk</label>
        <textarea name="description" class="form-control" rows="5">{{ old('description', $product->description) }}</textarea>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Bahan (Material)</label>
          <input type="text" name="material" class="form-control" value="{{ old('material', $product->material) }}">
        </div>
        <div class="form-group">
          <label class="form-label">Warna</label>
          <input type="text" name="color" class="form-control" value="{{ old('color', $product->color) }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Foto Utama</label>
        @if($product->image)
          <div style="margin-bottom:8px;">
            <img src="{{ Storage::url($product->image) }}" alt="Preview" style="height:100px;border-radius:8px;object-fit:cover;">
          </div>
        @endif
        <input type="file" name="image" class="form-control" accept="image/*">
        <div style="font-size:0.75rem;color:var(--gray);margin-top:4px;">Kosongkan jika tidak ingin mengubah gambar. Max 2MB.</div>
      </div>

      <div class="form-group">
        <label class="form-label" style="display:flex;align-items:center;gap:8px;">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
          Produk Aktif (Tampilkan di Katalog)
        </label>
      </div>
      <div class="form-group">
        <label class="form-label" style="display:flex;align-items:center;gap:8px;">
          <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
          Jadikan Unggulan (Tampil di Home)
        </label>
      </div>

      <hr style="border:none;border-top:1px solid var(--gray-light);margin:24px 0;">

      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-admin btn-admin-primary">Perbarui Produk</button>
        <a href="{{ route('admin.koleksi.index') }}" class="btn-admin btn-admin-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
