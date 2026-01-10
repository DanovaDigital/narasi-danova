<x-app-layout>
    <x-slot name="header">
        <div class="border-b bg-white">
            <div class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900">Artikel</h1>
                        <p class="mt-2 text-sm text-gray-600">Jelajahi semua artikel yang sudah dipublikasikan</p>
                    </div>

                    <form method="GET" action="{{ route('articles.index') }}" class="flex items-center gap-2">
                        <label for="category" class="sr-only">Kategori</label>
                        <select
                            id="category"
                            name="category"
                            onchange="this.form.submit()"
                            class="cursor-pointer rounded-lg border-gray-300 bg-white text-sm shadow-sm transition-all duration-200 ease-in focus:border-primary-500 focus:ring-1 focus:ring-primary-500">
                            <option value="">Semua kategori</option>
                            @foreach (($categories ?? collect()) as $cat)
                            <option value="{{ $cat->slug }}" @selected(($activeCategory ?? '' )===$cat->slug)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="cursor-pointer rounded-lg bg-primary-600 px-4 py-2 text-sm font-semibold text-white shadow-sm transition-all duration-200 ease-in hover:scale-105 hover:bg-primary-700 hover:shadow-md">Filter</button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="bg-gray-50 py-8">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @forelse ($articles as $article)
            @if ($loop->first)
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @endif

                <x-news-card :article="$article" />

                @if ($loop->last)
            </div>
            @endif
            @empty
            <div class="flex items-center justify-center rounded-xl bg-white p-16 shadow-sm ring-1 ring-gray-100">
                <div class="text-center">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">Belum Ada Artikel</h3>
                    <p class="mt-2 text-sm text-gray-500">Artikel akan ditampilkan di sini setelah dipublikasikan</p>
                </div>
            </div>
            @endforelse

            @if($articles->hasPages())
            <div class="pt-8">
                {{ $articles->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>