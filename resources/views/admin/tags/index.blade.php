<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Tags</h2>
            <a href="{{ route('admin.tags.create') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">+ New Tag</a>
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
                                    <th class="py-2 pr-4">Name</th>
                                    <th class="py-2 pr-4">Slug</th>
                                    <th class="py-2 pr-4">Articles</th>
                                    <th class="py-2">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y">
                                @forelse ($tags as $tag)
                                <tr>
                                    <td class="py-3 pr-4 font-medium text-gray-900">{{ $tag->name }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $tag->slug }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $tag->articles_count }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('admin.tags.edit', $tag) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        <span class="mx-2 text-gray-300">|</span>
                                        <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this tag?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-gray-500">No tags.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $tags->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>