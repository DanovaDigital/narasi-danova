@php
$siteName = $siteName ?? config('app.name');
$siteDescription = $siteDescription ?? null;
$footerText = $footerText ?? null;
@endphp

<footer class="bg-dark">
    <div class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid gap-12 lg:grid-cols-12 lg:gap-16">

            {{-- Brand Column --}}
            <div class="lg:col-span-4">
                <h2 class="font-display text-3xl font-bold text-white">{{ $siteName }}</h2>

                @if ($siteDescription)
                <p class="mt-4 text-base leading-relaxed text-gray-400">
                    {{ $siteDescription }}
                </p>
                @endif

                <div class="mt-8 flex flex-wrap gap-3">
                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 rounded-xl bg-brand-600 px-5 py-2.5 text-sm font-bold text-white transition-all hover:bg-brand-700">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Beranda
                    </a>

                    <a href="{{ route('articles.index') }}"
                        class="inline-flex items-center gap-2 rounded-xl border border-white/20 bg-white/5 px-5 py-2.5 text-sm font-bold text-white transition-all hover:border-brand-500/40 hover:bg-brand-500/10 hover:text-brand-200">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                        </svg>
                        Artikel
                    </a>
                </div>
            </div>

            {{-- Categories Column --}}
            <div class="lg:col-span-3">
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-400">Kategori</h3>

                @if(($navCategories ?? collect())->count())
                <div class="mt-6 space-y-3">
                    @foreach(($navCategories ?? []) as $cat)
                    <a href="{{ route('category.show', $cat->slug) }}"
                        class="group block">
                        <div class="flex items-center justify-between py-1">
                            <span class="text-sm font-semibold text-gray-400 transition-colors group-hover:text-white">
                                {{ $cat->name }}
                            </span>
                            <svg class="h-4 w-4 text-gray-600 opacity-0 transition-all group-hover:translate-x-1 group-hover:text-white group-hover:opacity-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </div>
                    </a>
                    @endforeach
                </div>
                @else
                <div class="mt-6 rounded-lg bg-gray-800 p-6 text-center">
                    <svg class="mx-auto h-8 w-8 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    <p class="mt-3 text-xs font-medium text-gray-500">Belum ada kategori</p>
                </div>
                @endif
            </div>

            {{-- Newsletter Column --}}
            <div class="lg:col-span-5">
                <h3 class="text-sm font-bold uppercase tracking-wider text-brand-400">Newsletter</h3>
                <p class="mt-2 text-sm text-gray-400">Dapatkan update berita terbaru langsung di inbox</p>

                <div class="mt-6">
                    <x-newsletter-form />
                </div>

                {{-- WhatsApp --}}
                @if (!empty($whatsappUrl))
                <a href="{{ $whatsappUrl }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="mt-6 block">
                    <div class="group flex items-center gap-4 rounded-2xl bg-white/5 p-4 ring-1 ring-white/10 transition-all hover:bg-brand-500/10 hover:ring-brand-500/20">
                        <div class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-green-500/15 ring-1 ring-green-500/20">
                            <svg class="h-6 w-6 text-green-400" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-bold text-white">WhatsApp</div>
                            <div class="mt-0.5 text-xs text-gray-300/80">Pengajuan berita via WhatsApp</div>
                        </div>
                        <svg class="h-5 w-5 text-white/40 transition-transform group-hover:translate-x-1 group-hover:text-brand-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div>
        <div class="mx-auto max-w-7xl px-4 pt-10 pb-6 sm:px-6 lg:px-8">
            <div class="flex flex-col items-center justify-between gap-4 sm:flex-row">
                <p class="text-sm text-gray-300/80">
                    {{ $footerText ?? ('© ' . now()->year . ' ' . $siteName . '. All rights reserved.') }}
                </p>

                <div class="flex flex-wrap items-center gap-6">
                    <a href="#" class="text-sm font-medium text-gray-300/80 transition-colors hover:text-white">
                        Privasi
                    </a>
                    <a href="#" class="text-sm font-medium text-gray-300/80 transition-colors hover:text-white">
                        Syarat
                    </a>
                    <a href="#" class="text-sm font-medium text-gray-300/80 transition-colors hover:text-white">
                        Kontak
                    </a>
                </div>
            </div>
        </div>
    </div>
</footer>