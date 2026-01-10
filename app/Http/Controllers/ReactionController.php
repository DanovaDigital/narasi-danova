<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleReaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReactionController extends Controller
{
    /**
     * Toggle a reaction on an article
     */
    public function toggle(Request $request, Article $article)
    {
        $validated = $request->validate([
            'type' => 'required|in:like,love,insightful,helpful',
        ]);

        $type = $validated['type'];

        // Prepare reaction data
        $reactionData = [
            'article_id' => $article->id,
            'type' => $type,
        ];

        if (Auth::check()) {
            $reactionData['user_id'] = Auth::id();

            // Check if user already reacted with this type
            $existing = ArticleReaction::where('article_id', $article->id)
                ->where('user_id', Auth::id())
                ->where('type', $type)
                ->first();

            if ($existing) {
                // Remove reaction (toggle off)
                $existing->delete();
                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'counts' => $this->getReactionCounts($article),
                ]);
            }
        } else {
            // For guests, use IP address
            $reactionData['ip_address'] = $request->ip();

            // Check if IP already reacted with this type
            $existing = ArticleReaction::where('article_id', $article->id)
                ->where('ip_address', $request->ip())
                ->where('type', $type)
                ->first();

            if ($existing) {
                $existing->delete();
                return response()->json([
                    'success' => true,
                    'action' => 'removed',
                    'counts' => $this->getReactionCounts($article),
                ]);
            }
        }

        // Add new reaction
        ArticleReaction::create($reactionData);

        return response()->json([
            'success' => true,
            'action' => 'added',
            'counts' => $this->getReactionCounts($article),
        ]);
    }

    /**
     * Get reaction counts for an article
     */
    private function getReactionCounts(Article $article): array
    {
        return $article->reactions()
            ->selectRaw('type, COUNT(*) as count')
            ->groupBy('type')
            ->pluck('count', 'type')
            ->toArray();
    }
}
