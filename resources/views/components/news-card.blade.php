@props([
'article',
'layout' => 'default', // default, featured, minimal, horizontal
'showExcerpt' => true,
'showCategory' => true,
'showMeta' => true,
])

@php
$layoutClasses = match($layout) {
'featured' => 'group block overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all duration-200 hover:border-gray-300 active:scale-[0.99]',
'horizontal' => 'group flex gap-3.5 rounded-2xl border border-gray-200 bg-white p-4 transition-all duration-200 hover:border-gray-300',
'minimal' => 'group block',
default => 'group block overflow-hidden rounded-2xl border border-gray-200 bg-white transition-all duration-200 hover:border-gray-300 active:scale-[0.99]',
};
@endphp

<article {{ $attributes->merge(['class' => $layoutClasses]) }}>
    @if($layout === 'horizontal')
    {{-- Horizontal Layout: Thumbnail + Content --}}
    @if($article->featured_image_url)
    <div class="h-20 w-28 flex-shrink-0 overflow-hidden rounded-xl sm:h-24 sm:w-32">
        <img src="{{ $article->featured_image_url }}"
            alt="{{ $article->title }}"
            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
            loading="lazy">
    </div>
    @else
    <div class="h-20 w-28 flex-shrink-0 overflow-hidden rounded-xl bg-gradient-to-br from-gray-200 to-gray-100 sm:h-24 sm:w-32"></div>
    @endif

    <div class="flex-1 min-w-0">
        @if($showCategory && $article->category)
        <a href="{{ route('category.show', $article->category->slug) }}"
            class="inline-block text-xs font-bold uppercase tracking-wide text-brand-600 transition-colors hover:text-brand-700">
            {{ $article->category->name }}
        </a>
        @endif

        <h3 class="mt-1 font-serif text-sm font-bold leading-snug text-dark sm:text-base">
            <a href="{{ route('articles.show', $article->slug) }}" class="transition-colors group-hover:text-brand-600">
                {{ Str::limit($article->title, 75) }}
            </a>
        </h3>

        @if($showMeta)
        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
            <time datetime="{{ $article->published_at?->toIso8601String() }}">
                {{ $article->published_at?->diffForHumans() }}
            </time>
            @if(!empty($article->read_time_minutes))
            <span>•</span>
            <span>{{ (int) $article->read_time_minutes }} min</span>
            @endif
        </div>
        @endif
    </div>
    @else
    {{-- Vertical Layout: Image on top --}}
    <a href="{{ route('articles.show', $article->slug) }}" class="block">
        @if($article->featured_image_url)
        <div class="aspect-video overflow-hidden">
            <img src="{{ $article->featured_image_url }}"
                alt="{{ $article->title }}"
                class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"
                loading="lazy">
        </div>
        @else
        <div class="aspect-video bg-gradient-to-br from-gray-200 to-gray-100"></div>
        @endif
    </a>

    <div class="p-4 {{ $layout === 'featured' ? 'sm:p-5' : '' }}">
        @if($showCategory && $article->category)
        <a href="{{ route('category.show', $article->category->slug) }}"
            class="inline-block text-xs font-bold uppercase tracking-wide text-brand-600 transition-colors hover:text-brand-700">
            {{ $article->category->name }}
        </a>
        @endif

        <h3 class="mt-2 font-serif font-bold leading-snug text-dark {{ $layout === 'featured' ? 'text-lg sm:text-xl' : 'text-base' }}">
            <a href="{{ route('articles.show', $article->slug) }}" class="transition-colors group-hover:text-brand-600">
                {{ Str::limit($article->title, $layout === 'featured' ? 90 : 70) }}
            </a>
        </h3>

        @if($showExcerpt && $article->excerpt)
        <p class="mt-2 text-sm leading-relaxed text-gray-600 {{ $layout === 'featured' ? 'sm:text-base' : '' }}">
            {{ Str::limit($article->excerpt, $layout === 'featured' ? 140 : 100) }}
        </p>
        @endif

        @if($showMeta)
        <div class="mt-3 flex items-center gap-2 text-xs text-gray-500">
            <time datetime="{{ $article->published_at?->toIso8601String() }}">
                {{ $article->published_at?->format('d M Y') }}
            </time>
            @if(!empty($article->read_time_minutes))
            <span>•</span>
            <span>{{ (int) $article->read_time_minutes }} menit</span>
            @endif
            <span>•</span>
            <span>{{ number_format((int) $article->views_count) }} views</span>
        </div>
        @endif
    </div>
    @endif
</article>