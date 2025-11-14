<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function show($slug)
    {
        $tag = Tag::where('slug', $slug)->firstOrFail();

        $articles = $tag->articles()
            ->published()
            ->with(['category', 'author'])
            ->orderBy('published_at', 'desc')
            ->paginate(12);

        return view('frontend.tag.show', compact('tag', 'articles'));
    }
}
