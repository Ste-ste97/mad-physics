<?php

namespace App\Filament\Resources\UploadPointResource\Pages;

use App\Filament\Resources\UploadPointResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUploadPoint extends CreateRecord
{
    protected static string $resource = UploadPointResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
