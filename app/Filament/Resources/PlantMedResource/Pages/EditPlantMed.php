<?php

namespace App\Filament\Resources\PlantMedResource\Pages;

use App\Filament\Resources\PlantMedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPlantMed extends EditRecord
{
    protected static string $resource = PlantMedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    // After edit utiliser getImageAttribute pour afficher enregistrer l'image dans la propriété image de la table plant_meds
    protected function afterSave(): void
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
