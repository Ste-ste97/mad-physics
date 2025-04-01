<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('All')->modifyQueryUsing(function ($query) {$query->withoutGlobalScope(SoftDeletingScope::class);}),
            'active' => Tab::make('Active'),
            'deleted' => Tab::make('Deleted')->modifyQueryUsing(function ($query) {$query->withoutGlobalScope(SoftDeletingScope::class)->onlyTrashed();}),
        ];
    }


}
