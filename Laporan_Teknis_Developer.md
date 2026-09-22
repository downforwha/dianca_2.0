# Laporan Teknis Pengembangan - Dianca Atelier
*Dokumen internal untuk Developer*

## 1. Informasi Proyek
- **Nama Proyek:** Dianca Atelier (Butik 2.0)
- **Framework:** Laravel 11.x
- **Frontend:** Blade Templating, Vanilla CSS (Custom Properties, Grid/Flexbox), JavaScript
- **Database:** MySQL
- **Deployment:** Railway (FrankenPHP / Railpack)

## 2. Arsitektur & Lingkungan
- **Proxy & HTTPS:** Karena Railway menggunakan sistem Load Balancer, aplikasi dikonfigurasi untuk mempercayai proxy (`$middleware->trustProxies(at: '*')`) pada `bootstrap/app.php`. Selain itu, URL asset dipaksa menggunakan HTTPS melalui `URL::forceScheme('https')` di `AppServiceProvider` agar tidak terjadi *Mixed Content* yang memblokir CSS di *production*.
- **Routing & Controller:** Menggunakan standar resource controller Laravel. Checkout diarahkan langsung ke WhatsApp API.
- **Admin Panel:** Menggunakan autentikasi bawaan atau custom middleware dengan *seeder* khusus (`AdminUserSeeder`).

## 3. Optimasi Frontend (UI/UX)
- **Desain Responsif:** Semua elemen menggunakan CSS Grid (`.grid-2`, `.grid-3`, `.grid-4`, `.bento-grid`, `.kontak-layout`). Penyesuaian media queries (`@media (max-width: 768px)`) diimplementasikan di `style.css` dan `admin.css` untuk mencegah penumpukan elemen di layar mobile.
- **Dark Mode:** Diimplementasikan menggunakan variabel CSS (`--primary`, `--bg`, dll.) yang di-override ketika `body` memiliki class `dark-mode`.
- **Performa:** Gambar menggunakan atribut `loading="lazy"`. Penggunaan inline grid styles telah dihapus dan dipusatkan di file CSS agar ter-cache dengan baik oleh browser.

## 4. Log Perbaikan Terakhir (Deployment)
- **Isu:** Desain CSS tidak termuat (tampilan berantakan) setelah deploy.
- **Penyebab:** Variabel `APP_URL` menggunakan `http://` sedangkan Railway melayani di `https://`, memicu pemblokiran *Mixed Content*. Selain itu Laravel tidak mengenali HTTPS dari Load Balancer.
- **Solusi:** Memperbarui config `APP_URL` menjadi `https://`, mengatur *Trust Proxies*, dan memaksa skema HTTPS di `AppServiceProvider`.
- **Isu Layout:** Tampilan berantakan di HP pada sisi Konsumen dan Admin.
- **Penyebab:** Penggunaan *inline styles* `style="display:grid; grid-template-columns:..."` yang menimpa *media queries*.
- **Solusi:** Menghapus *inline styles* dan menggantinya dengan class CSS responsif (`.grid-2`, `.grid-3`, dll).

## 5. Deployment Checklist (Railway)
1. Environment Variables (`DB_HOST`, `DB_PASSWORD`, dsb) diambil langsung dari koneksi Database internal Railway.
2. `APP_URL` wajib menggunakan `https://`.
3. `APP_ENV` diatur ke `production` dan `APP_DEBUG` ke `false`.
4. Perintah deploy (NPM / Composer) dikelola otomatis oleh *Railpack*.

---
*Laporan dibuat secara otomatis pada penyelesaian fase deployment.*
