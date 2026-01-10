<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::query()
            ->withCount('articles')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.categories.index', [
            'categories' => $categories,
        ]);
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories,name'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:categories,slug'],
            'description' => ['nullable', 'string'],
        ]);

        $data['slug'] = $this->ensureUniqueSlug(
            $data['slug'] ?? Str::slug($data['name'])
        );

        Category::query()->create($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category created.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('categories', 'name')->ignore($category->id)],
            'slug' => ['nullable', 'string', 'max:255', Rule::unique('categories', 'slug')->ignore($category->id)],
            'description' => ['nullable', 'string'],
        ]);

        $slugBase = $data['slug'] ?? Str::slug($data['name']);
        $data['slug'] = $this->ensureUniqueSlug($slugBase, $category->id);

        $category->update($data);

        return redirect()->route('admin.categories.index')->with('success', 'Category updated.');
    }

    public function destroy(Category $category)
    {
        if ($category->articles()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete category with articles.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Category deleted.');
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
            Category::query()
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
