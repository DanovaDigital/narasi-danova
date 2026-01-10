@php
$siteName = $siteName ?? config('app.name');
@endphp

<nav class="border-b bg-white shadow-sm">
    {{-- Top Bar --}}
    <div class="border-b bg-gray-50">
        <div class="mx-auto max-w-7xl px-4 py-2 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between text-xs text-gray-600">
                <div class="flex items-center gap-4">
                    <span>{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Header --}}
    <div class="border-b">
        <div class="mx-auto max-w-7xl px-4 py-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <a href="{{ route('home') }}" class="cursor-pointer text-2xl font-bold tracking-tight text-gray-900 transition-all duration-200 ease-in hover:text-primary-600 md:text-3xl">
                    {{ $siteName }}
                </a>

                <form method="GET" action="{{ route('search') }}" class="hidden sm:flex items-center gap-2">
                    <label for="nav_search" class="sr-only">Cari</label>
                    <input
                        id="nav_search"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari berita..."
                        class="w-64 rounded-lg border-gray-300 text-sm shadow-sm transition-all duration-200 ease-in focus:border-primary-500 focus:ring-1 focus:ring-primary-500" />
                    <button type="submit" class="cursor-pointer rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in hover:scale-105 hover:bg-primary-700 hover:shadow-md">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- Category Navigation --}}
    <div class="bg-gray-900 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-1 overflow-x-auto">
                    <a href="{{ route('home') }}"
                        class="cursor-pointer whitespace-nowrap px-4 py-3 text-sm font-medium transition-all duration-200 ease-in hover:bg-gray-800 {{ request()->routeIs('home') ? 'bg-gray-800 border-b-2 border-primary-500' : '' }}">
                        Beranda
                    </a>
                    <a href="{{ route('articles.index') }}"
                        class="cursor-pointer whitespace-nowrap px-4 py-3 text-sm font-medium transition-all duration-200 ease-in hover:bg-gray-800 {{ request()->routeIs('articles.index') ? 'bg-gray-800 border-b-2 border-primary-500' : '' }}">
                        Semua Berita
                    </a>
                    @forelse(($navCategories ?? []) as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}"
                        class="cursor-pointer whitespace-nowrap px-4 py-3 text-sm font-medium transition-all duration-200 ease-in hover:bg-gray-800 {{ request()->route('slug') === $cat->slug ? 'bg-gray-800 border-b-2 border-primary-500' : '' }}">
                        {{ $cat->name }}
                    </a>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</nav>

<style>
    @keyframes marquee {
        0% {
            transform: translateX(0);
        }

        100% {
            transform: translateX(-50%);
        }
    }

    .animate-marquee {
        animation: marquee 20s linear infinite;
    }

    .animate-marquee:hover {
        animation-play-state: paused;
    }
</style>