<x-app-layout>
    @push('head')
    <x-seo-meta :article="$article" />
    @endpush

    <div x-data="readingProgress" x-init="init">
        {{-- Reading Progress Bar --}}
        <div class="reading-progress" aria-hidden="true" :style="`width: ${progress}%`"></div>

        @php
        $url = route('articles.show', $article->slug);
        $shareText = $article->title;
        $waUrl = 'https://wa.me/?text=' . urlencode($shareText . ' ' . $url);
        $xUrl = 'https://twitter.com/intent/tweet?text=' . urlencode($shareText) . '&url=' . urlencode($url);
        $fbUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url);
        @endphp

        <article x-ref="article" class="bg-paper">
            {{-- Article Header (Centered Layout) --}}
            <header class="border-b border-gray-100 bg-white">
                <div class="mx-auto max-w-4xl px-4 py-10 sm:py-14 md:py-20 text-center">
                    {{-- Category & Meta --}}
                    <div class="flex flex-wrap items-center justify-center gap-3 text-sm mb-6">
                        @if($article->category)
                        <a href="{{ route('category.show', $article->category->slug) }}"
                            class="inline-flex items-center rounded-full bg-brand-50 px-4 py-1.5 font-bold uppercase tracking-wider text-brand-600 text-xs hover:bg-brand-100 transition-colors">
                            {{ $article->category->name }}
                        </a>
                        @endif
                        <span class="text-gray-400">•</span>
                        <time class="text-gray-500" datetime="{{ $article->published_at?->toIso8601String() }}">
                            {{ $article->published_at?->format('d M Y') }}
                        </time>
                        <span class="text-gray-400">•</span>
                        <span class="text-gray-500">{{ number_format((int) $article->views_count) }} views</span>
                    </div>

                    {{-- Title --}}
                    <h1 class="font-display text-3xl sm:text-4xl md:text-5xl lg:text-6xl font-bold text-dark leading-tight mb-6 animate-fade-in-up">
                        {{ $article->title }}
                    </h1>

                    {{-- Excerpt --}}
                    @if ($article->excerpt)
                    <p class="text-lg sm:text-xl text-gray-500 leading-relaxed max-w-3xl mx-auto font-sans mb-8">
                        {{ $article->excerpt }}
                    </p>
                    @endif

                    {{-- Author Byline --}}
                    @if($article->author)
                    <div class="flex items-center justify-center gap-4">
                        @if($article->author->avatar_url)
                        <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}"
                            class="w-12 h-12 rounded-full object-cover border-2 border-white shadow-md">
                        @else
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center border-2 border-white shadow-md">
                            <span class="text-brand-700 font-display font-bold">
                                {{ collect(explode(' ', $article->author->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
                            </span>
                        </div>
                        @endif
                        <div class="text-left">
                            <a href="{{ route('author.show', $article->author->slug) }}" class="font-serif font-bold text-dark hover:text-brand-600 transition-colors">
                                {{ $article->author->name }}
                            </a>
                            @if(!empty($article->read_time_minutes))
                            <p class="text-sm text-gray-400">{{ (int) $article->read_time_minutes }} min read</p>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Tags --}}
                    @if ($article->tags->count())
                    <div class="mt-8 flex flex-wrap items-center justify-center gap-2">
                        @foreach ($article->tags as $tag)
                        <span class="rounded-full bg-gray-100 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-200 transition-colors">
                            #{{ $tag->name }}
                        </span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </header>

            {{-- Featured Image --}}
            @if($article->featured_image_url)
            <div class="w-full bg-gray-100">
                <div class="mx-auto max-w-5xl">
                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}"
                        class="w-full h-auto max-h-[500px] object-cover">
                </div>
            </div>
            @endif

            {{-- Article Content with Sticky Sidebar --}}
            <div class="py-10 sm:py-14 md:py-20">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="grid lg:grid-cols-12 gap-8 lg:gap-12">

                        {{-- Sticky Share Sidebar (Desktop) --}}
                        <aside class="hidden lg:block lg:col-span-1">
                            <div class="sticky top-24 space-y-4">
                                <p class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4">Share</p>

                                <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-green-500 text-white hover:bg-green-600 transition-all shadow-soft active:scale-95">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                    </svg>
                                </a>

                                <a href="{{ $xUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-black text-white hover:bg-gray-800 transition-all shadow-soft active:scale-95">
                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                    </svg>
                                </a>

                                <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer"
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white hover:bg-blue-700 transition-all shadow-soft active:scale-95">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </a>

                                <button type="button" onclick="navigator.clipboard.writeText('{{ $url }}').then(() => alert('Link berhasil disalin!'))"
                                    class="flex items-center justify-center w-10 h-10 rounded-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition-all shadow-soft active:scale-95">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                    </svg>
                                </button>
                            </div>
                        </aside>

                        {{-- Main Content --}}
                        <div class="lg:col-span-7">
                            <div class="bg-white rounded-2xl md:rounded-3xl p-6 sm:p-8 md:p-12 shadow-soft">
                                {{-- Back Link --}}
                                <a href="{{ route('articles.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-brand-600 hover:text-brand-700 transition-colors mb-8">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                    </svg>
                                    Kembali ke daftar artikel
                                </a>

                                {{-- Article Content with Typography Plugin --}}
                                <div class="prose prose-lg prose-red max-w-none font-serif dropcap
                                prose-headings:font-display prose-headings:text-dark
                                prose-p:text-gray-700 prose-p:leading-relaxed
                                prose-a:text-brand-600 prose-a:no-underline hover:prose-a:underline
                                prose-img:rounded-xl prose-img:shadow-soft
                                prose-blockquote:border-brand-500 prose-blockquote:bg-gray-50 prose-blockquote:rounded-r-xl prose-blockquote:py-2
                                prose-code:text-brand-600 prose-code:bg-brand-50 prose-code:px-1 prose-code:rounded">
                                    {!! nl2br(e($article->content)) !!}
                                </div>

                                {{-- Mobile Share Buttons --}}
                                <div class="mt-10 pt-8 border-t border-gray-100 lg:hidden">
                                    <p class="text-sm font-bold text-gray-500 mb-4">Bagikan artikel ini:</p>
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 rounded-xl bg-green-500 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-600 transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
                                            </svg>
                                            WhatsApp
                                        </a>
                                        <a href="{{ $xUrl }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 rounded-xl bg-black px-4 py-2.5 text-sm font-semibold text-white hover:bg-gray-800 transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                                            </svg>
                                            X / Twitter
                                        </a>
                                        <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer"
                                            class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-700 transition-colors">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                            </svg>
                                            Facebook
                                        </a>
                                        <button type="button" onclick="navigator.clipboard.writeText('{{ $url }}').then(() => alert('Link berhasil disalin!'))"
                                            class="inline-flex items-center gap-2 rounded-xl bg-gray-100 px-4 py-2.5 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition-colors">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3" />
                                            </svg>
                                            Copy Link
                                        </button>
                                    </div>
                                </div>
                            </div>

                            {{-- Related Articles --}}
                            @if (($related ?? collect())->count())
                            <div class="mt-12 md:mt-16">
                                <x-section-header title="Artikel Terkait" subtitle="Baca juga artikel lainnya yang mungkin Anda suka" />
                                <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                                    @foreach ($related as $ra)
                                    <x-article-card :article="$ra" variant="standard" :show-excerpt="false" />
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        {{-- Sidebar --}}
                        <aside class="lg:col-span-4 space-y-6">
                            {{-- Newsletter Card --}}
                            <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-10 h-10 rounded-xl bg-brand-50 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="font-serif font-bold text-dark text-lg">Newsletter</h3>
                                </div>
                                <p class="text-sm text-gray-500 mb-4">Subscribe untuk dapat update artikel terbaru langsung di inbox Anda.</p>
                                <x-newsletter-form />
                            </div>

                            {{-- Author Card (if exists) --}}
                            @if($article->author)
                            <div class="bg-white rounded-2xl p-6 shadow-soft border border-gray-100">
                                <h3 class="font-serif font-bold text-dark text-lg mb-4">Tentang Penulis</h3>
                                <div class="flex items-start gap-4">
                                    @if($article->author->avatar_url)
                                    <img src="{{ $article->author->avatar_url }}" alt="{{ $article->author->name }}"
                                        class="w-16 h-16 rounded-full object-cover border-2 border-gray-100">
                                    @else
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-brand-100 to-brand-200 flex items-center justify-center border-2 border-gray-100">
                                        <span class="text-brand-700 font-display font-bold text-lg">
                                            {{ collect(explode(' ', $article->author->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
                                        </span>
                                    </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <a href="{{ route('author.show', $article->author->slug) }}" class="font-serif font-bold text-dark hover:text-brand-600 transition-colors">
                                            {{ $article->author->name }}
                                        </a>
                                        @if($article->author->bio)
                                        <p class="text-sm text-gray-500 mt-1 line-clamp-3">{{ $article->author->bio }}</p>
                                        @endif
                                        <a href="{{ route('author.show', $article->author->slug) }}" class="inline-flex items-center gap-1 text-sm font-medium text-brand-600 hover:text-brand-700 mt-3">
                                            Lihat semua artikel
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </aside>
                    </div>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>