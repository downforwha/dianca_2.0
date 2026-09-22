<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="@yield('meta_description', 'DIANCA ATELIER — Koleksi Fashion Premium untuk Wanita Modern Indonesia')">
  <title>@yield('title', 'DIANCA ATELIER') — @yield('page_title', 'Fashion Premium')</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
  @stack('styles')
</head>
<body>

<!-- ══════════════════════════════════════════════════
     NAVBAR — Gray & White Theme
════════════════════════════════════════════════════ -->
<nav class="navbar" id="navbar">
  <div class="navbar-inner">
    <!-- Brand -->
    <a href="{{ route('home') }}" class="navbar-brand">
      DIANCA <em>Atelier</em>
    </a>

    <!-- Desktop Navigation -->
    <div class="navbar-nav">
      <a href="{{ route('home') }}"       class="{{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
      <a href="{{ route('koleksi') }}"    class="{{ request()->routeIs('koleksi') ? 'active' : '' }}">Koleksi</a>
      <a href="{{ route('portfolio') }}"  class="{{ request()->routeIs('portfolio') ? 'active' : '' }}">Portfolio</a>
      <a href="{{ route('about') }}"      class="{{ request()->routeIs('about') ? 'active' : '' }}">About Us</a>
      <a href="{{ route('size-guide') }}" class="{{ request()->routeIs('size-guide') ? 'active' : '' }}">Size Guide</a>
      <a href="{{ route('kontak') }}" class="btn btn-nav">Pesan Sekarang</a>
    </div>
  </div>
</nav>

<!-- Mobile Bottom Nav -->
<nav class="bottom-nav">
  <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
    <span>Home</span>
  </a>
  <a href="{{ route('koleksi') }}" class="bottom-nav-item {{ request()->routeIs('koleksi') ? 'active' : '' }}">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.57a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.57a2 2 0 0 0-1.34-2.23z"/></svg>
    <span>Koleksi</span>
  </a>
  <a href="{{ route('portfolio') }}" class="bottom-nav-item {{ request()->routeIs('portfolio') ? 'active' : '' }}">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
    <span>Portfolio</span>
  </a>
  <a href="{{ route('kontak') }}" class="bottom-nav-item {{ request()->routeIs('kontak') ? 'active' : '' }}">
    <svg class="icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
    <span>Kontak</span>
  </a>
</nav>

<!-- Main Content -->
<main>
  @yield('content')
</main>

<!-- Float Controls -->
<div class="float-controls">
  <button id="darkModeToggle" class="float-btn" title="Toggle Dark Mode" aria-label="Toggle Dark Mode">
    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/></svg>
  </button>
  <div id="google_translate_element" style="border-radius: 8px; overflow: hidden;"></div>
</div>

<!-- WhatsApp Float Button -->
<a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}" target="_blank" class="wa-float" title="Chat WhatsApp" aria-label="Hubungi kami via WhatsApp">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
</a>

<!-- ══════════════════════════════════════════════════
     FOOTER — Dark gray theme, matching navbar
════════════════════════════════════════════════════ -->
<footer class="footer">
  <div class="container">


    {{-- Footer Main Grid --}}
    <div class="footer-main">
      {{-- Brand --}}
      <div>
        <div class="footer-brand-name">DIANCA <em>Atelier</em></div>
        <div class="footer-tagline">Tampil Cantik, Tampil Percaya Diri</div>
        <p class="footer-desc">Menyajikan koleksi fashion pilihan dengan kualitas premium untuk wanita modern Indonesia.</p>
        <div class="social-links">
          <a href="{{ \App\Models\Setting::get('social_instagram', 'https://www.instagram.com/diancaatelier/') }}" target="_blank" class="social-link" aria-label="Instagram">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
          </a>
          <a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}" target="_blank" class="social-link" aria-label="WhatsApp">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
          </a>
          <a href="#" class="social-link" aria-label="TikTok">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5"/></svg>
          </a>
        </div>
      </div>

      {{-- Menu --}}
      <div>
        <h4>Menu</h4>
        <div class="footer-links">
          <a href="{{ route('home') }}">Home</a>
          <a href="{{ route('koleksi') }}">Koleksi</a>
          <a href="{{ route('portfolio') }}">Portfolio</a>
          <a href="{{ route('about') }}">About Us</a>
          <a href="{{ route('size-guide') }}">Size Guide</a>
          <a href="{{ route('kontak') }}">Kontak</a>
        </div>
      </div>

      {{-- Kategori --}}
      <div>
        <h4>Kategori</h4>
        <div class="footer-links">
          <a href="{{ route('koleksi') }}?kategori=dress">Dress</a>
          <a href="{{ route('koleksi') }}?kategori=blouse">Blouse</a>
          <a href="{{ route('koleksi') }}?kategori=outer">Outer</a>
          <a href="{{ route('koleksi') }}?kategori=rok">Rok</a>
          <a href="{{ route('koleksi') }}?kategori=aksesoris">Aksesoris</a>
        </div>
      </div>

      {{-- Kontak --}}
      <div>
        <h4>Kontak Kami</h4>
        <div class="footer-contact">
          <p>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:6px;"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
            {{ \App\Models\Setting::get('butik_address','Jl. Contoh No. 1') }}
          </p>
          <p>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:6px;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            {{ \App\Models\Setting::get('butik_hours','Senin - Sabtu: 09.00 - 21.00') }}
          </p>
          <p>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:6px;"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
            <a href="mailto:{{ \App\Models\Setting::get('butik_email','') }}" style="word-break:break-all;">{{ \App\Models\Setting::get('butik_email','butik@email.com') }}</a>
          </p>
          <p>
            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="display:inline;vertical-align:middle;margin-right:6px;"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
            <a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}" target="_blank">
              {{ \App\Models\Setting::get('butik_wa_display', '+62 895-4330-58138') }}
            </a>
          </p>
        </div>
      </div>
    </div>

    {{-- Footer Bottom --}}
    <div class="footer-bottom">
      <p>&copy; {{ date('Y') }} DIANCA ATELIER. All rights reserved.</p>
      <div class="footer-bottom-links">
        <a href="#">Privacy Policy</a>
        <a href="#">Terms of Service</a>
      </div>
    </div>
  </div>
</footer>

<script>
  // ── Navbar scroll effect ──
  const navbar = document.getElementById('navbar');
  function updateNavbar() {
    navbar.classList.toggle('scrolled', window.scrollY > 40);
  }
  window.addEventListener('scroll', updateNavbar, { passive: true });
  updateNavbar();

  // ── SweetAlert2 Toast ──
  const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 4000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer);
      toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
  });

  @if(session('success'))
    Toast.fire({ icon: 'success', title: "{{ session('success') }}" });
  @endif
  @if(session('error'))
    Toast.fire({ icon: 'error', title: "{{ session('error') }}" });
  @endif

  // ── Scroll animations & Stagger ──
  let staggerIndex = 0;
  let lastIntersectTime = 0;
  
  const observer = new IntersectionObserver((entries) => {
    const now = Date.now();
    if (now - lastIntersectTime > 150) staggerIndex = 0;
    lastIntersectTime = now;

    entries.forEach(e => {
      if (e.isIntersecting) {
        if (!e.target.className.match(/delay-\d/)) {
          staggerIndex++;
          e.target.classList.add(`delay-${Math.min(staggerIndex, 8)}`);
        }
        // requestAnimationFrame to ensure CSS applies delay before visible state
        requestAnimationFrame(() => {
          e.target.classList.add('visible');
        });
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.05, rootMargin: '0px 0px -50px 0px' });
  document.querySelectorAll('.animate-fade-up').forEach(el => observer.observe(el));

  // ── Parallax Minimalis ──
  window.addEventListener('scroll', () => {
    const scrollY = window.scrollY;
    document.querySelectorAll('.parallax-bg').forEach(el => {
      el.style.transform = `translateY(${scrollY * 0.15}px)`;
    });
  }, { passive: true });

  // ── Dark Mode Toggle ──
  const darkModeToggle = document.getElementById('darkModeToggle');
  const body = document.body;
  if (localStorage.getItem('darkMode') === 'enabled') {
    body.classList.add('dark-mode');
  }
  darkModeToggle.addEventListener('click', () => {
    body.classList.toggle('dark-mode');
    localStorage.setItem('darkMode', body.classList.contains('dark-mode') ? 'enabled' : 'disabled');
  });

  // ── Wishlist Logic ──
  function toggleWishlist(productId, btnElement) {
    fetch(`/wishlist/toggle/${productId}`, {
      method: 'POST',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'added') {
        btnElement.classList.add('active');
        Toast.fire({ icon: 'success', title: 'Ditambahkan ke wishlist' });
      } else {
        btnElement.classList.remove('active');
        Toast.fire({ icon: 'info', title: 'Dihapus dari wishlist' });
      }
    })
    .catch(() => {
      Toast.fire({ icon: 'error', title: 'Terjadi kesalahan' });
    });
  }
</script>

<!-- Google Translate Widget -->
<script type="text/javascript">
function googleTranslateElementInit() {
  new google.translate.TranslateElement({
    pageLanguage: 'id',
    includedLanguages: 'id,en',
    layout: google.translate.TranslateElement.InlineLayout.SIMPLE
  }, 'google_translate_element');
}
</script>
<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>

@stack('scripts')
</body>
</html>
