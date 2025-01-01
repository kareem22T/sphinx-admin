<?php

namespace App\Filament\Resources\Tour\TourResource\Pages;

use App\Filament\Resources\Tour\TourResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTours extends ListRecords
{
    protected static string $resource = TourResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
