{{--
    Article Card Skeleton Loader Component
    
    Usage:
    <x-article-card-skeleton variant="standard" />
    <x-article-card-skeleton variant="featured" />
    <x-article-card-skeleton variant="overlay" class="h-[400px]" />
    <x-article-card-skeleton variant="horizontal" />
    <x-article-card-skeleton variant="minimal" />
    
    Loop example:
    @for($i = 0; $i < 4; $i++)
        <x-article-card-skeleton variant="standard" />
    @endfor
--}}

@props([
'variant' => 'standard', // standard, featured, overlay, horizontal, minimal
])

@php
$variantClasses = match($variant) {
'featured' => 'group',
'overlay' => 'group relative h-[320px] sm:h-[400px] rounded-2xl overflow-hidden isolate',
'horizontal' => 'group flex gap-4 rounded-2xl bg-white p-4',
'minimal' => 'group block',
default => 'group flex flex-col gap-3',
};
@endphp

<article {{ $attributes->merge(['class' => $variantClasses]) }}>
    @if($variant === 'featured')
    {{-- Featured/Hero Card Skeleton --}}
    <div class="grid md:grid-cols-2 gap-4 md:gap-8 items-center bg-white md:bg-transparent rounded-2xl overflow-hidden animate-pulse">
        <div class="relative overflow-hidden rounded-2xl">
            <div class="w-full aspect-video md:aspect-[4/3] bg-gradient-to-br from-gray-200 to-gray-100"></div>
        </div>

        <div class="py-4 md:py-6 px-4 md:px-0 space-y-4">
            <div class="h-4 w-24 bg-gray-200 rounded"></div>
            <div class="space-y-3">
                <div class="h-8 bg-gray-200 rounded w-full"></div>
                <div class="h-8 bg-gray-200 rounded w-5/6"></div>
                <div class="h-8 bg-gray-200 rounded w-4/6"></div>
            </div>
            <div class="space-y-2">
                <div class="h-3 bg-gray-100 rounded w-full"></div>
                <div class="h-3 bg-gray-100 rounded w-full"></div>
                <div class="h-3 bg-gray-100 rounded w-3/4"></div>
            </div>
            <div class="flex items-center gap-3">
                <div class="h-3 w-20 bg-gray-200 rounded"></div>
                <div class="h-3 w-20 bg-gray-200 rounded"></div>
            </div>
        </div>
    </div>

    @elseif($variant === 'overlay')
    {{-- Overlay Card Skeleton --}}
    <div class="h-full animate-pulse">
        <div class="absolute inset-0 w-full h-full bg-gradient-to-br from-gray-300 to-gray-200"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-black/20 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-5 sm:p-6 space-y-3 z-10">
            <div class="h-5 w-24 bg-white/30 rounded-full"></div>
            <div class="space-y-2">
                <div class="h-6 bg-white/40 rounded w-5/6"></div>
                <div class="h-6 bg-white/40 rounded w-4/6"></div>
            </div>
            <div class="flex items-center gap-2">
                <div class="h-3 w-20 bg-white/30 rounded"></div>
                <div class="h-3 w-16 bg-white/30 rounded"></div>
            </div>
        </div>
    </div>

    @elseif($variant === 'horizontal')
    {{-- Horizontal Card Skeleton --}}
    <div class="relative h-20 w-28 flex-shrink-0 overflow-hidden rounded-xl sm:h-24 sm:w-32 bg-gradient-to-br from-gray-200 to-gray-100 animate-pulse"></div>
    <div class="flex-1 min-w-0 space-y-3">
        <div class="h-3 w-20 bg-gray-200 rounded"></div>
        <div class="space-y-2">
            <div class="h-4 bg-gray-200 rounded w-full"></div>
            <div class="h-4 bg-gray-200 rounded w-5/6"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="h-2 w-16 bg-gray-100 rounded"></div>
            <div class="h-2 w-12 bg-gray-100 rounded"></div>
        </div>
    </div>

    @elseif($variant === 'minimal')
    {{-- Minimal Card Skeleton --}}
    <div class="animate-pulse space-y-3">
        <div class="h-3 w-20 bg-gray-200 rounded"></div>
        <div class="space-y-2">
            <div class="h-4 bg-gray-200 rounded w-full"></div>
            <div class="h-4 bg-gray-200 rounded w-4/6"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="h-2 w-16 bg-gray-100 rounded"></div>
            <div class="h-2 w-12 bg-gray-100 rounded"></div>
        </div>
    </div>

    @else
    {{-- Standard Card Skeleton --}}
    <div class="overflow-hidden rounded-xl animate-pulse">
        <div class="relative">
            <div class="w-full aspect-[4/3] bg-gradient-to-br from-gray-200 to-gray-100"></div>
        </div>
    </div>

    <div class="flex flex-col space-y-3">
        <div class="h-3 w-20 bg-gray-200 rounded"></div>
        <div class="space-y-2">
            <div class="h-5 bg-gray-200 rounded w-full"></div>
            <div class="h-5 bg-gray-200 rounded w-5/6"></div>
        </div>
        <div class="space-y-1">
            <div class="h-3 bg-gray-100 rounded w-full"></div>
            <div class="h-3 bg-gray-100 rounded w-4/6"></div>
        </div>
        <div class="flex items-center gap-2">
            <div class="h-2 w-16 bg-gray-100 rounded"></div>
            <div class="h-2 w-12 bg-gray-100 rounded"></div>
        </div>
    </div>
    @endif
</article>