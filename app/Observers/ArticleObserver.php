<?php

namespace App\Observers;

use App\Models\Article;
use App\Services\ImageOptimizationService;
use Illuminate\Support\Facades\Cache;

class ArticleObserver
{
    protected ImageOptimizationService $imageService;

    public function __construct(ImageOptimizationService $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Handle the Article "created" event.
     */
    public function created(Article $article): void
    {
        // Optimize cover image if uploaded
        if ($article->cover_image) {
            try {
                $this->imageService->optimizeArticleCover($article->cover_image);
            } catch (\Exception $e) {
                \Log::error('Failed to optimize article cover: ' . $e->getMessage());
            }
        }

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
        // Re-optimize if cover image changed
        if ($article->wasChanged('cover_image') && $article->cover_image) {
            try {
                // Delete old optimized versions
                if ($article->getOriginal('cover_image')) {
                    $this->imageService->deleteOptimizedVersions($article->getOriginal('cover_image'));
                }
                // Create new optimized versions
                $this->imageService->optimizeArticleCover($article->cover_image);
            } catch (\Exception $e) {
                \Log::error('Failed to optimize updated article cover: ' . $e->getMessage());
            }
        }

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
        // Delete optimized image versions
        if ($article->cover_image) {
            try {
                $this->imageService->deleteOptimizedVersions($article->cover_image);
            } catch (\Exception $e) {
                \Log::error('Failed to delete optimized images: ' . $e->getMessage());
            }
        }

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
