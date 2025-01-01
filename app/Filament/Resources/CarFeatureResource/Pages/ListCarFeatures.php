<?php

namespace App\Filament\Resources\CarFeatureResource\Pages;

use App\Filament\Resources\CarFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCarFeatures extends ListRecords
{
    protected static string $resource = CarFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
