<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Symptom;
use App\Models\PlantMed;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\PlantMedResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\PlantMedResource\RelationManagers;

class PlantMedResource extends Resource
{
    protected static ?string $model = PlantMed::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                    ->collection('image'),
                Forms\Components\Select::make('symptoms')
                    ->label('Symptoms')
                    ->multiple()
                    ->options(Symptom::all()->pluck('name', 'name'))
                    ->searchable(),
                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                    ->collection('images')
                    ->multiple(),
                Forms\Components\TextInput::make('nscient')
                    ->maxLength(255),
                Forms\Components\TextInput::make('famille')
                    ->maxLength(255),
                Forms\Components\TextInput::make('genre')
                    ->maxLength(255),
                Forms\Components\Textarea::make('description')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('habitat')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('propriete')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('usageInterne')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('usageExterne')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('precaution')
                    ->maxLength(65535)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sources'),
                Forms\Components\Toggle::make('is_featured')
                    ->required(),
                Forms\Components\Toggle::make('is_best_seller')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
                Forms\Components\Toggle::make('is_available')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('nscient')
                    ->searchable(),
                Tables\Columns\TextColumn::make('famille')
                    ->searchable(),
                Tables\Columns\TextColumn::make('genre')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_best_seller')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_available')
                    ->boolean(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListPlantMeds::route('/'),
            'create' => Pages\CreatePlantMed::route('/create'),
            'edit' => Pages\EditPlantMed::route('/{record}/edit'),
        ];
    }
}
