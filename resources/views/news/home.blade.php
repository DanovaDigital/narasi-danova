<x-app-layout>
    <div class="bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Hero Carousel --}}
            @if (($trending ?? collect())->count() >= 3)
            <x-hero-carousel :articles="$trending->take(5)" />
            @else
            <div class="flex items-center justify-center rounded-xl bg-white p-12 shadow-sm ring-1 ring-gray-100">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Artikel Unggulan</h3>
                    <p class="mt-2 text-sm text-gray-500">Artikel trending akan muncul di sini</p>
                </div>
            </div>
            @endif

            {{-- Editor's Pick Section --}}
            @if(($featured ?? collect())->count())
            <section class="mt-12">
                <x-section-header
                    title="Pilihan Editor"
                    subtitle="Artikel pilihan dari tim redaksi"
                    :link="route('articles.index')"
                    link-text="Lihat Semua" />

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($featured->take(4) as $article)
                    <x-news-card :article="$article" />
                    @endforeach
                </div>
            </section>
            @else
            <section class="mt-12">
                <x-section-header
                    title="Pilihan Editor"
                    subtitle="Artikel pilihan dari tim redaksi" />

                <div class="mt-6 flex items-center justify-center rounded-xl bg-white p-12 shadow-sm ring-1 ring-gray-100">
                    <div class="text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <p class="mt-4 text-sm text-gray-500">Belum ada artikel pilihan editor</p>
                    </div>
                </div>
            </section>
            @endif

            {{-- Latest Articles --}}
            @if(($latest ?? collect())->count())
            <section class="mt-12">
                <x-section-header
                    title="Berita Terbaru"
                    subtitle="Update berita terkini dari berbagai kategori"
                    :link="route('articles.index')"
                    link-text="Lihat Semua" />

                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($latest->take(6) as $article)
                    <x-news-card :article="$article" />
                    @endforeach
                </div>
            </section>
            @else
            <section class="mt-12">
                <x-section-header
                    title="Berita Terbaru"
                    subtitle="Update berita terkini dari berbagai kategori" />

                <div class="mt-6 flex items-center justify-center rounded-xl bg-white p-16 shadow-sm ring-1 ring-gray-100">
                    <div class="text-center">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Artikel</h3>
                        <p class="mt-2 text-sm text-gray-500">Artikel terbaru akan ditampilkan di sini</p>
                    </div>
                </div>
            </section>
            @endif

            {{-- Category Showcase --}}
            @if(($topCategories ?? collect())->count())
            <section class="mt-12">
                <div class="rounded-xl bg-white p-8 shadow-sm ring-1 ring-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900">Jelajahi Berdasarkan Kategori</h2>
                    <p class="mt-2 text-gray-600">Temukan berita sesuai minat Anda</p>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($topCategories->take(6) as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="group cursor-pointer rounded-lg bg-gray-50 p-5 ring-1 ring-gray-100 transition-all duration-200 ease-in hover:scale-[1.02] hover:bg-white hover:shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-lg font-bold text-gray-900">{{ $cat->name }}</div>
                                    <div class="mt-1 text-sm text-gray-600">{{ (int) $cat->articles_count }} artikel</div>
                                </div>
                                <svg class="h-6 w-6 text-primary-600 transition-transform duration-200 ease-in group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>
            @else
            <section class="mt-12">
                <div class="rounded-xl bg-white p-8 shadow-sm ring-1 ring-gray-100">
                    <h2 class="text-2xl font-bold text-gray-900">Jelajahi Berdasarkan Kategori</h2>
                    <p class="mt-2 text-gray-600">Temukan berita sesuai minat Anda</p>

                    <div class="mt-6 flex items-center justify-center p-12">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <p class="mt-4 text-sm text-gray-500">Belum ada kategori tersedia</p>
                        </div>
                    </div>
                </div>
            </section>
            @endif
        </div>
    </div>
</x-app-layout>