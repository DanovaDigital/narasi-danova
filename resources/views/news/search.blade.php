<x-app-layout>
    <div class="border-b bg-white">
        <div class="mx-auto max-w-7xl px-4 py-10 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold text-gray-900">Pencarian Artikel</h1>
            <p class="mt-2 text-gray-600">Temukan artikel berdasarkan judul, ringkasan, atau isi</p>

            <form method="GET" action="{{ route('search') }}" class="mt-6 flex w-full max-w-2xl gap-2">
                <label for="q" class="sr-only">Pencarian</label>
                <input
                    id="q"
                    name="q"
                    value="{{ $q }}"
                    placeholder="Ketik kata kunci..."
                    class="flex-1 rounded-lg border border-gray-300 bg-white px-4 py-3 text-gray-900 shadow-sm transition-all duration-200 ease-in focus:border-primary-500 focus:ring-1 focus:ring-primary-500" />
                <button type="submit" class="cursor-pointer rounded-lg bg-primary-600 px-6 py-3 font-semibold text-white shadow-sm transition-all duration-200 ease-in hover:scale-105 hover:bg-primary-700 hover:shadow-md">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </button>
            </form>
        </div>
    </div>

    <div class="bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(trim($q) !== '')
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <div class="text-sm text-gray-600">
                    Ditemukan <span class="font-bold text-gray-900">{{ $results->total() }}</span> hasil untuk:
                    <span class="font-semibold text-gray-900">"{{ $q }}"</span>
                </div>

                <div class="flex flex-wrap gap-3">
                    {{-- Category Filter --}}
                    <select
                        onchange="window.location.href=this.value"
                        class="cursor-pointer rounded-lg border-gray-300 bg-white text-sm shadow-sm transition-all duration-200 ease-in focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
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
                        class="cursor-pointer rounded-lg border-gray-300 bg-white text-sm shadow-sm transition-all duration-200 ease-in focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                        <option value="{{ route('search', ['q' => $q, 'category' => $selectedCategory, 'sort' => 'date']) }}" {{ $selectedSort === 'date' ? 'selected' : '' }}>Terbaru</option>
                        <option value="{{ route('search', ['q' => $q, 'category' => $selectedCategory, 'sort' => 'relevance']) }}" {{ $selectedSort === 'relevance' ? 'selected' : '' }}>Relevansi</option>
                        <option value="{{ route('search', ['q' => $q, 'category' => $selectedCategory, 'sort' => 'views']) }}" {{ $selectedSort === 'views' ? 'selected' : '' }}>Terpopuler</option>
                    </select>
                </div>
            </div>

            @if($results->count())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($results as $article)
                <x-news-card :article="$article" />
                @endforeach
            </div>

            <div class="mt-8">
                {{ $results->links() }}
            </div>
            @else
            <div class="flex items-center justify-center rounded-xl bg-white p-16 shadow-sm ring-1 ring-gray-100">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Tidak Ada Hasil</h3>
                    <p class="mt-2 text-sm text-gray-500">Tidak ada hasil yang cocok dengan pencarian Anda</p>
                    <p class="mt-1 text-sm text-gray-500">Coba gunakan kata kunci yang berbeda atau hapus filter</p>
                    <a href="{{ route('search') }}" class="mt-6 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-primary-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in hover:scale-105 hover:bg-primary-700 hover:shadow-md">
                        Hapus Pencarian
                    </a>
                </div>
            </div>
            @endif
            @else
            <div class="flex items-center justify-center rounded-xl bg-white p-16 shadow-sm ring-1 ring-gray-100">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Mulai Pencarian</h3>
                    <p class="mt-2 text-sm text-gray-500">Masukkan kata kunci untuk mulai mencari artikel</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>