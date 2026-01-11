<x-admin-layout>
    <x-slot name="heading">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Subscribers</h2>

            <a href="{{ route('admin.subscribers.export', request()->query()) }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Export CSV</a>
        </div>
    </x-slot>

    <div class="mb-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-serif font-bold text-gray-900">Subscribers</h2>
                <p class="text-sm text-gray-500 mt-1">Manage email subscribers</p>
            </div>
            <a href="{{ route('admin.subscribers.export', request()->query()) }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors shadow-soft">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Export CSV
            </a>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-soft border border-gray-200 overflow-hidden">
        <form method="GET" action="{{ route('admin.subscribers.index') }}" class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                <div class="flex gap-2 flex-wrap">
                    @php
                    $filters = [
                    'all' => 'All',
                    'active' => 'Active',
                    'inactive' => 'Inactive',
                    'verified' => 'Verified',
                    'unverified' => 'Unverified',
                    ];
                    @endphp

                    @foreach ($filters as $key => $label)
                    <a
                        href="{{ route('admin.subscribers.index', array_merge(request()->except('page'), ['filter' => $key])) }}"
                        class="rounded-md px-3 py-1.5 text-sm font-medium {{ $filter === $key ? 'bg-brand-600 text-white' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-50' }}">{{ $label }}</a>
                    @endforeach
                </div>

                <div class="flex gap-2 items-end">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1" for="q">Search</label>
                        <input id="q" name="q" value="{{ $q }}" placeholder="Search email" class="block w-64 rounded-md border-gray-300 px-3 py-2 text-sm shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                    </div>
                    <input type="hidden" name="filter" value="{{ $filter }}" />
                    <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800 transition-colors">Apply</button>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Active</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Verified</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Subscribed</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($subscribers as $subscriber)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $subscriber->email }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $subscriber->name ?? '-' }}</td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $subscriber->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $subscriber->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $subscriber->is_verified ? 'Verified' : 'Unverified' }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ optional($subscriber->subscribed_at)->format('Y-m-d H:i') ?? '-' }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium">
                            <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}" class="inline" onsubmit="return confirm('Delete this subscriber?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="mt-2">No subscribers found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($subscribers->hasPages())
        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
            {{ $subscribers->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>