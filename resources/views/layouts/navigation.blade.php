@php
$siteName = $siteName ?? config('app.name');
/** @var \Illuminate\Support\Collection<int, \App\Models\Category> $navCategories */
    $navCategories = $navCategories ?? collect();
    @endphp

    <nav x-data="smartHeader" x-init="init" class="sticky top-0 z-40 border-b border-gray-100 bg-white transition-shadow" :class="scrolled ? 'shadow-soft' : ''">
        {{-- Top Bar --}}
        <div class="border-b border-gray-50 bg-paper">
            <div class="mx-auto max-w-7xl px-4 py-2.5 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-xs font-medium text-gray-500">
                        <svg class="h-3.5 w-3.5 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ now()->isoFormat('dddd, D MMMM YYYY') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Main Header --}}
        <div class="border-b border-gray-100">
            <div class="mx-auto max-w-7xl px-4 py-5 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between gap-6">
                    <a href="{{ route('home') }}" class="group flex items-center gap-3">
                        <span class="font-display text-2xl font-bold tracking-tight text-dark transition-colors group-hover:text-brand-600 md:text-3xl">
                            {{ $siteName }}
                        </span>
                    </a>

                    <form method="GET" action="{{ route('search') }}" class="hidden items-center sm:flex">
                        <label for="nav_search" class="sr-only">Cari</label>
                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3.5">
                                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input
                                id="nav_search"
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari berita..."
                                class="w-72 rounded-xl border border-gray-200 bg-paper py-2.5 pl-10 pr-4 text-sm font-sans transition-all focus:border-brand-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-brand-500/20" />
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Category Navigation --}}
        <div class="bg-dark">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="scrollbar-hide flex items-center gap-1 overflow-x-auto">
                    <a href="{{ route('home') }}"
                        class="group relative whitespace-nowrap px-5 py-3.5 text-sm font-semibold text-white/90 transition-all hover:bg-white/10 hover:text-white {{ request()->routeIs('home') ? 'bg-white/10 text-white' : '' }}">
                        Beranda
                        @if(request()->routeIs('home'))
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-500"></div>
                        @endif
                    </a>
                    <a href="{{ route('articles.index') }}"
                        class="group relative whitespace-nowrap px-5 py-3.5 text-sm font-semibold text-white/90 transition-all hover:bg-white/10 hover:text-white {{ request()->routeIs('articles.index') ? 'bg-white/10 text-white' : '' }}">
                        Semua Berita
                        @if(request()->routeIs('articles.index'))
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-500"></div>
                        @endif
                    </a>
                    @foreach($navCategories as $cat)
                    @php
                    $isActiveCategory = request()->routeIs('category.show') && request()->route('slug') === $cat->slug;
                    @endphp
                    <a href="{{ route('category.show', $cat->slug) }}"
                        class="group relative whitespace-nowrap px-5 py-3.5 text-sm font-semibold text-white/90 transition-all hover:bg-white/10 hover:text-white {{ $isActiveCategory ? 'bg-white/10 text-white' : '' }}">
                        {{ $cat->name }}
                        @if($isActiveCategory)
                        <div class="absolute bottom-0 left-0 right-0 h-0.5 bg-brand-500"></div>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </nav>