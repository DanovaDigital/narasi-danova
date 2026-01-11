<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\NewsSubmission;
use App\Models\Subscriber;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalArticles = Article::query()->count();
        $totalPublishedArticles = Article::query()->where('status', 'published')->count();
        $totalDraftArticles = Article::query()->where('status', 'draft')->count();
        $totalSubscribers = Subscriber::query()->count();
        $totalSubmissions = NewsSubmission::query()->count();

        $totalViews = ArticleView::query()->count();
        $viewsToday = ArticleView::query()->where('viewed_at', '>=', now()->startOfDay())->count();
        $uniqueViewsToday = ArticleView::query()
            ->where('viewed_at', '>=', now()->startOfDay())
            ->select('ip_hash')
            ->distinct()
            ->count();
        $views24h = ArticleView::query()->where('viewed_at', '>=', now()->subHours(24))->count();
        $views7d = ArticleView::query()->where('viewed_at', '>=', now()->subDays(7))->count();
        $uniqueViews7d = ArticleView::query()
            ->where('viewed_at', '>=', now()->subDays(7))
            ->select('ip_hash')
            ->distinct()
            ->count();

        $newSubscribers7d = Subscriber::query()->where('created_at', '>=', now()->subDays(7))->count();
        $newSubmissions7d = NewsSubmission::query()->where('created_at', '>=', now()->subDays(7))->count();

        $topArticles = Article::query()
            ->orderByDesc('views_count')
            ->limit(10)
            ->get(['id', 'title', 'slug', 'views_count', 'published_at', 'status']);

        $viewsByDay = ArticleView::query()
            ->selectRaw('DATE(viewed_at) as day, COUNT(*) as total')
            ->where('viewed_at', '>=', now()->subDays(13)->startOfDay())
            ->groupBy(DB::raw('DATE(viewed_at)'))
            ->orderBy(DB::raw('DATE(viewed_at)'))
            ->get();

        $topArticles7d = ArticleView::query()
            ->join('articles', 'articles.id', '=', 'article_views.article_id')
            ->where('article_views.viewed_at', '>=', now()->subDays(7))
            ->select('articles.id', 'articles.title', 'articles.slug', DB::raw('COUNT(*) as total'))
            ->groupBy('articles.id', 'articles.title', 'articles.slug')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topCategories7d = ArticleView::query()
            ->join('articles', 'articles.id', '=', 'article_views.article_id')
            ->join('categories', 'categories.id', '=', 'articles.category_id')
            ->where('article_views.viewed_at', '>=', now()->subDays(7))
            ->select('categories.id', 'categories.name', DB::raw('COUNT(*) as total'))
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topAuthors7d = ArticleView::query()
            ->join('articles', 'articles.id', '=', 'article_views.article_id')
            ->leftJoin('authors', 'authors.id', '=', 'articles.author_id')
            ->where('article_views.viewed_at', '>=', now()->subDays(7))
            ->whereNotNull('articles.author_id')
            ->select('authors.id', 'authors.name', DB::raw('COUNT(*) as total'))
            ->groupBy('authors.id', 'authors.name')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        $topReferrersRaw = ArticleView::query()
            ->whereNotNull('referer')
            ->where('referer', '!=', '')
            ->where('viewed_at', '>=', now()->subDays(7))
            ->selectRaw('referer, COUNT(*) as total')
            ->groupBy('referer')
            ->orderByDesc('total')
            ->limit(50)
            ->get();

        $topReferrers = $topReferrersRaw
            ->map(function ($row) {
                $url = (string) $row->referer;
                $host = parse_url($url, PHP_URL_HOST);
                $host = $host ? strtolower((string) $host) : 'unknown';
                return [
                    'host' => $host,
                    'total' => (int) $row->total,
                ];
            })
            ->groupBy('host')
            ->map(fn($rows, $host) => [
                'host' => $host,
                'total' => (int) collect($rows)->sum('total'),
            ])
            ->sortByDesc('total')
            ->values()
            ->take(10);

        return view('admin.dashboard', [
            'totalArticles' => $totalArticles,
            'totalPublishedArticles' => $totalPublishedArticles,
            'totalDraftArticles' => $totalDraftArticles,
            'totalSubscribers' => $totalSubscribers,
            'totalSubmissions' => $totalSubmissions,
            'totalViews' => $totalViews,
            'viewsToday' => $viewsToday,
            'uniqueViewsToday' => $uniqueViewsToday,
            'views24h' => $views24h,
            'views7d' => $views7d,
            'uniqueViews7d' => $uniqueViews7d,
            'newSubscribers7d' => $newSubscribers7d,
            'newSubmissions7d' => $newSubmissions7d,
            'topArticles' => $topArticles,
            'viewsByDay' => $viewsByDay,
            'topArticles7d' => $topArticles7d,
            'topCategories7d' => $topCategories7d,
            'topAuthors7d' => $topAuthors7d,
            'topReferrers' => $topReferrers,
        ]);
    }
}
