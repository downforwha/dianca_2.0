@extends('layouts.admin')
@section('title','Tambah Produk')
@section('page_title','Tambah Produk Baru')
@section('page_subtitle','Masukkan detail produk ke dalam koleksi butik')

@section('content')
<div class="admin-card" style="max-width:800px;">
  <div class="admin-card-body">
    <form action="{{ route('admin.koleksi.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="form-group">
        <label class="form-label">Nama Produk *</label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Kategori *</label>
          <select name="category_id" class="form-control" required>
            <option value="">Pilih Kategori</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
            @endforeach
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Stok *</label>
          <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}" required min="0">
        </div>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Harga (Rp) *</label>
          <input type="number" name="price" class="form-control" value="{{ old('price') }}" required min="0">
        </div>
        <div class="form-group">
          <label class="form-label">Harga Diskon (Opsional)</label>
          <input type="number" name="sale_price" class="form-control" value="{{ old('sale_price') }}" min="0">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Deskripsi Produk</label>
        <textarea name="description" class="form-control" rows="5">{{ old('description') }}</textarea>
      </div>

      <div class="form-grid-2">
        <div class="form-group">
          <label class="form-label">Bahan (Material)</label>
          <input type="text" name="material" class="form-control" value="{{ old('material') }}">
        </div>
        <div class="form-group">
          <label class="form-label">Warna</label>
          <input type="text" name="color" class="form-control" value="{{ old('color') }}">
        </div>
      </div>

      <div class="form-group">
        <label class="form-label">Foto Utama</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <div style="font-size:0.75rem;color:var(--gray);margin-top:4px;">Disarankan: Rasio 3:4 atau 1:1, Max 2MB.</div>
      </div>

      <div class="form-group">
        <label class="form-label" style="display:flex;align-items:center;gap:8px;">
          <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
          Produk Aktif (Tampilkan di Katalog)
        </label>
      </div>
      <div class="form-group">
        <label class="form-label" style="display:flex;align-items:center;gap:8px;">
          <input type="checkbox" name="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
          Jadikan Unggulan (Tampil di Home)
        </label>
      </div>

      <hr style="border:none;border-top:1px solid var(--gray-light);margin:24px 0;">

      <div style="display:flex;gap:12px;">
        <button type="submit" class="btn-admin btn-admin-primary">Simpan Produk</button>
        <a href="{{ route('admin.koleksi.index') }}" class="btn-admin btn-admin-secondary">Batal</a>
      </div>
    </form>
  </div>
</div>
@endsection
