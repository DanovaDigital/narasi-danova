<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'author_id',
        'category_id',
        'title',
        'slug',
        'excerpt',
        'body',
        'featured_image',
        'is_featured',
        'is_published',
        'status',
        'published_at',
        'views_count',
        'meta_title',
        'meta_description',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(Author::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function views(): HasMany
    {
        return $this->hasMany(ArticleView::class);
    }

    public function scopePublished($query)
    {
        return $query
            ->where(function ($q) {
                $q->where(function ($q2) {
                    $q2->where('status', 'published');
                })->orWhere(function ($q2) {
                    $q2->where('is_published', true);
                });
            })
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Legacy compatibility: if DB column is still `body`, expose it as `content`.
     */
    public function getContentAttribute($value)
    {
        if ($value !== null) {
            return $value;
        }

        return $this->attributes['body'] ?? null;
    }

    public function getFeaturedImageUrlAttribute(): ?string
    {
        $path = (string) ($this->featured_image ?? '');
        $path = trim($path);

        if ($path === '') {
            return null;
        }

        if (preg_match('#^https?://#i', $path) || str_starts_with($path, '/')) {
            return $path;
        }

        $relative = ltrim($path, '/');
        if (!Storage::disk('public')->exists($relative)) {
            return null;
        }

        return asset('storage/' . $relative);
    }

    public function getFeaturedImageDisplayUrlAttribute(): string
    {
        return $this->featured_image_url ?: asset('images/article-placeholder.svg');
    }

    public function getMetaTitleAttribute($value)
    {
        return $value ?: $this->title;
    }

    public function getMetaDescriptionAttribute($value)
    {
        if ($value) {
            return $value;
        }

        $source = $this->excerpt ?: strip_tags((string) $this->content);
        return Str::limit($source, 160);
    }

    public function getReadTimeMinutesAttribute(): int
    {
        $text = strip_tags((string) ($this->content ?? ''));
        $text = trim(preg_replace('/\s+/', ' ', $text));

        if ($text === '') {
            return 0;
        }

        $words = str_word_count($text);
        $minutes = (int) ceil($words / 200);

        return max(1, $minutes);
    }

    /**
     * Get related articles based on same category or tags
     */
    public function relatedArticles(int $limit = 5)
    {
        return Article::query()
            ->where('id', '!=', $this->id)
            ->published()
            ->where(function ($query) {
                $query->where('category_id', $this->category_id)
                    ->orWhereHas('tags', function ($q) {
                        $q->whereIn('tags.id', $this->tags->pluck('id'));
                    });
            })
            ->orderByDesc('published_at')
            ->limit($limit)
            ->get();
    }
}
