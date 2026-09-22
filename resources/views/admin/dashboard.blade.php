@extends('layouts.admin')
@section('title','Dashboard')
@section('page_title','Dashboard Overview')
@section('page_subtitle', 'Ringkasan operasional dan finansial hari ini — ' . now()->translatedFormat('d F Y'))

@section('content')

{{-- Stats Cards (Baris 1) --}}
<div class="stats-grid animate-fade-up">
  {{-- Total Products --}}
  <div class="stat-card glass-panel">
    <div class="stat-icon text-primary">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20.38 3.46 16 2a4 4 0 0 1-8 0L3.62 3.46a2 2 0 0 0-1.34 2.23l.58 3.47a1 1 0 0 0 .99.84H6v10c0 1.1.9 2 2 2h8a2 2 0 0 0 2-2V10h2.15a1 1 0 0 0 .99-.84l.58-3.47a2 2 0 0 0-1.34-2.23z"/><path d="M8 10v8"/><path d="M12 10v8"/><path d="M16 10v8"/></svg>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ $totalProducts }}</div>
      <div class="stat-label">Total Produk</div>
    </div>
  </div>
  
  {{-- Total Orders --}}
  <div class="stat-card glass-panel">
    <div class="stat-icon text-info">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ $totalOrders }}</div>
      <div class="stat-label">Total Pesanan</div>
    </div>
  </div>

  {{-- Pending Orders --}}
  <div class="stat-card glass-panel">
    <div class="stat-icon text-warning">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ $pendingOrders }}</div>
      <div class="stat-label">Pesanan Pending</div>
    </div>
  </div>

  {{-- Revenue --}}
  <div class="stat-card glass-panel">
    <div class="stat-icon text-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 12V7H5a2 2 0 0 1 0-4h14v4"/><path d="M3 5v14a2 2 0 0 0 2 2h16v-5"/><path d="M18 12a2 2 0 0 0 0 4h4v-4Z"/></svg>
    </div>
    <div class="stat-content">
      <div class="stat-value" style="font-size: 1.25rem;">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</div>
      <div class="stat-label">Pendapatan (Bulan Ini)</div>
    </div>
  </div>
</div>

{{-- Rental Collection Stats (Baris 1.5) --}}
<div class="stats-grid animate-fade-up delay-50 mt-4 mb-4">
  <div class="stat-card glass-panel green">
    <div class="stat-icon text-success">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6 9 17l-5-5"/></svg>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ $readyCount }}</div>
      <div class="stat-label">Koleksi Ready</div>
    </div>
  </div>
  <div class="stat-card glass-panel amber">
    <div class="stat-icon text-warning">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ $rentCount }}</div>
      <div class="stat-label">Sedang Disewa</div>
    </div>
  </div>
  <div class="stat-card glass-panel blue">
    <div class="stat-icon text-info">
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
    </div>
    <div class="stat-content">
      <div class="stat-value">{{ $onProcessCount }}</div>
      <div class="stat-label">On Process</div>
    </div>
  </div>
  
  {{-- Quick Actions --}}
  <div class="stat-card glass-panel quick-actions-panel" style="background: linear-gradient(135deg, var(--primary), var(--primary-dark)); color: white;">
    <div class="stat-content w-100" style="width: 100%;">
      <div class="stat-label text-white mb-2" style="opacity: 0.9;">Aksi Cepat</div>
      <div class="quick-actions-grid">
        <a href="{{ route('admin.produk.create') }}" class="btn-quick" title="Tambah Produk">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="M12 5v14"/></svg>
        </a>
        <a href="{{ route('admin.pesanan.index') }}" class="btn-quick" title="Lihat Pesanan">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
        </a>
        <a href="{{ route('admin.keuangan.create') }}" class="btn-quick" title="Catat Transaksi">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M8 12h8"/><path d="M12 8v8"/></svg>
        </a>
      </div>
    </div>
  </div>
</div>

{{-- Baris 2: Charts --}}
<div class="admin-grid-2 animate-fade-up delay-100 mb-4">
  {{-- Orders Chart --}}
  <div class="admin-card glass-panel">
    <div class="admin-card-header">
      <div class="flex-align-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/><path d="M3 9h18"/><path d="M9 21V9"/></svg>
        <h3>Pesanan 6 Bulan Terakhir</h3>
      </div>
      <a href="{{ route('admin.pesanan.index') }}" class="btn-admin btn-admin-secondary btn-admin-sm">Lihat Semua</a>
    </div>
    <div class="admin-card-body">
      <div class="chart-container" style="height: 300px;">
        <canvas id="ordersChart"></canvas>
      </div>
    </div>
  </div>

  {{-- Revenue Line Chart --}}
  <div class="admin-card glass-panel">
    <div class="admin-card-header">
      <div class="flex-align-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-success" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 3v18h18"/><path d="m19 9-5 5-4-4-3 3"/></svg>
        <h3>Arus Kas 6 Bulan Terakhir</h3>
      </div>
      <a href="{{ route('admin.keuangan.index') }}" class="btn-admin btn-admin-secondary btn-admin-sm">Detail</a>
    </div>
    <div class="admin-card-body">
      <div class="chart-container" style="height: 300px;">
        <canvas id="revenueChart"></canvas>
      </div>
    </div>
  </div>
</div>

{{-- Baris 3: Tables --}}
<div class="admin-grid-layout animate-fade-up delay-150">
  
  {{-- Recent Orders (Kiri, lebih lebar) --}}
  <div class="admin-card glass-panel grid-col-span-2">
    <div class="admin-card-header">
      <div class="flex-align-center gap-2">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-info" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" x2="8" y1="13" y2="13"/><line x1="16" x2="8" y1="17" y2="17"/><polyline points="10 9 9 9 8 9"/></svg>
        <h3>Pesanan Terbaru</h3>
      </div>
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
          <tr class="table-row-hover">
            <td><span class="text-primary-dark font-bold text-sm">{{ $order->order_number }}</span></td>
            <td>
              <div class="font-semibold text-sm">{{ $order->customer_name }}</div>
              <div class="text-xs text-muted">{{ $order->customer_phone }}</div>
            </td>
            <td class="text-sm max-w-160">{{ Str::limit($order->product_name, 35) }}</td>
            <td class="font-bold text-sm text-primary-dark">{{ $order->formatted_total }}</td>
            <td>{!! $order->status_badge !!}</td>
          </tr>
          @empty
          <tr><td colspan="5" class="text-center text-muted p-6">Belum ada pesanan</td></tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  {{-- Low Stock & Financial Summary (Kanan) --}}
  <div class="flex-col gap-4">
    
    {{-- Financial Summary --}}
    <div class="admin-card glass-panel">
      <div class="admin-card-header">
        <div class="flex-align-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-primary" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
          <h3>Ringkasan Keuangan</h3>
        </div>
      </div>
      <div class="admin-card-body">
        <div class="flex-col gap-3">
          <div class="finance-box finance-income">
            <div>
              <div class="finance-label text-success">Pendapatan</div>
              <div class="finance-val">Rp {{ number_format($revenueThisMonth, 0, ',', '.') }}</div>
            </div>
            <div class="finance-icon text-success">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/></svg>
            </div>
          </div>
          <div class="finance-box finance-expense">
            <div>
              <div class="finance-label text-danger">Pengeluaran</div>
              <div class="finance-val">Rp {{ number_format($expenseThisMonth, 0, ',', '.') }}</div>
            </div>
            <div class="finance-icon text-danger">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 17 13.5 8.5 8.5 13.5 2 7"/><polyline points="16 17 22 17 22 11"/></svg>
            </div>
          </div>
          <div class="finance-box finance-profit">
            <div>
              <div class="finance-label text-primary-dark">Laba Bersih</div>
              <div class="finance-val text-primary-dark">Rp {{ number_format($profitThisMonth, 0, ',', '.') }}</div>
            </div>
            <div class="finance-icon text-primary-dark">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Low Stock --}}
    <div class="admin-card glass-panel">
      <div class="admin-card-header">
        <div class="flex-align-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="text-warning" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3Z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
          <h3>Stok Menipis</h3>
        </div>
        <a href="{{ route('admin.koleksi.index') }}" class="btn-admin btn-admin-secondary btn-admin-sm">Kelola</a>
      </div>
      <div class="admin-card-body p-0">
        @forelse($lowStock as $p)
        <div class="low-stock-item">
          @if($p->image)
            <img src="{{ asset('storage/'.$p->image) }}" alt="{{ $p->name }}" class="product-thumb">
          @else
            <div class="product-thumb-placeholder text-primary">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="16" height="20" x="4" y="2" rx="2"/><path d="M9 22v-4h6v4"/><path d="M8 6h.01"/><path d="M16 6h.01"/><path d="M12 6h.01"/><path d="M12 10h.01"/><path d="M12 14h.01"/><path d="M16 10h.01"/><path d="M16 14h.01"/><path d="M8 10h.01"/><path d="M8 14h.01"/></svg>
            </div>
          @endif
          <div class="flex-1 min-w-0">
            <div class="font-semibold text-sm truncate">{{ $p->name }}</div>
            <div class="text-xs text-muted">{{ $p->category->name }}</div>
          </div>
          <span class="badge {{ $p->stock === 0 ? 'badge-danger' : 'badge-warning' }}">
            {{ $p->stock }} pcs
          </span>
        </div>
        @empty
        <div class="text-center text-muted p-6">
          <div class="text-success mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="margin: 0 auto;"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m9 11 3 3L22 4"/></svg>
          </div>
          <p class="text-sm">Semua stok aman!</p>
        </div>
        @endforelse
      </div>
    </div>
    
  </div>
</div>

@push('scripts')
<script>
// Styling variables
const primaryColor = '#C9956C';
const primaryLight = 'rgba(201, 149, 108, 0.2)';
const successColor = '#10B981';
const successLight = 'rgba(16, 185, 129, 0.2)';
const dangerColor = '#EF4444';
const dangerLight = 'rgba(239, 68, 68, 0.2)';

// Orders Chart (Bar)
const ordersCtx = document.getElementById('ordersChart').getContext('2d');
new Chart(ordersCtx, {
  type: 'bar',
  data: {
    labels: {!! json_encode($chartLabels) !!},
    datasets: [{
      label: 'Jumlah Pesanan',
      data: {!! json_encode($chartData) !!},
      backgroundColor: primaryColor,
      borderColor: primaryColor,
      borderWidth: 0,
      borderRadius: 6,
      barPercentage: 0.6
    }]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { 
      legend: { display: false },
      tooltip: {
        backgroundColor: 'rgba(255, 255, 255, 0.95)',
        titleColor: '#1e293b',
        bodyColor: '#475569',
        borderColor: '#e2e8f0',
        borderWidth: 1,
        padding: 12,
        boxPadding: 6,
        usePointStyle: true,
      }
    },
    scales: {
      y: { 
        beginAtZero: true, 
        grid: { color:'rgba(0,0,0,0.04)', borderDash: [5, 5] }, 
        ticks: { precision: 0, color: '#94a3b8' },
        border: { display: false }
      },
      x: { 
        grid: { display: false },
        ticks: { color: '#64748b' },
        border: { display: false }
      }
    }
  }
});

// Revenue Chart (Line)
const revenueCtx = document.getElementById('revenueChart').getContext('2d');
new Chart(revenueCtx, {
  type: 'line',
  data: {
    labels: {!! json_encode($revenueLabels) !!},
    datasets: [
      {
        label: 'Pendapatan',
        data: {!! json_encode($incomeData) !!},
        backgroundColor: successLight,
        borderColor: successColor,
        borderWidth: 2,
        pointBackgroundColor: '#fff',
        pointBorderColor: successColor,
        pointBorderWidth: 2,
        pointRadius: 4,
        fill: true,
        tension: 0.4
      },
      {
        label: 'Pengeluaran',
        data: {!! json_encode($expenseData) !!},
        backgroundColor: dangerLight,
        borderColor: dangerColor,
        borderWidth: 2,
        pointBackgroundColor: '#fff',
        pointBorderColor: dangerColor,
        pointBorderWidth: 2,
        pointRadius: 4,
        fill: true,
        tension: 0.4
      }
    ]
  },
  options: {
    responsive: true,
    maintainAspectRatio: false,
    plugins: { 
      legend: { 
        position: 'top',
        align: 'end',
        labels: {
          usePointStyle: true,
          boxWidth: 8,
          color: '#64748b'
        }
      },
      tooltip: {
        mode: 'index',
        intersect: false,
        backgroundColor: 'rgba(255, 255, 255, 0.95)',
        titleColor: '#1e293b',
        bodyColor: '#475569',
        borderColor: '#e2e8f0',
        borderWidth: 1,
        padding: 12,
      }
    },
    interaction: {
      mode: 'nearest',
      axis: 'x',
      intersect: false
    },
    scales: {
      y: { 
        beginAtZero: true, 
        grid: { color:'rgba(0,0,0,0.04)', borderDash: [5, 5] }, 
        ticks: { 
          color: '#94a3b8',
          callback: function(value) {
            if(value >= 1000000) return 'Rp ' + (value / 1000000) + 'M';
            if(value >= 1000) return 'Rp ' + (value / 1000) + 'K';
            return 'Rp ' + value;
          }
        },
        border: { display: false }
      },
      x: { 
        grid: { display: false },
        ticks: { color: '#64748b' },
        border: { display: false }
      }
    }
  }
});
</script>
@endpush
@endsection
