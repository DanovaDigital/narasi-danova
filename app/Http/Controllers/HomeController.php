<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // Cache homepage data for 5 minutes
        $featured = Cache::remember('home.featured', 300, function () {
            return Article::query()
                ->published()
                ->where('is_featured', true)
                ->orderByDesc('published_at')
                ->limit(3)
                ->get();
        });

        $trending = Cache::remember('home.trending', 300, function () {
            return Article::query()
                ->published()
                ->orderByDesc('hot_score')
                ->orderByDesc('views_count')
                ->orderByDesc('published_at')
                ->limit(10)
                ->get();
        });

        $latest = Cache::remember('home.latest', 300, function () {
            return Article::query()
                ->published()
                ->orderByDesc('published_at')
                ->limit(20)
                ->get();
        });

        // Must Read: High engagement articles (different from trending)
        $mustRead = Cache::remember('home.must_read', 300, function () {
            return Article::query()
                ->published()
                ->where('is_featured', false) // Exclude featured to avoid duplication
                ->orderByDesc('views_count')
                ->orderByDesc('published_at')
                ->limit(4)
                ->get();
        });

        $topCategories = Cache::remember('home.top_categories', 300, function () {
            return Category::query()
                ->withCount(['articles' => function ($q) {
                    $q->published();
                }])
                ->orderByDesc('articles_count')
                ->orderBy('name')
                ->limit(10)
                ->get();
        });

        // Top Creators: Authors with most articles
        $topCreators = Cache::remember('home.top_creators', 300, function () {
            return Author::query()
                ->withCount(['articles' => function ($q) {
                    $q->published();
                }])
                ->having('articles_count', '>', 0)
                ->orderByDesc('articles_count')
                ->limit(6)
                ->get();
        });

        return view('news.home', [
            'featured' => $featured,
            'trending' => $trending,
            'latest' => $latest,
            'mustRead' => $mustRead,
            'topCategories' => $topCategories,
            'topCreators' => $topCreators,
        ]);
    }
}
