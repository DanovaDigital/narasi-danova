<x-admin-layout>
    <x-slot name="heading">Authors</x-slot>

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-2xl font-serif font-bold text-gray-900">Manage Authors</h2>
            <p class="text-sm text-gray-500 mt-1">Tambah dan kelola penulis</p>
        </div>
        <a href="{{ route('admin.authors.create') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors shadow-soft">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            New Author
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-soft border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Articles</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($authors as $author)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                @if($author->avatar_url)
                                <img src="{{ $author->avatar_url }}" alt="{{ $author->name }}" class="h-10 w-10 rounded-full object-cover border border-gray-200" />
                                @else
                                <div class="h-10 w-10 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center text-xs font-semibold text-gray-500">
                                    {{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr($author->name, 0, 1)) }}
                                </div>
                                @endif
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $author->name }}</div>
                                    @if($author->bio)
                                    <div class="mt-1 text-xs text-gray-500 line-clamp-1">{{ $author->bio }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $author->slug }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $author->articles_count }}</td>
                        <td class="px-6 py-4 text-right text-sm font-medium space-x-3">
                            <a href="{{ route('admin.authors.edit', $author) }}" class="text-brand-600 hover:text-brand-700">Edit</a>
                            <form method="POST" action="{{ route('admin.authors.destroy', $author) }}" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-700" onclick="return confirm('Delete this author?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 19a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v12z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m-6 4h6m-6 4h6" />
                            </svg>
                            <p class="mt-2">No authors found.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($authors->hasPages())
        <div class="border-t border-gray-200 px-6 py-4 bg-gray-50">
            {{ $authors->links() }}
        </div>
        @endif
    </div>
</x-admin-layout>