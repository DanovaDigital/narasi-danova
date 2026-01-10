<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin: Articles
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <p>
                        <a href="{{ route('admin.articles.create') }}">+ New Article</a>
                    </p>

                    <ul>
                        @forelse ($articles as $article)
                        <li>
                            <a href="{{ route('admin.articles.edit', $article) }}">{{ $article->title }}</a>
                            <small>({{ $article->status }})</small>
                        </li>
                        @empty
                        <li>No articles.</li>
                        @endforelse
                    </ul>

                    <div class="mt-4">{{ $articles->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>