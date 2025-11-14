<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class ArticleGuideWidget extends Widget
{
    protected static string $view = 'filament.widgets.article-guide-widget';
    
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 0;

    public static function canView(): bool
    {
        return auth()->user()->hasRole('reporter');
    }
}
