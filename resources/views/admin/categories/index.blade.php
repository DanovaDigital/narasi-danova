<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Admin: Categories</h2>
            <a href="{{ route('admin.categories.create') }}" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white hover:bg-indigo-700">+ New Category</a>
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
                                @forelse ($categories as $category)
                                <tr>
                                    <td class="py-3 pr-4 font-medium text-gray-900">{{ $category->name }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $category->slug }}</td>
                                    <td class="py-3 pr-4 text-gray-600">{{ $category->articles_count }}</td>
                                    <td class="py-3">
                                        <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:underline">Edit</a>
                                        <span class="mx-2 text-gray-300">|</span>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Delete this category?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-6 text-gray-500">No categories.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">{{ $categories->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>