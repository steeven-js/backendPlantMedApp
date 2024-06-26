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
use App\Models\Promotion;

class PlantMedResource extends Resource
{
    protected static ?string $model = PlantMed::class;

    protected static ?string $navigationIcon = 'heroicon-o-heart';

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Plantes médicinales';

    protected static ?string $modelLabel = 'Plantes médicinales';

    protected static ?string $navigationGroup = 'Application';

    protected static ?int $navigationSort = 0;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Informations')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->description('Informations générales sur la plante'),

                        Forms\Components\Section::make('symptomes associés')
                            ->schema([
                                Forms\Components\Select::make('symptoms')
                                    ->label('Symptoms')
                                    ->multiple()
                                    ->options(Symptom::all()->pluck('name', 'name'))
                                    ->searchable(),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('description')
                            ->schema([
                                Forms\Components\Textarea::make('description')
                                    ->label('description')
                                    ->rows(5)
                                    ->cols(10),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('Image')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('image')
                                    ->collection('image')
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('Images')
                            ->schema([
                                Forms\Components\SpatieMediaLibraryFileUpload::make('images')
                                    ->collection('images')
                                    ->multiple()
                                    ->maxFiles(5)
                                    ->hiddenLabel(),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('habitat')
                            ->schema([
                                Forms\Components\Textarea::make('habitat')
                                    ->label('Habitat')
                                    ->rows(5)
                                    ->cols(10),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('propriete')
                            ->schema([
                                Forms\Components\Textarea::make('propriete')
                                    ->label('propriete')
                                    ->rows(5)
                                    ->cols(10),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('usageInterne')
                            ->schema([
                                Forms\Components\Textarea::make('usageInterne')
                                    ->label('usageInterne')
                                    ->rows(5)
                                    ->cols(10),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('usageExterne')
                            ->schema([
                                Forms\Components\Textarea::make('usageExterne')
                                    ->label('usageExterne')
                                    ->rows(5)
                                    ->cols(10),
                            ])
                            ->collapsible(),

                        Forms\Components\Section::make('precaution')
                            ->schema([
                                Forms\Components\Textarea::make('precaution')
                                    ->label('precaution')
                                    ->rows(5)
                                    ->cols(10),
                            ])
                            ->collapsible(),

                        Forms\Components\Repeater::make('sources')
                            ->schema([
                                Forms\Components\TextInput::make('sources')
                                    ->required(),
                            ])
                            ->columns(2)
                    ])
                    ->columnSpan(['lg' => 2]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status de la plante')
                            ->schema([
                                Forms\Components\Toggle::make('is_active')
                                    ->label('Visible')
                                    ->helperText('Activer ou désactiver la plante pour la rendre visible ou non sur l\'application')
                                    ->default(false),

                                Forms\Components\Select::make('promotion')
                                    ->label('Promotion')
                                    ->options(Promotion::all()->pluck('name', 'name'))
                                    ->helperText('Choisir une promotion pour la plante'),
                            ]),

                        Forms\Components\Section::make('Information scientifiques')
                            ->schema([
                                Forms\Components\TextInput::make('nscient'),
                                Forms\Components\TextInput::make('famille'),
                                Forms\Components\TextInput::make('genre'),
                            ])->description('Informations scientifiques sur la plante'),

                        Forms\Components\Section::make('Status de disponibilité')
                            ->schema([
                                Forms\Components\Toggle::make('is_featured')
                                    ->label('Featured')
                                    ->helperText('Marquer la plante comme étant en vedette')
                                    ->default(false),
                                Forms\Components\Toggle::make('is_best_seller')
                                    ->label('Best seller')
                                    ->helperText('Marquer la plante comme étant un best seller')
                                    ->default(false),
                            ]),
                    ])
                    ->columnSpan(['lg' => 1]),
            ])
            ->columns(3);
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
                Tables\Columns\SpatieMediaLibraryImageColumn::make('image')
                    ->label('Image')
                    ->collection('image'),
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
