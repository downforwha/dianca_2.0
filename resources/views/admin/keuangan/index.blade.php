@extends('layouts.admin')
@section('title','Data Keuangan')
@section('page_title','Data Keuangan')
@section('page_subtitle','Laporan keuangan dan rekap pendapatan butik')

@section('content')

{{-- Period Filter --}}
<div class="admin-filter-bar" style="margin-bottom:24px;">
  <span style="font-weight:700;font-size:0.9rem;">Periode:</span>
  <div class="period-tabs">
    @foreach([['Bulan Ini','this_month'],['3 Bulan','3_months'],['6 Bulan','6_months'],['Tahun Ini','this_year'],['Semua','all']] as [$label, $val])
    <a href="{{ route('admin.keuangan.index') }}?period={{ $val }}"
       class="period-tab {{ (request('period', 'this_month') === $val) ? 'active' : '' }}">{{ $label }}</a>
    @endforeach
  </div>
  <div style="flex:1;display:flex;justify-content:flex-end;gap:10px;">
    <a href="{{ route('admin.keuangan.export') }}?period={{ request('period','this_month') }}" class="btn-admin btn-admin-success btn-admin-sm">📥 Export CSV (Google Sheets Sync)</a>
    <button onclick="openModal('modalAddRecord')" class="btn-admin btn-admin-primary">+ Tambah Catatan</button>
  </div>
</div>

{{-- Summary Cards --}}
<div class="keu-summary">
  <div class="keu-card keu-income" style="border-top:4px solid #28A745;">
    <div class="label">💚 Total Pendapatan</div>
    <div class="amount">Rp {{ number_format($totalIncome, 0, ',', '.') }}</div>
    <div style="font-size:0.78rem;color:var(--gray);margin-top:4px;">{{ $incomeCount }} transaksi</div>
  </div>
  <div class="keu-card keu-expense" style="border-top:4px solid #DC3545;">
    <div class="label">❤️ Total Pengeluaran</div>
    <div class="amount">Rp {{ number_format($totalExpense, 0, ',', '.') }}</div>
    <div style="font-size:0.78rem;color:var(--gray);margin-top:4px;">{{ $expenseCount }} transaksi</div>
  </div>
  <div class="keu-card keu-profit" style="border-top:4px solid var(--primary);">
    <div class="label">✨ Laba Bersih</div>
    <div class="amount">Rp {{ number_format($netProfit, 0, ',', '.') }}</div>
    <div style="font-size:0.78rem;color:{{ $netProfit >= 0 ? '#28A745' : '#DC3545' }};margin-top:4px;">
      {{ $netProfit >= 0 ? '📈 Profit' : '📉 Rugi' }}
    </div>
  </div>
</div>

{{-- Charts --}}
<div class="admin-layout" style="margin-bottom:24px;">
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>📊 Grafik Pendapatan vs Pengeluaran</h3>
    </div>
    <div class="admin-card-body">
      <div class="chart-container">
        <canvas id="keuanganChart"></canvas>
      </div>
    </div>
  </div>
  <div class="admin-card">
    <div class="admin-card-header">
      <h3>🥧 Distribusi Keuangan</h3>
    </div>
    <div class="admin-card-body">
      <div class="chart-container" style="height:240px;">
        <canvas id="donutChart"></canvas>
      </div>
    </div>
  </div>
</div>

{{-- Records Table --}}
<div class="admin-card">
  <div class="admin-card-header">
    <h3>📋 Riwayat Transaksi</h3>
    <div style="display:flex;gap:8px;">
      <select class="form-control" style="width:160px;" onchange="filterType(this.value)">
        <option value="">Semua Tipe</option>
        <option value="income" {{ request('type')==='income' ? 'selected' : '' }}>💚 Pendapatan</option>
        <option value="expense" {{ request('type')==='expense' ? 'selected' : '' }}>❤️ Pengeluaran</option>
      </select>
    </div>
  </div>
  <div class="table-wrap">
    <table class="admin-table">
      <thead>
        <tr>
          <th>Tanggal</th>
          <th>Keterangan</th>
          <th>Kategori</th>
          <th>No. Order</th>
          <th>Tipe</th>
          <th>Jumlah</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        @forelse($records as $rec)
        <tr>
          <td style="font-size:0.85rem;white-space:nowrap;">{{ $rec->date->format('d M Y') }}</td>
          <td>
            <div style="font-weight:600;font-size:0.88rem;">{{ $rec->description }}</div>
            @if($rec->notes)<div style="font-size:0.75rem;color:var(--gray);">{{ Str::limit($rec->notes, 40) }}</div>@endif
          </td>
          <td><span class="badge badge-primary">{{ $rec->category ?? 'Umum' }}</span></td>
          <td>
            @if($rec->order_id)
              <a href="{{ route('admin.pesanan.index') }}?search={{ $rec->order->order_number ?? '' }}"
                 style="font-size:0.8rem;color:var(--primary);font-weight:700;">
                {{ $rec->order->order_number ?? '#—' }}
              </a>
            @else
              <span style="color:var(--gray);font-size:0.8rem;">—</span>
            @endif
          </td>
          <td>
            <span class="badge {{ $rec->type === 'income' ? 'badge-success' : 'badge-danger' }}">
              {{ $rec->type === 'income' ? '💚 Pendapatan' : '❤️ Pengeluaran' }}
            </span>
          </td>
          <td style="font-weight:700;font-size:0.95rem;color:{{ $rec->type === 'income' ? '#1B7A3A' : '#A93226' }};">
            {{ $rec->type === 'income' ? '+' : '-' }} Rp {{ number_format($rec->amount, 0, ',', '.') }}
          </td>
          <td>
            <form action="{{ route('admin.keuangan.destroy', $rec) }}" method="POST" onsubmit="return confirm('Hapus catatan ini?')">
              @csrf @method('DELETE')
              <button class="btn-admin btn-admin-danger btn-admin-icon btn-admin-sm" title="Hapus">🗑️</button>
            </form>
          </td>
        </tr>
        @empty
        <tr><td colspan="7" style="text-align:center;padding:32px;color:var(--gray);">
          <div style="font-size:2.5rem;margin-bottom:10px;">💸</div>
          Belum ada catatan keuangan untuk periode ini.
        </td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  @if($records->hasPages())
  <div style="padding:16px 24px;border-top:1px solid var(--gray-light);display:flex;justify-content:center;">
    <div class="admin-pagination">
      @foreach($records->getUrlRange(max(1,$records->currentPage()-2), min($records->lastPage(),$records->currentPage()+2)) as $page => $url)
        <a href="{{ $url }}" class="page-link {{ $records->currentPage()===$page ? 'active' : '' }}">{{ $page }}</a>
      @endforeach
    </div>
  </div>
  @endif
</div>

{{-- Modal Add Record --}}
<div class="modal-overlay" id="modalAddRecord">
  <div class="modal" style="max-width:480px;">
    <div class="modal-header">
      <h3>💰 Tambah Catatan Keuangan</h3>
      <span class="modal-close" onclick="closeModal('modalAddRecord')">✕</span>
    </div>
    <form action="{{ route('admin.keuangan.store') }}" method="POST">
      @csrf
      <div class="modal-body">
        <div class="form-grid-2">
          <div class="form-group">
            <label class="form-label">Tipe *</label>
            <select name="type" class="form-control" required>
              <option value="income">💚 Pendapatan</option>
              <option value="expense">❤️ Pengeluaran</option>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Tanggal *</label>
            <input type="date" name="date" class="form-control" value="{{ now()->format('Y-m-d') }}" required>
          </div>
        </div>
        <div class="form-group">
          <label class="form-label">Jumlah (Rp) *</label>
          <input type="number" name="amount" class="form-control" required min="0" placeholder="150000">
        </div>
        <div class="form-group">
          <label class="form-label">Keterangan *</label>
          <input type="text" name="description" class="form-control" required placeholder="Misalnya: Pembelian bahan baku...">
        </div>
        <div class="form-group">
          <label class="form-label">Kategori</label>
          <select name="category" class="form-control">
            <option value="Penjualan">Penjualan</option>
            <option value="Bahan Baku">Bahan Baku</option>
            <option value="Operasional">Operasional</option>
            <option value="Marketing">Marketing</option>
            <option value="Pengiriman">Pengiriman</option>
            <option value="Lain-lain">Lain-lain</option>
          </select>
        </div>
        <div class="form-group">
          <label class="form-label">Catatan Tambahan</label>
          <textarea name="notes" class="form-control" rows="2" placeholder="Catatan opsional..."></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn-admin btn-admin-secondary" onclick="closeModal('modalAddRecord')">Batal</button>
        <button type="submit" class="btn-admin btn-admin-primary">💾 Simpan</button>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
// Revenue vs Expense chart
new Chart(document.getElementById('keuanganChart').getContext('2d'), {
  type: 'line',
  data: {
    labels: {!! json_encode($chartLabels) !!},
    datasets: [
      {
        label: 'Pendapatan',
        data: {!! json_encode($incomeData) !!},
        borderColor: '#28A745', backgroundColor: 'rgba(40,167,69,0.08)',
        tension: 0.4, fill: true, borderWidth: 2, pointRadius: 4,
      },
      {
        label: 'Pengeluaran',
        data: {!! json_encode($expenseData) !!},
        borderColor: '#DC3545', backgroundColor: 'rgba(220,53,69,0.08)',
        tension: 0.4, fill: true, borderWidth: 2, pointRadius: 4,
      }
    ]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: { legend: { position: 'bottom' } },
    scales: { y: { beginAtZero: true, ticks: { callback: v => 'Rp'+Number(v).toLocaleString('id-ID') } } }
  }
});

// Donut chart
new Chart(document.getElementById('donutChart').getContext('2d'), {
  type: 'doughnut',
  data: {
    labels: ['Pendapatan', 'Pengeluaran'],
    datasets: [{
      data: [{{ $totalIncome }}, {{ $totalExpense }}],
      backgroundColor: ['#28A745','#DC3545'],
      borderWidth: 0, borderRadius: 4,
    }]
  },
  options: {
    responsive: true, maintainAspectRatio: false,
    plugins: {
      legend: { position: 'bottom' },
      tooltip: { callbacks: { label: ctx => ' Rp ' + Number(ctx.parsed).toLocaleString('id-ID') } }
    },
    cutout: '65%'
  }
});

function filterType(val) {
  const url = new URL(window.location);
  if (val) url.searchParams.set('type', val);
  else url.searchParams.delete('type');
  window.location = url.toString();
}
</script>
@endpush
@endsection
