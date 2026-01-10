<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $category = Category::query()->where('slug', $slug)->firstOrFail();

        $articles = $category->articles()
            ->published()
            ->with(['category', 'author'])
            ->orderByDesc('published_at')
            ->paginate(20)
            ->withQueryString();

        // Related categories (other categories with articles)
        $relatedCategories = Category::query()
            ->where('id', '!=', $category->id)
            ->withCount(['articles' => function ($q) {
                $q->published();
            }])
            ->having('articles_count', '>', 0)
            ->orderByDesc('articles_count')
            ->limit(5)
            ->get();

        // Popular articles in this category
        $popularArticles = $category->articles()
            ->published()
            ->orderByDesc('views_count')
            ->orderByDesc('published_at')
            ->limit(5)
            ->get();

        return view('news.category', [
            'category' => $category,
            'articles' => $articles,
            'relatedCategories' => $relatedCategories,
            'popularArticles' => $popularArticles,
        ]);
    }
}
