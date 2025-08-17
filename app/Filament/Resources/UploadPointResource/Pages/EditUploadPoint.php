<?php

namespace App\Filament\Resources\UploadPointResource\Pages;

use App\Filament\Resources\UploadPointResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditUploadPoint extends EditRecord
{
    protected static string $resource = UploadPointResource::class;

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
