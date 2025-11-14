<?php

namespace App\Observers;

use App\Models\Article;
use Illuminate\Support\Facades\Cache;

class ArticleObserver
{
    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        // Clear cache jika artikel langsung published saat dibuat
        if ($article->status === 'published') {
            $this->clearHomepageCache();
        }
    }

    /**
     * Handle the Article "updated" event.
     */
    public function updated(Article $article): void
    {
        // Clear cache jika artikel baru saja di-publish
        if ($article->wasChanged('status') && $article->status === 'published') {
            $this->clearHomepageCache();
        }
        
        // Clear cache jika artikel published di-update (judul, gambar, dll)
        if ($article->status === 'published' && $article->wasChanged(['title', 'excerpt', 'cover_image', 'category_id'])) {
            $this->clearHomepageCache();
        }
    }

    /**
     * Handle the Article "deleted" event.
     */
    public function deleted(Article $article): void
    {
        // Clear cache jika artikel published dihapus
        if ($article->status === 'published') {
            $this->clearHomepageCache();
        }
    }

    /**
     * Handle the Article "restored" event.
     */
    public function restored(Article $article): void
    {
        // Clear cache jika artikel published di-restore
        if ($article->status === 'published') {
            $this->clearHomepageCache();
        }
    }

    /**
     * Clear homepage cache
     */
    protected function clearHomepageCache(): void
    {
        Cache::forget('homepage_data');
        Cache::forget('popular_articles');
    }
}
