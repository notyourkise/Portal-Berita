<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ArticleStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $user = auth()->user();
        $isReporter = $user->hasRole('reporter');
        $isRedaktur = $user->hasRole('redaktur');
        $isAdmin = $user->hasRole('admin');

        // Base query
        $query = Article::query();
        
        // Reporter only sees own articles
        if ($isReporter) {
            $query->where('author_id', $user->id);
        }

        $stats = [];

        // REPORTER STATS (Simple)
        if ($isReporter) {
            $stats = [
                Stat::make('My Articles', $query->count())
                    ->description('Total articles written')
                    ->descriptionIcon('heroicon-o-document-text')
                    ->color('primary'),
                
                Stat::make('Published', $query->where('status', 'published')->count())
                    ->description('Live articles')
                    ->descriptionIcon('heroicon-o-check-circle')
                    ->color('success'),
                
                Stat::make('In Review', $query->where('status', 'review')->count())
                    ->description('Waiting for approval')
                    ->descriptionIcon('heroicon-o-clock')
                    ->color('warning'),
                
                Stat::make('Drafts', $query->where('status', 'draft')->count())
                    ->description('Unpublished drafts')
                    ->descriptionIcon('heroicon-o-pencil')
                    ->color('gray'),
            ];
        }

        // REDAKTUR STATS (Editorial Focus)
        if ($isRedaktur) {
            $stats = [
                Stat::make('Total Articles', Article::count())
                    ->description('All articles in system')
                    ->descriptionIcon('heroicon-o-document-text')
                    ->color('primary'),
                
                Stat::make('Pending Review', Article::where('status', 'review')->count())
                    ->description('Needs approval')
                    ->descriptionIcon('heroicon-o-exclamation-triangle')
                    ->color('warning')
                    ->chart([7, 5, 10, 8, 12, 15, Article::where('status', 'review')->count()]),
                
                Stat::make('Published', Article::where('status', 'published')->count())
                    ->description('Live articles')
                    ->descriptionIcon('heroicon-o-check-circle')
                    ->color('success'),
                
                Stat::make('Scheduled', Article::where('status', 'scheduled')->count())
                    ->description('Future publications')
                    ->descriptionIcon('heroicon-o-calendar')
                    ->color('info'),
                
                Stat::make('Total Views', Article::sum('views'))
                    ->description('All time views')
                    ->descriptionIcon('heroicon-o-eye')
                    ->color('primary'),
                
                Stat::make('Articles This Month', Article::whereMonth('created_at', now()->month)->count())
                    ->description('Created this month')
                    ->descriptionIcon('heroicon-o-arrow-trending-up')
                    ->color('success')
                    ->chart([3, 5, 8, 10, 15, 12, Article::whereMonth('created_at', now()->month)->count()]),
            ];
        }

        // ADMIN STATS (Complete Overview)
        if ($isAdmin) {
            $stats = [
                Stat::make('Total Articles', Article::count())
                    ->description('All articles')
                    ->descriptionIcon('heroicon-o-document-text')
                    ->color('primary')
                    ->chart([10, 15, 20, 25, 30, 35, Article::count()]),
                
                Stat::make('Published', Article::where('status', 'published')->count())
                    ->description('Live articles')
                    ->descriptionIcon('heroicon-o-check-circle')
                    ->color('success'),
                
                Stat::make('Pending Review', Article::where('status', 'review')->count())
                    ->description('Needs approval')
                    ->descriptionIcon('heroicon-o-exclamation-triangle')
                    ->color('warning'),
                
                Stat::make('Total Views', Article::sum('views'))
                    ->description('All time views')
                    ->descriptionIcon('heroicon-o-eye')
                    ->color('info'),
                
                Stat::make('Total Users', \App\Models\User::count())
                    ->description('Registered users')
                    ->descriptionIcon('heroicon-o-users')
                    ->color('primary'),
                
                Stat::make('Categories', \App\Models\Category::count())
                    ->description('Active categories')
                    ->descriptionIcon('heroicon-o-folder')
                    ->color('warning'),
                
                Stat::make('Tags', \App\Models\Tag::count())
                    ->description('Available tags')
                    ->descriptionIcon('heroicon-o-tag')
                    ->color('info'),
                
                Stat::make('Featured Articles', Article::where('is_featured', true)->count())
                    ->description('Homepage highlights')
                    ->descriptionIcon('heroicon-o-star')
                    ->color('warning'),
            ];
        }

        return $stats;
    }

    public static function canView(): bool
    {
        return true; // All authenticated users can see
    }
}
