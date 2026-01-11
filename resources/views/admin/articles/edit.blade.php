<x-admin-layout>
    <x-slot name="heading">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Admin: Edit Article
        </h2>
    </x-slot>

    <div class="max-w-6xl">
        <div class="mb-6">
            <h2 class="text-2xl font-serif font-bold text-gray-900">Edit Article</h2>
            <p class="text-sm text-gray-500 mt-1">Update article details</p>
        </div>

        <div class="grid gap-6 lg:grid-cols-12">
            <div class="lg:col-span-8">
                <div class="bg-white rounded-xl shadow-soft border border-gray-200">
                    <div class="p-6">
                        <form method="POST" action="{{ route('admin.articles.update', $article) }}" enctype="multipart/form-data" class="space-y-6" data-article-form data-has-existing-image="{{ $article->featured_image_url ? '1' : '0' }}">
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
                                <label class="block text-sm font-medium text-gray-700 mb-1" for="featured_image">Featured Image</label>

                                @if($article->featured_image_url)
                                <div class="mb-3 flex items-start gap-4">
                                    <img src="{{ $article->featured_image_url }}" alt="{{ $article->title }}" class="h-20 w-32 rounded-lg object-cover border border-gray-200" />
                                    <div class="pt-1">
                                        <label class="inline-flex items-center gap-2 text-sm text-gray-700">
                                            <input type="checkbox" name="remove_featured_image" value="1" class="rounded border-gray-300 text-brand-600 focus:ring-brand-500" />
                                            <span>Remove current image</span>
                                        </label>
                                        <p class="mt-1 text-xs text-gray-500">Upload file baru untuk mengganti.</p>
                                    </div>
                                </div>
                                @endif

                                <input id="featured_image" type="file" name="featured_image" accept="image/*" class="block w-full rounded-md border border-gray-300 bg-white px-3 py-2 text-sm shadow-sm file:mr-4 file:rounded-md file:border-0 file:bg-gray-100 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-gray-700 hover:file:bg-gray-200" />
                                <p class="mt-1 text-xs text-gray-500">Disarankan landscape (mis. 1200×630). Max 4MB.</p>
                                @error('featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                                @error('remove_featured_image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
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

            {{-- SEO Preview (sticky right) --}}
            <aside class="lg:col-span-4">
                <div class="sticky top-6 space-y-4">
                    <div class="bg-white rounded-xl shadow-soft border border-gray-200 p-6">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-serif font-bold text-gray-900">SEO Preview</h3>
                                <p class="text-sm text-gray-500 mt-1">Preview tampilan di hasil pencarian</p>
                            </div>
                            <a href="{{ route('articles.show', $article->slug) }}" target="_blank" rel="noopener noreferrer"
                                class="shrink-0 inline-flex items-center gap-2 rounded-lg bg-gray-100 px-3 py-2 text-xs font-semibold text-gray-700 hover:bg-gray-200 transition-colors">
                                Preview
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                </svg>
                            </a>
                        </div>

                        <div class="mt-4 rounded-xl border border-gray-200 bg-gray-50 p-4">
                            <div class="text-xs text-gray-500">{{ url('/articles') }}/<span class="text-gray-600" data-seo-slug>{{ $article->slug }}</span></div>
                            <div class="mt-1 text-base font-semibold text-brand-700" data-seo-title>{{ $article->title }}</div>
                            <div class="mt-1 text-sm text-gray-600" data-seo-desc>{{ $article->excerpt ?: 'Deskripsi singkat (diambil dari excerpt).' }}</div>
                        </div>

                        <div class="mt-4 space-y-2 text-sm">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Title length</span>
                                <span class="font-medium" data-seo-title-len>{{ strlen((string) $article->title) }}</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Description length</span>
                                <span class="font-medium" data-seo-desc-len>{{ strlen((string) $article->excerpt) }}</span>
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
                const removeImageCheckbox = form.querySelector('input[name="remove_featured_image"]');

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

                    // untuk edit: dianggap OK bila ada featured image lama (dan tidak dicentang remove) atau upload baru
                    const hasExistingImage = (form.dataset.hasExistingImage === '1') && !(removeImageCheckbox && removeImageCheckbox.checked);
                    const hasNewImage = !!(imageInput && imageInput.files && imageInput.files.length > 0);
                    const okImage = hasExistingImage || hasNewImage;

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
                    removeImageCheckbox?.addEventListener(evt, update);
                });

                update();
            })();
        </script>
    </div>
</x-admin-layout>