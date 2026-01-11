<x-admin-layout>
    <x-slot name="heading">New Author</x-slot>

    <div class="max-w-3xl">
        <div class="mb-6">
            <h2 class="text-2xl font-serif font-bold text-gray-900">Create New Author</h2>
            <p class="text-sm text-gray-500 mt-1">Isi data penulis</p>
        </div>

        <div class="bg-white rounded-xl shadow-soft border border-gray-200">
            <div class="p-6">
                <form method="POST" action="{{ route('admin.authors.store') }}" enctype="multipart/form-data" class="space-y-6">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="name">Name</label>
                        <input id="name" name="name" value="{{ old('name') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                        @error('name')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="slug">Slug (optional)</label>
                        <input id="slug" name="slug" value="{{ old('slug') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                        @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="avatar">Avatar (upload)</label>
                        <input id="avatar" type="file" name="avatar" accept="image/*" class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200" />
                        <p class="mt-1 text-xs text-gray-500">PNG/JPG/WEBP. Max 4MB.</p>
                        @error('avatar')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="avatar_url">Atau Avatar URL (optional)</label>
                        <input id="avatar_url" name="avatar_url" value="{{ old('avatar_url') }}" placeholder="https://..." class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                        @error('avatar_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="bio">Bio (optional)</label>
                        <textarea id="bio" name="bio" rows="4" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('bio') }}</textarea>
                        @error('bio')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                    </div>

                    <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                        <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors shadow-soft">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Save Author
                        </button>
                        <a href="{{ route('admin.authors.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>