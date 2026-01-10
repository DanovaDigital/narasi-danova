@props([
'author',
'date',
'readTime' => null,
'showAvatar' => true,
])

<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    @if($showAvatar)
    @if($author->avatar_url)
    <img src="{{ $author->avatar_url }}"
        alt="{{ $author->name }}"
        class="h-10 w-10 rounded-full">
    @else
    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-primary-100 text-sm font-bold text-primary-700">
        {{ strtoupper(substr($author->name, 0, 1)) }}
    </div>
    @endif
    @endif

    <div class="flex-1">
        <div class="flex items-center gap-2">
            <a href="{{ route('author.show', $author->slug) }}"
                class="font-semibold text-gray-900 hover:text-primary-600">
                {{ $author->name }}
            </a>
        </div>
        <div class="flex items-center gap-2 text-sm text-gray-600">
            <time datetime="{{ $date?->toIso8601String() }}">
                {{ $date?->format('d M Y') }}
            </time>
            @if($readTime)
            <span>•</span>
            <span>{{ $readTime }} min read</span>
            @endif
        </div>
    </div>
</div>