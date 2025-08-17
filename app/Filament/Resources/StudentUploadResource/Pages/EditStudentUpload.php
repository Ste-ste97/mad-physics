<?php

namespace App\Filament\Resources\StudentUploadResource\Pages;

use App\Filament\Resources\StudentUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditStudentUpload extends EditRecord
{
    protected static string $resource = StudentUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
