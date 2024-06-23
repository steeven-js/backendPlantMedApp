<?php

namespace App\Filament\Resources\SymptomResource\Pages;

use App\Filament\Resources\SymptomResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSymptom extends CreateRecord
{
    protected static string $resource = SymptomResource::class;

    protected function afterCreate(): void
    {
        $this->record->image = $this->record->getImageAttribute();
        $this->record->save();
    }
}