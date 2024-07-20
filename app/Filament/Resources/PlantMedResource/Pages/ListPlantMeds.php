<?php

namespace App\Filament\Resources\PlantMedResource\Pages;

use App\Filament\Resources\PlantMedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;

class ListPlantMeds extends ListRecords
{
    protected static string $resource = PlantMedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make('All'),
            'Visible' => Tab::make()->query(fn ($query) => $query->where('is_active', true)),
            'Non Visible' => Tab::make()->query(fn ($query) => $query->where('is_active', false)),
            'is_featured' => Tab::make()->query(fn ($query) => $query->where('is_featured', true)),
            'is_best_seller' => Tab::make()->query(fn ($query) => $query->where('is_best_seller', true)),
            // 'Recently Viewed' => Tab::make()->query(fn ($query) => $query->where('recentlyViewed', true)),
        ];
    }
}
