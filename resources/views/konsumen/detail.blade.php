@extends('layouts.app')
@section('title', $product->name)
@section('page_title', $product->name)

@section('content')
<div style="padding-top:72px;"></div>

<div class="container" style="padding:48px 24px;">
  {{-- Breadcrumb --}}
  <div style="display:flex;align-items:center;gap:8px;font-size:0.85rem;color:var(--gray);margin-bottom:36px;">
    <a href="{{ route('home') }}" style="color:var(--primary)">Home</a>
    <span>›</span>
    <a href="{{ route('koleksi') }}" style="color:var(--primary)">Koleksi</a>
    <span>›</span>
    <a href="{{ route('koleksi') }}?kategori={{ $product->category->slug }}" style="color:var(--primary)">{{ $product->category->name }}</a>
    <span>›</span>
    <span style="color:var(--black)">{{ $product->name }}</span>
  </div>

  <div class="grid-2" style="gap:60px;align-items:start;">
    {{-- Images --}}
    <div>
      <div style="border-radius:20px;overflow:hidden;background:var(--cream);aspect-ratio:3/4;display:flex;align-items:center;justify-content:center;border:1px solid #D4AF37;box-shadow: 0 4px 20px rgba(212,175,55,0.1);">
        @if($product->image)
          <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" style="width:100%;height:100%;object-fit:cover;" id="mainImg">
        @else
          <div style="font-size:8rem;">{{ $product->category->icon ?? '👗' }}</div>
        @endif
      </div>
      {{-- Gallery --}}
      @if($product->gallery && count($product->gallery) > 0)
      <div style="display:flex;gap:10px;margin-top:12px;flex-wrap:wrap;">
        @if($product->image)
        <img src="{{ asset('storage/'.$product->image) }}" alt="Main" onclick="switchImg(this.src)"
             style="width:72px;height:72px;object-fit:cover;border-radius:10px;cursor:pointer;border:2px solid var(--primary);">
        @endif
        @foreach($product->gallery as $img)
        <img src="{{ asset('storage/'.$img) }}" alt="Foto {{ $loop->iteration }}" onclick="switchImg(this.src)"
             style="width:72px;height:72px;object-fit:cover;border-radius:10px;cursor:pointer;border:2px solid var(--gray-light);">
        @endforeach
      </div>
      @endif
    </div>

    {{-- Info --}}
    <div>
      <div style="font-size:0.75rem;letter-spacing:0.15em;text-transform:uppercase;color:var(--primary);margin-bottom:10px;">{{ $product->category->name }}</div>
      <h1 style="font-size:2rem;margin-bottom:16px;">{{ $product->name }}</h1>

      {{-- Price --}}
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:24px;">
        @if($product->sale_price)
          <span style="font-size:1.8rem;font-weight:700;color:var(--primary-dark);">Rp {{ number_format($product->sale_price,0,',','.') }}</span>
          <span style="font-size:1.1rem;color:var(--gray);text-decoration:line-through;">Rp {{ number_format($product->price,0,',','.') }}</span>
          <span style="background:var(--danger);color:#fff;font-size:0.75rem;font-weight:700;padding:4px 10px;border-radius:20px;">
            -{{ round((1 - $product->sale_price/$product->price)*100) }}%
          </span>
        @else
          <span style="font-size:1.8rem;font-weight:700;color:var(--primary-dark);">Rp {{ number_format($product->price,0,',','.') }}</span>
        @endif
      </div>

      {{-- Stock & Badges --}}
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:16px;">
        @if($product->stock > 0)
          @if($product->stock == 1 || $product->wishlists()->count() > 5)
            <span style="font-size:0.85rem;color:#D32F2F;font-weight:700;background:rgba(211,47,47,0.1);padding:4px 10px;border-radius:20px;">🔥 Sangat Diminati (Banyak Dicari)</span>
          @else
            <span style="font-size:0.85rem;color:var(--success);font-weight:600;background:rgba(76,175,80,0.1);padding:4px 10px;border-radius:20px;">Tersedia</span>
          @endif
        @else
          <span style="width:8px;height:8px;border-radius:50%;background:var(--danger);display:inline-block;"></span>
          <span style="font-size:0.85rem;color:var(--danger);font-weight:600;">Stok Habis</span>
        @endif
      </div>

      {{-- Sizes --}}
      @if($product->sizes)
      <div style="margin-bottom:24px;">
        <div style="font-size:0.85rem;font-weight:700;color:var(--dark);margin-bottom:10px;">Pilih Ukuran:</div>
        <div style="display:flex;gap:8px;flex-wrap:wrap;" id="sizeOptions">
          @foreach($product->sizes as $sz)
            <div class="size-option" onclick="selectSize(this, '{{ $sz }}')"
                 style="padding:10px 20px;border-radius:8px;border:2px solid var(--gray-light);cursor:pointer;font-weight:600;font-size:0.9rem;transition:all 0.2s;">
              {{ $sz }}
            </div>
          @endforeach
        </div>
        <a href="{{ route('size-guide') }}" style="font-size:0.8rem;color:var(--primary);margin-top:8px;display:inline-block;">📏 Panduan Ukuran</a>
      </div>
      @endif

      {{-- Details --}}
      @if($product->material || $product->color)
      <div style="background:var(--cream);border-radius:12px;padding:16px;margin-bottom:24px;">
        @if($product->material)<div style="font-size:0.88rem;margin-bottom:6px;"><strong>Bahan:</strong> {{ $product->material }}</div>@endif
        @if($product->color)<div style="font-size:0.88rem;"><strong>Warna:</strong> {{ $product->color }}</div>@endif
      </div>
      @endif

      {{-- Order Form --}}
      <div style="margin-bottom:24px;">
        <a href="#orderForm" class="btn btn-primary" style="width:100%;justify-content:center;margin-bottom:10px;">🛒 Pesan Sekarang</a>
        <a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}?text={{ urlencode('Halo, saya tertarik dengan produk: '.$product->name.' (Rp '.number_format($product->price,0,',','.').'). Apakah masih tersedia?') }}"
           target="_blank" class="btn btn-wa" style="width:100%;justify-content:center;">💬 Tanya via WhatsApp</a>
      </div>

      {{-- Description --}}
      @if($product->description)
      <div>
        <div style="font-weight:700;margin-bottom:10px;">Deskripsi Produk</div>
        <p style="color:var(--gray);line-height:1.8;font-size:0.95rem;">{{ $product->description }}</p>
      </div>
      @endif
    </div>
  </div>

  {{-- Order Form --}}
  <div id="orderForm" style="margin-top:60px;">
    <div style="background:var(--cream);border-radius:20px;padding:40px;">
      <h2 style="text-align:center;margin-bottom:8px;">📋 Form Pemesanan</h2>
      <p style="text-align:center;color:var(--gray);margin-bottom:32px;">Isi form di bawah — kami akan segera menghubungi Anda via WhatsApp</p>
      <form action="{{ route('kontak.store') }}" method="POST" style="max-width:600px;margin:0 auto;">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        <div class="grid-2" style="gap:16px;">
          <div class="form-group">
            <label class="form-label">Nama Lengkap *</label>
            <input type="text" name="customer_name" class="form-control" required placeholder="Nama Anda">
          </div>
          <div class="form-group">
            <label class="form-label">No. WhatsApp *</label>
            <input type="text" name="customer_phone" class="form-control" required placeholder="08xxxxxxxxxx">
          </div>
        </div>
        <div class="grid-2" style="gap:16px;">
          @if($product->sizes)
          <div class="form-group">
            <label class="form-label">Ukuran *</label>
            <select name="size" class="form-control" required id="sizeSelect">
              <option value="">Pilih ukuran...</option>
              @foreach($product->sizes as $sz)
                <option value="{{ $sz }}">{{ $sz }}</option>
              @endforeach
            </select>
          </div>
          @endif
          <div class="form-group">
            <label class="form-label">Jumlah</label>
            <input type="number" name="quantity" class="form-control" value="1" min="1" max="{{ $product->stock }}">
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Catatan (opsional)</label>
          <textarea name="notes" class="form-control" rows="3" placeholder="Warna yang diinginkan, alamat, dll."></textarea>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;justify-content:center;">
          💬 Kirim Pesanan via WhatsApp
        </button>
      </form>
    </div>
  </div>

  {{-- Reviews Section --}}
  <div style="margin-top:72px;background:var(--cream);border-radius:24px;padding:48px;">
    <div class="section-header" style="margin-bottom:32px;">
      <h2>Review & Testimoni</h2>
      <div class="divider-primary" style="margin-left:0;"></div>
    </div>

    <div style="display:grid;grid-template-columns:1fr;gap:40px;">
      @if($product->reviews->isEmpty())
        <div style="text-align:center;color:var(--gray);font-style:italic;">Belum ada review untuk produk ini. Jadilah yang pertama memberikan ulasan!</div>
      @else
        <div style="display:grid;grid-template-columns:repeat(auto-fill, minmax(300px, 1fr));gap:24px;">
          @foreach($product->reviews as $review)
            <div style="background:var(--white);padding:24px;border-radius:16px;box-shadow:var(--shadow-sm);">
              <div style="display:flex;justify-content:space-between;align-items:flex-start;margin-bottom:12px;">
                <div>
                  <div style="font-weight:700;color:var(--dark);">{{ $review->name }}</div>
                  <div style="font-size:0.85rem;color:var(--gray);">{{ $review->created_at->diffForHumans() }}</div>
                </div>
                <div style="color:#FFD700;font-size:1.1rem;line-height:1;">
                  {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                </div>
              </div>
              <p style="font-size:0.95rem;color:var(--gray);line-height:1.6;margin-bottom:{{ $review->photo ? '16px' : '0' }};">
                {{ $review->comment }}
              </p>
              @if($review->photo)
                <img src="{{ asset('storage/' . $review->photo) }}" alt="Review Image" style="width:100px;height:100px;object-fit:cover;border-radius:8px;cursor:pointer;" onclick="window.open(this.src)">
              @endif
            </div>
          @endforeach
        </div>
      @endif

      {{-- Review Form --}}
      <div style="background:var(--white);padding:32px;border-radius:16px;box-shadow:var(--shadow-md);">
        <h3 style="margin-bottom:24px;font-size:1.4rem;">Tulis Review Anda</h3>
        <form action="{{ route('reviews.store', $product->id) }}" method="POST" enctype="multipart/form-data">
          @csrf
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Rating</label>
            <div style="font-size:1.5rem;color:#FFD700;cursor:pointer;display:inline-flex;flex-direction:row-reverse;direction:rtl;" class="rating-stars">
              <input type="radio" name="rating" value="5" id="star5" style="display:none;" checked><label for="star5" style="cursor:pointer;">★</label>
              <input type="radio" name="rating" value="4" id="star4" style="display:none;"><label for="star4" style="cursor:pointer;">★</label>
              <input type="radio" name="rating" value="3" id="star3" style="display:none;"><label for="star3" style="cursor:pointer;">★</label>
              <input type="radio" name="rating" value="2" id="star2" style="display:none;"><label for="star2" style="cursor:pointer;">★</label>
              <input type="radio" name="rating" value="1" id="star1" style="display:none;"><label for="star1" style="cursor:pointer;">★</label>
            </div>
            <style>
              .rating-stars label:hover, .rating-stars label:hover ~ label, .rating-stars input:checked ~ label { color: #FFD700; }
              .rating-stars label { color: #ddd; transition: 0.2s; }
            </style>
          </div>
          <div class="form-group">
            <label class="form-label">Komentar</label>
            <textarea name="comment" class="form-control" rows="4"></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Upload Foto (Opsional, Max 10MB)</label>
            <input type="file" name="photo" class="form-control" accept="image/*">
            @error('photo')
              <div style="color:red;font-size:0.85rem;margin-top:4px;">{{ $message }}</div>
            @enderror
          </div>
          <button type="submit" class="btn btn-primary">Kirim Review</button>
        </form>
      </div>
    </div>
  </div>

  {{-- Related Products --}}
  @if($related->isNotEmpty())
  <div style="margin-top:72px;">
    <div class="section-header">
      <span class="eyebrow">Produk Terkait</span>
      <h2>Mungkin Kamu Suka</h2>
      <div class="divider-primary"></div>
    </div>
    <div class="grid-4">
      @foreach($related as $rel)
      <div class="product-card">
        <div class="product-card__img-wrap">
          @if($rel->image)
            <img src="{{ asset('storage/'.$rel->image) }}" alt="{{ $rel->name }}" loading="lazy">
          @else
            <div style="width:100%;height:100%;background:linear-gradient(135deg,var(--cream),var(--primary-pale));display:flex;align-items:center;justify-content:center;font-size:4rem;">👗</div>
          @endif
          <div class="product-card__overlay">
            <a href="{{ route('produk.detail', $rel->slug) }}" class="btn btn-white btn-sm">Lihat Detail</a>
          </div>
        </div>
        <div class="product-card__body">
          <div class="product-card__cat">{{ $rel->category->name }}</div>
          <a href="{{ route('produk.detail', $rel->slug) }}">
            <div class="product-card__name">{{ $rel->name }}</div>
          </a>
          <div class="product-card__price">
            <span class="price-new">Rp {{ number_format($rel->price,0,',','.') }}</span>
          </div>
        </div>
      </div>
      @endforeach
    </div>
  </div>
  @endif
</div>

@push('scripts')
<script>
function switchImg(src) {
  document.getElementById('mainImg').src = src;
}
function selectSize(el, size) {
  document.querySelectorAll('.size-option').forEach(o => {
    o.style.borderColor = 'var(--gray-light)';
    o.style.background  = 'transparent';
    o.style.color       = 'var(--black)';
  });
  el.style.borderColor = 'var(--primary)';
  el.style.background  = 'var(--primary)';
  el.style.color       = 'white';
  const sel = document.getElementById('sizeSelect');
  if (sel) sel.value = size;
}
</script>
@endpush
@endsection

