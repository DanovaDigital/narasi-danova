<x-admin-layout>
    <x-slot name="heading">Dashboard</x-slot>

    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
        {{-- Stats Cards --}}
        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Articles</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($totalArticles ?? 0)) }}</p>
                </div>
                <div class="p-3 bg-blue-50 rounded-lg">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Subscribers</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($totalSubscribers ?? 0)) }}</p>
                </div>
                <div class="p-3 bg-green-50 rounded-lg">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Submissions</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($totalSubmissions ?? 0)) }}</p>
                </div>
                <div class="p-3 bg-purple-50 rounded-lg">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Total Clicks/Views</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($totalViews ?? 0)) }}</p>
                </div>
                <div class="p-3 bg-amber-50 rounded-lg">
                    <svg class="w-6 h-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Views Today</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($viewsToday ?? 0)) }}</p>
                </div>
                <div class="p-3 bg-sky-50 rounded-lg">
                    <svg class="w-6 h-6 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Views (Last 7 Days)</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($views7d ?? 0)) }}</p>
                </div>
                <div class="p-3 bg-indigo-50 rounded-lg">
                    <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3v18m4-18v18m-9-9h18" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Views (Last 24 Hours)</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($views24h ?? 0)) }}</p>
                </div>
                <div class="p-3 bg-cyan-50 rounded-lg">
                    <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M7 14l4-4 4 4 6-6" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Unique Views Today</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($uniqueViewsToday ?? 0)) }}</p>
                    <p class="mt-1 text-xs text-gray-500">Distinct by IP hash</p>
                </div>
                <div class="p-3 bg-rose-50 rounded-lg">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium text-gray-500">Unique Views (Last 7 Days)</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format((int) ($uniqueViews7d ?? 0)) }}</p>
                    <p class="mt-1 text-xs text-gray-500">Distinct by IP hash</p>
                </div>
                <div class="p-3 bg-emerald-50 rounded-lg">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c0 2.761-2.239 5-5 5S2 13.761 2 11s2.239-5 5-5 5 2.239 5 5zm0 0c0 2.761 2.239 5 5 5s5-2.239 5-5-2.239-5-5-5-5 2.239-5 5z" />
                    </svg>
                </div>
            </div>
        </div>
    </div>

    {{-- Welcome Message --}}
    <div class="mt-6 bg-white rounded-xl p-6 shadow-soft border border-gray-100">
        <h2 class="text-lg font-serif font-bold text-gray-900">Selamat datang, {{ auth('admin')->user()->name }}!</h2>
        <p class="text-gray-600 mt-2">Kelola konten situs Anda melalui menu di sidebar.</p>
        <div class="mt-4 flex gap-3">
            <a href="{{ route('admin.articles.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                </svg>
                New Article
            </a>
            <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 rounded-lg bg-gray-100 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-2">
        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-serif font-bold text-gray-900">Top Artikel Populer</h3>
                    <p class="text-sm text-gray-500">Berdasarkan total views/clicks</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse(($topArticles ?? collect()) as $a)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-900">
                                <a class="hover:text-brand-700" href="{{ route('articles.show', $a->slug) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $a->title }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-right">{{ number_format((int) $a->views_count) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h3 class="text-lg font-serif font-bold text-gray-900">Top Referrer (7 hari)</h3>
                    <p class="text-sm text-gray-500">Sumber traffic teratas</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Host</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse(($topReferrers ?? collect()) as $r)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $r['host'] }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-right">{{ number_format((int) $r['total']) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-6 grid gap-6 lg:grid-cols-3">
        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="mb-4">
                <h3 class="text-lg font-serif font-bold text-gray-900">Top Artikel (7 hari)</h3>
                <p class="text-sm text-gray-500">Berdasarkan views terakhir 7 hari</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Title</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse(($topArticles7d ?? collect()) as $a)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-900">
                                <a class="hover:text-brand-700" href="{{ route('articles.show', $a->slug) }}" target="_blank" rel="noopener noreferrer">
                                    {{ $a->title }}
                                </a>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-right">{{ number_format((int) $a->total) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="mb-4">
                <h3 class="text-lg font-serif font-bold text-gray-900">Top Kategori (7 hari)</h3>
                <p class="text-sm text-gray-500">Kategori dengan views terbanyak</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Category</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse(($topCategories7d ?? collect()) as $c)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $c->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-right">{{ number_format((int) $c->total) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-soft border border-gray-100">
            <div class="mb-4">
                <h3 class="text-lg font-serif font-bold text-gray-900">Top Author (7 hari)</h3>
                <p class="text-sm text-gray-500">Author dengan views terbanyak</p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Author</th>
                            <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse(($topAuthors7d ?? collect()) as $au)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 text-sm text-gray-900">{{ $au->name }}</td>
                            <td class="px-4 py-2 text-sm text-gray-700 text-right">{{ number_format((int) $au->total) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="2" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-6 bg-white rounded-xl p-6 shadow-soft border border-gray-100">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-serif font-bold text-gray-900">Trend Views Harian</h3>
                <p class="text-sm text-gray-500">14 hari terakhir</p>
            </div>
        </div>

        @php
        $trendRows = ($viewsByDay ?? collect());
        $maxTrend = (int) ($trendRows->max('total') ?? 0);
        if ($maxTrend <= 0) {
            $maxTrend=1;
            }
            @endphp

            {{-- Simple bar chart --}}
            <div class="mb-6">
            <div class="flex items-stretch gap-2 h-40 w-full">
                @forelse($trendRows as $row)
                @php
                $val = (int) $row->total;
                $pct = max(2, (int) round(($val / $maxTrend) * 100));
                @endphp
                <div class="flex-1 min-w-[12px] h-full flex flex-col">
                    <div class="group relative flex-1 flex items-end">
                        <div
                            class="w-full rounded-t-lg bg-brand-600/80 hover:bg-brand-600 transition-colors"
                            data-bar-height="{{ $pct }}"
                            aria-label="{{ $row->day }}: {{ $val }} views"
                            title="{{ $row->day }}: {{ number_format($val) }} views"></div>

                        <div class="pointer-events-none absolute -top-9 left-1/2 -translate-x-1/2 whitespace-nowrap rounded-md bg-gray-900 px-2 py-1 text-xs text-white opacity-0 shadow-soft transition-opacity group-hover:opacity-100">
                            {{ number_format($val) }}
                        </div>
                    </div>
                    <div class="mt-2 text-[10px] text-gray-500 text-center">
                        {{ \Illuminate\Support\Str::of($row->day)->afterLast('-') }}
                    </div>
                </div>
                @empty
                <div class="flex-1 h-full flex items-center justify-center rounded-xl border border-dashed border-gray-200 bg-gray-50 text-sm text-gray-500">
                    Belum ada data.
                </div>
                @endforelse
            </div>
            <div class="mt-2 text-xs text-gray-500">Skala mengikuti nilai maksimum pada periode.</div>
    </div>

    <script>
        (function() {
            document.querySelectorAll('[data-bar-height]').forEach(function(el) {
                const raw = el.getAttribute('data-bar-height');
                const pct = Number(raw);
                if (!Number.isFinite(pct)) return;
                el.style.height = Math.max(0, Math.min(100, pct)) + '%';
            });
        })();
    </script>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Day</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Views</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse(($viewsByDay ?? collect()) as $row)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 text-sm text-gray-900">{{ $row->day }}</td>
                    <td class="px-4 py-2 text-sm text-gray-700 text-right">{{ number_format((int) $row->total) }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="2" class="px-4 py-8 text-center text-sm text-gray-500">Belum ada data.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    </div>
</x-admin-layout>