<?php

namespace App\Filament\Resources\UploadPointResource\Pages;

use App\Filament\Resources\UploadPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUploadPoints extends ListRecords
{
    protected static string $resource = UploadPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
