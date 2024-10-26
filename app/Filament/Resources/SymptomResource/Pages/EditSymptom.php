<?php

namespace App\Filament\Resources\SymptomResource\Pages;

use App\Filament\Resources\SymptomResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSymptom extends EditRecord
{
    protected static string $resource = SymptomResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

    protected function afterSave(): void
    {
        $this->record->image = $this->record->getImageAttribute();
        $this->record->save();
    }
}
