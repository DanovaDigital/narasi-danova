<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $q = trim((string) $request->query('q', ''));
        $category = $request->query('category');
        $sort = $request->query('sort', 'date'); // date, relevance, views

        $results = Article::query()
            ->published()
            ->with(['category'])
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($q2) use ($q) {
                    $q2->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%");
                });
            })
            ->when($category, function ($query) use ($category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('slug', $category);
                });
            })
            ->when($sort === 'views', fn($q) => $q->orderByDesc('views_count'))
            ->when($sort === 'relevance', fn($q) => $q->orderByDesc('hot_score'))
            ->when($sort === 'date' || !in_array($sort, ['views', 'relevance']), fn($q) => $q->orderByDesc('published_at'))
            ->paginate(20)
            ->withQueryString();

        $categories = Category::query()
            ->withCount(['articles' => fn($q) => $q->published()])
            ->having('articles_count', '>', 0)
            ->orderBy('name')
            ->get();

        return view('news.search', [
            'q' => $q,
            'results' => $results,
            'categories' => $categories,
            'selectedCategory' => $category,
            'selectedSort' => $sort,
        ]);
    }
}
