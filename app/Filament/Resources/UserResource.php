<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use STS\FilamentImpersonate\Tables\Actions\Impersonate;


class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                         ->label('Name')
                         ->required(),
                TextInput::make('email')
                         ->label('Email')
                         ->email()
                         ->required(),
                TextInput::make('password')
                         ->label('Password')
                         ->password()
                         ->required(fn($livewire) => $livewire instanceof CreateRecord)
                         ->visible(fn($livewire) => $livewire instanceof CreateRecord),
                Select::make('grade_level')
                      ->options([
                          'A' => "A' Lyceum",
                          'B' => "B' Lyceum",
                          'C' => "C' Lyceum",
                      ])
                      ->nullable()
                      ->searchable(),
                Select::make('roles')
                      ->multiple()
                      ->relationship('roles', 'name')
                      ->preload(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')
                          ->searchable()
                          ->sortable(),
                TextColumn::make('name')
                          ->searchable()
                          ->sortable(),
                TextColumn::make('email')
                          ->searchable()
                          ->sortable(),
                TextColumn::make('grade_level')
                          ->formatStateUsing(fn(string|null $state) => match ($state) {
                              'A' => "A' Lyceum",
                              'B' => "B' Lyceum",
                              'C' => "C' Lyceum",
                              default => '-',
                          }),
            ])
            ->filters([
                //
            ])
            ->actions([
                Impersonate::make(), // <---
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
                Tables\Actions\RestoreAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit'   => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
