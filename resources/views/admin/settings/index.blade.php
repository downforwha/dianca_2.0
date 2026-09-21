@extends('layouts.admin')
@section('title','Pengaturan Admin')
@section('page_title','Pengaturan Admin')
@section('page_subtitle','Konfigurasi informasi toko dan akun administrator')

@section('content')

<div class="admin-layout-even">

  {{-- ── INFORMASI TOKO ── --}}
  <div>
    <div class="admin-card">
      <div class="admin-card-header">
        <h3>🏪 Informasi Toko</h3>
      </div>
      <div class="admin-card-body">
        <form action="{{ route('admin.settings.update') }}" method="POST">
          @csrf @method('PUT')

          <div class="form-group">
            <label class="form-label">Nama Butik</label>
            <input type="text" name="settings[butik_name]" class="form-control"
                   value="{{ $settings['butik_name'] ?? 'DIANCA ATELIER' }}">
          </div>
          <div class="form-group">
            <label class="form-label">Tagline</label>
            <input type="text" name="settings[butik_tagline]" class="form-control"
                   value="{{ $settings['butik_tagline'] ?? 'Tampil Cantik, Tampil Percaya Diri' }}"
                   placeholder="Tagline singkat butik...">
          </div>
          <div class="form-group">
            <label class="form-label">Alamat Toko</label>
            <textarea name="settings[butik_address]" class="form-control" rows="2">{{ $settings['butik_address'] ?? '' }}</textarea>
          </div>
          <div class="form-grid-2">
            <div class="form-group">
              <label class="form-label">📱 No. WhatsApp</label>
              <input type="text" name="settings[butik_wa]" class="form-control"
                     value="{{ $settings['butik_wa'] ?? '' }}" placeholder="6281234567890">
              <div style="font-size:0.75rem;color:var(--gray);margin-top:4px;">Format tanpa tanda + atau strip</div>
            </div>
            <div class="form-group">
              <label class="form-label">📧 Email</label>
              <input type="email" name="settings[butik_email]" class="form-control"
                     value="{{ $settings['butik_email'] ?? '' }}" placeholder="butik@email.com">
            </div>
          </div>
          <div class="form-group">
            <label class="form-label">⏰ Jam Operasional</label>
            <input type="text" name="settings[butik_hours]" class="form-control"
                   value="{{ $settings['butik_hours'] ?? 'Senin - Sabtu: 09.00 - 21.00 WIB' }}"
                   placeholder="Senin - Sabtu: 09.00 - 21.00 WIB">
          </div>
          <div class="form-group">
            <label class="form-label">Instagram</label>
            <input type="text" name="settings[social_instagram]" class="form-control"
                   value="{{ $settings['social_instagram'] ?? '' }}" placeholder="@butikelegan">
          </div>
          <div class="form-group">
            <label class="form-label">Facebook</label>
            <input type="text" name="settings[social_facebook]" class="form-control"
                   value="{{ $settings['social_facebook'] ?? '' }}" placeholder="URL halaman Facebook">
          </div>
          <div class="form-group">
            <label class="form-label">TikTok</label>
            <input type="text" name="settings[social_tiktok]" class="form-control"
                   value="{{ $settings['social_tiktok'] ?? '' }}" placeholder="@butikelegan">
          </div>

          <hr style="border:none;border-top:1px solid var(--gray-light);margin:20px 0;">

          <div class="form-group">
            <label class="form-label">Pesan WA Default (Pesanan)</label>
            <textarea name="settings[wa_order_template]" class="form-control" rows="4"
                      placeholder="Halo {name}, pesanan Anda untuk {product} dengan ukuran {size} telah kami terima!">{{ $settings['wa_order_template'] ?? '' }}</textarea>
            <div style="font-size:0.75rem;color:var(--gray);margin-top:4px;">
              Variabel: {name}, {product}, {size}, {qty}, {total}, {order_number}
            </div>
          </div>

          <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;">
            💾 Simpan Pengaturan Toko
          </button>
        </form>
      </div>
    </div>
  </div>

  <div style="display:flex;flex-direction:column;gap:24px;">

    {{-- ── AKUN ADMIN ── --}}
    <div class="admin-card">
      <div class="admin-card-header">
        <h3>👤 Profil Admin</h3>
      </div>
      <div class="admin-card-body">
        <div style="display:flex;align-items:center;gap:16px;padding:20px;background:var(--primary-pale);border-radius:14px;margin-bottom:24px;">
          <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-dark));display:flex;align-items:center;justify-content:center;color:#fff;font-size:1.5rem;font-weight:700;flex-shrink:0;">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
          <div>
            <div style="font-weight:700;font-size:1rem;">{{ auth()->user()->name }}</div>
            <div style="color:var(--gray);font-size:0.85rem;">{{ auth()->user()->email }}</div>
            <span class="badge badge-primary" style="margin-top:4px;">Administrator</span>
          </div>
        </div>

        <form action="{{ route('admin.settings.profile') }}" method="POST">
          @csrf @method('PUT')
          <div class="form-group">
            <label class="form-label">Nama Lengkap</label>
            <input type="text" name="name" class="form-control" value="{{ auth()->user()->name }}" required>
          </div>
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" required>
          </div>
          <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;">
            💾 Update Profil
          </button>
        </form>
      </div>
    </div>

    {{-- ── GANTI PASSWORD ── --}}
    <div class="admin-card">
      <div class="admin-card-header">
        <h3>🔐 Ganti Password</h3>
      </div>
      <div class="admin-card-body">
        <form action="{{ route('admin.settings.password') }}" method="POST">
          @csrf @method('PUT')
          <div class="form-group">
            <label class="form-label">Password Saat Ini</label>
            <input type="password" name="current_password" class="form-control" required placeholder="Password lama Anda">
          </div>
          <div class="form-group">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password" class="form-control" required minlength="8" placeholder="Min. 8 karakter">
          </div>
          <div class="form-group">
            <label class="form-label">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="form-control" required minlength="8" placeholder="Ulangi password baru">
          </div>
          <button type="submit" class="btn-admin btn-admin-primary" style="width:100%;">
            🔐 Ganti Password
          </button>
        </form>
      </div>
    </div>

    {{-- ── ADMIN MANAGEMENT ── --}}
    <div class="admin-card">
      <div class="admin-card-header">
        <h3>👥 Daftar Admin</h3>
        <button class="btn-admin btn-admin-primary btn-admin-sm" onclick="openModal('modalAddAdmin')">+ Tambah Admin</button>
      </div>
      <div style="padding:0;">
        @foreach($admins as $admin)
        <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--gray-light);">
          <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,var(--primary),var(--primary-dark));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:700;font-size:0.9rem;flex-shrink:0;">
            {{ strtoupper(substr($admin->name,0,1)) }}
          </div>
          <div style="flex:1;">
            <div style="font-weight:600;font-size:0.88rem;">{{ $admin->name }}</div>
            <div style="font-size:0.75rem;color:var(--gray);">{{ $admin->email }}</div>
          </div>
          @if($admin->id !== auth()->id())
          <form action="{{ route('admin.settings.admin.destroy', $admin) }}" method="POST" onsubmit="return confirm('Hapus akun admin ini?')">
            @csrf @method('DELETE')
            <button class="btn-admin btn-admin-danger btn-admin-icon btn-admin-sm" title="Hapus Admin">🗑️</button>
          </form>
          @else
          <span class="badge badge-primary">Anda</span>
          @endif
        </div>
        @endforeach
      </div>
    </div>
  </div>
</div>

{{-- Modal Add Admin --}}
<div class="modal-overlay" id="modalAddAdmin">
  <div class="modal" style="max-width:440px;">
    <div class="modal-header">
      <h3>👤 Tambah Admin Baru</h3>
      <span class="modal-close" onclick="closeModal('modalAddAdmin')">✕</span>
    </div>
    <form action="{{ route('admin.settings.admin.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-group">
          <label class="form-label">Nama Lengkap *</label>
          <input type="text" name="name" class="form-control" required placeholder="Nama admin...">
        </div>
        <div class="form-group">
          <label class="form-label">Email *</label>
          <input type="email" name="email" class="form-control" required placeholder="admin@email.com">
        </div>
        <div class="form-group">
          <label class="form-label">Password *</label>
          <input type="password" name="password" class="form-control" required minlength="8" placeholder="Min. 8 karakter">
        </div>
        <div class="form-group">
          <label class="form-label">Konfirmasi Password *</label>
          <input type="password" name="password_confirmation" class="form-control" required minlength="8" placeholder="Ulangi password">
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-admin btn-admin-secondary" onclick="closeModal('modalAddAdmin')">Batal</button>
        <button type="submit" class="btn-admin btn-admin-primary">💾 Buat Akun Admin</button>
      </div>
    </form>
  </div>
</div>

@endsection
