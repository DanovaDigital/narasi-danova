<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Subscribers</h2>

            <a href="{{ route('admin.subscribers.export', request()->query()) }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">Export CSV</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="GET" action="{{ route('admin.subscribers.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
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
                                class="rounded-md px-3 py-1.5 text-sm {{ $filter === $key ? 'bg-gray-900 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}">{{ $label }}</a>
                            @endforeach
                        </div>

                        <div class="flex gap-2 items-end">
                            <div>
                                <label class="block text-xs text-gray-600" for="q">Search</label>
                                <input id="q" name="q" value="{{ $q }}" placeholder="Search email" class="border rounded-md px-3 py-2 text-sm w-64" />
                            </div>
                            <input type="hidden" name="filter" value="{{ $filter }}" />
                            <button type="submit" class="rounded-md bg-gray-900 px-4 py-2 text-sm font-semibold text-white hover:bg-gray-800">Apply</button>
                        </div>
                    </form>

                    <div class="mt-6 overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600">
                                <tr>
                                    <th class="py-2 pr-4">Email</th>
                                    <th class="py-2 pr-4">Name</th>
                                    <th class="py-2 pr-4">Active</th>
                                    <th class="py-2 pr-4">Verified</th>
                                    <th class="py-2 pr-4">Subscribed</th>
                                    <th class="py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse ($subscribers as $subscriber)
                                <tr>
                                    <td class="py-3 pr-4 font-medium text-gray-900">{{ $subscriber->email }}</td>
                                    <td class="py-3 pr-4 text-gray-700">{{ $subscriber->name ?? '-' }}</td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs {{ $subscriber->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                                            {{ $subscriber->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4">
                                        <span class="inline-flex items-center rounded-full px-2 py-0.5 text-xs {{ $subscriber->is_verified ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                            {{ $subscriber->is_verified ? 'Verified' : 'Unverified' }}
                                        </span>
                                    </td>
                                    <td class="py-3 pr-4 text-gray-600">{{ optional($subscriber->subscribed_at)->format('Y-m-d H:i') ?? '-' }}</td>
                                    <td class="py-3">
                                        <form method="POST" action="{{ route('admin.subscribers.destroy', $subscriber) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this subscriber?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="py-6 text-gray-500">No subscribers.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $subscribers->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>