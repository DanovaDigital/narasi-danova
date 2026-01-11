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
use Illuminate\Support\Facades\Schema;
use RuntimeException;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        // Admin user (for login to /admin/*)
        $adminName = (string) env('SEED_ADMIN_NAME', 'Admin');
        $adminRole = (string) env('SEED_ADMIN_ROLE', 'super_admin');
        $adminPin = (string) env('SEED_ADMIN_PIN', '123456');

        if (! app()->isLocal() && $adminPin === '123456') {
            throw new RuntimeException('Refusing to seed with default admin PIN outside local environment. Set SEED_ADMIN_PIN.');
        }

        /** @var Admin $admin */
        $admin = Admin::query()->orderBy('id')->first();
        if (! $admin) {
            $admin = Admin::query()->create([
                'name' => $adminName,
                'role' => in_array($adminRole, ['super_admin', 'editor'], true) ? $adminRole : 'super_admin',
            ]);
        }

        // Always ensure PIN exists (admin login requires it)
        if (! $admin->pin_hash) {
            $admin->pin_hash = Hash::make($adminPin);
            $admin->save();
        }

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

        // Create sample articles (make sure homepage has enough data)
        // - 3 featured (for "Pilihan Editor" hierarchical layout)
        // - >=3 trending (for hero carousel)
        $sample = [
            [
                'title' => 'Unggulan: Update Nasional Hari Ini',
                'slug' => 'unggulan-update-nasional-hari-ini',
                'category' => 'nasional',
                'tags' => ['update'],
                'is_featured' => true,
                'hot_score' => 85.2,
                'views_count' => 120,
            ],
            [
                'title' => 'Unggulan: Tren Teknologi yang Lagi Ramai',
                'slug' => 'unggulan-tren-teknologi-yang-lagi-ramai',
                'category' => 'teknologi',
                'tags' => ['viral'],
                'is_featured' => true,
                'hot_score' => 72.7,
                'views_count' => 80,
            ],
            [
                'title' => 'Unggulan: Breaking Ekonomi & Dampaknya',
                'slug' => 'unggulan-breaking-ekonomi-dampaknya',
                'category' => 'ekonomi',
                'tags' => ['breaking', 'update'],
                'is_featured' => true,
                'hot_score' => 90.5,
                'views_count' => 150,
            ],
            [
                'title' => 'Berita Nasional: Agenda Pekan Ini',
                'slug' => 'berita-nasional-agenda-pekan-ini',
                'category' => 'nasional',
                'tags' => ['update'],
                'is_featured' => false,
                'hot_score' => 22.1,
                'views_count' => 30,
            ],
            [
                'title' => 'Teknologi: Ringkasan Produk Baru',
                'slug' => 'teknologi-ringkasan-produk-baru',
                'category' => 'teknologi',
                'tags' => ['update'],
                'is_featured' => false,
                'hot_score' => 18.4,
                'views_count' => 25,
            ],
            [
                'title' => 'Ekonomi: Analisis Singkat Market',
                'slug' => 'ekonomi-analisis-singkat-market',
                'category' => 'ekonomi',
                'tags' => ['breaking'],
                'is_featured' => false,
                'hot_score' => 35.0,
                'views_count' => 55,
            ],
        ];

        foreach ($sample as $idx => $row) {
            $category = $categories->firstWhere('slug', $row['category']);
            $publishedAt = Carbon::now()->subHours(max(1, 10 - $idx * 2));

            $contentText = "Ini adalah isi artikel untuk {$row['title']}\n\n(Tanpa styling ribet, fokus MVP.)";

            $article = Article::query()->firstOrNew(['slug' => $row['slug']]);
            $article->admin_id = $admin->id;
            $article->author_id = $author->id;
            $article->category_id = $category->id;
            $article->title = $row['title'];
            $article->excerpt = 'Ringkasan singkat untuk ' . $row['title'];
            $article->status = 'published';
            $article->is_published = true;
            $article->published_at = $publishedAt;
            $article->is_featured = (bool) ($row['is_featured'] ?? false);
            $article->hot_score = (float) ($row['hot_score'] ?? 0);
            $article->views_count = (int) ($row['views_count'] ?? 0);

            // Store article body/content depending on schema
            $contentColumn = Schema::hasColumn('articles', 'content') ? 'content' : 'body';
            $article->setAttribute($contentColumn, $contentText);
            $article->save();

            $article->tags()->sync(
                $tags->whereIn('slug', $row['tags'])->pluck('id')->all()
            );
        }

        // Generate some fake views to make "hot" ordering visible
        $articles = Article::query()->where('status', 'published')->get();
        foreach ($articles as $i => $article) {
            $views24h = (int) ($article->views_count ?: ([30, 120, 80][$i] ?? 10));
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
