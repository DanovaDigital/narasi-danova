<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Store a new comment
     */
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:3|max:1000',
            'parent_id' => 'nullable|exists:comments,id',
            'author_name' => 'required_unless:user_id,null|string|max:255',
            'author_email' => 'required_unless:user_id,null|email|max:255',
        ]);

        $commentData = [
            'article_id' => $article->id,
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'is_approved' => Auth::check(), // Auto-approve for logged-in users
        ];

        if (Auth::check()) {
            $commentData['user_id'] = Auth::id();
        } else {
            $commentData['author_name'] = $validated['author_name'];
            $commentData['author_email'] = $validated['author_email'];
        }

        Comment::create($commentData);

        return redirect()
            ->route('articles.show', $article->slug)
            ->with(
                'success',
                Auth::check()
                    ? 'Komentar Anda telah ditambahkan.'
                    : 'Komentar Anda telah dikirim dan menunggu persetujuan.'
            );
    }

    /**
     * Approve a comment (admin only)
     */
    public function approve(Comment $comment)
    {
        if (!Auth::check() || !Auth::user()->canManageContent()) {
            abort(403);
        }

        $comment->update(['is_approved' => true]);

        return redirect()->back()->with('success', 'Komentar telah disetujui.');
    }

    /**
     * Delete a comment
     */
    public function destroy(Comment $comment)
    {
        // Users can delete their own comments, admins can delete any
        if (!Auth::check() || (Auth::id() !== $comment->user_id && !Auth::user()->canManageContent())) {
            abort(403);
        }

        $comment->delete();

        return redirect()->back()->with('success', 'Komentar telah dihapus.');
    }
}
