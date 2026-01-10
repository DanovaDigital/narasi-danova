<x-app-layout>
    <div class="bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Hero Carousel --}}
            @if (($trending ?? collect())->count() >= 3)
            <x-hero-carousel :articles="$trending->take(5)" />
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
            @endif

            {{-- Category Showcase --}}
            @if(($topCategories ?? collect())->count())
            <section class="mt-12">
                <div class="rounded-3xl bg-white p-8 shadow-sm ring-1 ring-gray-100">
                    <h2 class="text-2xl font-bold">Jelajahi Berdasarkan Kategori</h2>
                    <p class="mt-2 text-gray-600">Temukan berita sesuai minat Anda</p>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($topCategories->take(6) as $cat)
                        <a href="{{ route('category.show', $cat->slug) }}" class="group rounded-2xl bg-gray-50 p-5 ring-1 ring-gray-100 transition hover:bg-white">
                            <div class="flex items-center justify-between">
                                <div>
                                    <div class="text-lg font-bold">{{ $cat->name }}</div>
                                    <div class="mt-1 text-sm text-gray-600">{{ (int) $cat->articles_count }} artikel</div>
                                </div>
                                <svg class="h-6 w-6 transform transition group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        </div>
    </div>
</x-app-layout>