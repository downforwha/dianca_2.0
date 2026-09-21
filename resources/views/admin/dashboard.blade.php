@extends('layouts.admin')
@section('title','Dashboard')
@section('page_title','Dashboard')
@section('page_subtitle', 'Ringkasan aktivitas toko hari ini — ' . now()->translatedFormat('d F Y'))

@section('content')

{{-- Stats Cards --}}
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 24px;">
  <div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); padding: 24px; display: flex; align-items: center; gap: 16px;">
    <div class="stat-icon" style="font-size: 2rem; color: var(--primary);">👗</div>
    <div>
      <div class="stat-value" style="font-size: 1.5rem; font-weight: 600; color: var(--text-main);">{{ $totalProducts }}</div>
      <div class="stat-label" style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Total Produk</div>
    </div>
  </div>
  <div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); padding: 24px; display: flex; align-items: center; gap: 16px;">
    <div class="stat-icon" style="font-size: 2rem; color: var(--primary);">📋</div>
    <div>
      <div class="stat-value" style="font-size: 1.5rem; font-weight: 600; color: var(--text-main);">{{ $totalOrders }}</div>
      <div class="stat-label" style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Total Pesanan</div>
    </div>
  </div>
  <div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); padding: 24px; display: flex; align-items: center; gap: 16px;">
    <div class="stat-icon" style="font-size: 2rem; color: var(--primary);">🔔</div>
    <div>
      <div class="stat-value" style="font-size: 1.5rem; font-weight: 600; color: var(--text-main);">{{ $pendingOrders }}</div>
      <div class="stat-label" style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Pesanan Pending</div>
    </div>
  </div>
  <div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); padding: 24px; display: flex; align-items: center; gap: 16px;">
    <div class="stat-icon" style="font-size: 2rem; color: var(--primary);">💰</div>
    <div>
      <div class="stat-value" style="font-size: 1.25rem; font-weight: 600; color: var(--success);">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</div>
      <div class="stat-label" style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Pendapatan Bulan Ini</div>
    </div>
  </div>
</div>

{{-- Rental Collection Stats --}}
<div class="stats-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); margin-top: 24px; margin-bottom: 24px; gap: 24px;">
  <div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); border-top: 3px solid var(--success); padding: 24px; display: flex; align-items: center; gap: 16px;">
    <div class="stat-icon" style="font-size: 2rem; color: var(--success);">✅</div>
    <div>
      <div class="stat-value" style="font-size: 1.5rem; font-weight: 600; color: var(--text-main);">{{ $readyCount }}</div>
      <div class="stat-label" style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Koleksi Ready</div>
    </div>
  </div>
  <div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); border-top: 3px solid var(--warning); padding: 24px; display: flex; align-items: center; gap: 16px;">
    <div class="stat-icon" style="font-size: 2rem; color: var(--warning);">👗</div>
    <div>
      <div class="stat-value" style="font-size: 1.5rem; font-weight: 600; color: var(--text-main);">{{ $rentCount }}</div>
      <div class="stat-label" style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">Sedang Disewa</div>
    </div>
  </div>
  <div class="stat-card" style="background: var(--white); border: 1px solid var(--gray-light); border-top: 3px solid var(--info); padding: 24px; display: flex; align-items: center; gap: 16px;">
    <div class="stat-icon" style="font-size: 2rem; color: var(--info);">⏳</div>
    <div>
      <div class="stat-value" style="font-size: 1.5rem; font-weight: 600; color: var(--text-main);">{{ $onProcessCount }}</div>
      <div class="stat-label" style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.1em;">On Process</div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:24px;margin-bottom:24px;">

  {{-- Orders Chart --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>📊 Pesanan 6 Bulan Terakhir</h3>
      <a href="{{ route('admin.pesanan.index') }}" class="btn-admin btn-admin-secondary btn-admin-sm">Lihat Semua</a>
    </div>
    <div class="admin-card-body">
      <div class="chart-container">
        <canvas id="ordersChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Revenue Summary --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>💰 Keuangan Bulan Ini</h3>
      <a href="{{ route('admin.keuangan.index') }}" class="btn-admin btn-admin-secondary btn-admin-sm">Detail</a>
    </div>
    <div class="admin-card-body">
      <div style="display:flex;flex-direction:column;gap:16px;">
        <div style="padding:16px;background:rgba(16, 185, 129, 0.1);border: 1px solid rgba(16, 185, 129, 0.2);border-radius:12px;display:flex;align-items:center;justify-content:space-between;">
          <div>
            <div style="font-size:0.78rem;color:var(--success);font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">Pendapatan</div>
            <div style="font-size:1.4rem;font-weight:700;color:var(--text-main);margin-top:4px;">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</div>
          </div>
          <div style="font-size:2rem;">💚</div>
        </div>
        <div style="padding:16px;background:rgba(239, 68, 68, 0.1);border: 1px solid rgba(239, 68, 68, 0.2);border-radius:12px;display:flex;align-items:center;justify-content:space-between;">
          <div>
            <div style="font-size:0.78rem;color:var(--danger);font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">Pengeluaran</div>
            <div style="font-size:1.4rem;font-weight:700;color:var(--text-main);margin-top:4px;">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</div>
          </div>
          <div style="font-size:2rem;">❤️</div>
        </div>
        <div style="padding:16px;background:linear-gradient(135deg,var(--primary-pale),#F0DDD0);border-radius:12px;display:flex;align-items:center;justify-content:space-between;">
          <div>
            <div style="font-size:0.78rem;color:var(--primary-dark);font-weight:700;text-transform:uppercase;letter-spacing:0.08em;">Laba Bersih</div>
            <div style="font-size:1.4rem;font-weight:700;color:var(--primary-dark);margin-top:4px;">Rp {{ number_format($profitThisMonth, 0, ',', '.') }}</div>
          </div>
          <div style="font-size:2rem;">✨</div>
        </div>
      </div>
    </div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1.6fr 1fr;gap:24px;">

  {{-- Recent Orders --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>📋 Pesanan Terbaru</h3>
      <a href="{{ route('admin.pesanan.index') }}" class="btn-admin btn-admin-secondary btn-admin-sm">Lihat Semua →</a>
    </div>
    <div class="table-wrap">
      <table class="admin-table">
        <thead>
          <tr>
            <th>No. Order</th>
            <th>Pelanggan</th>
            <th>Produk</th>
            <th>Total</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($recentOrders as $order)
          <tr>
            <td><span style="font-weight:700;color:var(--primary-dark);font-size:0.82rem;">{{ $order->order_number }}</span></td>
            <td>
              <div style="font-weight:600;font-size:0.88rem;">{{ $order->customer_name }}</div>
              <div style="font-size:0.75rem;color:var(--gray);">{{ $order->customer_phone }}</div>
            </td>
            <td style="font-size:0.85rem;max-width:160px;">{{ Str::limit($order->product_name, 25) }}</td>
            <td style="font-weight:700;font-size:0.88rem;color:var(--primary-dark);">{{ $order->formatted_total }}</td>
            <td>{!! $order->status_badge !!}</td>
          </tr>
          @empty
          <tr><td colspan="5" style="text-align:center;color:var(--gray);padding:24px;">Belum ada pesanan</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Low Stock --}}
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>⚠️ Stok Menipis</h3>
      <a href="{{ route('admin.koleksi.index') }}" class="btn-admin btn-admin-secondary btn-admin-sm">Kelola</a>
    </div>
    <div class="admin-card-body" style="padding:0;">
      @forelse($lowStock as $p)
      <div style="display:flex;align-items:center;gap:12px;padding:14px 20px;border-bottom:1px solid var(--gray-light);">
        @if($p->image)
          <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" class="product-thumb">
        @else
          <div class="product-thumb" style="display:flex;align-items:center;justify-content:center;font-size:1.5rem;background:var(--cream);">
            {{ $p->category->icon ?? '👗' }}
          </div>
        @endif
        <div style="flex:1;min-width:0;">
          <div style="font-weight:600;font-size:0.85rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p->name }}</div>
          <div style="font-size:0.75rem;color:var(--gray);">{{ $p->category->name }}</div>
        </div>
        <span class="badge {{ $p->stock === 0 ? 'badge-danger' : 'badge-warning' }}">
          {{ $p->stock }} pcs
        </span>
      </div>
      @empty
      <div style="text-align:center;padding:24px;color:var(--gray);">
        <div style="font-size:2rem;margin-bottom:8px;">✅</div>
        <p style="font-size:0.85rem;">Semua stok aman!</p>
      </div>
      @endforelse
    </div>
  </div>
</div>

@push('scripts')
<script>
// Orders Chart
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
  type: 'bar',
  data: {
    labels: {!! json_encode($chartLabels) !!},
    datasets: [{
      label: 'Jumlah Pesanan',
      data: {!! json_encode($chartData) !!},
      backgroundColor: 'rgba(201,149,108,0.7)',
      borderColor: '#C9956C',
      borderWidth: 2,
      borderRadius: 8,
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { legend: { display: false } },
    scales: {
      y: { beginAtZero: true, grid: { color:'rgba(0,0,0,0.04)' }, ticks: { precision: 0 } },
      x: { grid: { display: false } }
    }
  }
});
</script>
@endpush
@endsection
