<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StudentUploadResource\Pages;
use App\Models\StudentUpload;
use App\Models\UploadPoint;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Auth;

class StudentUploadResource extends Resource
{
    protected static ?string $model = StudentUpload::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';


    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('upload_point_id')
                                   ->required()
                                   ->options(fn() => UploadPoint::query()->pluck('title', 'id'))
                                   ->searchable()
                                   ->preload(),

            Forms\Components\Select::make('user_id')
                                   ->label('Student')
                                   ->required()
                                   ->options(fn() => User::query()->pluck('name', 'id'))
                                   ->searchable()
                                   ->preload(),

            Forms\Components\FileUpload::make('file_path')
                                       ->label('Solution')
                                       ->image()
                                       ->required(),

            Forms\Components\Textarea::make('note')
                                     ->rows(3),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('file_path')->label('Solutions')->square(),
                Tables\Columns\TextColumn::make('user.name')->label('Μαθητής')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('uploadPoint.title')->sortable()->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
//                Tables\Actions\Action::make('download')
//                                     ->label('Λήψη')
//                                     ->icon('heroicon-o-arrow-down-tray')
//                                     ->action(function (StudentUpload $record) {
//                                         return response()->streamDownload(function () use ($record) {
//                                             echo Storage::get($record->file_path);
//                                         }, basename($record->file_path));
//                                     }),
                Tables\Actions\EditAction::make()->label(''),
                Tables\Actions\DeleteAction::make()->label(''),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(function ($query) {
                //
            });
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListStudentUploads::route('/'),
            'create' => Pages\CreateStudentUpload::route('/create'),
            'edit'   => Pages\EditStudentUpload::route('/{record}/edit'),
        ];
    }

    /** Θέτουμε αυτόματα τον χρήστη-δημιουργό στο create */
    public static function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::id();
        return $data;
    }
}
