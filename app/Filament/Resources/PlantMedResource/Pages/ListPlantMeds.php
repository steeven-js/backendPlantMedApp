<?php

namespace App\Filament\Resources\PlantMedResource\Pages;

use App\Filament\Resources\PlantMedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPlantMeds extends ListRecords
{
    protected static string $resource = PlantMedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
