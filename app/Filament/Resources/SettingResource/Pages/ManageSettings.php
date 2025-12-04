<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use App\Models\Setting;
use App\Models\Article;
use App\Models\Tag;
use Filament\Actions;
use Filament\Resources\Pages\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;

class ManageSettings extends Page
{
    protected static string $resource = SettingResource::class;

    protected static string $view = 'filament.resources.setting-resource.pages.manage-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'headline_article_id' => Setting::get('headline_article_id'),
            'hot_topics' => Setting::get('hot_topics', []),
        ]);
    }

    public function form(Form $form): Form
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
                            ->helperText('Pilih 5 tag dari daftar tag yang tersedia. Tag ditampilkan berdasarkan jumlah artikel yang dipublikasikan.')
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
                                ->mapWithKeys(fn($tag) => [$tag->id => "{$tag->name} ({$tag->articles_count} artikel)"])
                            )
                            ->searchable()
                            ->preload()
                            ->multiple()
                            ->maxItems(5)
                            ->minItems(5)
                            ->required(),
                    ])
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        Setting::set('headline_article_id', $data['headline_article_id'], 'integer');
        Setting::set('hot_topics', $data['hot_topics'], 'json');

        Notification::make()
            ->title('Pengaturan berhasil disimpan!')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Actions\Action::make('save')
                ->label('Simpan Pengaturan')
                ->submit('save'),
        ];
    }
}
