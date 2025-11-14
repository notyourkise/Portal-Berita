<?php

namespace App\Filament\Widgets;

use App\Models\Article;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;

class LatestArticles extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';
    
    protected static ?int $sort = 2;
    
    protected static ?string $pollingInterval = null;

    public function table(Table $table): Table
    {
        $user = auth()->user();
        $isReporter = $user->hasRole('reporter');

        return $table
            ->query(
                Article::query()
                    ->with(['author', 'category'])
                    ->when($isReporter, fn (Builder $query) => $query->where('author_id', $user->id))
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->sortable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'draft',
                        'warning' => 'review',
                        'success' => 'published',
                        'info' => 'scheduled',
                    ]),
                
                Tables\Columns\TextColumn::make('views')
                    ->sortable()
                    ->icon('heroicon-o-eye'),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime()
                    ->sortable()
                    ->since(),
            ])
            ->defaultSort('created_at', 'desc')
            ->heading($isReporter ? 'My Recent Articles' : 'Latest Articles');
    }

    public static function canView(): bool
    {
        return true;
    }
}
