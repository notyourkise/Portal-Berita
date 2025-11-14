<?php

namespace App\Filament\Resources\ArticleResource\Pages;

use App\Filament\Resources\ArticleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditArticle extends EditRecord
{
    protected static string $resource = ArticleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make()
                ->visible(function () {
                    $user = auth()->user();
                    $record = $this->record;
                    
                    // Admin can delete any article
                    if ($user->hasRole('admin')) {
                        return true;
                    }
                    
                    // Redaktur and Reporter can only delete draft/review articles they own
                    if (in_array($record->status, ['draft', 'review']) && $record->author_id === $user->id) {
                        return true;
                    }
                    
                    return false;
                }),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $user = auth()->user();
        
        // Set editor_id when Redaktur or Admin publishes/schedules an article
        if (in_array($data['status'], ['published', 'scheduled'])) {
            // Only set editor_id if it's not already set and user is Redaktur/Admin
            if (empty($this->record->editor_id) && $user->hasAnyRole(['redaktur', 'admin'])) {
                $data['editor_id'] = $user->id;
            }
        }

        // Auto-set published_at for published status
        if ($data['status'] === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
