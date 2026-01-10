<x-app-layout>
    {{-- Category Hero Header --}}
    <div class="bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-600 text-white">
        <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
            <div class="flex items-center gap-2 text-sm">
                <a href="{{ route('home') }}" class="hover:underline">Beranda</a>
                <span>→</span>
                <span class="font-medium">Kategori</span>
            </div>
            <h1 class="mt-4 text-4xl font-bold md:text-5xl">{{ $category->name }}</h1>
            @if ($category->description)
            <p class="mt-3 text-lg text-purple-100">{{ $category->description }}</p>
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
                    <article class="mb-6 overflow-hidden rounded-lg bg-white shadow-lg">
                        <div class="aspect-video bg-gradient-to-br from-blue-500 to-purple-600"></div>
                        <div class="p-6">
                            <div class="flex items-center gap-3 text-xs text-gray-500">
                                <span class="rounded-full bg-indigo-100 px-3 py-1 font-semibold text-indigo-700">Featured</span>
                                <span>{{ optional($featured->published_at)->format('d M Y') }}</span>
                                <span>•</span>
                                <span>{{ number_format((int) $featured->views_count) }} views</span>
                            </div>
                            <h2 class="mt-3 text-2xl font-bold text-gray-900">
                                <a href="{{ route('articles.show', $featured->slug) }}" class="hover:text-indigo-600">{{ $featured->title }}</a>
                            </h2>
                            @if ($featured->excerpt)
                            <p class="mt-3 text-gray-700">{{ \Illuminate\Support\Str::limit($featured->excerpt, 200) }}</p>
                            @endif
                            <a href="{{ route('articles.show', $featured->slug) }}" class="mt-4 inline-flex items-center gap-2 font-semibold text-indigo-600 hover:underline">
                                Baca Selengkapnya
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </article>

                    {{-- Article Grid --}}
                    <div class="space-y-4">
                        @foreach($articles->skip(1) as $article)
                        <article class="group flex gap-4 rounded-lg bg-white p-4 shadow hover:shadow-md">
                            <div class="h-24 w-32 flex-shrink-0 overflow-hidden rounded-lg bg-gradient-to-br from-green-500 to-teal-600"></div>
                            <div class="flex-1">
                                <div class="text-xs text-gray-500">
                                    <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                                    <span class="mx-2">•</span>
                                    <span>{{ number_format((int) $article->views_count) }} views</span>
                                </div>
                                <h3 class="mt-2 text-base font-bold text-gray-900 group-hover:text-indigo-600">
                                    <a href="{{ route('articles.show', $article->slug) }}">{{ $article->title }}</a>
                                </h3>
                                @if ($article->excerpt)
                                <p class="mt-2 text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($article->excerpt, 120) }}</p>
                                @endif
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <div class="mt-6">
                        {{ $articles->links() }}
                    </div>
                    @else
                    <div class="rounded-lg bg-white p-12 text-center shadow">
                        <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <p class="mt-4 text-gray-600">Belum ada artikel untuk kategori ini.</p>
                        <a href="{{ route('home') }}" class="mt-4 inline-block rounded-lg bg-indigo-600 px-6 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
                            Kembali ke Beranda
                        </a>
                    </div>
                    @endif
                </div>

                {{-- Sidebar --}}
                <aside class="space-y-6">
                    {{-- Related Categories --}}
                    <section class="rounded-lg bg-white p-5 shadow">
                        <h3 class="text-sm font-bold uppercase tracking-wide text-gray-500">Kategori Lainnya</h3>
                        <div class="mt-4 space-y-2">
                            @foreach(\App\Models\Category::withCount(['articles' => fn($q) => $q->published()])->orderByDesc('articles_count')->limit(8)->get() as $cat)
                            <a href="{{ route('category.show', $cat->slug) }}"
                                class="group flex items-center justify-between rounded-lg px-3 py-2 hover:bg-gray-50 {{ $cat->id === $category->id ? 'bg-indigo-50' : '' }}">
                                <span class="text-sm font-medium {{ $cat->id === $category->id ? 'text-indigo-600' : 'text-gray-900 group-hover:text-indigo-600' }}">
                                    {{ $cat->name }}
                                </span>
                                <span class="rounded-full bg-gray-100 px-2 py-0.5 text-xs font-bold text-gray-600">
                                    {{ $cat->articles_count }}
                                </span>
                            </a>
                            @endforeach
                        </div>
                    </section>

                    {{-- Newsletter --}}
                    <section class="rounded-lg bg-gradient-to-br from-indigo-600 to-purple-600 p-6 text-white shadow-lg">
                        <svg class="h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-3 text-lg font-bold">Newsletter</h3>
                        <p class="mt-1 text-sm text-indigo-100">Dapatkan update {{ $category->name }} terbaru</p>
                        <div class="mt-4">
                            <x-newsletter-form />
                        </div>
                    </section>

                    {{-- Ad Space --}}
                    <section class="rounded-lg border-2 border-dashed border-gray-300 bg-gray-50 p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <p class="mt-2 text-xs font-medium text-gray-500">Ruang Iklan</p>
                    </section>
                </aside>
            </div>
        </div>
    </div>
</x-app-layout>