<x-app-layout>
    {{-- Category Hero Header --}}
    <div class="bg-dark text-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:py-16 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm text-gray-400">
                <a href="{{ route('home') }}" class="cursor-pointer transition-colors duration-200 ease-in hover:text-white hover:underline">Beranda</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
                <span class="font-medium text-white">Kategori</span>
            </div>
            <h1 class="mt-4 font-display text-4xl font-bold md:text-5xl">{{ $category->name }}</h1>
            @if ($category->description)
            <p class="mt-3 text-lg text-gray-300 max-w-2xl">{{ $category->description }}</p>
            @endif
            <div class="mt-6 flex items-center gap-4 text-sm">
                <div class="flex items-center gap-2 bg-white/10 rounded-full px-4 py-2">
                    <svg class="h-4 w-4 text-brand-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>{{ $articles->total() }} artikel</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-paper py-8 sm:py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-8 lg:grid-cols-3">
                {{-- Main Content --}}
                <div class="lg:col-span-2">
                    @if($articles->count())
                    {{-- Featured Article --}}
                    @php $featured = $articles->first(); @endphp
                    <article class="group mb-8 overflow-hidden rounded-2xl bg-white shadow-soft transition-all duration-200 ease-in hover:shadow-hover">
                        <a href="{{ route('articles.show', $featured->slug) }}" class="block">
                            @if($featured->featured_image_url)
                            <div class="aspect-video overflow-hidden">
                                <img src="{{ $featured->featured_image_url }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition-transform duration-500 ease-in group-hover:scale-105" loading="lazy">
                            </div>
                            @else
                            <div class="aspect-video bg-gradient-to-br from-gray-200 to-gray-100"></div>
                            @endif
                        </a>
                        <div class="p-6 sm:p-8">
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span class="rounded-full bg-brand-50 px-3 py-1 font-bold text-brand-600 uppercase tracking-wide">Unggulan</span>
                                <span>{{ optional($featured->published_at)->format('d M Y') }}</span>
                                @if(!empty($featured->read_time_minutes))
                                <span>•</span>
                                <span>{{ (int) $featured->read_time_minutes }} menit</span>
                                @endif
                            </div>
                            <h2 class="mt-4 font-serif text-2xl font-bold text-dark sm:text-3xl">
                                <a href="{{ route('articles.show', $featured->slug) }}" class="cursor-pointer transition-colors duration-200 ease-in hover:text-brand-600">{{ $featured->title }}</a>
                            </h2>
                            @if ($featured->excerpt)
                            <p class="mt-3 text-gray-500 leading-relaxed font-sans">{{ \Illuminate\Support\Str::limit($featured->excerpt, 200) }}</p>
                            @endif
                            <a href="{{ route('articles.show', $featured->slug) }}" class="group/link mt-5 inline-flex cursor-pointer items-center gap-2 font-bold text-brand-600 transition-colors duration-200 ease-in hover:text-brand-700">
                                Baca Selengkapnya
                                <svg class="h-4 w-4 transition-transform duration-200 ease-in group-hover/link:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article Grid --}}
                    <div class="space-y-4">
                        @foreach($articles->skip(1) as $article)
                        <x-article-card :article="$article" variant="horizontal" />
                        @endforeach
                    </div>

                    @if($articles->hasPages())
                    <div class="mt-8">
                        {{ $articles->links() }}
                    </div>
                    @endif
                    @else
                    <div class="flex items-center justify-center rounded-2xl bg-white p-16 shadow-soft">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 font-serif text-lg font-bold text-dark">Belum Ada Artikel</h3>
                            <p class="mt-2 text-sm text-gray-500">Belum ada artikel untuk kategori ini</p>
                            <a href="{{ route('home') }}" class="mt-6 inline-flex cursor-pointer items-center gap-2 rounded-xl bg-dark px-6 py-3 text-sm font-bold text-white shadow-sm transition-all duration-200 ease-in hover:bg-gray-800 hover:shadow-md">
                                Kembali ke Beranda
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6">
                    {{-- Related Categories --}}
                    @if(($relatedCategories ?? collect())->count())
                    <section class="rounded-2xl bg-white p-6 shadow-soft">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Kategori Lainnya</h3>
                        <div class="space-y-2">
                            @foreach($relatedCategories as $cat)
                            <a href="{{ route('category.show', $cat->slug) }}" class="group flex cursor-pointer items-center justify-between rounded-xl p-3 transition-all duration-200 ease-in hover:bg-gray-50">
                                <span class="text-sm font-medium text-gray-700 font-sans transition-colors duration-200 ease-in group-hover:text-brand-600">{{ $cat->name }}</span>
                                <span class="text-xs text-gray-400 bg-gray-100 px-2 py-0.5 rounded-full">{{ $cat->articles_count ?? 0 }}</span>
                            </a>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Popular Articles --}}
                    @if(($popularArticles ?? collect())->count())
                    <section class="rounded-2xl bg-white p-6 shadow-soft">
                        <h3 class="text-sm font-bold uppercase tracking-wider text-gray-400 mb-4">Artikel Populer</h3>
                        <div class="space-y-4">
                            @foreach($popularArticles as $popular)
                            <article class="group">
                                <a href="{{ route('articles.show', $popular->slug) }}" class="cursor-pointer font-serif text-sm font-bold text-dark transition-colors duration-200 ease-in hover:text-brand-600 leading-snug">
                                    {{ \Illuminate\Support\Str::limit($popular->title, 60) }}
                                </a>
                                <div class="mt-1 text-xs text-gray-400">
                                    {{ number_format((int) $popular->views_count) }} views
                                </div>
                            </article>
                            @endforeach
                        </div>
                    </section>
                    @endif
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>