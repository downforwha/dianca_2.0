@extends('layouts.app')
@section('title', 'Halaman Tidak Ditemukan')

@section('content')
<section style="min-height: 80vh; display: flex; align-items: center; justify-content: center; text-align: center; padding: 40px 20px;">
    <div style="max-width: 600px;">
        <h1 style="font-family: 'Playfair Display', serif; font-size: 8rem; color: var(--primary); margin: 0; line-height: 1;">404</h1>
        <h2 style="font-family: 'Playfair Display', serif; font-size: 2rem; color: var(--primary); margin: 20px 0 10px;">Halaman Tidak Ditemukan</h2>
        <p style="color: var(--gray); font-size: 1.1rem; margin-bottom: 30px; font-weight: 300;">
            Maaf, halaman yang Anda cari mungkin telah dihapus, namanya diubah, atau sementara tidak tersedia.
        </p>
        <a href="{{ route('home') }}" class="btn-primary" style="display: inline-block; padding: 12px 32px; font-size: 1rem; border-radius: 4px;">
            Kembali ke Beranda
        </a>
    </div>
</section>
@endsection
