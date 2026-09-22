@extends('layouts.app')
@section('title','DIANCA ATELIER')
@section('page_title','Beranda')

@section('content')



{{-- ── HERO (PRO-MAX CLEAN WHITE) ── --}}
<section class="hero" style="min-height: 90vh; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; background: transparent; border-bottom: 1px solid #D4AF37;">
  <!-- Parallax Decorative Elements -->
  <div class="parallax-bg" style="position: absolute; top: -10%; left: -5%; opacity: 0.02; pointer-events: none; font-family: 'Cormorant Garamond', serif; font-size: 45rem; font-style: italic; font-weight: 700; color: var(--primary); z-index: 1; user-select: none;">
    D
  </div>
  <div class="parallax-bg" style="position: absolute; bottom: -30%; right: -5%; opacity: 0.02; pointer-events: none; font-family: 'Cormorant Garamond', serif; font-size: 35rem; font-style: italic; font-weight: 700; color: var(--primary); z-index: 1; user-select: none;">
    A
  </div>
  <div class="container" style="position: relative; z-index: 2; text-align: center; color: var(--primary);">
    <div class="hero-content animate-fade-up" style="max-width: 800px; margin: 0 auto; padding-top: 80px;">
      <span class="hero-eyebrow" style="font-size: 0.75rem; letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 24px; display: inline-block; color: var(--gray); font-weight: 600; padding: 4px 12px; background: var(--cream); border: 1px solid var(--gray-light); border-radius: 40px;">Koleksi Premium</span>
      <h1 style="font-family: 'Cormorant Garamond', serif; font-size: clamp(3.5rem, 8vw, 6rem); line-height: 1; margin-bottom: 24px; font-weight: 600; letter-spacing: 0.02em; color: var(--primary);">
        DIANCA<br><em style="font-style: italic; font-weight: 400; color: #b8932c;">Atelier</em>
      </h1>
      <p style="font-size: 1.125rem; color: var(--gray); margin-bottom: 48px; max-width: 500px; margin-inline: auto; line-height: 1.7;">
        Eksplorasi mahakarya eksklusif untuk wanita modern. Tersedia opsi sewa dan pengerjaan kustom.
      </p>
      <div class="hero-actions" style="display: flex; gap: 16px; justify-content: center;">
        <a href="{{ route('koleksi') }}" class="btn btn-lg" style="background: var(--white); color: #b8932c; border: 1px solid #D4AF37; font-weight: 600; transition: transform 0.3s ease; box-shadow: 0 8px 25px rgba(212,175,55,0.2);">Eksplorasi Koleksi</a>
      </div>
    </div>
  </div>
</section>

{{-- ── CATEGORY BENTO GRID ── --}}
<section class="section" style="padding: 120px 0; background: var(--white);">
  <div class="container">
    <div class="section-header" style="text-align: center; margin-bottom: 80px;">
      <h2 style="font-size: 2.25rem; font-weight: 400; letter-spacing: -0.01em;">Kategori Pilihan</h2>
    </div>
    
    <div class="bento-grid">
      @foreach($categories as $index => $cat)
      @php
        $spanClass = ($index == 0) ? 'grid-column: span 2; grid-row: span 2;' : (($index == 1) ? 'grid-column: span 2;' : 'grid-column: span 1;');
        $bgImages = [
            'cat_dress_1789934758453.png',
            'cat_blouse_1789934774344.png',
            'cat_outer_1789934788760.png',
            'cat_rok_1789934805266.png'
        ];
        $bg = isset($bgImages[$index]) ? asset('assets/images/redesign/' . $bgImages[$index]) : asset('assets/images/redesign/cat_dress_1789934758453.png');
      @endphp
      <a href="{{ route('koleksi') }}?kategori={{ $cat->slug }}" class="category-card animate-fade-up bento-item" style="{{ $spanClass }} background: url('{{ $bg }}') center/cover no-repeat; padding: 40px; position: relative; overflow: hidden; display: flex; flex-direction: column; justify-content: space-between; text-decoration: none; border: 1px solid #D4AF37; box-shadow: 0 10px 30px rgba(0,0,0,0.05); transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);">
        <div style="position: absolute; inset: 0; background: linear-gradient(to bottom, rgba(255,255,255,0.7), rgba(255,255,255,0.3)); z-index: 1;"></div>
        <div style="position: relative; z-index: 2; height: 100%; display: flex; flex-direction: column; justify-content: flex-end;">
          <div class="name" style="font-size: 2.25rem; font-family: 'Cormorant Garamond', serif; font-style: italic; font-weight: 600; color: #9c7717; margin-bottom: 4px; text-shadow: 1px 1px 0px rgba(255,255,255,0.8);">{{ $cat->name }}</div>
          <div class="count" style="font-size: 0.8rem; color: var(--primary); text-transform: uppercase; letter-spacing: 0.15em; font-weight: 600;">{{ $cat->active_products_count }} Koleksi</div>
        </div>
      </a>
      @endforeach
    </div>
  </div>
</section>

{{-- ── FEATURED PRODUCTS ── --}}
<section class="section" style="padding: 120px 0; background: var(--white); border-top: 1px solid var(--gray-light);">
  <div class="container">
    <div class="section-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px; margin-bottom: 80px;">
      <div>
        <h2 style="font-size: 2.25rem; font-weight: 400; letter-spacing: -0.01em; margin-bottom: 0;">Signature Pieces</h2>
      </div>
      <a href="{{ route('koleksi') }}" class="btn" style="background: transparent; color: var(--primary); border: 1px solid var(--gray-light);">Lihat Semua</a>
    </div>

    <div class="grid-4" style="gap: 40px 32px;">
      @forelse($featured as $index => $product)
      @php
          $prodImages = [
              'prod_1_1789934824990.png',
              'prod_2_1789934839818.png',
              'prod_3_1789934853254.png',
              'prod_4_1789934870113.png'
          ];
          $fallbackBg = asset('assets/images/redesign/' . $prodImages[$product->id % 4]);
      @endphp
      <div class="product-card animate-fade-up" style="border: none; background: transparent; transition: none; overflow: visible;">
        <div class="product-card__img-wrap" style="overflow: hidden; aspect-ratio: 3/4; position: relative; background: var(--cream); border: 1px solid #D4AF37; box-shadow: 0 15px 35px rgba(0,0,0,0.05); transition: transform 0.4s cubic-bezier(0.25, 1, 0.5, 1);">
          @if($product->image)
            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease;">
          @else
            <img src="{{ $fallbackBg }}" alt="{{ $product->name }}" loading="lazy" style="width: 100%; height: 100%; object-fit: cover; transition: transform 0.7s ease;">
          @endif
          
          <div class="product-card__overlay" style="position: absolute; inset: 0; background: rgba(255,255,255,0.8); backdrop-filter: blur(4px); display: flex; align-items: center; justify-content: center; opacity: 0; transition: opacity 0.4s ease;">
            <a href="{{ route('produk.detail', $product->slug) }}" class="btn" style="background: var(--white); color: #b8932c; border: 1px solid #D4AF37; transform: translateY(10px); transition: transform 0.4s ease; font-weight: 600; box-shadow: 0 4px 15px rgba(212,175,55,0.2);">Lihat Detail</a>
          </div>
          
          {{-- Status Badge (Clean Minimal) --}}
          <div style="position: absolute; top: 12px; right: 12px; padding: 4px 12px; font-size: 0.65rem; font-weight: 600; letter-spacing: 0.1em; text-transform: uppercase; background: var(--white); color: var(--primary); border: 1px solid var(--gray-light); border-radius: 40px;">
            {{ $product->rental_status ?? 'Ready' }}
          </div>
        </div>
        <div class="product-card__body" style="padding: 20px 0 0 0; text-align: center;">
          <div class="product-card__cat" style="font-size: 0.7rem; color: var(--gray); text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 6px; font-weight: 600;">{{ $product->category->name }}</div>
          <a href="{{ route('produk.detail', $product->slug) }}" style="text-decoration: none; color: var(--primary);">
            <div class="product-card__name" style="font-family: 'Cormorant Garamond', serif; font-size: 1.25rem; font-weight: 600; margin-bottom: 10px;">{{ $product->name }}</div>
          </a>
          <div class="product-card__price" style="font-size: 0.95rem; color: var(--gray);">
            @if($product->sale_price)
              <span class="price-old" style="text-decoration: line-through; opacity: 0.5; margin-right: 8px;">{{ $product->formatted_price }}</span>
              <span class="price-new" style="color: var(--primary); font-weight: 500;">Rp {{ number_format($product->sale_price,0,',','.') }}</span>
            @else
              <span class="price-new" style="color: var(--primary); font-weight: 500;">{{ $product->formatted_price }}</span>
            @endif
          </div>
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1;text-align:center;padding:60px 20px;color:var(--gray)">
        <p>Koleksi sedang disiapkan. Pantau terus ya!</p>
      </div>
      @endforelse
    </div>
  </div>
</section>

{{-- ── CTA BANNER (CLEAN) ── --}}
<section class="section-sm" style="background: var(--cream); padding: 120px 0; text-align: center; border-top: 1px solid var(--gray-light);">
  <div class="container">
    <h2 style="font-family: 'Cormorant Garamond', serif; font-size: 3rem; margin-bottom: 24px; font-weight: 600; color: var(--primary);">Elevate Your Style</h2>
    <p style="color: var(--gray); max-width: 500px; margin: 0 auto 48px; font-size: 1.125rem; line-height: 1.7;">Konsultasikan desain, gaya, dan ukuran bersama fashion stylist kami.</p>
    <a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}" target="_blank" class="btn btn-lg" style="background: var(--white); color: #b8932c; border: 1px solid #D4AF37; font-weight: 600; box-shadow: 0 8px 25px rgba(212,175,55,0.2);">
      Hubungi via WhatsApp
    </a>
  </div>
</section>

@endsection

