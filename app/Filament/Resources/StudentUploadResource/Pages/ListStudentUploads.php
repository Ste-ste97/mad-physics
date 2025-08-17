<?php

namespace App\Filament\Resources\StudentUploadResource\Pages;

use App\Filament\Resources\StudentUploadResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStudentUploads extends ListRecords
{
    protected static string $resource = StudentUploadResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
