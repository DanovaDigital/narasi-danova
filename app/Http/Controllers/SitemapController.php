<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Author;
use App\Models\Category;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $xml = Cache::remember('sitemap.xml.v1', 3600, function () {
            $toHttps = static fn(string $value): string => (string) preg_replace('#^http://#i', 'https://', $value);
            $urls = [];

            $urls[] = [
                'loc' => $toHttps(route('home')),
                'lastmod' => now(),
                'changefreq' => 'daily',
                'priority' => '1.0',
            ];

            $urls[] = [
                'loc' => $toHttps(route('articles.index')),
                'lastmod' => now(),
                'changefreq' => 'daily',
                'priority' => '0.8',
            ];

            Category::query()
                ->select(['slug', 'updated_at'])
                ->orderBy('slug')
                ->chunk(200, function ($categories) use (&$urls, $toHttps) {
                    foreach ($categories as $category) {
                        $urls[] = [
                            'loc' => $toHttps(route('category.show', $category->slug)),
                            'lastmod' => $category->updated_at,
                            'changefreq' => 'weekly',
                            'priority' => '0.6',
                        ];
                    }
                });

            Author::query()
                ->select(['slug', 'updated_at'])
                ->orderBy('slug')
                ->chunk(200, function ($authors) use (&$urls, $toHttps) {
                    foreach ($authors as $author) {
                        $urls[] = [
                            'loc' => $toHttps(route('author.show', $author->slug)),
                            'lastmod' => $author->updated_at,
                            'changefreq' => 'weekly',
                            'priority' => '0.6',
                        ];
                    }
                });

            Article::query()
                ->published()
                ->select(['slug', 'updated_at', 'featured_image_url'])
                ->orderByDesc('published_at')
                ->chunk(200, function ($articles) use (&$urls, $toHttps) {
                    foreach ($articles as $article) {
                        $urls[] = [
                            'loc' => $toHttps(route('articles.show', $article->slug)),
                            'lastmod' => $article->updated_at,
                            'changefreq' => 'weekly',
                            'priority' => '0.7',
                            'image' => $article->featured_image_url ? $toHttps((string) $article->featured_image_url) : null,
                        ];
                    }
                });

            $escape = static fn(string $value): string => htmlspecialchars($value, ENT_XML1 | ENT_QUOTES, 'UTF-8');

            $lines = [];
            $lines[] = '<?xml version="1.0" encoding="UTF-8"?>';
            $lines[] = '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">';

            foreach ($urls as $u) {
                $lines[] = '  <url>';
                $lines[] = '    <loc>' . $escape((string) $u['loc']) . '</loc>';

                if (!empty($u['lastmod'])) {
                    $lastmod = $u['lastmod'] instanceof \DateTimeInterface
                        ? $u['lastmod']->format('c')
                        : (string) $u['lastmod'];
                    $lines[] = '    <lastmod>' . $escape($lastmod) . '</lastmod>';
                }

                if (!empty($u['changefreq'])) {
                    $lines[] = '    <changefreq>' . $escape((string) $u['changefreq']) . '</changefreq>';
                }

                if (!empty($u['priority'])) {
                    $lines[] = '    <priority>' . $escape((string) $u['priority']) . '</priority>';
                }

                if (!empty($u['image'])) {
                    $lines[] = '    <image:image>';
                    $lines[] = '      <image:loc>' . $escape((string) $u['image']) . '</image:loc>';
                    $lines[] = '    </image:image>';
                }

                $lines[] = '  </url>';
            }

            $lines[] = '</urlset>';

            return implode("\n", $lines) . "\n";
        });

        return response($xml, 200)
            ->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
