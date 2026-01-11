<x-admin-layout>
    <x-slot name="heading">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Newsletters</h2>
            <a href="{{ route('admin.newsletters.create') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">+ Compose</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="text-left text-gray-600">
                                <tr>
                                    <th class="py-2 pr-4">Subject</th>
                                    <th class="py-2 pr-4">Sent Count</th>
                                    <th class="py-2 pr-4">Sent By</th>
                                    <th class="py-2 pr-4">Sent At</th>
                                    <th class="py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse ($newsletters as $newsletter)
                                <tr>
                                    <td class="py-3 pr-4 font-medium text-gray-900">{{ $newsletter->subject }}</td>
                                    <td class="py-3 pr-4 text-gray-700">{{ $newsletter->sent_count }}</td>
                                    <td class="py-3 pr-4 text-gray-700">{{ $newsletter->sender?->name ?? '-' }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $newsletter->sent_at?->format('Y-m-d H:i') ?? 'Draft' }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('admin.newsletters.show', $newsletter) }}" class="text-indigo-600 hover:underline">View</a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-gray-500">No newsletters.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $newsletters->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>