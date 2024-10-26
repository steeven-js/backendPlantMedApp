<?php

namespace App\Filament\Resources\PlantMedResource\Pages;

use App\Filament\Resources\PlantMedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreatePlantMed extends CreateRecord
{
    protected static string $resource = PlantMedResource::class;

    protected function afterCreate(): void
    {
        $this->record->image = $this->record->getImageAttribute();
        $this->record->save();

        // Urls des images
        $urls = $this->record->getMedia('images')->map(function ($item) {
            return $item->getUrl();
        })->toArray();

        // Enregistrer dans images le tableau des URLs
        $this->record->images = $urls;

        // Sauvegarder les données
        $this->record->save();
    }
}
