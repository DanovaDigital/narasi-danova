@props([
'author',
'showArticleCount' => true,
'size' => 'md', // sm, md, lg
])

@php
$sizeClasses = match($size) {
'sm' => [
'image' => 'w-16 h-16 border-2',
'name' => 'text-sm',
'role' => 'text-[10px]',
],
'lg' => [
'image' => 'w-28 h-28 sm:w-32 sm:h-32 border-4',
'name' => 'text-lg sm:text-xl',
'role' => 'text-xs',
],
default => [
'image' => 'w-20 h-20 sm:w-24 sm:h-24 border-4',
'name' => 'text-base sm:text-lg',
'role' => 'text-xs',
],
};
@endphp

<a href="{{ route('author.show', $author->slug) }}" {{ $attributes->merge(['class' => 'flex flex-col items-center text-center gap-3 group']) }}>
    <div class="relative">
        @if($author->avatar_url)
        <img src="{{ $author->avatar_url }}"
            alt="{{ $author->name }}"
            class="{{ $sizeClasses['image'] }} rounded-full object-cover border-white shadow-md transition-transform duration-300 group-hover:scale-105">
        @else
        {{-- Fallback avatar with initials --}}
        <div class="{{ $sizeClasses['image'] }} rounded-full bg-gradient-to-br from-brand-100 to-brand-200 border-white shadow-md flex items-center justify-center transition-transform duration-300 group-hover:scale-105">
            <span class="text-brand-700 font-display font-bold {{ $size === 'lg' ? 'text-2xl' : 'text-lg' }}">
                {{ collect(explode(' ', $author->name))->map(fn($n) => strtoupper(substr($n, 0, 1)))->take(2)->join('') }}
            </span>
        </div>
        @endif
    </div>
    <div class="space-y-1">
        <h4 class="font-serif font-bold text-dark {{ $sizeClasses['name'] }} group-hover:text-brand-600 transition-colors">
            {{ $author->name }}
        </h4>

        @if($showArticleCount && isset($author->articles_count))
        <p class="{{ $sizeClasses['role'] }} font-bold uppercase tracking-wider text-brand-600">
            {{ $author->articles_count }} {{ Str::plural('Artikel', $author->articles_count) }}
        </p>
        @elseif($author->bio)
        <p class="{{ $sizeClasses['role'] }} text-gray-500 line-clamp-2 max-w-[150px]">
            {{ Str::limit($author->bio, 50) }}
        </p>
        @endif
    </div>
</a>