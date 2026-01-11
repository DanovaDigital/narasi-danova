<x-app-layout>
    @push('title')
    {{ \App\Models\SiteSetting::getValue('site_name', config('app.name')) }}
    @endpush

    @push('seo')
    <x-seo-default />
    <x-seo-breadcrumbs :items="[[
        'name' => 'Beranda',
        'url' => route('home'),
    ]]" />
    @endpush

    <div class="bg-paper">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 sm:py-8">

            {{-- Must Read Section (Bento Grid) --}}
            @if(($mustRead ?? collect())->count() >= 3)
            <section class="mb-10 md:mb-14">

                <div class="grid gap-4 lg:grid-cols-2">
                    {{-- Large Card Left --}}
                    <x-article-card :article="$mustRead->first()" variant="overlay" class="lg:row-span-2 h-[400px] lg:h-auto" />

                    {{-- Two Smaller Cards Right --}}
                    <div class="grid gap-4">
                        @foreach($mustRead->slice(1, 2) as $article)
                        <x-article-card :article="$article" variant="overlay" class="h-[180px] sm:h-[200px]" />
                        @endforeach
                    </div>
                </div>

                {{-- Additional Must Read Cards --}}
                @if($mustRead->count() > 3)
                <div class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($mustRead->slice(3) as $article)
                    <x-article-card :article="$article" variant="horizontal" />
                    @endforeach
                </div>
                @endif
            </section>
            @endif

            {{-- Story Categories (Horizontal Scroll) --}}
            @if(($topCategories ?? collect())->count())
            <section class="mb-10 md:mb-14">
                <x-section-header
                    title="Kategori"
                    subtitle="Jelajahi berdasarkan topik" />

                <div class="flex gap-4 sm:gap-6 overflow-x-auto pb-4 scrollbar-hide -mx-4 px-4 sm:-mx-0 sm:px-0">
                    @foreach($topCategories as $cat)
                    <x-story-circle :category="$cat" />
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Trending Section --}}
            @if(($trending ?? collect())->count())
            <section class="mb-10 md:mb-14">
                <x-section-header
                    title="Trending 🔥"
                    subtitle="Berita yang sedang hangat" />

                <div class="grid gap-6 lg:grid-cols-3">
                    {{-- Main Trending Card --}}
                    @php $mainTrending = $trending->first(); @endphp
                    <div class="lg:col-span-2">
                        <x-article-card :article="$mainTrending" variant="overlay" class="h-[350px] sm:h-[400px]" />
                    </div>

                    {{-- Trending List --}}
                    <div class="space-y-4 bg-white rounded-2xl p-5 shadow-soft">
                        <h4 class="font-serif font-bold text-dark text-lg border-b border-gray-100 pb-3">Top Stories</h4>
                        @foreach($trending->slice(1, 5) as $index => $article)
                        <div class="flex gap-4 items-start {{ !$loop->last ? 'border-b border-gray-50 pb-4' : '' }}">
                            <span class="text-2xl font-display font-bold text-brand-200">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                            <div class="flex-1 min-w-0">
                                <h5 class="font-serif font-bold text-sm text-dark leading-snug line-clamp-2 hover:text-brand-600 transition-colors">
                                    <a href="{{ route('articles.show', $article->slug) }}">
                                        {{ $article->title }}
                                    </a>
                                </h5>
                                <p class="text-xs text-gray-400 mt-1">
                                    {{ $article->published_at?->diffForHumans() }}
                                </p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            {{-- Hero Featured Article --}}
            @if(($featured ?? collect())->count())
            <section class="mb-10 md:mb-14">
                <x-section-header
                    title="Pilihan Editor"
                    subtitle="Artikel pilihan dari tim redaksi"
                    :link="route('articles.index')" />

                @php $heroArticle = $featured->first(); @endphp
                <x-article-card :article="$heroArticle" variant="featured" :show-author="true" />
            </section>
            @endif

            {{-- Latest News Grid --}}
            @if(($latest ?? collect())->count())
            <section class="mb-10 md:mb-14">
                <x-section-header
                    title="Berita Terbaru"
                    subtitle="Update berita terkini"
                    :link="route('articles.index')" />

                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach($latest->take(8) as $article)
                    <x-article-card :article="$article" variant="standard" :show-excerpt="false" />
                    @endforeach
                </div>
            </section>
            @endif



            {{-- Top Creators Section --}}
            @if(($topCreators ?? collect())->count())
            <section class="mb-10 md:mb-14">
                <x-section-header
                    title="Penulis Teratas"
                    subtitle="Kreator konten terbaik kami" />

                <div class="bg-white rounded-2xl p-6 sm:p-8 shadow-soft">
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-6 sm:gap-8">
                        @foreach($topCreators as $author)
                        <x-creator-avatar :author="$author" />
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            {{-- Newsletter CTA --}}
            <section class="mb-10 md:mb-14">
                <div class="bg-gradient-to-br from-dark to-gray-800 rounded-2xl md:rounded-3xl p-8 sm:p-10 md:p-12 text-center text-white overflow-hidden relative">
                    {{-- Background Pattern --}}
                    <div class="absolute inset-0 opacity-5">
                        <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                            <pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse">
                                <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5" />
                            </pattern>
                            <rect width="100%" height="100%" fill="url(#grid)" />
                        </svg>
                    </div>

                    <div class="relative z-10 max-w-2xl mx-auto">
                        <h2 class="font-display text-2xl sm:text-3xl md:text-4xl font-bold mb-4">
                            Dapatkan berita terbaru 📬
                        </h2>
                        <p class="text-gray-300 mb-6 sm:mb-8 text-sm sm:text-base">
                            Subscribe newsletter kami dan dapatkan update berita langsung di inbox Anda.
                        </p>

                        <div class="max-w-md mx-auto">
                            <x-newsletter-form />
                        </div>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>