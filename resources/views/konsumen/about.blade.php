@extends('layouts.app')
@section('title','About Us')
@section('page_title','Tentang Kami')

@section('content')

<div class="page-header">
  <div class="container">
    <h1>About Us</h1>
    <p>Mengenal lebih dekat DIANCA ATELIER dan cerita di balik setiap koleksi kami</p>
  </div>
</div>

{{-- ── STORY ── --}}
<section class="section">
  <div class="container">
    <div class="about-split">
      <div class="about-img-wrap">
        <div style="width:100%;aspect-ratio:4/5;background:linear-gradient(135deg,var(--primary-pale),var(--cream-dark));border-radius:20px;display:flex;align-items:center;justify-content:center;font-size:8rem;">
          👗
        </div>
      </div>
      <div>
        <span class="eyebrow" style="font-size:0.75rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--primary);display:block;margin-bottom:12px;">Cerita Kami</span>
        <h2 style="margin-bottom:24px;">Perjalanan Kami<br><em style="font-family:'Cormorant Garamond',serif;font-style:italic;color:var(--primary)">Menuju Keindahan</em></h2>
        <p style="color:var(--gray);line-height:1.9;margin-bottom:20px;">
          DIANCA ATELIER lahir dari kecintaan mendalam terhadap fashion dan keyakinan bahwa setiap wanita berhak tampil cantik dan percaya diri. Kami berdiri sejak 2019 dengan visi sederhana namun kuat: menghadirkan busana berkualitas tinggi dengan desain yang timeless dan elegan.
        </p>
        <p style="color:var(--gray);line-height:1.9;margin-bottom:32px;">
          Berawal dari garasi kecil dengan hanya 10 koleksi, kini DIANCA ATELIER telah melayani ribuan pelanggan setia di seluruh Indonesia. Setiap helai kain yang kami pilih, setiap jahitan yang kami kerjakan, adalah bukti dedikasi kami untuk memberikan yang terbaik.
        </p>
        <div class="grid-3" style="margin-bottom:32px;">
          <div style="text-align:center;padding:20px;background:var(--cream);border-radius:12px;border:1px solid #D4AF37;box-shadow: 0 4px 20px rgba(212,175,55,0.1);">
            <div style="font-size:2rem;font-weight:700;color:var(--primary-dark);font-family:'Playfair Display',serif;">500+</div>
            <div style="font-size:0.8rem;color:var(--gray);margin-top:4px;">Koleksi</div>
          </div>
          <div style="text-align:center;padding:20px;background:var(--cream);border-radius:12px;border:1px solid #D4AF37;box-shadow: 0 4px 20px rgba(212,175,55,0.1);">
            <div style="font-size:2rem;font-weight:700;color:var(--primary-dark);font-family:'Playfair Display',serif;">5K+</div>
            <div style="font-size:0.8rem;color:var(--gray);margin-top:4px;">Pelanggan Puas</div>
          </div>
          <div style="text-align:center;padding:20px;background:var(--cream);border-radius:12px;border:1px solid #D4AF37;box-shadow: 0 4px 20px rgba(212,175,55,0.1);">
            <div style="font-size:2rem;font-weight:700;color:var(--primary-dark);font-family:'Playfair Display',serif;">5 ★</div>
            <div style="font-size:0.8rem;color:var(--gray);margin-top:4px;">Rating Rata-rata</div>
          </div>
        </div>
        <a href="{{ route('koleksi') }}" class="btn btn-primary">Lihat Koleksi Kami →</a>
      </div>
    </div>
  </div>
</section>

{{-- ── VISI MISI ── --}}
<section class="section bg-cream">
  <div class="container">
    <div class="section-header">
      <span class="eyebrow">Apa yang Kami Percaya</span>
      <h2>Visi & Misi</h2>
      <div class="divider-primary"></div>
    </div>
    <div class="grid-2">
      <div style="background:var(--white);border-radius:20px;padding:40px;box-shadow:var(--shadow-sm);">
        <div style="width:60px;height:60px;background:var(--primary-pale);border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:20px;">👁️</div>
        <h3 style="margin-bottom:16px;">Visi</h3>
        <p style="color:var(--gray);line-height:1.9;">Menjadi butik online terpercaya dan terdepan di Indonesia yang menghadirkan fashion berkualitas premium dengan harga terjangkau, memberdayakan wanita Indonesia untuk tampil memukau di setiap kesempatan.</p>
      </div>
      <div style="background:var(--white);border-radius:20px;padding:40px;box-shadow:var(--shadow-sm);">
        <div style="width:60px;height:60px;background:var(--primary-pale);border-radius:15px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;margin-bottom:20px;">🎯</div>
        <h3 style="margin-bottom:16px;">Misi</h3>
        <ul style="color:var(--gray);line-height:2;padding-left:20px;">
          <li>Menghadirkan koleksi fashion berkualitas premium dengan harga terjangkau</li>
          <li>Memberikan pengalaman berbelanja yang menyenangkan dan mudah</li>
          <li>Memberikan pelayanan personal terbaik melalui konsultasi fashion</li>
          <li>Mendukung industri fashion lokal Indonesia</li>
        </ul>
      </div>
    </div>
  </div>
</section>

{{-- ── VALUES ── --}}
<section class="section">
  <div class="container">
    <div class="section-header">
      <span class="eyebrow">Yang Kami Junjung</span>
      <h2>Nilai-Nilai Kami</h2>
      <div class="divider-primary"></div>
    </div>
    <div class="values-grid">
      <div class="value-card">
        <div class="icon">💎</div>
        <h4>Kualitas</h4>
        <p>Kami tidak berkompromi dengan kualitas. Setiap produk melewati seleksi ketat sebelum sampai ke tangan Anda.</p>
      </div>
      <div class="value-card">
        <div class="icon">🤝</div>
        <h4>Kepercayaan</h4>
        <p>Kepercayaan pelanggan adalah amanah terbesar kami. Kami berkomitmen untuk selalu jujur dan transparan.</p>
      </div>
      <div class="value-card">
        <div class="icon">✨</div>
        <h4>Inovasi</h4>
        <p>Kami terus berinovasi dalam desain, layanan, dan pengalaman berbelanja untuk memberikan yang terbaik.</p>
      </div>
    </div>
  </div>
</section>

{{-- ── INFO TOKO ── --}}
<section class="section-sm bg-cream">
  <div class="container">
    <div class="section-header">
      <span class="eyebrow">Kunjungi Kami</span>
      <h2>Informasi Toko</h2>
      <div class="divider-primary"></div>
    </div>
    <div class="grid-3">
      <div style="background:var(--white);border-radius:16px;padding:32px;text-align:center;box-shadow:var(--shadow-sm);">
        <div style="font-size:2.5rem;margin-bottom:16px;">📍</div>
        <h4 style="margin-bottom:10px;">Alamat</h4>
        <p style="color:var(--gray);font-size:0.9rem;">{{ \App\Models\Setting::get('butik_address','Jl. Contoh No. 1, Kota Anda') }}</p>
      </div>
      <div style="background:var(--white);border-radius:16px;padding:32px;text-align:center;box-shadow:var(--shadow-sm);">
        <div style="font-size:2.5rem;margin-bottom:16px;">⏰</div>
        <h4 style="margin-bottom:10px;">Jam Operasional</h4>
        <p style="color:var(--gray);font-size:0.9rem;">{{ \App\Models\Setting::get('butik_hours','Senin - Sabtu: 09.00 - 21.00 WIB') }}</p>
      </div>
      <div style="background:var(--white);border-radius:16px;padding:32px;text-align:center;box-shadow:var(--shadow-sm);">
        <div style="font-size:2.5rem;margin-bottom:16px;">💬</div>
        <h4 style="margin-bottom:10px;">Hubungi Kami</h4>
        <p style="color:var(--gray);font-size:0.9rem;margin-bottom:12px;">{{ \App\Models\Setting::get('butik_email','') }}</p>
        <a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}" target="_blank" class="btn btn-wa btn-sm">💬 WhatsApp</a>
      </div>
    </div>
  </div>
</section>

{{-- ── CTA ── --}}
<section class="section-sm" style="background:linear-gradient(135deg,var(--black),#2D1A14);padding:64px 0;">
  <div class="container text-center">
    <h2 style="color:#fff;margin-bottom:16px;">Siap Tampil Memukau?</h2>
    <p style="color:rgba(255,255,255,0.7);max-width:480px;margin:0 auto 32px;">Jelajahi koleksi kami dan temukan busana yang sempurna untuk setiap momen spesial Anda.</p>
    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap;">
      <a href="{{ route('koleksi') }}" class="btn btn-primary">👗 Lihat Koleksi</a>
      <a href="{{ route('kontak') }}" class="btn btn-white">📞 Hubungi Kami</a>
    </div>
  </div>
</section>

@endsection
