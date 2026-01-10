<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'article_id',
        'user_id',
        'parent_id',
        'author_name',
        'author_email',
        'content',
        'is_approved',
    ];

    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Get the article this comment belongs to
     */
    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Get the user who wrote this comment
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the parent comment
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Get the replies to this comment
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Get approved replies
     */
    public function approvedReplies(): HasMany
    {
        return $this->replies()->where('is_approved', true);
    }

    /**
     * Scope to get only approved comments
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope to get only root comments (not replies)
     */
    public function scopeRootComments($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Get the author name (from user or guest)
     */
    public function getAuthorNameAttribute()
    {
        return $this->user ? $this->user->name : $this->attributes['author_name'];
    }
}
