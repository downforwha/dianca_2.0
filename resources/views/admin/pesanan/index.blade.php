@extends('layouts.admin')
@section('title','Data Pesanan')
@section('page_title','Pesanan WhatsApp')
@section('page_subtitle','Data pesanan masuk dari konsumen via WhatsApp')

@section('content')

{{-- Summary badges --}}
<div style="display:flex;gap:12px;flex-wrap:wrap;margin-bottom:24px;">
  @foreach([
    ['Semua','','#6B6B6B','','badge-secondary'],
    ['Pending','pending','#FFC107','🕐','badge-warning'],
    ['Diproses','processing','#17A2B8','⚙️','badge-info'],
    ['Selesai','done','#28A745','✅','badge-success'],
    ['Dibatalkan','cancelled','#DC3545','❌','badge-danger'],
  ] as [$label, $val, $color, $icon, $bClass])
  <a href="{{ route('admin.pesanan.index') }}{{ $val ? '?status='.$val : '' }}"
     style="display:flex;align-items:center;gap:8px;padding:10px 20px;border-radius:25px;border:2px solid {{ request('status')===$val ? $color : 'var(--gray-light)' }};background:{{ request('status')===$val ? $color : 'var(--white)' }};color:{{ request('status')===$val ? 'white' : 'var(--dark)' }};font-weight:700;font-size:0.84rem;transition:all 0.2s;">
    {{ $icon }} {{ $label }}
    <span class="badge {{ $bClass }}" style="{{ request('status')===$val ? 'background:rgba(255,255,255,0.3);color:#fff;' : '' }}">{{ $counts[$val ?? 'all'] ?? $counts['all'] }}</span>
  </a>
  @endforeach
</div>

<div class="admin-filter-bar">
  <form method="GET" action="{{ route('admin.pesanan.index') }}" style="display:flex;gap:12px;flex:1;flex-wrap:wrap;align-items:center;">
    @if(request('status'))
      <input type="hidden" name="status" value="{{ request('status') }}">
    @endif
    <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Cari nama atau nomor pesanan..." class="form-control" style="flex:1;min-width:220px;">
    <input type="date" name="from" value="{{ request('from') }}" class="form-control" style="width:160px;" title="Dari tanggal">
    <input type="date" name="to" value="{{ request('to') }}" class="form-control" style="width:160px;" title="Sampai tanggal">
    <button type="submit" class="btn-admin btn-admin-primary">Cari</button>
    @if(request()->hasAny(['search','from','to','status']))
      <a href="{{ route('admin.pesanan.index') }}" class="btn-admin btn-admin-secondary">✕ Reset</a>
    @endif
  </form>
  <a href="{{ route('admin.pesanan.export') }}" class="btn-admin btn-admin-success">📥 Export CSV</a>
</div>

<div class="admin-card">
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>No. Order</th>
          <th>Pelanggan</th>
          <th>Produk</th>
          <th>Ukuran / Qty</th>
          <th>Total</th>
          <th>Tanggal</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($orders as $order)
        <tr>
          <td>
            <div style="font-weight:700;color:var(--primary-dark);font-size:0.82rem;">{{ $order->order_number }}</div>
            <div style="font-size:0.72rem;color:var(--gray);margin-top:2px;">{{ $order->created_at->format('d/m/y H:i') }}</div>
          </td>
          <td>
            <div style="font-weight:600;font-size:0.88rem;">{{ $order->customer_name }}</div>
            <a href="https://wa.me/{{ preg_replace('/\D/','',$order->customer_phone) }}" target="_blank"
               style="font-size:0.75rem;color:#25D366;font-weight:600;">
              💬 {{ $order->customer_phone }}
            </a>
          </td>
          <td style="max-width:180px;">
            <div style="font-size:0.88rem;font-weight:600;">{{ Str::limit($order->product_name, 28) }}</div>
            @if($order->fitting_date)<div style="font-size:0.75rem;color:var(--info);margin-top:2px;" title="Jadwal Fitting">📅 {{ \Carbon\Carbon::parse($order->fitting_date)->format('d/m/Y H:i') }}</div>@endif
            @if($order->notes)<div style="font-size:0.75rem;color:var(--gray);margin-top:2px;" title="{{ $order->notes }}">📝 {{ Str::limit($order->notes, 30) }}</div>@endif
          </td>
          <td style="text-align:center;">
            <div style="font-size:0.85rem;">{{ $order->size ?? '—' }}</div>
            <div style="font-size:0.8rem;color:var(--gray);">x{{ $order->quantity }}</div>
          </td>
          <td style="font-weight:700;font-size:0.88rem;color:var(--primary-dark);">{{ $order->formatted_total }}</td>
          <td style="font-size:0.82rem;color:var(--gray);">{{ $order->created_at->format('d M Y') }}</td>
          <td>{!! $order->status_badge !!}</td>
          <td>
            <div style="display:flex;gap:4px;flex-wrap:wrap;">
              {{-- WA Button --}}
              <a href="{{ $order->wa_link }}" target="_blank"
                 class="btn-admin btn-admin-icon" style="background:linear-gradient(135deg,#25D366,#128C7E);color:#fff;border-radius:8px;"
                 title="Buka WhatsApp">💬</a>

              @if($order->status === 'pending')
              <a href="{{ $order->whatsapp_reminder_link }}" target="_blank"
                 class="btn-admin btn-admin-icon" style="background:var(--warning);color:#fff;border-radius:8px;"
                 title="Kirim Pengingat Pembayaran (H-3/Abandoned)">🔔</a>
              @endif

              {{-- Status Update --}}
              <div style="position:relative;" x-data>
                <select onchange="updateStatus({{ $order->id }}, this.value)"
                        class="status-select"
                        style="border-color:{{ ['pending'=>'#FFC107','processing'=>'#17A2B8','done'=>'#28A745','cancelled'=>'#DC3545'][$order->status] ?? '#D4D4D4' }};color:{{ ['pending'=>'#856404','processing'=>'#0C5460','done'=>'#155724','cancelled'=>'#721C24'][$order->status] ?? '#6B6B6B' }};">
                  <option value="pending"    {{ $order->status==='pending'    ? 'selected' : '' }}>🕐 Pending</option>
                  <option value="processing" {{ $order->status==='processing' ? 'selected' : '' }}>⚙️ Diproses</option>
                  <option value="done"       {{ $order->status==='done'       ? 'selected' : '' }}>✅ Selesai</option>
                  <option value="cancelled"  {{ $order->status==='cancelled'  ? 'selected' : '' }}>❌ Batal</option>
                </select>
              </div>

              {{-- Invoice --}}
              <a href="{{ route('admin.pesanan.invoice', $order) }}" target="_blank" class="btn-admin btn-admin-primary btn-admin-icon btn-admin-sm" title="Cetak Invoice">🖨️</a>

              {{-- Delete --}}
              <form action="{{ route('admin.pesanan.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus pesanan ini?')">
                @csrf @method('DELETE')
                <button class="btn-admin btn-admin-danger btn-admin-icon btn-admin-sm" title="Hapus">🗑️</button>
              </form>
            </div>
          </td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;padding:40px;color:var(--gray);">
          <div style="font-size:2.5rem;margin-bottom:12px;">📭</div>
          <div>Tidak ada pesanan {{ request('status') ? 'dengan status ini' : '' }}</div>
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  {{-- Pagination --}}
  @if($orders->hasPages())
  <div class="admin-card-body" style="border-top:1px solid var(--gray-light);padding:16px 24px;display:flex;align-items:center;justify-content:space-between;">
    <p style="font-size:0.82rem;color:var(--gray);">
      Menampilkan {{ $orders->firstItem() }}–{{ $orders->lastItem() }} dari {{ $orders->total() }} pesanan
    </p>
    <div class="admin-pagination">
      @foreach($orders->getUrlRange(max(1,$orders->currentPage()-2), min($orders->lastPage(),$orders->currentPage()+2)) as $page => $url)
        <a href="{{ $url }}" class="page-link {{ $orders->currentPage()===$page ? 'active' : '' }}">{{ $page }}</a>
      @endforeach
    </div>
  </div>
  @endif
</div>

{{-- Update status via AJAX --}}
<form id="statusForm" method="POST" style="display:none;">
  @csrf @method('PATCH')
  <input type="hidden" name="status" id="statusValue">
</form>

@push('scripts')
<script>
function updateStatus(orderId, status) {
  if (!confirm('Ubah status pesanan ini?')) return;
  const form = document.getElementById('statusForm');
  form.action = `/admin/pesanan/${orderId}/status`;
  document.getElementById('statusValue').value = status;
  form.submit();
}
</script>
@endpush
@endsection
