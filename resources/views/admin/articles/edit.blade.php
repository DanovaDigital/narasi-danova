<x-admin-layout>
    <x-slot name="heading">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin: Edit Article
        </h2>
    </x-slot>

    <div class="max-w-4xl">
        <div class="mb-6">
            <h2 class="text-2xl font-serif font-bold text-gray-900">Edit Article</h2>
            <p class="text-sm text-gray-500 mt-1">Update article details</p>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.articles.update', $article) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="title">Title</label>
                        <input id="title" name="title" value="{{ old('title', $article->title) }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                        @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="slug">Slug</label>
                        <input id="slug" name="slug" value="{{ old('slug', $article->slug) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                        @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="author_id">Author</label>
                            <select id="author_id" name="author_id" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                @foreach ($authors as $author)
                                <option value="{{ $author->id }}" @selected(old('author_id', $article->author_id) == $author->id)>{{ $author->name }}</option>
                                @endforeach
                            </select>
                            @error('author_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="category_id">Category</label>
                            <select id="category_id" name="category_id" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $article->category_id) == $category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="excerpt">Excerpt</label>
                        <textarea id="excerpt" name="excerpt" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('excerpt', $article->excerpt) }}</textarea>
                        @error('excerpt')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="body">Body</label>
                        <textarea id="body" name="body" rows="12" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 font-mono text-sm">{{ old('body', $article->body) }}</textarea>
                        @error('body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="status">Status</label>
                            <select id="status" name="status" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                <option value="draft" @selected(old('status', $article->status) === 'draft')>Draft</option>
                                <option value="published" @selected(old('status', $article->status) === 'published')>Published</option>
                            </select>
                            @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1" for="published_at">Published At</label>
                            <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', optional($article->published_at)->format('Y-m-d\TH:i')) }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                            @error('published_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors shadow-soft">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Update Article
                        </button>
                        <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
                    </div>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <form method="POST" action="{{ route('admin.articles.destroy', $article) }}" onsubmit="return confirm('Are you sure you want to delete this article?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-red-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-red-700 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Article
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>