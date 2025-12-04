<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // Cache homepage data selama 5 menit (300 detik)
        // Otomatis clear saat artikel published via ArticleObserver
        $cacheKey = 'homepage_data';
        $cacheDuration = 300; // 5 menit

        $data = Cache::remember($cacheKey, $cacheDuration, function () {
            // Get headline article from settings, fallback to latest published
            $headlineId = Setting::get('headline_article_id');
            $headlineArticle = $headlineId 
                ? Article::published()->find($headlineId) 
                : Article::published()->latest('published_at')->first();

            // Latest articles - headline + 12 more (total 13)
            if ($headlineArticle) {
                $latestArticles = collect([$headlineArticle])->merge(
                    Article::published()
                        ->where('id', '!=', $headlineArticle->id)
                        ->latest('published_at')
                        ->take(12)
                        ->get()
                );
            } else {
                // Fallback if no articles exist
                $latestArticles = collect([]);
            }

            // Articles by category (Politik, Ekonomi, Olahraga)
            $categories = Category::where('is_active', true)
                ->orderBy('order')
                ->take(3)
                ->get();

            $categorizedArticles = [];
            foreach ($categories as $category) {
                $categorizedArticles[$category->slug] = Article::published()
                    ->where('category_id', $category->id)
                    ->latest('published_at')
                    ->take(4)
                    ->get();
            }

            // Mahasiswa articles
            $mahasiswaCategory = Category::where('slug', 'kegiatan-mahasiswa')
                ->orWhere('name', 'like', '%mahasiswa%')
                ->first();
            
            $mahasiswaArticles = $mahasiswaCategory 
                ? Article::published()
                    ->where('category_id', $mahasiswaCategory->id)
                    ->latest('published_at')
                    ->take(4)
                    ->get()
                : collect([]);

            // Most viewed articles (cache separately for 1 hour)
            $popularArticles = Cache::remember('popular_articles', 3600, function () {
                return Article::published()
                    ->orderBy('views', 'desc')
                    ->take(5)
                    ->get();
            });

            // Hot Topics - Get from settings or fallback to top 5 by article count
            $hotTopicIds = Setting::get('hot_topics', []);
            
            if (!empty($hotTopicIds)) {
                // Use Admin selection, preserve order
                $hotTopics = Tag::whereIn('id', $hotTopicIds)
                    ->withCount(['articles' => function($q) {
                        $q->where('status', 'published')
                          ->where('published_at', '<=', now());
                    }])
                    ->get()
                    ->sortBy(function($tag) use ($hotTopicIds) {
                        return array_search($tag->id, $hotTopicIds);
                    })
                    ->values(); // Reset keys after sorting
            } else {
                // Fallback: top 5 tags by article count
                $hotTopics = Tag::withCount(['articles' => function($q) {
                        $q->where('status', 'published')
                          ->where('published_at', '<=', now());
                    }])
                    ->get()
                    ->filter(function($tag) {
                        return $tag->articles_count > 0;
                    })
                    ->sortByDesc('articles_count')
                    ->take(5)
                    ->values();
            }

            return compact(
                'latestArticles',
                'categories',
                'categorizedArticles',
                'popularArticles',
                'hotTopics',
                'mahasiswaArticles'
            );
        });

        return view('frontend.home', $data);
    }
}
