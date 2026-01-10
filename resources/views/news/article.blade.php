<x-app-layout>
    @push('head')
    <x-seo-meta :article="$article" />
    @endpush

    <x-slot name="header">
        <div class="border-b bg-white">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="text-xs text-gray-500">
                    @if($article->category)
                    <a href="{{ route('category.show', $article->category->slug) }}" class="font-medium text-gray-700 hover:underline">{{ $article->category->name }}</a>
                    <span class="mx-2">•</span>
                    @endif
                    <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                    <span class="mx-2">•</span>
                    <span>{{ number_format((int) $article->views_count) }} views</span>
                </div>
                <h1 class="mt-2 text-2xl font-semibold text-gray-900">{{ $article->title }}</h1>
                @if ($article->excerpt)
                <p class="mt-3 max-w-3xl text-sm text-gray-700">{{ $article->excerpt }}</p>
                @endif

                @if ($article->tags->count())
                <div class="mt-4 flex flex-wrap gap-2">
                    @foreach ($article->tags as $tag)
                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs text-gray-700">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </x-slot>

    @php
    $url = route('articles.show', $article->slug);
    $shareText = $article->title;
    $waUrl = 'https://wa.me/?text=' . urlencode($shareText . ' ' . $url);
    $xUrl = 'https://twitter.com/intent/tweet?text=' . urlencode($shareText) . '&url=' . urlencode($url);
    $fbUrl = 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($url);
    @endphp

    <div class="py-8">
        <div class="mx-auto grid max-w-7xl gap-8 px-4 sm:px-6 lg:px-8 lg:grid-cols-3">
            <div class="lg:col-span-2">
                <div class="rounded-3xl border bg-white p-8 shadow-sm ring-1 ring-gray-100">
                    <div class="flex flex-wrap items-center justify-between gap-3">
                        <a href="{{ route('articles.index') }}" class="text-sm font-medium text-primary-600 hover:underline">&larr; Kembali ke daftar artikel</a>

                        <div class="flex flex-wrap gap-2">
                            <a href="{{ $waUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Share WhatsApp</a>
                            <a href="{{ $xUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Share X</a>
                            <a href="{{ $fbUrl }}" target="_blank" rel="noopener noreferrer" class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Share Facebook</a>
                            <button type="button" onclick="navigator.clipboard.writeText('{{ $url }}')" class="rounded-xl border border-gray-200 bg-white px-3 py-2 text-xs font-semibold text-gray-700 shadow-sm hover:bg-gray-50">Copy link</button>
                        </div>
                    </div>

                    <hr class="my-5" />

                    {{-- Author Byline --}}
                    @if($article->author)
                    <x-author-byline
                        :author="$article->author"
                        :date="$article->published_at"
                        :read-time="$article->read_time_minutes"
                        class="mb-6" />
                    @endif

                    {{-- Article Content with Typography --}}
                    <article class="max-w-none text-gray-800 leading-relaxed">
                        {!! nl2br(e($article->content)) !!}
                    </article>
                </div>

                @if (($related ?? collect())->count())
                <div class="mt-12 border-t pt-12">
                    <x-section-header title="Artikel Terkait" subtitle="Baca juga artikel lainnya yang mungkin Anda suka" />
                    <div class="mt-6 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach ($related as $ra)
                        <x-news-card :article="$ra" layout="minimal" :show-excerpt="false" />
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <aside class="space-y-6">
                <div class="rounded-3xl border bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Newsletter</h2>
                    <p class="mt-2 text-sm text-gray-600">Subscribe untuk dapat update artikel terbaru.</p>
                    <div class="mt-4">
                        <x-newsletter-form />
                    </div>
                </div>

                <div class="rounded-3xl border bg-white p-6 shadow-sm ring-1 ring-gray-100">
                    <h2 class="text-lg font-semibold text-gray-900">Ajukan Berita</h2>
                    <p class="mt-2 text-sm text-gray-600">Punya info berita? Kirim lewat form.</p>
                    <a href="{{ route('news.submission.form') }}" class="mt-4 inline-flex w-full items-center justify-center rounded-2xl bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm hover:bg-primary-700">Buka Form</a>
                </div>
            </aside>
        </div>
    </div>
</x-app-layout>