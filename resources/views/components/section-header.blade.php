@props([
'title',
'subtitle' => null,
'icon' => null,
'link' => null,
'linkText' => 'Lihat Semua →',
])

<div {{ $attributes->merge(['class' => 'flex items-center justify-between border-b pb-3']) }}>
    <div class="flex items-center gap-3">
        @if($icon)
        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-primary-100 text-primary-600">
            {!! $icon !!}
        </div>
        @endif

        <div>
            <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
            @if($subtitle)
            <p class="text-sm text-gray-600">{{ $subtitle }}</p>
            @endif
        </div>
    </div>

    @if($link)
    <a href="{{ $link }}" class="group cursor-pointer text-sm font-semibold text-primary-600 transition-all duration-200 ease-in hover:text-primary-700 hover:underline">
        <span class="inline-flex items-center gap-1">
            {{ $linkText }}
            <svg class="h-4 w-4 transition-transform duration-200 ease-in group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </span>
    </a>
    @endif
</div>