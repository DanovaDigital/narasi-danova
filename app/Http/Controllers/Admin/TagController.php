<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::query()
            ->withCount('articles')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.tags.index', [
            'tags' => $tags,
        ]);
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tags,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:tags,slug'],
        ]);

        $data['slug'] = $this->ensureUniqueSlug(
            $data['slug'] ?? Str::slug($data['name'])
        );

        Tag::query()->create($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag created.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', [
            'tag' => $tag,
        ]);
    }

    public function update(Request $request, Tag $tag)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('tags', 'name')->ignore($tag->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('tags', 'slug')->ignore($tag->id)],
        ]);

        $slugBase = $data['slug'] ?? Str::slug($data['name']);
        $data['slug'] = $this->ensureUniqueSlug($slugBase, $tag->id);

        $tag->update($data);

        return redirect()->route('admin.tags.index')->with('success', 'Tag updated.');
    }

    public function destroy(Tag $tag)
    {
        $tag->articles()->detach();
        $tag->delete();

        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted.');
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
            Tag::query()
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->where('slug', $candidate)
            ->exists()
        ) {
            $candidate = $slug . '-' . $suffix;
            $suffix++;
        }

        return $candidate;
    }
}
