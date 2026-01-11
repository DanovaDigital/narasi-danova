<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Author extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'bio',
        'avatar_url',
        'social_links',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }

    public function getAvatarUrlAttribute($value): ?string
    {
        if (!$value) {
            return null;
        }

        $value = (string) $value;

        if (Str::startsWith($value, ['http://', 'https://', 'data:'])) {
            return $value;
        }

        // Already a public URL produced by Storage::url(), keep as-is
        if (Str::startsWith($value, ['/storage/', 'storage/'])) {
            return $value;
        }

        // Treat as path in public storage (e.g., authors/xxx.jpg)
        return asset('storage/' . ltrim($value, '/'));
    }
}
