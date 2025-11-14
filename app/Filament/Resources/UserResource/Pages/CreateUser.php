<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateUser extends CreateRecord
{
    protected static string $resource = UserResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'User created successfully';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ensure email is verified by default
        if (empty($data['email_verified_at'])) {
            $data['email_verified_at'] = now();
        }

        return $data;
    }
}
