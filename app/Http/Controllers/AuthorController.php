<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    public function show(Request $request, string $slug)
    {
        $author = Author::query()->where('slug', $slug)->firstOrFail();

        $articles = $author->articles()
            ->published()
            ->orderByDesc('published_at')
            ->paginate(20)
            ->withQueryString();

        return view('news.author', [
            'author' => $author,
            'articles' => $articles,
        ]);
    }
}
