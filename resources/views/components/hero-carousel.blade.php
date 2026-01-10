@props(['articles'])

<div x-data="{
    currentSlide: 0,
    totalSlides: {{ count($articles) }},
    autoplayInterval: null,
    init() {
        this.autoplayInterval = setInterval(() => {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        }, 5000);
    },
    nextSlide() {
        this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        clearInterval(this.autoplayInterval);
        this.autoplayInterval = setInterval(() => {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        }, 5000);
    },
    previousSlide() {
        this.currentSlide = (this.currentSlide - 1 + this.totalSlides) % this.totalSlides;
        clearInterval(this.autoplayInterval);
        this.autoplayInterval = setInterval(() => {
            this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
        }, 5000);
    }
}" class="relative overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-gray-100">
    <div class="relative h-[500px] lg:h-[600px]">
        @foreach($articles as $index => $article)
        <div
            x-show="currentSlide === {{ $index }}"
            x-transition:enter="transition ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-x-full"
            x-transition:enter-end="opacity-100 translate-x-0"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-start="opacity-100 translate-x-0"
            x-transition:leave-end="opacity-0 -translate-x-full"
            class="absolute inset-0">

            {{-- Background Image (prefer real image), fallback to neutral gradient --}}
            @if($article->featured_image)
            <img src="{{ $article->featured_image }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
            @else
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-gray-800"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>

            {{-- Content --}}
            <div class="absolute inset-0 flex items-end">
                <div class="w-full p-8 lg:p-12">
                    <div class="mx-auto max-w-5xl">
                        @if($article->category)
                        <x-badge variant="primary" size="lg" class="bg-white/15 text-white ring-1 ring-white/20">{{ $article->category->name }}</x-badge>
                        @endif

                        <h2 class="mt-4 text-3xl font-bold leading-tight text-white lg:text-5xl">
                            <a href="{{ route('articles.show', $article->slug) }}" class="hover:underline">
                                {{ $article->title }}
                            </a>
                        </h2>

                        @if($article->excerpt)
                        <p class="mt-4 max-w-3xl text-lg text-gray-100">
                            {{ \Illuminate\Support\Str::limit($article->excerpt, 200) }}
                        </p>
                        @endif

                        <div class="mt-6 flex flex-wrap items-center gap-4 text-sm text-gray-200">
                            @if($article->author)
                            <div class="flex items-center gap-2">
                                <div class="flex h-8 w-8 items-center justify-center rounded-full bg-white/20 text-xs font-bold text-white">
                                    {{ strtoupper(substr($article->author->name ?? '', 0, 1)) }}
                                </div>
                                <span class="font-medium">{{ $article->author->name }}</span>
                            </div>
                            @endif
                            <span>•</span>
                            <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                            @if(!empty($article->read_time_minutes))
                            <span>•</span>
                            <span>{{ (int) $article->read_time_minutes }} menit</span>
                            @endif
                            <span>•</span>
                            <span>{{ number_format((int) $article->views_count) }} views</span>
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('articles.show', $article->slug) }}" class="group inline-flex cursor-pointer items-center gap-2 rounded-xl bg-white px-6 py-3 font-semibold text-gray-900 shadow-sm ring-1 ring-white/40 transition-all duration-200 ease-in hover:scale-105 hover:bg-gray-50 hover:shadow-md">
                                Baca Artikel
                                <svg class="h-5 w-5 transition-transform duration-200 ease-in group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Navigation Arrows --}}
    <button
        @click="previousSlide()"
        class="absolute left-4 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 cursor-pointer items-center justify-center rounded-xl bg-white/15 backdrop-blur-sm ring-1 ring-white/20 transition-all duration-200 ease-in hover:scale-110 hover:bg-white/25">
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <button
        @click="nextSlide()"
        class="absolute right-4 top-1/2 z-10 flex h-12 w-12 -translate-y-1/2 cursor-pointer items-center justify-center rounded-xl bg-white/15 backdrop-blur-sm ring-1 ring-white/20 transition-all duration-200 ease-in hover:scale-110 hover:bg-white/25">
        <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    {{-- Indicators --}}
    <div class="absolute bottom-4 left-1/2 z-10 flex -translate-x-1/2 gap-2">
        @foreach($articles as $index => $article)
        <button
            @click="currentSlide = {{ $index }}"
            :class="currentSlide === {{ $index }} ? 'w-8 bg-white' : 'w-3 bg-white/50'"
            class="h-3 cursor-pointer rounded-full transition-all duration-300 ease-in hover:bg-white/75">
        </button>
        @endforeach
    </div>
</div>