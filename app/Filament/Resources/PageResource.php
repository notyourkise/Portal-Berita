<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class PageResource extends Resource
{
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    
    protected static ?string $navigationLabel = 'Halaman';
    
    protected static ?string $modelLabel = 'Halaman';
    
    protected static ?string $pluralModelLabel = 'Halaman';
    
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Halaman')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn (callable $set, $state) => $set('slug', \Illuminate\Support\Str::slug($state)))
                            ->maxLength(255),
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug URL')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('URL halaman, otomatis dibuat dari judul'),
                        Forms\Components\RichEditor::make('content')
                            ->label('Konten')
                            ->required()
                            ->columnSpanFull()
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'bulletList',
                                'orderedList',
                                'h2',
                                'h3',
                                'blockquote',
                                'codeBlock',
                            ]),
                    ])->columns(2),
                    
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true)
                            ->required(),
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->required()
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan (semakin kecil, semakin atas)'),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan Navbar')
                    ->description('Atur apakah halaman ini ditampilkan di menu navbar frontend')
                    ->schema([
                        Forms\Components\Toggle::make('show_in_navbar')
                            ->label('Tampilkan di Navbar')
                            ->default(false)
                            ->live()
                            ->helperText('Aktifkan untuk menampilkan halaman ini di menu navigasi'),
                        Forms\Components\TextInput::make('navbar_order')
                            ->label('Urutan di Navbar')
                            ->numeric()
                            ->default(0)
                            ->helperText('Urutan tampilan di navbar (semakin kecil, semakin kiri)'),
                        Forms\Components\TextInput::make('navbar_icon')
                            ->label('Icon Navbar')
                            ->placeholder('bi bi-house')
                            ->helperText('Class icon Bootstrap Icons (contoh: bi bi-house, bi bi-person)'),
                        Forms\Components\Select::make('navbar_parent')
                            ->label('Parent Menu')
                            ->options(fn () => Page::whereNull('navbar_parent')
                                ->where('show_in_navbar', true)
                                ->pluck('title', 'slug'))
                            ->placeholder('Tidak ada (menu utama)')
                            ->helperText('Pilih jika ini adalah submenu dari menu lain'),
                        Forms\Components\Select::make('menu_type')
                            ->label('Tipe Menu')
                            ->options([
                                'single' => 'Single Page (Menu Biasa)',
                                'dropdown' => 'Dropdown Menu'
                            ])
                            ->default('single')
                            ->live()
                            ->visible(fn (Forms\Get $get) => $get('show_in_navbar'))
                            ->helperText('Pilih tipe menu: Single untuk link halaman, Dropdown untuk menu dengan sub-menu'),
                        Forms\Components\Repeater::make('dropdown_items')
                            ->label('Item Dropdown')
                            ->schema([
                                Forms\Components\TextInput::make('label')
                                    ->label('Label Menu')
                                    ->required()
                                    ->maxLength(255)
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('icon')
                                    ->label('Icon')
                                    ->placeholder('bi bi-star')
                                    ->helperText('Class icon Bootstrap Icons')
                                    ->columnSpan(1),
                                Forms\Components\TextInput::make('slug')
                                    ->label('Slug (URL)')
                                    ->required()
                                    ->maxLength(255)
                                    ->helperText('URL slug untuk halaman ini (contoh: mahasiswa, kelas)')
                                    ->columnSpan(2),
                                Forms\Components\RichEditor::make('content')
                                    ->label('Konten Halaman')
                                    ->helperText('Isi konten untuk sub-menu ini')
                                    ->columnSpanFull()
                                    ->toolbarButtons([
                                        'bold',
                                        'italic',
                                        'underline',
                                        'strike',
                                        'link',
                                        'heading',
                                        'bulletList',
                                        'orderedList',
                                        'blockquote',
                                        'codeBlock',
                                        'table',
                                    ]),
                            ])
                            ->visible(fn (Forms\Get $get) => $get('menu_type') === 'dropdown' && $get('show_in_navbar'))
                            ->columnSpanFull()
                            ->columns(2)
                            ->addActionLabel('Tambah Item Dropdown')
                            ->defaultItems(0)
                            ->collapsible()
                            ->helperText('Tambahkan item-item yang akan muncul dalam dropdown menu beserta kontennya'),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->copyable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                Tables\Columns\IconColumn::make('show_in_navbar')
                    ->label('Di Navbar')
                    ->boolean()
                    ->trueIcon('heroicon-o-bars-3')
                    ->falseIcon('heroicon-o-minus')
                    ->trueColor('info')
                    ->falseColor('gray'),
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order', 'asc');
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
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
