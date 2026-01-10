<x-app-layout>
    {{-- Category Hero Header --}}
    <div class="bg-gradient-to-r from-primary-600 to-primary-700 text-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="cursor-pointer transition-colors duration-200 ease-in hover:underline">Beranda</a>
                <span>→</span>
                <span class="font-medium">Kategori</span>
            </div>
            <h1 class="mt-4 text-4xl font-bold md:text-5xl">{{ $category->name }}</h1>
            @if ($category->description)
            <p class="mt-3 text-lg text-primary-100">{{ $category->description }}</p>
            @endif
            <div class="mt-6 flex items-center gap-4 text-sm">
                <div class="flex items-center gap-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span>{{ $articles->total() }} artikel</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid gap-6 lg:grid-cols-3">
                {{-- Main Content --}}
                <div class="lg:col-span-2">
                    @if($articles->count())
                    {{-- Featured Article --}}
                    @php $featured = $articles->first(); @endphp
                    <article class="group mb-6 overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100 transition-all duration-200 ease-in hover:shadow-md">
                        @if($featured->featured_image)
                        <div class="aspect-video overflow-hidden">
                            <img src="{{ $featured->featured_image }}" alt="{{ $featured->title }}" class="h-full w-full object-cover transition-transform duration-300 ease-in group-hover:scale-110" loading="lazy">
                        </div>
                        @else
                        <div class="aspect-video bg-gradient-to-br from-gray-200 to-gray-100"></div>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span class="rounded-lg bg-primary-100 px-3 py-1 font-semibold text-primary-700 ring-1 ring-primary-200">Unggulan</span>
                                <span>{{ optional($featured->published_at)->format('d M Y') }}</span>
                                @if(!empty($featured->read_time_minutes))
                                <span>•</span>
                                <span>{{ (int) $featured->read_time_minutes }} menit</span>
                                @endif
                            </div>
                            <h2 class="mt-3 text-2xl font-bold text-gray-900">
                                <a href="{{ route('articles.show', $featured->slug) }}" class="cursor-pointer transition-colors duration-200 ease-in hover:text-primary-600">{{ $featured->title }}</a>
                            </h2>
                            @if ($featured->excerpt)
                            <p class="mt-3 text-gray-700">{{ \Illuminate\Support\Str::limit($featured->excerpt, 200) }}</p>
                            @endif
                            <a href="{{ route('articles.show', $featured->slug) }}" class="group mt-4 inline-flex cursor-pointer items-center gap-2 font-semibold text-primary-600 transition-colors duration-200 ease-in hover:text-primary-700">
                                Baca Selengkapnya
                                <svg class="h-4 w-4 transition-transform duration-200 ease-in group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article Grid --}}
                    <div class="space-y-4">
                        @foreach($articles->skip(1) as $article)
                        <x-news-card :article="$article" layout="horizontal" />
                        @endforeach
                    </div>

                    @if($articles->hasPages())
                    <div class="mt-6">
                        {{ $articles->links() }}
                    </div>
                    @endif
                    @else
                    <div class="flex items-center justify-center rounded-xl bg-white p-16 shadow-sm ring-1 ring-gray-100">
                        <div class="text-center">
                            <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Artikel</h3>
                            <p class="mt-2 text-sm text-gray-500">Belum ada artikel untuk kategori ini</p>
                            <a href="{{ route('home') }}" class="mt-6 inline-flex cursor-pointer items-center gap-2 rounded-lg bg-primary-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in hover:scale-105 hover:bg-primary-700 hover:shadow-md">
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
                    <section class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">Kategori Lainnya</h3>
                        <div class="mt-4 space-y-2">
                            @foreach($relatedCategories as $cat)
                            <a href="{{ route('category.show', $cat->slug) }}" class="group flex cursor-pointer items-center justify-between rounded-lg p-3 transition-all duration-200 ease-in hover:bg-gray-50">
                                <span class="text-sm font-medium text-gray-700 transition-colors duration-200 ease-in group-hover:text-primary-600">{{ $cat->name }}</span>
                                <span class="text-xs text-gray-500">{{ $cat->articles_count ?? 0 }}</span>
                            </a>
                            @endforeach
                        </div>
                    </section>
                    @endif

                    {{-- Popular Articles --}}
                    @if(($popularArticles ?? collect())->count())
                    <section class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-700">Artikel Populer</h3>
                        <div class="mt-4 space-y-4">
                            @foreach($popularArticles as $popular)
                            <article class="group">
                                <a href="{{ route('articles.show', $popular->slug) }}" class="cursor-pointer text-sm font-bold text-gray-900 transition-colors duration-200 ease-in hover:text-primary-600">
                                    {{ \Illuminate\Support\Str::limit($popular->title, 60) }}
                                </a>
                                <div class="mt-1 text-xs text-gray-500">
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