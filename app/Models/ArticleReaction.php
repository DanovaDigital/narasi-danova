<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArticleReaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'ip_address',
        'type',
    ];

    /**
     * Get the article this reaction belongs to
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the user who reacted
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
