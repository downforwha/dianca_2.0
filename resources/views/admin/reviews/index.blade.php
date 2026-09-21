@extends('layouts.admin')

@section('title', 'Kelola Review & Testimoni')
@section('page_title', 'Review & Testimoni')

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <h5 style="margin:0;">Daftar Review Pelanggan</h5>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>Produk</th>
                        <th>Pelanggan</th>
                        <th>Rating</th>
                        <th>Komentar</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reviews as $review)
                    <tr>
                        <td>{{ $review->product->name }}</td>
                        <td>{{ $review->name }}</td>
                        <td>
                            <div style="color:#FFD700;font-size:1.1rem;">
                                {{ str_repeat('★', $review->rating) }}{{ str_repeat('☆', 5 - $review->rating) }}
                            </div>
                        </td>
                        <td style="max-width:300px;white-space:normal;">{{ $review->comment ?? '-' }}</td>
                        <td>
                            @if($review->photo)
                                <img src="{{ asset('storage/' . $review->photo) }}" alt="Foto Review" style="width:60px;height:60px;object-fit:cover;border-radius:8px;border:1px solid var(--border-color);">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            @if($review->is_visible)
                                <span class="badge" style="background:rgba(76,175,80,0.1);color:#4CAF50;">Ditampilkan</span>
                            @else
                                <span class="badge" style="background:rgba(244,67,54,0.1);color:#F44336;">Disembunyikan</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.reviews.toggle', $review->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-sm btn-{{ $review->is_visible ? 'warning' : 'success' }}" title="{{ $review->is_visible ? 'Sembunyikan Review' : 'Tampilkan Review' }}">
                                    @if($review->is_visible)
                                        <i class="fas fa-eye-slash"></i> Sembunyikan
                                    @else
                                        <i class="fas fa-eye"></i> Tampilkan
                                    @endif
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted" style="padding:40px;">Belum ada review pelanggan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
