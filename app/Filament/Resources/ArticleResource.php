<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ArticleResource\Pages;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Tables\Filters\SelectFilter;
use Filament\Support\Enums\FontWeight;
use Illuminate\Support\Str;

class ArticleResource extends Resource
{
    protected static ?string $model = Article::class;

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    
    protected static ?string $navigationLabel = 'Articles';
    
    protected static ?string $navigationGroup = 'Content Management';
    
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $isReporter = auth()->user()->hasRole('reporter');
        $isRedaktur = auth()->user()->hasRole('redaktur');
        $isAdmin = auth()->user()->hasRole('admin');

        return $form
            ->schema([
                Grid::make(3)
                    ->schema([
                        // Main Content Column (2/3)
                        Grid::make(1)
                            ->columnSpan(2)
                            ->schema([
                                Section::make('Article Content')
                                    ->schema([
                                        Forms\Components\TextInput::make('title')
                                            ->required()
                                            ->maxLength(255)
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn ($state, callable $set) => 
                                                $set('slug', Str::slug($state))
                                            ),
                                        
                                        Forms\Components\TextInput::make('slug')
                                            ->required()
                                            ->maxLength(255)
                                            ->unique(ignoreRecord: true)
                                            ->helperText('Auto-generated from title, can be edited'),
                                        
                                        Forms\Components\Textarea::make('excerpt')
                                            ->rows(3)
                                            ->maxLength(500)
                                            ->helperText('Short summary of the article'),
                                        
                                        Forms\Components\RichEditor::make('body')
                                            ->required()
                                            ->columnSpanFull()
                                            ->fileAttachmentsDirectory('articles/attachments'),
                                    ]),

                                Section::make('SEO Settings')
                                    ->collapsed()
                                    ->schema([
                                        Forms\Components\TextInput::make('meta_title')
                                            ->maxLength(255)
                                            ->helperText('Leave empty to use article title'),
                                        
                                        Forms\Components\Textarea::make('meta_description')
                                            ->rows(2)
                                            ->maxLength(160)
                                            ->helperText('Max 160 characters for best SEO'),
                                        
                                        Forms\Components\TextInput::make('meta_keywords')
                                            ->maxLength(255)
                                            ->helperText('Comma-separated keywords'),
                                    ]),
                            ]),

                        // Sidebar Column (1/3)
                        Grid::make(1)
                            ->columnSpan(1)
                            ->schema([
                                Section::make('Publishing')
                                    ->schema([
                                        Forms\Components\Select::make('status')
                                            ->options(function () use ($isReporter, $isRedaktur, $isAdmin) {
                                                // Reporter hanya bisa pilih Draft dan In Review
                                                if ($isReporter) {
                                                    return [
                                                        'draft' => 'Draft',
                                                        'review' => 'In Review',
                                                    ];
                                                }
                                                
                                                // Redaktur dan Admin bisa pilih semua
                                                return [
                                                    'draft' => 'Draft',
                                                    'review' => 'In Review',
                                                    'published' => 'Published',
                                                    'scheduled' => 'Scheduled',
                                                ];
                                            })
                                            ->required()
                                            ->default('draft')
                                            ->helperText(function () use ($isReporter, $isRedaktur, $isAdmin) {
                                                if ($isReporter) return 'Change to "Review" to submit to editor';
                                                if ($isRedaktur) return 'Approve or reject articles';
                                                return 'Full control over article status';
                                            }),
                                        
                                        Forms\Components\DateTimePicker::make('published_at')
                                            ->label('Publish Date')
                                            ->visible(fn ($get) => in_array($get('status'), ['published', 'scheduled']))
                                            ->required(fn ($get) => $get('status') === 'published')
                                            ->native(false)
                                            ->displayFormat('d/m/Y H:i')
                                            ->format('Y-m-d H:i:s')
                                            ->seconds(false)
                                            ->default(now())
                                            ->helperText('Format: Tanggal/Bulan/Tahun Jam:Menit (24 jam)'),
                                        
                                        Forms\Components\DateTimePicker::make('scheduled_at')
                                            ->label('Schedule For')
                                            ->visible(fn ($get) => $get('status') === 'scheduled')
                                            ->required(fn ($get) => $get('status') === 'scheduled')
                                            ->minDate(now())
                                            ->native(false)
                                            ->displayFormat('d/m/Y H:i')
                                            ->format('Y-m-d H:i:s')
                                            ->seconds(false),
                                        
                                        // Featured toggle removed - now controlled via Settings
                                        // Forms\Components\Toggle::make('is_featured')
                                        //     ->label('Featured Article')
                                        //     ->helperText('Show on homepage')
                                        //     ->visible(fn () => $isAdmin),
                                        
                                        Forms\Components\Toggle::make('allow_comments')
                                            ->label('Allow Comments')
                                            ->default(true),
                                    ]),

                                Section::make('Organization')
                                    ->description('Pilih kategori utama dan tag untuk mengorganisir artikel Anda')
                                    ->schema([
                                        Forms\Components\Placeholder::make('organization_help')
                                            ->label('')
                                            ->content('💡 **Cara memilih kategori & tag:**
- **Kategori** = Topik utama (contoh: Olahraga, Politik, Teknologi)
- **Tag** = Sub-topik spesifik (contoh: untuk Olahraga → pilih Sepakbola, Basket, dll)
- Anda bisa memilih **lebih dari 1 tag** untuk artikel yang mencakup beberapa topik'),
                                        
                                        Forms\Components\Select::make('category_id')
                                            ->label('Kategori Utama')
                                            ->relationship('category', 'name')
                                            ->required()
                                            ->searchable()
                                            ->preload()
                                            ->helperText('Pilih 1 kategori: Politik, Ekonomi, Teknologi, Olahraga, Hiburan, Gaya Hidup, Kesehatan, Pendidikan')
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                                Forms\Components\Textarea::make('description'),
                                            ])
                                            ->createOptionUsing(function ($data) {
                                                $category = Category::create([
                                                    'name' => $data['name'],
                                                    'slug' => Str::slug($data['name']),
                                                    'description' => $data['description'] ?? null,
                                                ]);
                                                return $category->id;
                                            })
                                            ->visible(fn () => auth()->user()->can('view_categories')),
                                        
                                        Forms\Components\Select::make('tags')
                                            ->label('Tag / Sub-Kategori (Opsional)')
                                            ->relationship('tags', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->helperText('Contoh: Pilih "Olahraga" sebagai kategori, lalu pilih tag "Sepakbola" + "Liga Indonesia". Bisa kosong jika tidak ada tag yang sesuai.')
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255)
                                                    ->label('Nama Tag'),
                                            ])
                                            ->label('Tags')
                                            ->relationship('tags', 'name')
                                            ->multiple()
                                            ->searchable()
                                            ->preload()
                                            ->createOptionForm([
                                                Forms\Components\TextInput::make('name')
                                                    ->required()
                                                    ->maxLength(255),
                                            ])
                                            ->createOptionUsing(function ($data) {
                                                $tag = Tag::create([
                                                    'name' => $data['name'],
                                                    'slug' => Str::slug($data['name']),
                                                ]);
                                                return $tag->id;
                                            }),
                                    ]),

                                Section::make('Cover Image')
                                    ->description('⚠️ PENTING: Upload gambar dengan rasio 16:9 untuk tampilan terbaik')
                                    ->schema([
                                        Forms\Components\Placeholder::make('image_guide')
                                            ->label('')
                                            ->content('
                                                📏 Panduan Ukuran Gambar:
                                                • Headline Card: 1200x675px atau 800x450px (rasio 16:9)
                                                • Card Artikel: 400x225px atau 600x338px (rasio 16:9)
                                                • Ukuran file maksimal: 5MB
                                                • Format: JPG, PNG, WebP
                                                • Gambar akan otomatis di-crop menggunakan object-fit: cover
                                            ')
                                            ->columnSpanFull(),
                                        
                                        Forms\Components\FileUpload::make('cover_image')
                                            ->label('Upload Image')
                                            ->image()
                                            ->directory('articles/covers')
                                            ->maxSize(5120)
                                            ->imageEditor()
                                            ->imageResizeMode('cover')
                                            ->imageCropAspectRatio('16:9')
                                            ->imageResizeTargetWidth('1200')
                                            ->imageResizeTargetHeight('675')
                                            ->helperText('Klik untuk upload atau drag & drop. Editor gambar tersedia untuk crop.')
                                            ->required(),
                                        
                                        Forms\Components\TextInput::make('cover_image_caption')
                                            ->label('Image Caption')
                                            ->maxLength(255)
                                            ->helperText('Keterangan/kredit foto (opsional)'),
                                    ]),

                                Section::make('Attribution')
                                    ->schema([
                                        Forms\Components\Select::make('author_id')
                                            ->label('Author')
                                            ->relationship('author', 'name')
                                            ->default(auth()->id())
                                            ->required()
                                            ->disabled(fn () => $isReporter)
                                            ->helperText($isReporter ? 'You are the author' : 'Select article author'),
                                        
                                        Forms\Components\Select::make('editor_id')
                                            ->label('Editor')
                                            ->relationship('editor', 'name')
                                            ->searchable()
                                            ->preload()
                                            ->helperText('Who reviewed this article')
                                            ->visible(fn () => !$isReporter),
                                    ]),

                                Section::make('Statistics')
                                    ->schema([
                                        Forms\Components\TextInput::make('views')
                                            ->label('View Count')
                                            ->numeric()
                                            ->default(0)
                                            ->disabled()
                                            ->dehydrated(false),
                                    ])
                                    ->visible(fn ($record) => $record !== null),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        $isReporter = auth()->user()->hasRole('reporter');
        
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(40)
                    ->weight(FontWeight::Bold)
                    ->description(fn (Article $record): string => Str::limit($record->excerpt ?? '', 60)),
                
                Tables\Columns\TextColumn::make('category.name')
                    ->badge()
                    ->color('primary')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('tags.name')
                    ->badge()
                    ->color('warning')
                    ->separator(',')
                    ->limit(2)
                    ->tooltip(function (Article $record) {
                        return $record->tags->pluck('name')->join(', ');
                    })
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'draft' => 'gray',
                        'review' => 'warning',
                        'published' => 'success',
                        'scheduled' => 'info',
                    })
                    ->sortable(),
                
                // Featured column hidden - now controlled via Settings
                // Tables\Columns\IconColumn::make('is_featured')
                //     ->boolean()
                //     ->label('Featured')
                //     ->toggleable(),
                
                Tables\Columns\TextColumn::make('views')
                    ->numeric()
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'review' => 'In Review',
                        'published' => 'Published',
                        'scheduled' => 'Scheduled',
                    ])
                    ->default($isReporter ? 'draft' : null),
                
                SelectFilter::make('category')
                    ->relationship('category', 'name'),
                
                // Featured filter hidden - now controlled via Settings
                // SelectFilter::make('is_featured')
                //     ->label('Featured')
                //     ->options([
                //         '1' => 'Featured',
                //         '0' => 'Not Featured',
                //     ]),
                
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->visible(function (Article $record) {
                        $user = auth()->user();
                        
                        // Admin can delete any article
                        if ($user->hasRole('admin')) {
                            return true;
                        }
                        
                        // Redaktur and Reporter can only delete draft articles they own
                        if (in_array($record->status, ['draft', 'review']) && $record->author_id === $user->id) {
                            return true;
                        }
                        
                        return false;
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->modifyQueryUsing(function (Builder $query) use ($isReporter) {
                // Reporter can only see their own articles
                if ($isReporter) {
                    $query->where('author_id', auth()->id());
                }
                return $query;
            });
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
            'index' => Pages\ListArticles::route('/'),
            'create' => Pages\CreateArticle::route('/create'),
            'view' => Pages\ViewArticle::route('/{record}'),
            'edit' => Pages\EditArticle::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function canCreate(): bool
    {
        return auth()->user()->can('create_articles');
    }

    public static function canEdit($record): bool
    {
        $user = auth()->user();
        
        if ($user->can('edit_articles')) {
            return true;
        }
        
        if ($user->can('edit_own_articles') && $record->author_id === $user->id) {
            // Reporter can't edit if already published or in review by editor
            if ($user->hasRole('reporter') && in_array($record->status, ['published'])) {
                return false;
            }
            return true;
        }
        
        return false;
    }

    public static function canDelete($record): bool
    {
        $user = auth()->user();
        
        if ($user->can('delete_articles')) {
            return true;
        }
        
        if ($user->can('delete_own_articles') && $record->author_id === $user->id) {
            // Reporter can't delete if published
            if ($user->hasRole('reporter') && $record->status === 'published') {
                return false;
            }
            return true;
        }
        
        return false;
    }
}
