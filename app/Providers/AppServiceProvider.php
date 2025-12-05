<?php

namespace App\Providers;

use App\Models\Article;
use App\Models\Page;
use App\Models\Setting;
use App\Observers\ArticleObserver;
use App\Observers\SettingObserver;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register Observers untuk auto clear cache
        Article::observe(ArticleObserver::class);
        Setting::observe(SettingObserver::class);

        // Share navbar pages to all views
        View::composer('frontend.layouts.app', function ($view) {
            $navbarPages = Page::inNavbar()
                ->whereNull('navbar_parent')
                ->get();
            $view->with('navbarPages', $navbarPages);
        });
    }
}
