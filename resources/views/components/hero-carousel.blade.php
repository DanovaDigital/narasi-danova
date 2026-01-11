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
}" class="relative overflow-hidden rounded-3xl bg-white shadow-sm">
    <div class="relative h-[400px] sm:h-[480px] lg:h-[520px]">
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

            {{-- Background Image --}}
            @if($article->featured_image)
            <img src="{{ $article->featured_image }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="lazy">
            @else
            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-gray-800"></div>
            @endif
            <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/40 to-transparent"></div>

            {{-- Content --}}
            <div class="absolute inset-0 flex items-end">
                <div class="w-full p-5 sm:p-8 lg:p-10">
                    <div class="mx-auto max-w-5xl">
                        @if($article->category)
                        <span class="inline-flex items-center rounded-full bg-white/20 px-3 py-1 text-xs font-bold uppercase tracking-wide text-white backdrop-blur-sm sm:px-4 sm:py-1.5 sm:text-sm">
                            {{ $article->category->name }}
                        </span>
                        @endif

                        <h2 class="mt-3 text-2xl font-bold leading-tight text-white sm:mt-4 sm:text-3xl lg:text-4xl">
                            <a href="{{ route('articles.show', $article->slug) }}" class="hover:underline">
                                {{ $article->title }}
                            </a>
                        </h2>

                        @if($article->excerpt)
                        <p class="mt-2 hidden max-w-2xl text-sm leading-relaxed text-gray-100 sm:block sm:text-base lg:mt-3">
                            {{ \Illuminate\Support\Str::limit($article->excerpt, 160) }}
                        </p>
                        @endif

                        <div class="mt-3 flex flex-wrap items-center gap-2 text-xs text-gray-200 sm:mt-4 sm:gap-3 sm:text-sm">
                            @if($article->author)
                            <div class="flex items-center gap-2">
                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-white/20 text-xs font-bold text-white backdrop-blur-sm sm:h-7 sm:w-7">
                                    {{ strtoupper(substr($article->author->name ?? '', 0, 1)) }}
                                </div>
                                <span class="font-semibold">{{ $article->author->name }}</span>
                            </div>
                            @endif
                            <span>•</span>
                            <span>{{ optional($article->published_at)->format('d M Y') }}</span>
                            @if(!empty($article->read_time_minutes))
                            <span class="hidden sm:inline">•</span>
                            <span class="hidden sm:inline">{{ (int) $article->read_time_minutes }} menit</span>
                            @endif
                        </div>

                        <div class="mt-4 sm:mt-5">
                            <a href="{{ route('articles.show', $article->slug) }}"
                                class="group inline-flex items-center gap-2 rounded-full bg-white px-5 py-2.5 text-sm font-bold text-gray-900 shadow-lg transition-all hover:scale-105 hover:shadow-xl active:scale-95 sm:px-6 sm:py-3 sm:text-base">
                                Baca Artikel
                                <svg class="h-4 w-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
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
        class="absolute left-3 top-1/2 z-10 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm transition-all hover:scale-110 hover:bg-white/30 active:scale-95 sm:left-4 sm:h-11 sm:w-11">
        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
        </svg>
    </button>

    <button
        @click="nextSlide()"
        class="absolute right-3 top-1/2 z-10 flex h-9 w-9 -translate-y-1/2 items-center justify-center rounded-full bg-white/20 backdrop-blur-sm transition-all hover:scale-110 hover:bg-white/30 active:scale-95 sm:right-4 sm:h-11 sm:w-11">
        <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
        </svg>
    </button>

    {{-- Indicators --}}
    <div class="absolute bottom-3 left-1/2 z-10 flex -translate-x-1/2 gap-1.5 sm:bottom-4 sm:gap-2">
        @foreach($articles as $index => $article)
        <button
            @click="currentSlide = {{ $index }}"
            :class="currentSlide === {{ $index }} ? 'w-6 bg-white sm:w-7' : 'w-1.5 bg-white/50 sm:w-2'"
            class="h-1.5 rounded-full transition-all duration-300 hover:bg-white/80 sm:h-2">
        </button>
        @endforeach
    </div>
</div>