<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use App\Models\Article;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Pengaturan Website';
    
    protected static ?string $navigationGroup = 'Konfigurasi';
    
    protected static ?int $navigationSort = 99;

    public static function canViewAny(): bool
    {
        return auth()->user()->hasRole('admin');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Pengaturan Homepage')
                    ->description('Tentukan artikel headline dan hot topics yang ditampilkan di homepage')
                    ->schema([
                        Select::make('headline_article_id')
                            ->label('Artikel Headline Utama')
                            ->helperText('Artikel ini akan ditampilkan sebagai headline besar di homepage')
                            ->options(
                                Article::where('status', 'published')
                                    ->latest('published_at')
                                    ->limit(50)
                                    ->pluck('title', 'id')
                            )
                            ->searchable()
                            ->preload()
                            ->required(),
                        
                        Select::make('hot_topics')
                            ->label('Hot Topics (5 Tag)')
                            ->helperText('Pilih 5 tag yang akan ditampilkan di sidebar Hot Topics')
                            ->options(
                                Tag::withCount(['articles' => function($q) {
                                    $q->where('status', 'published')
                                      ->where('published_at', '<=', now());
                                }])
                                ->get()
                                ->filter(function($tag) {
                                    return $tag->articles_count > 0;
                                })
                                ->sortByDesc('articles_count')
                                ->take(50)
                                ->mapWithKeys(fn($tag) => [$tag->id => "{$tag->name} ({$tag->articles_count} artikel)"])
                            )
                            ->searchable()
                            ->preload()
                            ->multiple()
                            ->maxItems(5)
                            ->minItems(5)
                            ->required(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Pengaturan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                //
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
        ];
    }
}
