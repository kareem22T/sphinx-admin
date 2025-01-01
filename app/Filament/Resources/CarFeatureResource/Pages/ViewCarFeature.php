<?php

namespace App\Filament\Resources\CarFeatureResource\Pages;

use App\Filament\Resources\CarFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewCarFeature extends ViewRecord
{
    protected static string $resource = CarFeatureResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
