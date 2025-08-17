<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UploadPointResource\Pages;
use App\Models\UploadPoint;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class UploadPointResource extends Resource
{
    protected static ?string $model = UploadPoint::class;

    protected static ?string $navigationIcon = 'heroicon-o-cloud-arrow-up';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('title')
                                      ->required()->live(onBlur: true)
                                      ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state))),
            Forms\Components\TextInput::make('slug')->required()->unique(ignoreRecord: true),

            Forms\Components\MarkdownEditor::make('instructions')
                                           ->columnSpanFull(),

            Forms\Components\Grid::make(3)->schema([
                Forms\Components\Toggle::make('is_active')->label('Ενεργό')->default(true),
                Forms\Components\DateTimePicker::make('start_at')->label('Έναρξη'),
                Forms\Components\DateTimePicker::make('end_at')->label('Λήξη'),
            ]),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')->searchable()->sortable(),
                Tables\Columns\IconColumn::make('is_active')->label('Active')->boolean(),
                Tables\Columns\TextColumn::make('start_at')->dateTime()->sortable(),
                Tables\Columns\TextColumn::make('end_at')->dateTime()->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make()->label(''),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListUploadPoints::route('/'),
            'create' => Pages\CreateUploadPoint::route('/create'),
            'edit'   => Pages\EditUploadPoint::route('/{record}/edit'),
        ];
    }
}
