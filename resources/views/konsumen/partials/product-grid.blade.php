@if($products->isEmpty())
  <div style="text-align:center;padding:80px 20px;color:var(--gray);">
    <div style="font-size:4rem;margin-bottom:20px;">🔍</div>
    <h3 style="margin-bottom:12px;">Produk tidak ditemukan</h3>
    <p>Coba ubah kata kunci atau kategori pencarian Anda.</p>
    <a href="{{ route('koleksi') }}" class="btn btn-outline" style="margin-top:24px;">Lihat Semua Produk</a>
  </div>
@else
  <div class="grid-3">
    @foreach($products as $product)
    <div class="product-card">
      <div class="product-card__img-wrap" style="border: 1px solid #D4AF37; box-shadow: 0 10px 25px rgba(0,0,0,0.05); border-radius: var(--radius); overflow: hidden;">
        @if($product->image)
          <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" loading="lazy">
        @else
          @php
              $prodImages = [
                  'prod_1_1789934824990.png',
                  'prod_2_1789934839818.png',
                  'prod_3_1789934853254.png',
                  'prod_4_1789934870113.png'
              ];
              $fallbackBg = asset('assets/images/redesign/' . $prodImages[$product->id % 4]);
          @endphp
          <img src="{{ $fallbackBg }}" alt="{{ $product->name }}" loading="lazy" style="width:100%; height:100%; object-fit:cover;">
        @endif
        @if($product->sale_price)<span class="product-card__badge sale">SALE</span>@endif
        @if($product->stock == 1 || $product->wishlists()->count() > 5)
          <span class="product-card__badge" style="background:#D32F2F;color:white;top:12px;left:12px;{{ $product->sale_price ? 'top:42px;' : '' }}">🔥 TRENDING</span>
        @endif
        <div class="product-card__overlay">
          <a href="{{ route('produk.detail', $product->slug) }}" class="btn btn-white btn-sm">Lihat Detail</a>
        </div>
        <button onclick="toggleWishlist({{ $product->id }}, this)" 
                class="wishlist-btn" 
                style="position:absolute;top:12px;right:12px;background:white;border:none;border-radius:50%;width:36px;height:36px;display:flex;align-items:center;justify-content:center;cursor:pointer;box-shadow:0 2px 8px rgba(0,0,0,0.1);z-index:2;font-size:1.2rem;transition:transform 0.2s;">
          {!! in_array($product->id, $wishlisted ?? []) ? '❤️' : '🤍' !!}
        </button>
      </div>
      <div class="product-card__body">
        <div class="product-card__cat">{{ $product->category->name }}</div>
        <a href="{{ route('produk.detail', $product->slug) }}">
          <div class="product-card__name" style="font-family: 'Cormorant Garamond', serif; font-size: 1.4rem; font-weight: 600;">{{ $product->name }}</div>
        </a>
        @if($product->material)
          <div style="font-size:0.78rem;color:var(--gray);margin-bottom:8px;">{{ $product->material }} · {{ $product->color }}</div>
        @endif
        <div class="product-card__price">
          @if($product->sale_price)
            <span class="price-new">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
            <span class="price-old">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
          @else
            <span class="price-new">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
          @endif
        </div>
        @if($product->sizes)
        <div class="product-card__sizes">
          @foreach($product->sizes as $sz)
            <span class="size-tag">{{ $sz }}</span>
          @endforeach
        </div>
        @endif
        <a href="{{ route('kontak') }}?produk={{ urlencode($product->name) }}&harga={{ $product->price }}"
           class="btn btn-wa btn-sm" style="margin-top:14px;width:100%;justify-content:center;">
          💬 Pesan via WA
        </a>
      </div>
    </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  <div class="pagination">
    @if($products->onFirstPage())
      <span class="page-btn" style="opacity:0.4;">←</span>
    @else
      <a href="{{ $products->previousPageUrl() }}" class="page-btn ajax-page" data-url="{{ $products->previousPageUrl() }}">←</a>
    @endif

    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
      <a href="{{ $url }}" class="page-btn ajax-page {{ $products->currentPage() === $page ? 'active' : '' }}" data-url="{{ $url }}">{{ $page }}</a>
    @endforeach

    @if($products->hasMorePages())
      <a href="{{ $products->nextPageUrl() }}" class="page-btn ajax-page" data-url="{{ $products->nextPageUrl() }}">→</a>
    @else
      <span class="page-btn" style="opacity:0.4;">→</span>
    @endif
  </div>

  <p style="text-align:center;color:var(--gray);font-size:0.85rem;margin-top:16px;">
    Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }} produk
  </p>
@endif
