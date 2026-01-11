<x-app-layout>
    @push('title')
    Pencarian Artikel | {{ \App\Models\SiteSetting::getValue('site_name', config('app.name')) }}
    @endpush

    @push('seo')
    <x-seo-default
        title="Pencarian Artikel | {{ \App\Models\SiteSetting::getValue('site_name', config('app.name')) }}"
        description="Cari artikel berdasarkan judul, ringkasan, atau isi."
        :canonical="route('search')"
        robots="noindex, follow" />
    <x-seo-breadcrumbs :items="[
        ['name' => 'Beranda', 'url' => route('home')],
        ['name' => 'Pencarian', 'url' => route('search')],
    ]" />
    @endpush

    <div class="border-b border-gray-100 bg-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <h1 class="font-display text-4xl font-bold text-dark">Pencarian Artikel</h1>
            <p class="mt-3 text-lg text-gray-600">Temukan artikel berdasarkan judul, ringkasan, atau isi</p>

            <form method="GET" action="{{ route('search') }}" class="mt-8 flex w-full max-w-2xl gap-3">
                <label for="q" class="sr-only">Pencarian</label>
                <input
                    id="q"
                    name="q"
                    value="{{ $q }}"
                    placeholder="Ketik kata kunci..."
                    class="flex-1 rounded-xl border border-gray-200 bg-gray-50 px-5 py-3.5 text-gray-900 shadow-sm transition-all duration-200 placeholder:text-gray-400 focus:border-brand-500 focus:bg-white focus:ring-2 focus:ring-brand-500/20" />
                <button type="submit" class="cursor-pointer rounded-xl bg-brand-600 px-6 py-3.5 font-semibold text-white shadow-sm transition-all duration-200 hover:bg-brand-700 hover:shadow-md">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="bg-paper py-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(trim($q) !== '')
            <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
                <div class="text-gray-600">
                    Ditemukan <span class="font-semibold text-dark">{{ $results->total() }}</span> hasil untuk:
                    <span class="font-semibold text-brand-600">"{{ $q }}"</span>
                </div>

                <div class="flex flex-wrap gap-3">
                    {{-- Category Filter --}}
                    <select
                        onchange="window.location.href=this.value"
                        class="cursor-pointer rounded-xl border-gray-200 bg-white px-4 py-2.5 text-sm shadow-soft transition-all duration-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20">
                        <option value="{{ route('search', ['q' => $q, 'sort' => $selectedSort]) }}">Semua Kategori</option>
                        @foreach($categories as $cat)
                        <option
                            value="{{ route('search', ['q' => $q, 'category' => $cat->slug, 'sort' => $selectedSort]) }}"
                            {{ $selectedCategory === $cat->slug ? 'selected' : '' }}>
                            {{ $cat->name }} ({{ $cat->articles_count }})
                        </option>
                        @endforeach
                    </select>

                    {{-- Sort Options --}}
                    <select
                        onchange="window.location.href=this.value"
                        class="cursor-pointer rounded-xl border-gray-200 bg-white px-4 py-2.5 text-sm shadow-soft transition-all duration-200 focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20">
                        <option value="{{ route('search', ['q' => $q, 'category' => $selectedCategory, 'sort' => 'date']) }}" {{ $selectedSort === 'date' ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ route('search', ['q' => $q, 'category' => $selectedCategory, 'sort' => 'relevance']) }}" {{ $selectedSort === 'relevance' ? 'selected' : '' }}>Relevansi</option>
                        <option value="{{ route('search', ['q' => $q, 'category' => $selectedCategory, 'sort' => 'views']) }}" {{ $selectedSort === 'views' ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                </div>
            </div>

            @if($results->count())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($results as $article)
                <x-article-card :article="$article" variant="standard" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $results->links() }}
            </div>
            @else
            <div class="flex items-center justify-center rounded-2xl bg-white p-16 shadow-soft">
                <div class="text-center">
                    <svg class="mx-auto h-20 w-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="mt-6 font-display text-xl font-semibold text-dark">Tidak Ada Hasil</h3>
                    <p class="mt-2 text-gray-500">Tidak ada hasil yang cocok dengan pencarian Anda</p>
                    <p class="mt-1 text-sm text-gray-400">Coba gunakan kata kunci yang berbeda atau hapus filter</p>
                    <a href="{{ route('search') }}" class="mt-6 inline-flex cursor-pointer items-center gap-2 rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-brand-700 hover:shadow-md">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Hapus Pencarian
                    </a>
                </div>
            </div>
            @endif
            @else
            <div class="flex items-center justify-center rounded-2xl bg-white p-16 shadow-soft">
                <div class="text-center">
                    <div class="mx-auto flex h-20 w-20 items-center justify-center rounded-full bg-brand-50">
                        <svg class="h-10 w-10 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <h3 class="mt-6 font-display text-xl font-semibold text-dark">Mulai Pencarian</h3>
                    <p class="mt-2 text-gray-500">Masukkan kata kunci untuk mulai mencari artikel</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>