<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class RssController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(50)
            ->get();

        return response()->view('frontend.rss', compact('articles'))
            ->header('Content-Type', 'application/rss+xml');
    }

    public function category($slug)
    {
        $category = \App\Models\Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->limit(50)
            ->get();

        return response()->view('frontend.rss', compact('articles', 'category'))
            ->header('Content-Type', 'application/rss+xml');
    }
}
