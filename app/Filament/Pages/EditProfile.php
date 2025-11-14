<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;

class EditProfile extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static string $view = 'filament.pages.edit-profile';
    
    protected static ?string $navigationLabel = 'My Profile';
    
    protected static ?string $title = 'Edit Profile';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 98;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'name' => auth()->user()->name,
            'email' => auth()->user()->email,
        ]);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Profile Information')
                    ->description('Update your account profile information.')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('John Doe')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->required()
                            ->unique(ignoreRecord: true, table: 'users', column: 'email')
                            ->maxLength(255)
                            ->placeholder('john@example.com')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
                
                Forms\Components\Section::make('Account Information')
                    ->description('Your account details.')
                    ->schema([
                        Forms\Components\Placeholder::make('role')
                            ->label('Role')
                            ->content(fn (): string => auth()->user()->roles->pluck('name')->map(fn($role) => ucfirst($role))->join(', ')),
                        
                        Forms\Components\Placeholder::make('email_verified_at')
                            ->label('Email Verified')
                            ->content(fn (): string => 
                                auth()->user()->email_verified_at 
                                    ? '✅ Verified on ' . auth()->user()->email_verified_at->format('M d, Y')
                                    : '❌ Not verified'
                            ),
                        
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Member Since')
                            ->content(fn (): string => auth()->user()->created_at->format('M d, Y') . ' (' . auth()->user()->created_at->diffForHumans() . ')'),
                        
                        Forms\Components\Placeholder::make('articles_count')
                            ->label('Total Articles')
                            ->content(fn (): string => auth()->user()->articles()->count() . ' articles written'),
                    ])
                    ->columns(2)
                    ->collapsible(),
            ])
            ->statePath('data');
    }

    public function updateProfile(): void
    {
        $data = $this->form->getState();

        // Update user profile
        auth()->user()->update([
            'name' => $data['name'],
            'email' => $data['email'],
        ]);

        // Send success notification
        Notification::make()
            ->title('Success')
            ->body('Your profile has been updated successfully.')
            ->success()
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('updateProfile')
                ->label('Save Changes')
                ->submit('updateProfile')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }
}
