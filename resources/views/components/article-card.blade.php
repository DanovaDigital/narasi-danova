@props([
'article',
'variant' => 'standard', // standard, featured, overlay, horizontal, minimal
'showExcerpt' => true,
'showCategory' => true,
'showMeta' => true,
'showAuthor' => false,
])

@php
$variantClasses = match($variant) {
'featured' => 'group',
'overlay' => 'group relative h-[320px] sm:h-[400px] rounded-2xl overflow-hidden isolate',
'horizontal' => 'group flex gap-4 rounded-2xl bg-white p-4 transition-all duration-200 hover:shadow-soft',
'minimal' => 'group block',
default => 'group flex flex-col gap-3',
};
@endphp

@php
$placeholder = asset('images/article-placeholder.svg');
$imageSrc = $article->featured_image_display_url;
@endphp

<article {{ $attributes->merge(['class' => $variantClasses]) }}>

    @if($variant === 'featured')
    {{-- Featured/Hero Card - Large layout with side-by-side content --}}
    <div class="grid md:grid-cols-2 gap-4 md:gap-8 items-center bg-white md:bg-transparent rounded-2xl overflow-hidden">
        <a href="{{ route('articles.show', $article->slug) }}" class="block overflow-hidden rounded-2xl">
            <div class="relative">
                <div data-skeleton class="absolute inset-0 rounded-2xl bg-gradient-to-br from-gray-200 to-gray-100 animate-pulse"></div>
                <img src="{{ $imageSrc }}"
                    alt="{{ $article->title }}"
                    class="w-full h-full aspect-video md:aspect-[4/3] object-cover shadow-soft transition-transform duration-500 group-hover:scale-[1.02]"
                    loading="lazy"
                    onload="this.previousElementSibling?.classList.add('hidden')"
                    onerror="this.src='{{ $placeholder }}'; this.previousElementSibling?.classList.add('hidden')">
            </div>
        </a>

        <div class="py-4 md:py-6 px-4 md:px-0">
            @if($showCategory && $article->category)
            <a href="{{ route('category.show', $article->category->slug) }}"
                class="inline-block text-xs font-bold uppercase tracking-wider text-brand-600 mb-3 hover:text-brand-700 transition-colors">
                {{ $article->category->name }}
            </a>
            @endif

            <h2 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-display font-bold leading-tight text-dark mb-4">
                <a href="{{ route('articles.show', $article->slug) }}" class="hover:text-brand-700 transition-colors">
                    {{ $article->title }}
                </a>
            </h2>

            @if($showExcerpt && $article->excerpt)
            <p class="text-gray-500 leading-relaxed line-clamp-3 font-sans text-sm md:text-base">
                {{ Str::limit($article->excerpt, 160) }}
            </p>
            @endif

            @if($showMeta)
            <div class="mt-4 flex flex-wrap items-center gap-3 text-xs text-gray-400 font-sans">
                @if($showAuthor && $article->author)
                <span class="font-medium text-dark">{{ $article->author->name }}</span>
                <span>•</span>
                @endif
                <time datetime="{{ $article->published_at?->toIso8601String() }}">
                    {{ $article->published_at?->format('d M Y') }}
                </time>
                <span>•</span>
                <span>{{ number_format((int) $article->views_count) }} views</span>
                @if(!empty($article->read_time_minutes))
                <span>•</span>
                <span>{{ (int) $article->read_time_minutes }} min read</span>
                @endif
            </div>
            @endif
        </div>
    </div>

    @elseif($variant === 'overlay')
    {{-- Overlay/Dark Card - Image background with gradient overlay --}}
    <a href="{{ route('articles.show', $article->slug) }}" class="block h-full">
        <div data-skeleton class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-700 to-gray-900 animate-pulse"></div>
        <img src="{{ $imageSrc }}"
            alt="{{ $article->title }}"
            class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
            loading="lazy"
            onload="this.previousElementSibling?.classList.add('hidden')"
            onerror="this.src='{{ $placeholder }}'; this.previousElementSibling?.classList.add('hidden')">

        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>

        <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-6 text-white z-10">
            @if($showCategory && $article->category)
            <span class="inline-block rounded-full bg-white/20 backdrop-blur-sm px-3 py-1 text-xs font-bold uppercase tracking-wide mb-3">
                {{ $article->category->name }}
            </span>
            @endif

            <h3 class="text-xl sm:text-2xl font-serif font-bold leading-tight mb-2">
                {{ Str::limit($article->title, 80) }}
            </h3>

            @if($showMeta)
            <div class="flex items-center gap-2 text-xs text-gray-300">
                <time datetime="{{ $article->published_at?->toIso8601String() }}">
                    {{ $article->published_at?->format('d M Y') }}
                </time>
                <span>•</span>
                <span>{{ number_format((int) $article->views_count) }} views</span>
                @if(!empty($article->read_time_minutes))
                <span>•</span>
                <span>{{ (int) $article->read_time_minutes }} min</span>
                @endif
            </div>
            @endif
        </div>
    </a>

    @elseif($variant === 'horizontal')
    {{-- Horizontal Layout: Thumbnail + Content side by side --}}
    <div class="relative h-20 w-28 flex-shrink-0 overflow-hidden rounded-xl sm:h-24 sm:w-32">
        <div data-skeleton class="absolute inset-0 bg-gradient-to-br from-gray-200 to-gray-100 animate-pulse"></div>
        <img src="{{ $imageSrc }}"
            alt="{{ $article->title }}"
            class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-110"
            loading="lazy"
            onload="this.previousElementSibling?.classList.add('hidden')"
            onerror="this.src='{{ $placeholder }}'; this.previousElementSibling?.classList.add('hidden')">
    </div>

    <div class="flex-1 min-w-0">
        @if($showCategory && $article->category)
        <a href="{{ route('category.show', $article->category->slug) }}"
            class="inline-block text-xs font-bold uppercase tracking-wide text-brand-600 transition-colors hover:text-brand-700">
            {{ $article->category->name }}
        </a>
        @endif

        <h3 class="mt-1 text-sm font-serif font-bold leading-snug text-dark sm:text-base">
            <a href="{{ route('articles.show', $article->slug) }}" class="transition-colors group-hover:text-brand-600">
                {{ Str::limit($article->title, 75) }}
            </a>
        </h3>

        @if($showMeta)
        <div class="mt-2 flex items-center gap-2 text-xs text-gray-400 font-sans">
            <time datetime="{{ $article->published_at?->toIso8601String() }}">
                {{ $article->published_at?->diffForHumans() }}
            </time>
            <span>•</span>
            <span>{{ number_format((int) $article->views_count) }} views</span>
            @if(!empty($article->read_time_minutes))
            <span>•</span>
            <span>{{ (int) $article->read_time_minutes }} min</span>
            @endif
        </div>
        @endif
    </div>

    @elseif($variant === 'minimal')
    {{-- Minimal Layout: Simple text-focused --}}
    @if($showCategory && $article->category)
    <a href="{{ route('category.show', $article->category->slug) }}"
        class="inline-block text-xs font-bold uppercase tracking-wide text-brand-600 transition-colors hover:text-brand-700">
        {{ $article->category->name }}
    </a>
    @endif

    <h3 class="mt-1 text-base font-serif font-bold leading-snug text-dark sm:text-lg">
        <a href="{{ route('articles.show', $article->slug) }}" class="transition-colors group-hover:text-brand-600">
            {{ Str::limit($article->title, 80) }}
        </a>
    </h3>

    @if($showMeta)
    <div class="mt-2 flex items-center gap-2 text-xs text-gray-400 font-sans">
        <time datetime="{{ $article->published_at?->toIso8601String() }}">
            {{ $article->published_at?->format('d M Y') }}
        </time>
        <span>•</span>
        <span>{{ number_format((int) $article->views_count) }} views</span>
        @if(!empty($article->read_time_minutes))
        <span>•</span>
        <span>{{ (int) $article->read_time_minutes }} min</span>
        @endif
    </div>
    @endif

    @else
    {{-- Standard Card: Image on top, content below --}}
    <a href="{{ route('articles.show', $article->slug) }}" class="block overflow-hidden rounded-xl">
        <div class="relative">
            <div data-skeleton class="absolute inset-0 rounded-xl bg-gradient-to-br from-gray-200 to-gray-100 animate-pulse"></div>
            <img src="{{ $imageSrc }}"
                alt="{{ $article->title }}"
                class="w-full aspect-[4/3] object-cover transition-transform duration-500 group-hover:scale-[1.02]"
                loading="lazy"
                onload="this.previousElementSibling?.classList.add('hidden')"
                onerror="this.src='{{ $placeholder }}'; this.previousElementSibling?.classList.add('hidden')">
        </div>
    </a>

    <div class="flex flex-col">
        @if($showCategory && $article->category)
        <a href="{{ route('category.show', $article->category->slug) }}"
            class="flex items-center gap-2 text-xs font-sans text-gray-400 mb-1">
            <span class="font-bold uppercase tracking-wide text-brand-600 hover:text-brand-700 transition-colors">
                {{ $article->category->name }}
            </span>
        </a>
        @endif

        <h3 class="text-base sm:text-lg font-serif font-bold leading-snug text-dark group-hover:text-brand-600 transition-colors">
            <a href="{{ route('articles.show', $article->slug) }}">
                {{ Str::limit($article->title, 70) }}
            </a>
        </h3>

        @if($showExcerpt && $article->excerpt)
        <p class="mt-2 text-sm text-gray-500 leading-relaxed line-clamp-2 font-sans">
            {{ Str::limit($article->excerpt, 100) }}
        </p>
        @endif

        @if($showMeta)
        <div class="mt-2 flex items-center gap-2 text-xs text-gray-400 font-sans">
            <time datetime="{{ $article->published_at?->toIso8601String() }}">
                {{ $article->published_at?->format('d M Y') }}
            </time>
            <span>•</span>
            <span>{{ number_format((int) $article->views_count) }} views</span>
            @if(!empty($article->read_time_minutes))
            <span>•</span>
            <span>{{ (int) $article->read_time_minutes }} min</span>
            @endif
        </div>
        @endif
    </div>
    @endif
</article>