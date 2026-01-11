<x-admin-layout>
    <x-slot name="heading">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin: New Article
        </h2>
    </x-slot>

    <div class="max-w-6xl">
        <div class="mb-6">
            <h2 class="text-2xl font-serif font-bold text-gray-900">Create New Article</h2>
            <p class="text-sm text-gray-500 mt-1">Fill in the details to create a new article</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-soft border border-gray-200">
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.articles.store') }}" enctype="multipart/form-data" class="space-y-6" data-article-form>
                            @csrf

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="title">Title</label>
                                <input id="title" name="title" value="{{ old('title') }}" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="slug">Slug</label>
                                <input id="slug" name="slug" value="{{ old('slug') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                                @error('slug')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="author_id">Author</label>
                                    <select id="author_id" name="author_id" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                        <option value="">Select author</option>
                                        @foreach ($authors as $author)
                                        <option value="{{ $author->id }}" @selected(old('author_id')==$author->id)>{{ $author->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('author_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="category_id">Category</label>
                                    <select id="category_id" name="category_id" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                        <option value="">Select category</option>
                                        @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" @selected(old('category_id')==$category->id)>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="excerpt">Excerpt</label>
                                <textarea id="excerpt" name="excerpt" rows="3" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">{{ old('excerpt') }}</textarea>
                                @error('excerpt')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="featured_image">Featured Image</label>
                                <input id="featured_image" type="file" name="featured_image" accept="image/*" class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200" />
                                <p class="mt-1 text-xs text-gray-500">Disarankan landscape (mis. 1200×630). Max 4MB.</p>
                                @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="body">Body</label>
                                <textarea id="body" name="body" rows="12" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500 font-mono text-sm">{{ old('body') }}</textarea>
                                @error('body')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="status">Status</label>
                                    <select id="status" name="status" required class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500">
                                        <option value="draft" @selected(old('status')==='draft' )>Draft</option>
                                        <option value="published" @selected(old('status')==='published' )>Published</option>
                                    </select>
                                    @error('status')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1" for="published_at">Published At (optional)</label>
                                    <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at') }}" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-brand-500 focus:ring-brand-500" />
                                    @error('published_at')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                </div>
                            </div>

                            <div class="flex items-center gap-3 pt-4 border-t border-gray-200">
                                <button type="submit" class="inline-flex items-center gap-2 rounded-lg bg-brand-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-brand-700 transition-colors shadow-soft">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Save Article
                                </button>
                                <a href="{{ route('admin.articles.index') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>

            </div>

            {{-- SEO Preview (sticky right) --}}
            <aside class="lg:col-span-4">
                <div class="sticky top-6 space-y-4">
                    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                        <h3 class="text-lg font-serif font-bold text-gray-900">SEO Preview</h3>
                        <p class="text-sm text-gray-500 mt-1">Preview tampilan di hasil pencarian</p>

                        <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <div class="text-xs text-gray-500" id="seo-url">{{ url('/articles') }}/<span class="text-gray-600" data-seo-slug>slug</span></div>
                            <div class="mt-1 text-base font-semibold text-brand-700" data-seo-title>Judul artikel</div>
                            <div class="mt-1 text-sm text-gray-600" data-seo-desc>Deskripsi singkat (diambil dari excerpt).</div>
                        </div>

                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Title length</span>
                                <span class="font-medium" data-seo-title-len>0</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Description length</span>
                                <span class="font-medium" data-seo-desc-len>0</span>
                            </div>
                        </div>

                        <div class="mt-4 rounded-lg border border-amber-200 bg-amber-50 p-3 text-xs text-amber-800">
                            Tips: title ideal 50–60 karakter, description 140–160 karakter.
                        </div>
                    </div>

                    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                        <h3 class="text-lg font-serif font-bold text-gray-900">Checklist</h3>
                        <div class="mt-3 space-y-2 text-sm">
                            <div class="flex items-start gap-2">
                                <span class="mt-0.5 h-2 w-2 rounded-full bg-gray-300" data-check="title"></span>
                                <span class="text-gray-700">Title terisi & tidak terlalu panjang</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="mt-0.5 h-2 w-2 rounded-full bg-gray-300" data-check="slug"></span>
                                <span class="text-gray-700">Slug rapi (lowercase & dash)</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="mt-0.5 h-2 w-2 rounded-full bg-gray-300" data-check="excerpt"></span>
                                <span class="text-gray-700">Excerpt ada untuk meta description</span>
                            </div>
                            <div class="flex items-start gap-2">
                                <span class="mt-0.5 h-2 w-2 rounded-full bg-gray-300" data-check="image"></span>
                                <span class="text-gray-700">Featured image ada (OG)</span>
                            </div>
                        </div>
                    </div>
                </div>
            </aside>
        </div>

        <script>
            (function() {
                const form = document.querySelector('[data-article-form]');
                if (!form) return;

                const titleInput = form.querySelector('#title');
                const slugInput = form.querySelector('#slug');
                const excerptInput = form.querySelector('#excerpt');
                const imageInput = form.querySelector('#featured_image');

                const seoTitle = document.querySelector('[data-seo-title]');
                const seoSlug = document.querySelector('[data-seo-slug]');
                const seoDesc = document.querySelector('[data-seo-desc]');
                const seoTitleLen = document.querySelector('[data-seo-title-len]');
                const seoDescLen = document.querySelector('[data-seo-desc-len]');

                const checkTitle = document.querySelector('[data-check="title"]');
                const checkSlug = document.querySelector('[data-check="slug"]');
                const checkExcerpt = document.querySelector('[data-check="excerpt"]');
                const checkImage = document.querySelector('[data-check="image"]');

                function slugify(text) {
                    return (text || '')
                        .toString()
                        .trim()
                        .toLowerCase()
                        .replace(/[^a-z0-9\s-]/g, '')
                        .replace(/\s+/g, '-')
                        .replace(/-+/g, '-')
                        .replace(/^-|-$/g, '');
                }

                function setDot(dot, ok) {
                    if (!dot) return;
                    dot.classList.remove('bg-gray-300', 'bg-green-500', 'bg-red-500');
                    dot.classList.add(ok ? 'bg-green-500' : 'bg-red-500');
                }

                function update() {
                    const title = (titleInput?.value || '').trim();
                    const slug = (slugInput?.value || '').trim() || slugify(title);
                    const excerpt = (excerptInput?.value || '').trim();

                    if (seoTitle) seoTitle.textContent = title || 'Judul artikel';
                    if (seoSlug) seoSlug.textContent = slug || 'slug';
                    if (seoDesc) seoDesc.textContent = excerpt || 'Deskripsi singkat (diambil dari excerpt).';

                    const titleLen = title.length;
                    const descLen = excerpt.length;
                    if (seoTitleLen) seoTitleLen.textContent = String(titleLen);
                    if (seoDescLen) seoDescLen.textContent = String(descLen);

                    const okTitle = titleLen >= 10 && titleLen <= 70;
                    const okSlug = slug !== '' && slug === slugify(slug);
                    const okExcerpt = descLen >= 30;
                    const okImage = !!(imageInput && imageInput.files && imageInput.files.length > 0);

                    setDot(checkTitle, okTitle);
                    setDot(checkSlug, okSlug);
                    setDot(checkExcerpt, okExcerpt);
                    setDot(checkImage, okImage);
                }

                ['input', 'change'].forEach(evt => {
                    titleInput?.addEventListener(evt, update);
                    slugInput?.addEventListener(evt, update);
                    excerptInput?.addEventListener(evt, update);
                    imageInput?.addEventListener(evt, update);
                });

                update();
            })();
        </script>
    </div>
</x-admin-layout>