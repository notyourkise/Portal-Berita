<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Article;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function show($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $articles = Article::published()
            ->where('category_id', $category->id)
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.category.show', compact('category', 'articles'));
    }
}
