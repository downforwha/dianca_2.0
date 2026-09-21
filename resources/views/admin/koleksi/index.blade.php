@extends('layouts.admin')
@section('title','Pengaturan Koleksi')
@section('page_title','Pengaturan Koleksi')
@section('page_subtitle','Kelola produk dan kategori koleksi butik')

@section('content')

<div class="admin-tabs">
  <button class="admin-tab active" data-tab="produk" onclick="switchTab('produk')">👗 Produk ({{ $products->total() }})</button>
  <button class="admin-tab" data-tab="kategori" onclick="switchTab('kategori')">🏷️ Kategori ({{ $categories->count() }})</button>
</div>

{{-- ── TAB PRODUK ── --}}
<div id="produk" class="tab-content active">
  <div class="admin-filter-bar">
    <form method="GET" action="{{ route('admin.koleksi.index') }}" style="display:flex;gap:12px;flex:1;flex-wrap:wrap;">
      <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari produk..." class="form-control" style="flex:1;min-width:200px;">
      <select name="kategori" class="form-control" style="width:180px;" onchange="this.form.submit()">
        <option value="">Semua Kategori</option>
        @foreach($categories as $cat)
          <option value="{{ $cat->id }}" {{ request('kategori') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
        @endforeach
      </select>
      <select name="status" class="form-control" style="width:150px;" onchange="this.form.submit()">
        <option value="">Semua Status</option>
        <option value="active" {{ request('status')=='active' ? 'selected' : '' }}>Aktif</option>
        <option value="inactive" {{ request('status')=='inactive' ? 'selected' : '' }}>Nonaktif</option>
        <option value="low_stock" {{ request('status')=='low_stock' ? 'selected' : '' }}>Stok Sedikit</option>
      </select>
      <button type="submit" class="btn-admin btn-admin-primary">Cari</button>
    </form>
    <button class="btn-admin btn-admin-primary" onclick="openModal('modalAddProduct')">+ Tambah Produk</button>
  </div>

  <div class="admin-card">
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th style="width:50px;">#</th>
            <th>Produk</th>
            <th>Kategori</th>
            <th>Harga</th>
            <th>Stok</th>
            <th>Ukuran</th>
            <th>Wishlist</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($products as $product)
          <tr>
            <td style="color:var(--gray);font-size:0.8rem;">{{ $products->firstItem() + $loop->index }}</td>
            <td>
              <div style="display:flex;align-items:center;gap:12px;">
                @if($product->image)
                  <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="product-thumb">
                @else
                  <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;font-size:1.5rem;background:var(--cream);">
                    {{ $product->category->icon ?? '👗' }}
                  </div>
                @endif
                <div>
                  <div style="font-weight:600;font-size:0.9rem;">{{ $product->name }}</div>
                  <div style="font-size:0.75rem;color:var(--gray);">{{ $product->slug }}</div>
                </div>
              </div>
            </td>
            <td><span class="badge badge-primary">{{ $product->category->name }}</span></td>
            <td>
              <div style="font-weight:700;font-size:0.88rem;color:var(--primary-dark);">Rp {{ number_format($product->price,0,',','.') }}</div>
              @if($product->sale_price)<div style="font-size:0.75rem;color:var(--danger);">Sale: Rp {{ number_format($product->sale_price,0,',','.') }}</div>@endif
            </td>
            <td>
              <span class="badge {{ $product->stock === 0 ? 'badge-danger' : ($product->stock <= 5 ? 'badge-warning' : 'badge-success') }}">
                {{ $product->stock }} pcs
              </span>
            </td>
            <td>
              @if($product->sizes)
                <div style="display:flex;gap:3px;flex-wrap:wrap;">
                  @foreach(array_slice($product->sizes, 0, 4) as $sz)
                    <span style="font-size:0.68rem;padding:2px 6px;border-radius:4px;background:var(--gray-light);color:var(--dark);">{{ $sz }}</span>
                  @endforeach
                  @if(count($product->sizes) > 4)
                    <span style="font-size:0.68rem;color:var(--gray);">+{{ count($product->sizes)-4 }}</span>
                  @endif
                </div>
              @else <span style="color:var(--gray);font-size:0.8rem;">—</span> @endif
            </td>
            <td>
              <span class="badge badge-danger">❤️ {{ $product->wishlists_count ?? 0 }}</span>
            </td>
            <td>
              <form action="{{ route('admin.koleksi.toggle', $product) }}" method="POST">
                @csrf @method('PATCH')
                <label class="toggle-switch">
                  <input type="checkbox" {{ $product->is_active ? 'checked' : '' }} onchange="this.form.submit()">
                  <div class="toggle-slider"></div>
                </label>
              </form>
            </td>
            <td>
              <div style="display:flex;gap:6px;">
                <button class="btn-admin btn-admin-secondary btn-admin-icon btn-admin-sm"
                        onclick="editProduct({{ json_encode($product) }})" title="Edit">✏️</button>
                <form action="{{ route('admin.koleksi.destroy', $product) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-admin btn-admin-danger btn-admin-icon btn-admin-sm" title="Hapus">🗑️</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="8" style="text-align:center;padding:36px;color:var(--gray);">
            <div style="font-size:2.5rem;margin-bottom:12px;">📦</div>
            Belum ada produk. <button class="btn-admin btn-admin-primary btn-admin-sm" onclick="openModal('modalAddProduct')">Tambah Produk</button>
          </td></tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    @if($products->hasPages())
    <div class="admin-card-body" style="padding-top:0;">
      <div class="admin-pagination">
        @foreach($products->links()->elements[0] ?? [] as $page => $url)
          <a href="{{ $url }}" class="page-link {{ $products->currentPage() == $page ? 'active' : '' }}">{{ $page }}</a>
        @endforeach
      </div>
    </div>
    @endif
  </div>
</div>

{{-- ── TAB KATEGORI ── --}}
<div id="kategori" class="tab-content">
  <div style="display:flex;justify-content:flex-end;margin-bottom:16px;">
    <button class="btn-admin btn-admin-primary" onclick="openModal('modalAddCategory')">+ Tambah Kategori</button>
  </div>
  <div class="admin-card">
    <div class="table-wrap">
      <table class="admin-table">
        <thead><tr><th>#</th><th>Ikon</th><th>Nama Kategori</th><th>Slug</th><th>Produk</th><th>Status</th><th>Aksi</th></tr></thead>
        <tbody>
          @forelse($categories as $cat)
          <tr>
            <td style="color:var(--gray);font-size:0.8rem;">{{ $loop->iteration }}</td>
            <td style="font-size:1.5rem;">{{ $cat->icon ?? '👗' }}</td>
            <td style="font-weight:600;">{{ $cat->name }}</td>
            <td style="color:var(--gray);font-size:0.82rem;">{{ $cat->slug }}</td>
            <td><span class="badge badge-info">{{ $cat->products_count }} produk</span></td>
            <td><span class="badge {{ $cat->is_active ? 'badge-success' : 'badge-secondary' }}">{{ $cat->is_active ? 'Aktif' : 'Nonaktif' }}</span></td>
            <td>
              <div style="display:flex;gap:6px;">
                <button class="btn-admin btn-admin-secondary btn-admin-icon" onclick="editCategory({{ json_encode($cat) }})">✏️</button>
                <form action="{{ route('admin.koleksi.kategori.destroy', $cat) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                  @csrf @method('DELETE')
                  <button type="submit" class="btn-admin btn-admin-danger btn-admin-icon">🗑️</button>
                </form>
              </div>
            </td>
          </tr>
          @empty
          <tr><td colspan="7" style="text-align:center;padding:24px;color:var(--gray);">Belum ada kategori</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>

{{-- ── MODAL ADD/EDIT PRODUCT ── --}}
<div class="modal-overlay" id="modalAddProduct">
  <div class="modal" style="max-width:700px;">
    <div class="modal-header">
      <h3 id="modalProductTitle">✨ Tambah Produk Baru</h3>
      <span class="modal-close" onclick="closeModal('modalAddProduct')">✕</span>
    </div>
    <form action="{{ route('admin.koleksi.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
      @csrf
      <input type="hidden" name="_method" id="productMethod" value="POST">
      <input type="hidden" name="product_id" id="editProductId">
      <div class="modal-body">
        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Nama Produk *</label>
            <input type="text" name="name" id="pName" class="form-control" required placeholder="Nama produk...">
          </div>
          <div class="form-group">
            <label class="form-label">Kategori *</label>
            <select name="category_id" id="pCat" class="form-control" required>
              <option value="">Pilih kategori...</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->icon ?? '' }} {{ $cat->name }}</option>
              @endforeach
            </select>
          </div>
        </div>
        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Harga *</label>
            <input type="number" name="price" id="pPrice" class="form-control" required placeholder="150000">
          </div>
          <div class="form-group">
            <label class="form-label">Harga Sale (opsional)</label>
            <input type="number" name="sale_price" id="pSalePrice" class="form-control" placeholder="120000">
          </div>
        </div>
        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Stok *</label>
            <input type="number" name="stock" id="pStock" class="form-control" required placeholder="10" min="0">
          </div>
          <div class="form-group">
            <label class="form-label">Bahan</label>
            <input type="text" name="material" id="pMaterial" class="form-control" placeholder="Katun, Sifon, dll.">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Warna Tersedia</label>
          <input type="text" name="color" id="pColor" class="form-control" placeholder="Merah, Biru, Hitam, Putih">
        </div>
        <div class="form-group">
          <label class="form-label">Ukuran Tersedia</label>
          <div class="size-check-group" id="sizeCheckGroup">
            @foreach(['XS','S','M','L','XL','XXL','XXXL','Free Size'] as $s)
              <label class="size-check" id="sc-{{ $s }}">
                <input type="checkbox" name="sizes[]" value="{{ $s }}"> {{ $s }}
              </label>
            @endforeach
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" id="pDesc" class="form-control" rows="3" placeholder="Deskripsi singkat produk..."></textarea>
        </div>
        <div class="form-group">
          <label class="form-label">Foto Produk</label>
          <div class="upload-area" onclick="document.getElementById('productImg').click()">
            <div class="upload-icon">📷</div>
            <p>Klik untuk upload foto produk</p>
            <p><span>Browse file</span> atau drag & drop</p>
          </div>
          <input type="file" id="productImg" name="image" accept="image/*" style="display:none;" onchange="previewImg(this)">
          <div id="imgPreviewWrap" class="image-preview"></div>
        </div>
        <div class="form-group">
          <label class="form-label">Foto Tambahan (opsional, maks. 5)</label>
          <input type="file" name="gallery[]" multiple accept="image/*" class="form-control">
        </div>
        <div style="display:flex;gap:20px;">
          <label class="form-check">
            <input type="checkbox" name="is_active" id="pActive" value="1" checked>
            <label style="font-size:0.88rem;">Produk Aktif</label>
          </label>
          <label class="form-check">
            <input type="checkbox" name="is_featured" id="pFeatured" value="1">
            <label style="font-size:0.88rem;">Tampil di Homepage</label>
          </label>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-admin btn-admin-secondary" onclick="closeModal('modalAddProduct')">Batal</button>
        <button type="submit" class="btn-admin btn-admin-primary" id="productSubmitBtn">💾 Simpan Produk</button>
      </div>
    </form>
  </div>
</div>

{{-- ── MODAL ADD/EDIT CATEGORY ── --}}
<div class="modal-overlay" id="modalAddCategory">
  <div class="modal" style="max-width:480px;">
    <div class="modal-header">
      <h3 id="modalCatTitle">🏷️ Tambah Kategori</h3>
      <span class="modal-close" onclick="closeModal('modalAddCategory')">✕</span>
    </div>
    <form action="{{ route('admin.koleksi.kategori.store') }}" method="POST" id="categoryForm">
      @csrf
      <input type="hidden" name="_method" id="catMethod" value="POST">
      <input type="hidden" name="category_id" id="editCatId">
      <div class="modal-body">
        <div class="form-group">
          <label class="form-label">Nama Kategori *</label>
          <input type="text" name="name" id="cName" class="form-control" required placeholder="Nama kategori...">
        </div>
        <div class="form-group">
          <label class="form-label">Ikon (emoji)</label>
          <input type="text" name="icon" id="cIcon" class="form-control" placeholder="👗" maxlength="5">
          <div style="font-size:0.78rem;color:var(--gray);margin-top:4px;">Gunakan emoji sebagai ikon, contoh: 👗 👜 💍</div>
        </div>
        <div class="form-group">
          <label class="form-label">Deskripsi</label>
          <textarea name="description" id="cDesc" class="form-control" rows="2" placeholder="Deskripsi singkat kategori..."></textarea>
        </div>
        <label class="form-check">
          <input type="checkbox" name="is_active" id="cActive" value="1" checked>
          <label style="font-size:0.88rem;">Kategori Aktif</label>
        </label>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-admin btn-admin-secondary" onclick="closeModal('modalAddCategory')">Batal</button>
        <button type="submit" class="btn-admin btn-admin-primary">💾 Simpan Kategori</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
// Size checkboxes
document.querySelectorAll('.size-check input').forEach(cb => {
  cb.addEventListener('change', function() {
    this.closest('.size-check').classList.toggle('checked', this.checked);
  });
});

// Image preview
function previewImg(input) {
  const wrap = document.getElementById('imgPreviewWrap');
  wrap.innerHTML = '';
  if (input.files[0]) {
    const img = document.createElement('img');
    img.src = URL.createObjectURL(input.files[0]);
    img.className = 'preview-thumb';
    wrap.appendChild(img);
  }
}

// Edit Product
function editProduct(p) {
  document.getElementById('modalProductTitle').textContent = '✏️ Edit Produk';
  document.getElementById('productMethod').value = 'PUT';
  document.getElementById('productForm').action = `/admin/koleksi/${p.id}`;
  document.getElementById('editProductId').value = p.id;
  document.getElementById('pName').value     = p.name;
  document.getElementById('pPrice').value    = p.price;
  document.getElementById('pSalePrice').value= p.sale_price || '';
  document.getElementById('pStock').value    = p.stock;
  document.getElementById('pCat').value      = p.category_id;
  document.getElementById('pMaterial').value = p.material || '';
  document.getElementById('pColor').value    = p.color || '';
  document.getElementById('pDesc').value     = p.description || '';
  document.getElementById('pActive').checked   = !!p.is_active;
  document.getElementById('pFeatured').checked = !!p.is_featured;

  // Sizes
  const sizes = p.sizes || [];
  document.querySelectorAll('.size-check input').forEach(cb => {
    const checked = sizes.includes(cb.value);
    cb.checked = checked;
    cb.closest('.size-check').classList.toggle('checked', checked);
  });

  document.getElementById('productSubmitBtn').textContent = '💾 Update Produk';
  openModal('modalAddProduct');
}

// Edit Category
function editCategory(c) {
  document.getElementById('modalCatTitle').textContent = '✏️ Edit Kategori';
  document.getElementById('catMethod').value = 'PUT';
  document.getElementById('categoryForm').action = `/admin/koleksi/kategori/${c.id}`;
  document.getElementById('editCatId').value = c.id;
  document.getElementById('cName').value  = c.name;
  document.getElementById('cIcon').value  = c.icon || '';
  document.getElementById('cDesc').value  = c.description || '';
  document.getElementById('cActive').checked = !!c.is_active;
  openModal('modalAddCategory');
}
</script>
@endpush
@endsection
