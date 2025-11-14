<?php

namespace App\Observers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingObserver
{
    /**
     * Handle the Setting "created" event.
     */
    public function created(Setting $setting): void
    {
        $this->clearCacheIfHomepageSetting($setting);
    }

    /**
     * Handle the Setting "updated" event.
     */
    public function updated(Setting $setting): void
    {
        $this->clearCacheIfHomepageSetting($setting);
    }

    /**
     * Handle the Setting "deleted" event.
     */
    public function deleted(Setting $setting): void
    {
        $this->clearCacheIfHomepageSetting($setting);
    }

    /**
     * Clear cache if homepage-related setting changed
     */
    protected function clearCacheIfHomepageSetting(Setting $setting): void
    {
        // Clear cache jika setting headline_article_id atau hot_topics berubah
        if (in_array($setting->key, ['headline_article_id', 'hot_topics'])) {
            Cache::forget('homepage_data');
            Cache::forget('popular_articles');
        }
    }
}
