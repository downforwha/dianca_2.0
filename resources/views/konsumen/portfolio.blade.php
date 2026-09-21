@extends('layouts.app')
@section('title', 'Portfolio - Dianca Atelier')

@section('content')
<style>
  /* ── ELEGANT PORTFOLIO SPECIFIC CSS ── */
  body {
    background: var(--white);
  }
  .portfolio-hero {
    padding: 180px 0 100px;
    text-align: center;
    background: var(--cream);
    border-bottom: 1px solid var(--gray-light);
  }
  .portfolio-hero h1 {
    font-size: clamp(3.5rem, 8vw, 6.5rem);
    font-family: 'Cormorant Garamond', serif;
    font-weight: 600;
    letter-spacing: 0.05em;
    margin-bottom: 16px;
    color: var(--black);
  }
  .portfolio-hero p {
    font-size: 1.125rem;
    color: var(--gray);
    max-width: 600px;
    margin: 0 auto;
    line-height: 1.8;
  }
  .masonry-grid {
    column-count: 3;
    column-gap: 24px;
    padding: 60px 0;
  }
  @media (max-width: 992px) { .masonry-grid { column-count: 2; } }
  @media (max-width: 576px) { .masonry-grid { column-count: 1; } }

  .masonry-item {
    break-inside: avoid;
    margin-bottom: 24px;
    position: relative;
    overflow: hidden;
    border-radius: var(--radius-lg);
    group: relative;
  }
  
  .masonry-img {
    width: 100%;
    display: block;
    transition: transform 0.8s cubic-bezier(0.25, 1, 0.5, 1);
  }

  .masonry-item:hover .masonry-img {
    transform: scale(1.08);
  }

  .masonry-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to top, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0) 50%);
    opacity: 0;
    transition: opacity 0.4s ease;
    display: flex;
    flex-direction: column;
    justify-content: flex-end;
    padding: 32px;
  }

  .masonry-item:hover .masonry-overlay {
    opacity: 1;
  }

  .masonry-overlay h3 {
    color: var(--white);
    font-family: 'Cormorant Garamond', serif;
    font-size: 1.75rem;
    margin-bottom: 8px;
    transform: translateY(20px);
    transition: transform 0.4s ease;
  }

  .masonry-overlay p {
    color: rgba(255,255,255,0.8);
    font-size: 0.9rem;
    text-transform: uppercase;
    letter-spacing: 0.1em;
    transform: translateY(20px);
    transition: transform 0.4s ease 0.1s;
  }

  .masonry-item:hover .masonry-overlay h3,
  .masonry-item:hover .masonry-overlay p {
    transform: translateY(0);
  }
</style>

<div class="portfolio-hero animate-fade-up">
  <div class="container">
    <h1>Lookbook <em style="font-style: italic; font-weight: 400;">&</em> Portfolio</h1>
    <p>Sebuah mahakarya eksklusif yang dirancang dengan dedikasi tinggi. Temukan inspirasi gaun impian Anda dari koleksi terbaik Dianca Atelier.</p>
  </div>
</div>

<div class="container">
  <div class="masonry-grid">
    @forelse($portfolioItems as $item)
      <a href="{{ route('produk.detail', $item->slug) }}" class="masonry-item animate-fade-up" style="display: block;">
        @if($item->image)
          <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="masonry-img">
        @else
          @php $randomId = ($item->id % 3) + 1; @endphp
          <img src="{{ asset('images/portfolio/' . $randomId . '.png') }}" alt="{{ $item->name }}" class="masonry-img" style="object-fit: cover;">
        @endif
        
        <div class="masonry-overlay">
          <h3>{{ $item->name }}</h3>
          <p>{{ $item->category->name ?? 'Premium Collection' }}</p>
        </div>
      </a>
    @empty
      {{-- Dummy content if no featured items --}}
      @for($i = 1; $i <= 6; $i++)
      <div class="masonry-item animate-fade-up">
        @php $imgId = (($i - 1) % 3) + 1; @endphp
        <img src="{{ asset('images/portfolio/' . $imgId . '.png') }}" alt="Portfolio {{ $i }}" class="masonry-img">
        <div class="masonry-overlay">
          <h3>Bespoke Gown {{ $i }}</h3>
          <p>Custom Made</p>
        </div>
      </div>
      @endfor
    @endforelse
  </div>
</div>
@endsection
