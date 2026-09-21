@extends('layouts.app')
@section('title','Koleksi')
@section('page_title','Koleksi Produk')

@section('content')


<div class="page-header">
  <div class="container">
    <h1>Koleksi Kami</h1>
    <p>Temukan busana impian Anda dari koleksi pilihan terbaik kami</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- Filter Bar --}}
    <div class="filter-bar" style="display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap;">
      <div class="filter-tabs">
        <a href="{{ route('koleksi') }}" class="filter-tab {{ !$activeCategory ? 'active' : '' }}">✦ Semua</a>
        @foreach($categories as $cat)
          <a href="{{ route('koleksi') }}?kategori={{ $cat->slug }}{{ request('search') ? '&search='.request('search') : '' }}"
             class="filter-tab {{ $activeCategory === $cat->slug ? 'active' : '' }}">
            {{ $cat->icon ?? '' }} {{ $cat->name }}
          </a>
        @endforeach
      </div>
      <form id="filter-form" method="GET" action="{{ route('koleksi') }}" style="display:flex;gap:8px;">
        @if($activeCategory)
          <input type="hidden" name="kategori" value="{{ $activeCategory }}">
        @endif
        <div class="search-wrap">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari produk..." class="form-control" style="width:220px;">
          <span class="search-icon">🔍</span>
        </div>
        <select name="sort" class="form-control" style="width:160px;" onchange="this.form.submit()">
          <option value="">Urutkan</option>
          <option value="newest" {{ request('sort')=='newest' ? 'selected' : '' }}>Terbaru</option>
          <option value="price_asc" {{ request('sort')=='price_asc' ? 'selected' : '' }}>Harga Terendah</option>
          <option value="price_desc" {{ request('sort')=='price_desc' ? 'selected' : '' }}>Harga Tertinggi</option>
        </select>
      </form>
    </div>

    {{-- Products Grid --}}
    <div id="product-grid-container">
      @include('konsumen.partials.product-grid')
    </div>
  </div>
</section>

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', () => {
    const filterForm = document.getElementById('filter-form');
    const filterTabs = document.querySelectorAll('.filter-tab');
    const productContainer = document.getElementById('product-grid-container');

    const fetchProducts = async (url) => {
      productContainer.style.opacity = '0.5';
      try {
        const response = await fetch(url, {
          headers: { 'X-Requested-With': 'XMLHttpRequest' }
        });
        if (response.ok) {
          const html = await response.text();
          productContainer.innerHTML = html;
          history.pushState(null, '', url);
        }
      } catch (e) {
        console.error('Error fetching products:', e);
      } finally {
        productContainer.style.opacity = '1';
      }
    };

    filterForm.addEventListener('submit', (e) => {
      e.preventDefault();
      const url = new URL(filterForm.action);
      const formData = new FormData(filterForm);
      const params = new URLSearchParams(formData);
      
      // Clean up empty params
      for (const [key, value] of Array.from(params.entries())) {
        if (!value) params.delete(key);
      }
      
      url.search = params.toString();
      fetchProducts(url.toString());
    });

    filterForm.querySelector('select[name="sort"]').addEventListener('change', () => {
      filterForm.dispatchEvent(new Event('submit'));
    });

    filterTabs.forEach(tab => {
      tab.addEventListener('click', (e) => {
        e.preventDefault();
        filterTabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        fetchProducts(tab.href);
      });
    });

    document.addEventListener('click', (e) => {
      if (e.target.closest('.ajax-page')) {
        e.preventDefault();
        const url = e.target.closest('.ajax-page').getAttribute('data-url');
        if (url) fetchProducts(url);
      }
    });
  });
</script>
@endpush

@endsection
