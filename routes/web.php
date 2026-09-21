<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\KoleksiController;
use App\Http\Controllers\Admin\PesananController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\KeuanganController;
use Illuminate\Support\Facades\Route;

// ─── KONSUMEN ROUTES ──────────────────────────────────────────
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/koleksi', [HomeController::class, 'koleksi'])->name('koleksi');
Route::get('/koleksi/{slug}', [HomeController::class, 'detail'])->name('produk.detail');
Route::get('/portfolio', [HomeController::class, 'portfolio'])->name('portfolio');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/size-guide', [HomeController::class, 'sizeGuide'])->name('size-guide');
Route::get('/kontak', [HomeController::class, 'kontak'])->name('kontak');
Route::post('/kontak/pesan', [KontakController::class, 'store'])->name('kontak.store');
Route::post('/wishlist/toggle/{productId}', [\App\Http\Controllers\WishlistController::class, 'toggle'])->name('wishlist.toggle');
Route::post('/reviews/{productId}', [\App\Http\Controllers\ReviewController::class, 'store'])->name('reviews.store');
// ─── ADMIN AUTH ───────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected admin routes
    Route::middleware(\App\Http\Middleware\AdminMiddleware::class)->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/dashboard', [DashboardController::class, 'index']);

        // Koleksi (Products & Categories)
        Route::get('/koleksi', [KoleksiController::class, 'index'])->name('koleksi.index');
        Route::post('/koleksi', [KoleksiController::class, 'store'])->name('koleksi.store');
        Route::put('/koleksi/{product}', [KoleksiController::class, 'update'])->name('koleksi.update');
        Route::delete('/koleksi/{product}', [KoleksiController::class, 'destroy'])->name('koleksi.destroy');
        Route::patch('/koleksi/{product}/toggle', [KoleksiController::class, 'toggle'])->name('koleksi.toggle');

        // Category sub-routes
        Route::post('/koleksi/kategori', [KoleksiController::class, 'storeCategory'])->name('koleksi.kategori.store');
        Route::put('/koleksi/kategori/{category}', [KoleksiController::class, 'updateCategory'])->name('koleksi.kategori.update');
        Route::delete('/koleksi/kategori/{category}', [KoleksiController::class, 'destroyCategory'])->name('koleksi.kategori.destroy');

        // Pesanan
        Route::get('/pesanan', [PesananController::class, 'index'])->name('pesanan.index');
        Route::get('/pesanan/{order}', [PesananController::class, 'show'])->name('pesanan.show');
        Route::get('/pesanan/{order}/invoice', [PesananController::class, 'invoice'])->name('pesanan.invoice');
        Route::patch('/pesanan/{order}/status', [PesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
        Route::delete('/pesanan/{order}', [PesananController::class, 'destroy'])->name('pesanan.destroy');
        Route::get('/pesanan-export', [PesananController::class, 'export'])->name('pesanan.export');

        // Keuangan
        Route::get('/keuangan', [KeuanganController::class, 'index'])->name('keuangan.index');
        Route::post('/keuangan', [KeuanganController::class, 'store'])->name('keuangan.store');
        Route::delete('/keuangan/{record}', [KeuanganController::class, 'destroy'])->name('keuangan.destroy');
        Route::get('/keuangan/export', [KeuanganController::class, 'export'])->name('keuangan.export');

        // Reviews
        Route::get('/reviews', [\App\Http\Controllers\Admin\ReviewController::class, 'index'])->name('reviews.index');
        Route::patch('/reviews/{id}/toggle', [\App\Http\Controllers\Admin\ReviewController::class, 'toggleVisibility'])->name('reviews.toggle');

        // Settings
        Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingsController::class, 'update'])->name('settings.update');
        Route::put('/settings/profile', [SettingsController::class, 'updateProfile'])->name('settings.profile');
        Route::put('/settings/password', [SettingsController::class, 'updatePassword'])->name('settings.password');
        Route::post('/settings/admin', [SettingsController::class, 'storeAdmin'])->name('settings.admin.store');
        Route::delete('/settings/admin/{user}', [SettingsController::class, 'destroyAdmin'])->name('settings.admin.destroy');
    });
});
