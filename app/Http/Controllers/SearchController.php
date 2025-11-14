<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->input('q');
        
        $articles = Article::published()
            ->when($keyword, function ($query, $keyword) {
                return $query->where(function ($q) use ($keyword) {
                    $q->where('title', 'ILIKE', "%{$keyword}%")
                      ->orWhere('body', 'ILIKE', "%{$keyword}%")
                      ->orWhere('excerpt', 'ILIKE', "%{$keyword}%");
                });
            })
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('frontend.search', compact('articles', 'keyword'));
    }
}
