@props([
'category',
'size' => 'md', // sm, md, lg
])

@php
$sizeClasses = match($size) {
'sm' => [
'wrapper' => 'w-14 h-14',
'ring' => 'p-0.5 border',
'label' => 'text-[10px]',
],
'lg' => [
'wrapper' => 'w-24 h-24',
'ring' => 'p-1 border-2',
'label' => 'text-xs',
],
default => [
'wrapper' => 'w-18 h-18 sm:w-20 sm:h-20',
'ring' => 'p-0.5 sm:p-1 border-2',
'label' => 'text-[10px] sm:text-xs',
],
};
@endphp

<a href="{{ route('category.show', $category->slug) }}"
    {{ $attributes->merge(['class' => 'flex flex-col items-center gap-2 group cursor-pointer']) }}>
    <div class="rounded-full {{ $sizeClasses['ring'] }} border-brand-500/30 group-hover:border-brand-500 transition-all duration-300 {{ $sizeClasses['wrapper'] }} transform-gpu transition-transform group-hover:rotate-6 group-hover:scale-105">
        @if($category->image_url ?? false)
        <img src="{{ $category->image_url }}"
            alt="{{ $category->name }}"
            class="w-full h-full rounded-full object-cover">
        @else
        {{-- Fallback gradient with icon --}}
        <div class="w-full h-full rounded-full bg-gradient-to-br from-brand-100 to-brand-50 flex items-center justify-center group-hover:from-brand-200 group-hover:to-brand-100 transition-colors">
            <svg class="w-1/3 h-1/3 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
            </svg>
        </div>
        @endif
    </div>
    <span class="{{ $sizeClasses['label'] }} font-bold text-center uppercase tracking-wide text-gray-600 group-hover:text-brand-600 transition-colors line-clamp-1 max-w-[80px]">
        {{ $category->name }}
    </span>
</a>