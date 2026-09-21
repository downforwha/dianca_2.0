@extends('layouts.app')
@section('title','Kontak & Pemesanan')
@section('page_title','Kontak')

@section('content')

<div class="page-header">
  <div class="container">
    <h1>Kontak & Pemesanan</h1>
    <p>Pesan produk favorit Anda — kami langsung hubungi via WhatsApp!</p>
  </div>
</div>

<section class="section">
  <div class="container">
    <div class="kontak-layout">

      {{-- ORDER FORM --}}
      <div>
        <div class="kontak-form-card">
          <div style="margin-bottom:32px;">
            <span style="font-size:0.75rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--primary);display:block;margin-bottom:8px;">Mulai Pesan</span>
            <h2 style="font-size:1.8rem;margin-bottom:8px;">Form Pemesanan</h2>
            <p style="color:var(--gray);font-size:0.9rem;">Isi form di bawah → kami redirect ke WhatsApp dengan pesan otomatis!</p>
          </div>

          @if($errors->any())
            <div class="alert alert-error">
              ❌ {{ $errors->first() }}
            </div>
          @endif

          <form action="{{ route('kontak.store') }}" method="POST">
            @csrf

            <div class="grid-2" style="gap:16px;">
              <div class="form-group">
                <label class="form-label">Nama Lengkap *</label>
                <input type="text" name="customer_name" class="form-control {{ $errors->has('customer_name') ? 'is-invalid' : '' }}"
                       value="{{ old('customer_name') }}" required placeholder="Nama Anda" autocomplete="name">
                @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
              <div class="form-group">
                <label class="form-label">No. WhatsApp *</label>
                <input type="text" name="customer_phone" class="form-control {{ $errors->has('customer_phone') ? 'is-invalid' : '' }}"
                       value="{{ old('customer_phone') }}" required placeholder="08xxxxxxxxxx" autocomplete="tel">
                @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Email (opsional)</label>
              <input type="email" name="customer_email" class="form-control"
                     value="{{ old('customer_email') }}" placeholder="email@contoh.com" autocomplete="email">
            </div>

            <div class="form-group">
              <label class="form-label">Produk yang Diminati</label>
              <select name="product_id" class="form-control" id="productSelect" onchange="updatePrice()">
                <option value="">-- Pilih Produk (opsional) --</option>
                @foreach($products as $prod)
                  <option value="{{ $prod->id }}"
                    data-price="{{ $prod->price }}"
                    data-sizes="{{ json_encode($prod->sizes ?? []) }}"
                    {{ old('product_id') == $prod->id || request('produk') == $prod->name ? 'selected' : '' }}>
                    {{ $prod->name }} — Rp {{ number_format($prod->price, 0, ',', '.') }}
                  </option>
                @endforeach
              </select>
            </div>

            <div class="grid-2" style="gap:16px;">
              <div class="form-group">
                <label class="form-label">Ukuran</label>
                <select name="size" class="form-control" id="sizeSelect">
                  <option value="">Pilih ukuran...</option>
                  <option value="XS">XS</option>
                  <option value="S">S</option>
                  <option value="M" selected>M</option>
                  <option value="L">L</option>
                  <option value="XL">XL</option>
                  <option value="XXL">XXL</option>
                </select>
              </div>
              <div class="form-group">
                <label class="form-label">Jumlah *</label>
                <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 1) }}" min="1" max="50" required id="qtyInput" oninput="updatePrice()">
              </div>
            </div>

            {{-- Price preview --}}
            <div id="pricePreview" style="background:var(--cream);border-radius:12px;padding:16px;margin-bottom:20px;display:none;">
              <div style="display:flex;justify-content:space-between;align-items:center;">
                <span style="font-size:0.88rem;color:var(--gray);">Estimasi Total:</span>
                <span style="font-size:1.2rem;font-weight:700;color:var(--primary-dark);" id="totalPrice">Rp 0</span>
              </div>
              <p style="font-size:0.75rem;color:var(--gray);margin-top:4px;">*Final harga dikonfirmasi via WhatsApp</p>
            </div>

            <div class="form-group">
              <label class="form-label">Jadwal Fitting (Opsional)</label>
              <input type="datetime-local" name="fitting_date" class="form-control" value="{{ old('fitting_date') }}">
            </div>

            <div class="form-group">
              <label class="form-label">Alamat Pengiriman (opsional)</label>
              <input type="text" name="customer_address" class="form-control" value="{{ old('customer_address') }}" placeholder="Jl. Contoh No. 1, Kota...">
            </div>

            <div class="form-group">
              <label class="form-label">Catatan Tambahan (opsional)</label>
              <textarea name="notes" class="form-control" rows="3" placeholder="Warna yang diinginkan, waktu pengiriman, atau pertanyaan lain...">{{ old('notes') }}</textarea>
            </div>

            <button type="submit" class="btn btn-wa" style="width:100%;justify-content:center;font-size:1rem;padding:16px;">
              💬 Kirim Pesanan via WhatsApp
            </button>
            <p style="text-align:center;font-size:0.8rem;color:var(--gray);margin-top:12px;">
              Pesanan Anda akan tersimpan dan kami redirect ke WhatsApp untuk konfirmasi
            </p>
          </form>
        </div>
      </div>

      {{-- CONTACT INFO --}}
      <div>
        <div style="position:sticky;top:100px;">
          <div style="margin-bottom:8px;">
            <span style="font-size:0.75rem;letter-spacing:0.2em;text-transform:uppercase;color:var(--primary);display:block;margin-bottom:8px;">Informasi Kontak</span>
            <h2 style="margin-bottom:16px;">Hubungi Kami</h2>
            <p style="color:var(--gray);">Kami siap membantu Anda dari Senin sampai Sabtu</p>
          </div>

          <div style="margin-top:28px;display:flex;flex-direction:column;gap:20px;">
            <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--cream);border-radius:14px;">
              <div style="width:44px;height:44px;background:var(--primary-pale);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">📍</div>
              <div>
                <div style="font-weight:700;margin-bottom:4px;">Alamat</div>
                <div style="color:var(--gray);font-size:0.9rem;">{{ \App\Models\Setting::get('butik_address','Jl. Contoh No. 1, Kota Anda') }}</div>
              </div>
            </div>

            <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--cream);border-radius:14px;">
              <div style="width:44px;height:44px;background:var(--primary-pale);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">⏰</div>
              <div>
                <div style="font-weight:700;margin-bottom:4px;">Jam Operasional</div>
                <div style="color:var(--gray);font-size:0.9rem;">{{ \App\Models\Setting::get('butik_hours','Senin - Sabtu: 09.00 - 21.00 WIB') }}</div>
                <div style="color:var(--gray);font-size:0.9rem;">Minggu: Tutup</div>
              </div>
            </div>

            <div style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:var(--cream);border-radius:14px;">
              <div style="width:44px;height:44px;background:var(--primary-pale);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">📧</div>
              <div>
                <div style="font-weight:700;margin-bottom:4px;">Email</div>
                <a href="mailto:{{ \App\Models\Setting::get('butik_email','') }}" style="color:var(--primary);font-size:0.9rem;word-break:break-all;">
                  {{ \App\Models\Setting::get('butik_email','butik.elegan@email.com') }}
                </a>
              </div>
            </div>

            <a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}"
               target="_blank"
               style="display:flex;gap:16px;align-items:flex-start;padding:20px;background:linear-gradient(135deg,#25D366,#128C7E);border-radius:14px;color:#fff;text-decoration:none;">
              <div style="width:44px;height:44px;background:rgba(255,255,255,0.2);border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;flex-shrink:0;">💬</div>
              <div>
                <div style="font-weight:700;margin-bottom:4px;">WhatsApp</div>
                <div style="font-size:0.9rem;opacity:0.9;">+{{ \App\Models\Setting::get('butik_wa','6281234567890') }}</div>
                <div style="font-size:0.8rem;opacity:0.7;margin-top:2px;">Klik untuk chat langsung →</div>
              </div>
            </a>
          </div>

          {{-- Social Media --}}
          <div style="margin-top:28px;padding:20px;background:var(--white);border-radius:14px;box-shadow:var(--shadow-sm);">
            <div style="font-weight:700;margin-bottom:14px;font-size:0.9rem;">Ikuti Kami di Sosial Media</div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
              <a href="{{ \App\Models\Setting::get('social_instagram', '#') }}" target="_blank" style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:linear-gradient(135deg,#E1306C,#F77737);border-radius:10px;color:#fff;font-size:0.82rem;font-weight:700;">
                📸 Instagram
              </a>
              <a href="{{ \App\Models\Setting::get('social_facebook', '#') }}" target="_blank" style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:#1877F2;border-radius:10px;color:#fff;font-size:0.82rem;font-weight:700;">
                📘 Facebook
              </a>
              <a href="{{ \App\Models\Setting::get('social_tiktok', '#') }}" target="_blank" style="display:flex;align-items:center;gap:8px;padding:10px 16px;background:#000;border-radius:10px;color:#fff;font-size:0.82rem;font-weight:700;">
                🎵 TikTok
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

@push('scripts')
<script>
function updatePrice() {
  const select = document.getElementById('productSelect');
  const qty    = parseInt(document.getElementById('qtyInput').value) || 1;
  const option = select.options[select.selectedIndex];
  const price  = parseFloat(option.getAttribute('data-price')) || 0;

  if (price > 0) {
    const total = price * qty;
    document.getElementById('pricePreview').style.display = 'block';
    document.getElementById('totalPrice').textContent = 'Rp ' + total.toLocaleString('id-ID');

    // Update size options based on product
    const sizes = JSON.parse(option.getAttribute('data-sizes') || '[]');
    const sizeSelect = document.getElementById('sizeSelect');
    if (sizes.length > 0) {
      sizeSelect.innerHTML = '<option value="">Pilih ukuran...</option>';
      sizes.forEach(s => {
        sizeSelect.innerHTML += `<option value="${s}">${s}</option>`;
      });
    }
  } else {
    document.getElementById('pricePreview').style.display = 'none';
  }
}
// Init on load if product pre-selected
document.addEventListener('DOMContentLoaded', updatePrice);
</script>
@endpush
@endsection

