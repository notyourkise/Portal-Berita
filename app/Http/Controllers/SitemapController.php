<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Http\Request;

class SitemapController extends Controller
{
    public function index()
    {
        $articles = Article::published()
            ->orderBy('updated_at', 'desc')
            ->get();

        $categories = Category::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        $tags = Tag::where('is_active', true)
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->view('frontend.sitemap', compact('articles', 'categories', 'tags'))
            ->header('Content-Type', 'text/xml');
    }
}
