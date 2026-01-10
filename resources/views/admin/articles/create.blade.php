<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin: New Article
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.articles.store') }}">
                        @csrf

                        <div>
                            <label>Title</label>
                            <input name="title" value="{{ old('title') }}" />
                            @error('title')<div>{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label>Slug</label>
                            <input name="slug" value="{{ old('slug') }}" />
                            @error('slug')<div>{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label>Author</label>
                            <select name="author_id">
                                @foreach ($authors as $author)
                                <option value="{{ $author->id }}" @selected(old('author_id')==$author->id)>{{ $author->name }}</option>
                                @endforeach
                            </select>
                            @error('author_id')<div>{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label>Category</label>
                            <select name="category_id">
                                @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')<div>{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label>Excerpt</label>
                            <textarea name="excerpt">{{ old('excerpt') }}</textarea>
                            @error('excerpt')<div>{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label>Body</label>
                            <textarea name="body" rows="10">{{ old('body') }}</textarea>
                            @error('body')<div>{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label>Status</label>
                            <select name="status">
                                <option value="draft" @selected(old('status')==='draft' )>draft</option>
                                <option value="published" @selected(old('status')==='published' )>published</option>
                            </select>
                            @error('status')<div>{{ $message }}</div>@enderror
                        </div>

                        <div>
                            <label>Published At (optional)</label>
                            <input name="published_at" value="{{ old('published_at') }}" placeholder="YYYY-MM-DD HH:MM:SS" />
                            @error('published_at')<div>{{ $message }}</div>@enderror
                        </div>

                        <button type="submit">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>