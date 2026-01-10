<?php

namespace App\Console\Commands;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Console\Command;

class ComputeHotScores extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'news:compute-hot-scores';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = now();
        $since24h = now()->subHours(24);
        $since1h = now()->subHour();

        $articles = Article::query()
            ->where('status', 'published')
            ->get();

        foreach ($articles as $article) {
            $publishedAt = $article->published_at ?? $article->created_at ?? $now;
            $ageHours = max(0, $publishedAt->diffInMinutes($now) / 60.0);

            // Exponential decay with tau=24h
            $decay = exp(-$ageHours / 24.0);

            $views24h = ArticleView::query()
                ->where('article_id', $article->id)
                ->where('viewed_at', '>=', $since24h)
                ->count();

            $views1h = ArticleView::query()
                ->where('article_id', $article->id)
                ->where('viewed_at', '>=', $since1h)
                ->count();

            $unique24h = ArticleView::query()
                ->where('article_id', $article->id)
                ->where('viewed_at', '>=', $since24h)
                ->distinct('ip_hash')
                ->count('ip_hash');

            // Simple MVP score: recent velocity has higher weight.
            $raw = ($unique24h * 1.0) + ($views24h * 0.2) + ($views1h * 2.0);
            $score = $raw * $decay;

            $article->forceFill([
                'hot_score' => round($score, 4),
            ])->save();
        }

        $this->info('Hot scores computed for ' . $articles->count() . ' articles.');

        return self::SUCCESS;
    }
}
