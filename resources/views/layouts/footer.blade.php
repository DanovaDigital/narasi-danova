@php
$siteName = $siteName ?? config('app.name');
$siteDescription = $siteDescription ?? null;
$footerText = $footerText ?? null;
@endphp

<footer class="border-t bg-white">
    <div class="mx-auto max-w-7xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="grid gap-8 md:grid-cols-3">
            <div>
                <div class="text-lg font-bold text-gray-900">{{ $siteName }}</div>
                @if ($siteDescription)
                <p class="mt-2 text-sm text-gray-600">{{ $siteDescription }}</p>
                @endif

                <div class="mt-4 flex items-center gap-3">
                    <a href="{{ route('home') }}" class="cursor-pointer text-sm font-medium text-primary-600 transition-all duration-200 ease-in hover:text-primary-700 hover:underline">Home</a>
                    <span class="text-gray-300">•</span>
                    <a href="{{ route('articles.index') }}" class="cursor-pointer text-sm font-medium text-primary-600 transition-all duration-200 ease-in hover:text-primary-700 hover:underline">Artikel</a>
                </div>
            </div>

            <div>
                <div class="text-sm font-bold text-gray-900">Kategori</div>
                <ul class="mt-3 space-y-2">
                    @forelse (($navCategories ?? []) as $cat)
                    <li>
                        <a href="{{ route('category.show', $cat->slug) }}" class="group cursor-pointer text-sm text-gray-600 transition-all duration-200 ease-in hover:text-primary-600">
                            <span class="inline-block transition-transform duration-200 ease-in group-hover:translate-x-1">{{ $cat->name }}</span>
                        </a>
                    </li>
                    @empty
                    <li class="flex items-center gap-2 text-sm text-gray-400">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        Belum ada kategori
                    </li>
                    @endforelse
                </ul>
            </div>

            <div>
                <div class="text-sm font-bold text-gray-900">Newsletter</div>
                <p class="mt-2 text-sm text-gray-600">Dapatkan update artikel terbaru</p>
                <div class="mt-4">
                    <x-newsletter-form />
                </div>

                @if (!empty($whatsappUrl))
                <div class="mt-6">
                    <a
                        href="{{ $whatsappUrl }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="group inline-flex cursor-pointer items-center justify-center gap-2 rounded-lg bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in hover:scale-105 hover:bg-green-700 hover:shadow-md">
                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                        WhatsApp
                    </a>
                </div>
                @endif

                <div class="mt-3">
                    <a href="{{ route('news.submission.form') }}" class="cursor-pointer text-sm text-gray-600 transition-all duration-200 ease-in hover:text-primary-600 hover:underline">
                        Form Pengajuan Berita
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-10 border-t pt-6 text-center text-sm text-gray-500">
            {{ $footerText ?? ('© ' . now()->year . ' ' . $siteName . '. All rights reserved.') }}
        </div>
    </div>
</footer>