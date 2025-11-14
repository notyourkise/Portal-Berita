<?php

namespace App\Filament\Pages;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Pages\Page;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePassword extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-key';

    protected static string $view = 'filament.pages.change-password';
    
    protected static ?string $navigationLabel = 'Change Password';
    
    protected static ?string $title = 'Change Password';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 99;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Change Your Password')
                    ->description('Update your account password. Make sure to use a strong password.')
                    ->schema([
                        Forms\Components\TextInput::make('current_password')
                            ->label('Current Password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->rules(['required', 'string'])
                            ->validationAttribute('current password')
                            ->autocomplete('current-password')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('password')
                            ->label('New Password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->rules([
                                'required',
                                'string',
                                'confirmed',
                                Password::min(8)
                                    ->mixedCase()
                                    ->numbers()
                                    ->symbols(),
                            ])
                            ->validationAttribute('new password')
                            ->autocomplete('new-password')
                            ->helperText('Password must be at least 8 characters with uppercase, lowercase, numbers, and symbols.')
                            ->columnSpanFull(),
                        
                        Forms\Components\TextInput::make('password_confirmation')
                            ->label('Confirm New Password')
                            ->password()
                            ->required()
                            ->revealable()
                            ->rules(['required', 'string'])
                            ->validationAttribute('password confirmation')
                            ->autocomplete('new-password')
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ])
            ->statePath('data');
    }

    public function updatePassword(): void
    {
        $data = $this->form->getState();

        // Validate current password
        if (!Hash::check($data['current_password'], auth()->user()->password)) {
            Notification::make()
                ->title('Error')
                ->body('Current password is incorrect.')
                ->danger()
                ->send();
            
            return;
        }

        // Update password
        auth()->user()->update([
            'password' => Hash::make($data['password']),
        ]);

        // Send success notification
        Notification::make()
            ->title('Success')
            ->body('Your password has been changed successfully.')
            ->success()
            ->send();
        
        // Redirect to dashboard
        $this->redirect(route('filament.admin.pages.dashboard'));
    }

    protected function getFormActions(): array
    {
        return [
            Forms\Components\Actions\Action::make('updatePassword')
                ->label('Update Password')
                ->submit('updatePassword')
                ->color('primary')
                ->icon('heroicon-o-check'),
        ];
    }
}
