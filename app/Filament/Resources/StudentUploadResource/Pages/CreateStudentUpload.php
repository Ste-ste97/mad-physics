<?php

namespace App\Filament\Resources\StudentUploadResource\Pages;

use App\Filament\Resources\StudentUploadResource;
use Filament\Resources\Pages\CreateRecord;

class CreateStudentUpload extends CreateRecord
{
    protected static string $resource = StudentUploadResource::class;

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
