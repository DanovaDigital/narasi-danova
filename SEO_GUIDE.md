# Panduan Implementasi SEO Maximum & Google Search Console

Dokumen ini berisi langkah-langkah teknis untuk memastikan website memiliki fondasi SEO terbaik ("Mentok Kanan") dan terintegrasi sempurna dengan Google Search Console.

## 📋 Checklist Implementasi Coding

Pastikan `<head>` HTML memuat elemen berikut secara urut:

1.  **Basic Meta Tags**:

    ```html
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Judul Halaman Utama | Nama Brand</title>
    <meta
        name="description"
        content="Deskripsi menarik, mengandung keyword, maksimal 160 karakter."
    />
    <link
        rel="canonical"
        href="[https://www.websiteanda.com/halaman-ini](https://www.websiteanda.com/halaman-ini)"
    />
    ```

2.  **Robots & Indexing**:

    ```html
    <meta
        name="robots"
        content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1"
    />
    ```

3.  **Open Graph (Agar link bagus saat di-share di WA/FB)**:

    ```html
    <meta property="og:locale" content="id_ID" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="Judul Halaman" />
    <meta property="og:description" content="Deskripsi singkat halaman." />
    <meta
        property="og:url"
        content="[https://websiteanda.com/halaman-ini](https://websiteanda.com/halaman-ini)"
    />
    <meta property="og:site_name" content="Nama Brand" />
    <meta
        property="og:image"
        content="[https://websiteanda.com/assets/og-image.jpg](https://websiteanda.com/assets/og-image.jpg)"
    />
    ```

4.  **Structured Data (JSON-LD)**:
    _Wajib diletakkan sebelum tag `</head>` atau di dalam `<body>`._
    Gunakan [Schema Markup Generator](https://technicalseo.com/tools/schema-markup-generator/) untuk membuat script JSON-LD yang valid.

## 🚀 Integrasi Google Search Console (GSC)

Agar data website masuk ke Google dengan cepat:

### Langkah 1: Verifikasi Domain

1. Buka [Google Search Console](https://search.google.com/search-console).
2. Pilih metode **Domain** (bukan URL prefix) agar mencakup semua subdomain (http/https/www).
3. Copy **TXT Record** yang diberikan Google.
4. Masuk ke penyedia domain (cPanel/Cloudflare/Niagahoster), buka DNS Management.
5. Tambahkan TXT Record tersebut. Tunggu propagasi (bisa 1 jam - 24 jam).

### Langkah 2: Submit Sitemap

Setelah terverifikasi:

1. Pastikan website Anda memiliki file `sitemap.xml` (biasanya di `domain.com/sitemap.xml`).
2. Di menu kiri GSC, klik **Sitemaps**.
3. Masukkan URL sitemap Anda dan klik **Submit**.
4. Pastikan statusnya **"Success"**.

### Langkah 3: Tes URL (Inspect URL)

Jika ada halaman baru yang ingin segera diindeks:

1. Paste URL halaman tersebut di kolom pencarian atas GSC.
2. Klik **"Request Indexing"**.

## ⚙️ Konfigurasi Robots.txt

Robots disajikan di endpoint `https://domain.com/robots.txt`. Kontennya sama seperti contoh di bawah, namun sitemap menggunakan URL absolut (sesuai rekomendasi GSC).

```txt
User-agent: *
Allow: /

# Disallow admin atau halaman login
Disallow: /admin/
Disallow: /login/
Disallow: /dashboard/

# Tunjukkan lokasi sitemap
Sitemap: [https://www.websiteanda.com/sitemap.xml](https://www.websiteanda.com/sitemap.xml)
```
