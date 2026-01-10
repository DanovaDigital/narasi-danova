<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Article;
use App\Models\ArticleView;
use App\Models\Author;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user (for login to /admin/*)
        Admin::query()->firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'super_admin',
            ]
        );

        $author = Author::query()->firstOrCreate(
            ['slug' => 'redaksi'],
            ['name' => 'Redaksi', 'bio' => 'Tim redaksi']
        );

        $categories = collect([
            ['name' => 'Nasional', 'slug' => 'nasional'],
            ['name' => 'Teknologi', 'slug' => 'teknologi'],
            ['name' => 'Ekonomi', 'slug' => 'ekonomi'],
        ])->map(fn($c) => Category::query()->firstOrCreate(['slug' => $c['slug']], ['name' => $c['name']]));

        $tags = collect([
            ['name' => 'Breaking', 'slug' => 'breaking'],
            ['name' => 'Viral', 'slug' => 'viral'],
            ['name' => 'Update', 'slug' => 'update'],
        ])->map(fn($t) => Tag::query()->firstOrCreate(['slug' => $t['slug']], ['name' => $t['name']]));

        // Create a few sample articles
        $sample = [
            ['title' => 'Contoh Berita Nasional', 'slug' => 'contoh-berita-nasional', 'category' => 'nasional', 'tags' => ['update']],
            ['title' => 'Contoh Berita Teknologi', 'slug' => 'contoh-berita-teknologi', 'category' => 'teknologi', 'tags' => ['viral']],
            ['title' => 'Breaking: Contoh Berita Ekonomi', 'slug' => 'breaking-contoh-berita-ekonomi', 'category' => 'ekonomi', 'tags' => ['breaking', 'update']],
        ];

        foreach ($sample as $idx => $row) {
            $category = $categories->firstWhere('slug', $row['category']);
            $article = Article::query()->firstOrCreate(
                ['slug' => $row['slug']],
                [
                    'author_id' => $author->id,
                    'category_id' => $category->id,
                    'title' => $row['title'],
                    'excerpt' => 'Ringkasan singkat untuk ' . $row['title'],
                    'body' => "Ini adalah isi artikel untuk {$row['title']}\n\n(Tanpa styling ribet, fokus MVP.)",
                    'status' => 'published',
                    'published_at' => Carbon::now()->subHours(6 - $idx * 2),
                    'hot_score' => 0,
                ]
            );

            $article->tags()->sync(
                $tags->whereIn('slug', $row['tags'])->pluck('id')->all()
            );
        }

        // Generate some fake views to make "hot" ordering visible
        $articles = Article::query()->where('status', 'published')->get();
        foreach ($articles as $i => $article) {
            $views24h = [30, 120, 80][$i] ?? 10;
            for ($v = 0; $v < $views24h; $v++) {
                $ts = Carbon::now()->subMinutes(rand(0, 60 * 24 - 1));
                ArticleView::query()->create([
                    'article_id' => $article->id,
                    'ip_hash' => hash('sha256', 'seed-ip-' . $i . '-' . $v),
                    'user_agent_hash' => hash('sha256', 'seed-ua'),
                    'viewed_at' => $ts,
                ]);
            }
        }
    }
}
