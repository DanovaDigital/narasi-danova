<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Category;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $categorySlug = trim((string) $request->query('category', ''));

        $articles = Article::query()
            ->published()
            ->with(['category', 'tags'])
            ->when($categorySlug !== '', function ($q) use ($categorySlug) {
                $q->whereHas('category', function ($qc) use ($categorySlug) {
                    $qc->where('slug', $categorySlug);
                });
            })
            ->orderByDesc('published_at')
            ->paginate(20)
            ->withQueryString();

        $categories = Category::query()->orderBy('name')->get();

        return view('news.index', [
            'articles' => $articles,
            'categories' => $categories,
            'activeCategory' => $categorySlug,
        ]);
    }

    public function show(Request $request, string $slug)
    {
        $article = Article::query()
            ->with(['category', 'tags'])
            ->where('slug', $slug)
            ->published()
            ->firstOrFail();

        $article->increment('views_count');

        $ip = $request->ip() ?? 'unknown';
        $userAgent = (string) $request->userAgent();

        $referer = $request->headers->get('referer');

        ArticleView::query()->create([
            'article_id' => $article->id,
            'ip_address' => $request->ip(),
            'user_agent' => $userAgent === '' ? null : $userAgent,
            'referer' => $referer,
            'ip_hash' => hash('sha256', $ip),
            'user_agent_hash' => $userAgent === '' ? null : hash('sha256', $userAgent),
            'viewed_at' => now(),
        ]);

        $tagIds = $article->tags->pluck('id')->all();

        $related = Article::query()
            ->published()
            ->with(['category'])
            ->where('id', '!=', $article->id)
            ->where(function ($q) use ($article, $tagIds) {
                $q->where('category_id', $article->category_id);

                if (count($tagIds) > 0) {
                    $q->orWhereHas('tags', function ($qt) use ($tagIds) {
                        $qt->whereIn('tags.id', $tagIds);
                    });
                }
            })
            ->orderByDesc('published_at')
            ->limit(6)
            ->get();

        return view('news.article', [
            'article' => $article,
            'related' => $related,
        ]);
    }
}
