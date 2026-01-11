<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AuthorController extends Controller
{
    public function index()
    {
        $authors = Author::query()
            ->withCount('articles')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.authors.index', [
            'authors' => $authors,
        ]);
    }

    public function create()
    {
        return view('admin.authors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:authors,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:authors,slug'],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:4096'],
            'avatar_url' => ['nullable', 'string', 'max:2048'],
        ]);

        $data['slug'] = $this->ensureUniqueSlug(
            $data['slug'] ?? Str::slug($data['name'])
        );

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('authors', 'public');
            $data['avatar_url'] = $path;
        }

        unset($data['avatar']);

        Author::query()->create($data);

        return redirect()->route('admin.authors.index')->with('success', 'Author created.');
    }

    public function edit(Author $author)
    {
        return view('admin.authors.edit', [
            'author' => $author,
        ]);
    }

    public function update(Request $request, Author $author)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('authors', 'name')->ignore($author->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('authors', 'slug')->ignore($author->id)],
            'bio' => ['nullable', 'string'],
            'avatar' => ['nullable', 'image', 'max:4096'],
            'avatar_url' => ['nullable', 'string', 'max:2048'],
            'remove_avatar' => ['nullable', 'boolean'],
        ]);

        $slugBase = $data['slug'] ?? Str::slug($data['name']);
        $data['slug'] = $this->ensureUniqueSlug($slugBase, $author->id);

        $rawExisting = $author->getRawOriginal('avatar_url');
        $existingPath = $this->extractStoredAvatarPath($rawExisting);

        if (!empty($data['remove_avatar'])) {
            if ($existingPath) {
                Storage::disk('public')->delete($existingPath);
            }
            $data['avatar_url'] = null;
        }

        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->storePublicly('authors', 'public');
            $data['avatar_url'] = $path;

            if ($existingPath) {
                Storage::disk('public')->delete($existingPath);
            }
        }

        unset($data['avatar'], $data['remove_avatar']);

        $author->update($data);

        return redirect()->route('admin.authors.index')->with('success', 'Author updated.');
    }

    public function destroy(Author $author)
    {
        if ($author->articles()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete author with articles.');
        }

        $author->delete();

        return redirect()->route('admin.authors.index')->with('success', 'Author deleted.');
    }

    private function ensureUniqueSlug(string $slug, ?int $ignoreId = null): string
    {
        $slug = Str::slug($slug);
        if ($slug === '') {
            $slug = Str::random(8);
        }

        $candidate = $slug;
        $suffix = 2;

        while (
            Author::query()
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $candidate)
            ->exists()
        ) {
            $candidate = $slug . '-' . $suffix;
            $suffix++;
        }

        return $candidate;
    }

    private function extractStoredAvatarPath(?string $avatarUrl): ?string
    {
        if (!$avatarUrl) {
            return null;
        }

        $avatarUrl = (string) $avatarUrl;

        if (Str::startsWith($avatarUrl, ['http://', 'https://', 'data:'])) {
            return null;
        }

        if (Str::startsWith($avatarUrl, '/storage/')) {
            return ltrim(Str::after($avatarUrl, '/storage/'), '/');
        }

        if (Str::startsWith($avatarUrl, 'storage/')) {
            return Str::after($avatarUrl, 'storage/');
        }

        // Assume already a relative path stored in DB (e.g. authors/xyz.jpg)
        return $avatarUrl;
    }
}
