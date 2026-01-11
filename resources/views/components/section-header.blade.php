@props([
'title',
'subtitle' => null,
'icon' => null,
'link' => null,
'linkText' => 'Lihat Semua',
])

<div {{ $attributes->merge(['class' => 'flex items-end justify-between mb-6 border-b border-gray-100 pb-3']) }}>
    <div class="flex items-center gap-3">
        @if($icon)
        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-brand-50 text-brand-600">
            {!! $icon !!}
        </div>
        @endif

        <div>
            <h2 class="text-xl sm:text-2xl font-serif font-bold text-dark">{{ $title }}</h2>
            @if($subtitle)
            <p class="mt-0.5 text-sm text-gray-500 font-sans">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if($link)
    <a href="{{ $link }}" class="group inline-flex items-center gap-1 text-sm font-medium text-brand-600 transition-all duration-200 ease-in hover:text-brand-700 hover:underline">
        <span>{{ $linkText }}</span>
        <svg class="h-4 w-4 transition-transform duration-200 ease-in group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </a>
    @endif
</div>