<x-app-layout>
    {{-- Author Hero Section --}}
    <div class="bg-dark text-white">
        <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center gap-8 md:flex-row">
                {{-- Avatar --}}
                <div class="flex-shrink-0">
                    @if($author->avatar_url)
                    <img src="{{ $author->avatar_url }}"
                        alt="{{ $author->name }}"
                        class="h-36 w-36 rounded-full border-4 border-brand-500 shadow-lg ring-4 ring-brand-500/20">
                    @else
                    <div class="flex h-36 w-36 items-center justify-center rounded-full border-4 border-brand-500 bg-brand-500/20 font-display text-5xl font-bold shadow-lg ring-4 ring-brand-500/20">
                        {{ strtoupper(substr($author->name, 0, 1)) }}
                    </div>
                    @endif
                </div>

                {{-- Author Info --}}
                <div class="flex-1 text-center md:text-left">
                    <div class="inline-block rounded-full bg-brand-500/10 px-4 py-1.5 text-sm font-medium text-brand-400">Penulis</div>
                    <h1 class="mt-4 font-display text-4xl font-bold leading-tight md:text-5xl">{{ $author->name }}</h1>

                    @if($author->bio)
                    <p class="mt-4 max-w-2xl text-lg leading-relaxed text-gray-300">{{ $author->bio }}</p>
                    @endif

                    {{-- Stats --}}
                    <div class="mt-8 flex flex-wrap justify-center gap-8 md:justify-start">
                        <div class="text-center">
                            <div class="font-display text-3xl font-bold text-brand-400">{{ $articles->total() }}</div>
                            <div class="mt-1 text-sm text-gray-400">Artikel</div>
                        </div>
                        <div class="text-center">
                            <div class="font-display text-3xl font-bold text-brand-400">{{ number_format($articles->sum('views_count')) }}</div>
                            <div class="mt-1 text-sm text-gray-400">Total Views</div>
                        </div>
                    </div>

                    {{-- Social Links --}}
                    @if($author->social_links && count($author->social_links) > 0)
                    <div class="mt-6 flex flex-wrap justify-center gap-3 md:justify-start">
                        @foreach($author->social_links as $platform => $url)
                        <a href="{{ $url }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="flex items-center gap-2 rounded-xl bg-white/5 px-4 py-2.5 text-sm font-medium ring-1 ring-white/10 backdrop-blur-sm transition-all duration-200 hover:bg-brand-500/20 hover:text-brand-400 hover:ring-brand-500/30">
                            @if($platform === 'twitter')
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"></path>
                            </svg>
                            @elseif($platform === 'linkedin')
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"></path>
                            </svg>
                            @elseif($platform === 'facebook')
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"></path>
                            </svg>
                            @elseif($platform === 'instagram')
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"></path>
                            </svg>
                            @else
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"></path>
                            </svg>
                            @endif
                            {{ ucfirst($platform) }}
                        </a>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Articles Section --}}
    <div class="bg-paper py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <x-section-header
                title="Artikel Terbaru"
                :subtitle="'Semua artikel oleh ' . $author->name"
                class="mb-8" />

            @if($articles->count())
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach($articles as $article)
                <x-article-card :article="$article" variant="standard" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $articles->links() }}
            </div>
            @else
            <div class="rounded-2xl bg-white p-16 text-center shadow-soft">
                <svg class="mx-auto h-20 w-20 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                <h3 class="mt-6 font-display text-xl font-semibold text-gray-900">Belum Ada Artikel</h3>
                <p class="mt-2 text-gray-500">Penulis ini belum memiliki artikel yang dipublikasikan.</p>
                <a href="{{ route('home') }}" class="mt-6 inline-flex items-center gap-2 rounded-xl bg-brand-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition-all duration-200 hover:bg-brand-700 hover:shadow-md">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>