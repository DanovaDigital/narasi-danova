@props([
'article',
'layout' => 'default', // default, featured, minimal, horizontal
'showExcerpt' => true,
'showCategory' => true,
'showMeta' => true,
])

@php
$layoutClasses = match($layout) {
'featured' => 'group block overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100 transition-all duration-200 ease-in hover:shadow-md hover:scale-[1.02]',
'horizontal' => 'group flex gap-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 transition-all duration-200 ease-in hover:shadow-md',
'minimal' => 'group block',
default => 'group block overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100 transition-all duration-200 ease-in hover:shadow-md hover:scale-[1.02]',
};
@endphp

<article {{ $attributes->merge(['class' => $layoutClasses]) }}>
    @if($layout === 'horizontal')
    {{-- Horizontal Layout: Thumbnail + Content --}}
    @if($article->featured_image)
    <div class="h-24 w-32 flex-shrink-0 overflow-hidden rounded-lg">
        <img src="{{ $article->featured_image }}"
            alt="{{ $article->title }}"
            class="h-full w-full object-cover transition-transform duration-300 ease-in group-hover:scale-110"
            loading="lazy">
    </div>
    @else
    <div class="h-24 w-32 flex-shrink-0 overflow-hidden rounded-lg bg-gradient-to-br from-gray-200 to-gray-100"></div>
    @endif

    <div class="flex-1">
        @if($showCategory && $article->category)
        <a href="{{ route('category.show', $article->category->slug) }}"
            class="cursor-pointer text-xs font-semibold uppercase tracking-wide text-primary-600 transition-colors duration-200 ease-in hover:text-primary-700 hover:underline">
            {{ $article->category->name }}
        </a>
        @endif

        <h3 class="mt-1 text-base font-bold leading-tight text-gray-900">
            <a href="{{ route('articles.show', $article->slug) }}" class="cursor-pointer transition-colors duration-200 ease-in group-hover:text-primary-600">
                {{ Str::limit($article->title, 80) }}
            </a>
        </h3>

        @if($showMeta)
        <div class="mt-2 flex items-center gap-2 text-xs text-gray-500">
            <time datetime="{{ $article->published_at?->toIso8601String() }}">
                {{ $article->published_at?->diffForHumans() }}
            </time>
            @if(!empty($article->read_time_minutes))
            <span>•</span>
            <span>{{ (int) $article->read_time_minutes }} min read</span>
            @endif
            <span>•</span>
            <span>{{ number_format((int) $article->views_count) }} views</span>
        </div>
        @endif
    </div>
    @else
    {{-- Vertical Layout: Image on top --}}
    <a href="{{ route('articles.show', $article->slug) }}" class="block cursor-pointer">
        @if($article->featured_image)
        <div class="aspect-video overflow-hidden">
            <img src="{{ $article->featured_image }}"
                alt="{{ $article->title }}"
                class="h-full w-full object-cover transition-transform duration-300 ease-in group-hover:scale-110"
                loading="lazy">
        </div>
        @else
        <div class="aspect-video bg-gradient-to-br from-gray-200 to-gray-100"></div>
        @endif
    </a>

    <div class="p-4 {{ $layout === 'featured' ? 'p-6' : '' }}">
        @if($showCategory && $article->category)
        <a href="{{ route('category.show', $article->category->slug) }}"
            class="cursor-pointer text-xs font-semibold uppercase tracking-wide text-primary-600 transition-colors duration-200 ease-in hover:text-primary-700 hover:underline">
            {{ $article->category->name }}
        </a>
        @endif

        <h3 class="mt-2 font-bold leading-tight text-gray-900 {{ $layout === 'featured' ? 'text-xl' : 'text-base' }}">
            <a href="{{ route('articles.show', $article->slug) }}" class="cursor-pointer transition-colors duration-200 ease-in group-hover:text-primary-600">
                {{ Str::limit($article->title, $layout === 'featured' ? 100 : 70) }}
            </a>
        </h3>

        @if($showExcerpt && $article->excerpt)
        <p class="mt-2 text-sm text-gray-600 {{ $layout === 'featured' ? 'text-base' : '' }}">
            {{ Str::limit($article->excerpt, $layout === 'featured' ? 150 : 100) }}
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