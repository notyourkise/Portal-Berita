<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Widgets\ChartWidget;

class ArticleChart extends ChartWidget
{
    protected static ?string $heading = 'Articles by Status';
    
    protected static ?int $sort = 3;

    protected function getData(): array
    {
        $user = auth()->user();
        $isReporter = $user->hasRole('reporter');

        $query = Article::query();
        
        if ($isReporter) {
            $query->where('author_id', $user->id);
        }

        return [
            'datasets' => [
                [
                    'label' => 'Articles',
                    'data' => [
                        $query->clone()->where('status', 'draft')->count(),
                        $query->clone()->where('status', 'review')->count(),
                        $query->clone()->where('status', 'published')->count(),
                        $query->clone()->where('status', 'scheduled')->count(),
                    ],
                    'backgroundColor' => [
                        'rgb(156, 163, 175)', // gray for draft
                        'rgb(245, 158, 11)',  // warning for review
                        'rgb(34, 197, 94)',   // success for published
                        'rgb(59, 130, 246)',  // info for scheduled
                    ],
                ],
            ],
            'labels' => ['Draft', 'In Review', 'Published', 'Scheduled'],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    public static function canView(): bool
    {
        // Only show for Redaktur and Admin
        return auth()->user()->hasAnyRole(['redaktur', 'admin']);
    }
}
