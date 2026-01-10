# Narasi DanovaDigital — Portal Berita (MVP)

Fokus tahap awal: fungsionalitas jalan dulu. Styling tidak diprioritaskan (0 styling pun OK).

## Fitur MVP

-   Public pages: Beranda trending, detail artikel, kategori, penulis, search.
-   CMS minimal: CRUD artikel di `/admin/articles` (proteksi dengan admin key).
-   Tracking view: setiap buka detail artikel tercatat di `article_views`.
-   Hot scoring: command `news:compute-hot-scores` menghitung `hot_score`.

## Quick start (SQLite default)

```bash
composer install
npm install
npm run dev
php artisan migrate
php artisan db:seed
php artisan news:compute-hot-scores
php artisan serve
```

Buka:

-   Home: `http://127.0.0.1:8000/home`
-   Admin articles: `http://127.0.0.1:8000/admin/articles?admin_key=my-secret-admin-key-change-in-production`

**Note**: Admin area memerlukan `admin_key` di query parameter atau header `X-Admin-Key`. Default key ada di `.env` (`ADMIN_KEY`).

## Pakai MySQL

1. Copy `.env.mysql.example` ke `.env` lalu isi kredensial MySQL.
2. Jalankan:

```bash
php artisan migrate:fresh
php artisan db:seed
php artisan news:compute-hot-scores
```

## Catatan

-   Untuk share: sudah ada meta OG dasar dan tombol Web Share + Copy Link di halaman artikel.
-   Algoritme hot score saat ini sederhana (MVP) dan bisa disempurnakan nanti.
