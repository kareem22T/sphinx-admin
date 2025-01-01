<?php

namespace App\Filament\Resources\Tour\TourResource\Pages;

use App\Filament\Resources\Tour\TourResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTour extends ViewRecord
{
    protected static string $resource = TourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
