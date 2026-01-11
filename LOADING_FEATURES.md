# Loading States & Placeholder Images - Dokumentasi

## 📋 Ringkasan Update

Berikut adalah implementasi untuk 3 fitur yang diminta:

### 1. ✅ WhatsApp Bubble - Posisi Pojok Kanan Bawah

**File:** `resources/views/components/whatsapp-bubble.blade.php`

-   ✅ Posisi diubah dari `bottom-6 left-6` → `bottom-6 right-6`
-   ✅ Tooltip muncul dari kanan ke kiri
-   ✅ Fixed position & melayang di atas semua konten (z-50)
-   ✅ Smooth hover animation

**Penggunaan:**
Sudah otomatis terintegrasi di `layouts/app.blade.php`.

---

### 2. ✅ Image Placeholder/Not Found

**File:** `public/images/article-placeholder.svg`

-   ✅ SVG placeholder yang bersih dan rapih
-   ✅ Otomatis muncul saat image error/tidak ada
-   ✅ Sudah terintegrasi di component `article-card.blade.php`

**Cara Kerja:**

```blade
<img src="{{ $imageSrc }}"
    onerror="this.src='{{ $placeholder }}'; this.previousElementSibling?.classList.add('hidden')">
```

Jika image gagal load, otomatis fallback ke placeholder SVG.

---

### 3. ✅ Loading States & Skeleton Loaders

#### A. Page Loading State (Global)

**File:**

-   `resources/js/app.js` - Alpine.js pageLoader component
-   `resources/views/layouts/app.blade.php` - Loading overlay

**Fitur:**

-   ✅ Loading spinner muncul otomatis saat navigasi antar halaman
-   ✅ Backdrop blur effect
-   ✅ Spinner animation dengan brand color

**Cara Kerja:**
Sudah otomatis aktif untuk semua link internal. Tidak perlu konfigurasi tambahan.

**Menonaktifkan untuk link tertentu:**

```blade
<a href="..." data-no-loader>Link tanpa loader</a>
```

#### B. Skeleton Loading untuk Cards

**File:** `resources/views/components/article-card-skeleton.blade.php`

**Variant yang tersedia:**

-   `standard` - Card standar dengan gambar di atas
-   `featured` - Hero/featured card besar
-   `overlay` - Card dengan overlay gelap
-   `horizontal` - Layout horizontal (thumbnail + text)
-   `minimal` - Layout minimal tanpa gambar

**Contoh Penggunaan:**

```blade
{{-- Saat loading data --}}
@if($loading)
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @for($i = 0; $i < 8; $i++)
            <x-article-card-skeleton variant="standard" />
        @endfor
    </div>
@else
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($articles as $article)
            <x-article-card :article="$article" variant="standard" />
        @endforeach
    </div>
@endif
```

**Contoh untuk variant lain:**

```blade
{{-- Featured/Hero --}}
<x-article-card-skeleton variant="featured" />

{{-- Overlay dengan height custom --}}
<x-article-card-skeleton variant="overlay" class="h-[400px]" />

{{-- Horizontal --}}
<x-article-card-skeleton variant="horizontal" />

{{-- Minimal --}}
<x-article-card-skeleton variant="minimal" />
```

#### C. Loading Overlay Component (Optional)

**File:** `resources/views/components/loading-overlay.blade.php`

Untuk use case khusus yang membutuhkan loading overlay terpisah.

**Penggunaan dengan Alpine.js:**

```blade
<div x-data="{ loading: false }">
    <button @click="loading = true; setTimeout(() => loading = false, 2000)">
        Load Data
    </button>

    <x-loading-overlay x-bind:show="loading" />
</div>
```

---

## 🎨 Image Loading dengan Skeleton

Card components sudah memiliki built-in skeleton untuk image loading:

```blade
<div class="relative">
    {{-- Skeleton background (hilang saat image loaded) --}}
    <div data-skeleton class="absolute inset-0 rounded-xl bg-gradient-to-br from-gray-200 to-gray-100 animate-pulse"></div>

    {{-- Image --}}
    <img src="{{ $imageSrc }}"
        loading="lazy"
        onload="this.previousElementSibling?.classList.add('hidden')"
        onerror="this.src='{{ $placeholder }}'; this.previousElementSibling?.classList.add('hidden')">
</div>
```

**Cara Kerja:**

1. Skeleton muncul di background (absolute positioned)
2. Saat image selesai load → `onload` event → skeleton hidden
3. Jika image error → fallback ke placeholder SVG

---

## 🚀 Testing

### Test WhatsApp Bubble:

1. Buka halaman mana saja
2. Lihat pojok kanan bawah
3. Hover untuk melihat tooltip

### Test Image Placeholder:

1. Buat artikel tanpa featured image
2. Atau edit database: set `featured_image_url` ke URL yang tidak valid
3. Lihat card artikel → akan muncul placeholder SVG

### Test Loading State:

1. Klik link navigasi antar halaman
2. Akan muncul loading spinner sebelum halaman berpindah

### Test Skeleton Loader:

**Manual Test (tambahkan di controller):**

```php
// Di controller, contoh: HomeController
public function index()
{
    // Simulasi loading delay
    if (request()->has('skeleton-test')) {
        sleep(2); // Delay 2 detik
    }

    // ... existing code
}
```

**Di blade file:**

```blade
@if(request()->has('skeleton-test'))
    {{-- Simulasi loading --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @for($i = 0; $i < 8; $i++)
            <x-article-card-skeleton variant="standard" />
        @endfor
    </div>
@else
    {{-- Data asli --}}
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($articles as $article)
            <x-article-card :article="$article" variant="standard" />
        @endforeach
    </div>
@endif
```

Akses: `http://localhost/?skeleton-test=1`

---

## 📦 Files Modified/Created

### Modified:

1. ✅ `resources/views/components/whatsapp-bubble.blade.php` - Posisi pojok kanan bawah
2. ✅ `resources/views/layouts/app.blade.php` - Loading overlay integration
3. ✅ `resources/js/app.js` - Page loader Alpine component

### Created:

1. ✅ `resources/views/components/article-card-skeleton.blade.php` - Skeleton component
2. ✅ `resources/views/components/loading-overlay.blade.php` - Loading overlay component
3. ✅ `LOADING_FEATURES.md` - Dokumentasi ini

### Existing (Already good):

1. ✅ `public/images/article-placeholder.svg` - Placeholder image
2. ✅ `resources/views/components/article-card.blade.php` - Sudah ada image loading skeleton

---

## 💡 Tips & Best Practices

### 1. Image Optimization

-   Selalu upload featured image untuk artikel (wajib!)
-   Gunakan format WebP untuk performa lebih baik
-   Compress images sebelum upload

### 2. Skeleton Loading

-   Gunakan skeleton saat fetch data async (AJAX/Livewire)
-   Pastikan skeleton variant sesuai dengan card variant
-   Jumlah skeleton = expected number of items

### 3. Loading State

-   Page loader otomatis untuk navigasi normal
-   Untuk form submission, bisa tambahkan loading state manual
-   Disable button saat proses loading

---

## 🎯 Next Steps (Optional)

Jika ingin enhancement lebih lanjut:

1. **Lazy Loading Images:**

    ```blade
    <img loading="lazy" ...>
    ```

    (Sudah diterapkan di article-card)

2. **Livewire Integration:**

    ```blade
    <div wire:loading>
        <x-article-card-skeleton variant="standard" />
    </div>
    <div wire:loading.remove>
        <x-article-card :article="$article" variant="standard" />
    </div>
    ```

3. **Progressive Image Loading:**
    - BlurHash atau LQIP (Low Quality Image Placeholder)
    - Implementasi: https://github.com/spatie/laravel-blurred-image

---

## ✅ Checklist Completion

-   [x] WhatsApp bubble pojok kanan bawah & melayang
-   [x] Image placeholder/not-found dengan SVG
-   [x] Loading state untuk pages (global page loader)
-   [x] Skeleton loading untuk cards (semua variants)
-   [x] Documentation
-   [x] Assets compiled (npm run build)

**Status: SEMUA FITUR SELESAI! ✅**
