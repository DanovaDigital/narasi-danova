# Portal Berita - Panduan Setup

## Ringkas: Cara akses Admin (tanpa email/password)

Panel admin di project ini **tidak memakai email/password** untuk login.
Login menggunakan:

-   `ADMIN_KEY` (wajib)
-   PIN 6 digit (wajib)

## 1) Konfigurasi Environment

Set di `.env` (wajib di production):

```bash
APP_URL=https://your-domain.com
ADMIN_KEY=your-strong-random-secret
ADMIN_NOTIFICATION_EMAILS=admin-notify@example.com,other@example.com
```

Kalau kamu pakai subdomain admin (mis. `admin.your-domain.com`), tambahkan:

```bash
SESSION_DOMAIN=.your-domain.com
```

## 2) Jalankan Migration

```bash
php artisan migrate --force
```

Migration penting untuk fitur keamanan admin:

-   `2026_01_11_000001_add_security_fields_to_admins_table.php` (menambah `pin_hash`)
-   `2026_01_11_033114_drop_email_and_password_from_admins_table.php` (menghapus `email` + `password` dari tabel `admins`)

## 3) Seed Admin + Konten (opsional untuk dev)

```bash
php artisan db:seed
```

Seeder akan membuat admin dan contoh artikel (sesuai seeder yang sudah ada di project).

## 4) Atur PIN Admin (wajib)

Set PIN 6 digit lewat artisan command:

```bash
php artisan admin:set-pin --pin=123456
```

Atau kalau mau spesifik berdasarkan ID admin:

```bash
php artisan admin:set-pin 1 --pin=123456
```

Catatan: login admin akan ditolak kalau PIN belum diset.

## Hostinger Quick Deploy (Shared Hosting)

1. Buat subdomain (opsional): `admin.your-domain.com`
2. Pastikan document root mengarah ke folder `public`.
    - Jika Hostinger mengharuskan pakai `public_html`, upload/copy **isi folder `public/`** ke `public_html/` (jangan ikut folder `public`-nya).
    - Pastikan `public_html/index.php` ada dan mengarah ke project Laravel yang benar (biasanya otomatis kalau isi `public/` sudah dipindah).
3. Set `.env` minimal: `APP_URL`, `ADMIN_KEY`, `DB_*`, dan `SESSION_DOMAIN` jika pakai subdomain
4. Jalankan:

```bash
php artisan migrate --force
php artisan db:seed
php artisan config:cache
```

### Penting: Asset Vite (`/build`) & Upload Gambar (`/storage`)

-   **Vite build**: jalankan `npm run build` (biasanya di lokal/CI), lalu pastikan folder `public/build/` ikut ter-upload ke `public_html/build/`.
-   **Upload gambar artikel** disimpan di `storage/app/public` dan diakses via URL `/storage/...`.
    -   Jika ada SSH: jalankan `php artisan storage:link`.
    -   Jika **tidak** ada symlink di shared hosting: copy folder `storage/app/public/` ke `public_html/storage/` setiap deploy (minimal folder `articles/`).

Tips: pastikan permission folder writable untuk upload: `storage/`, `bootstrap/cache/`, dan target `public_html/storage/`.

Catatan: kalau tidak ada SSH, jalankan langkah migration/seed lewat workflow deploy Hostinger (Git + composer) atau akses eksekusi perintah via panel yang tersedia.
