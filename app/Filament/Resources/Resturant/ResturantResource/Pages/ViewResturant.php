<?php

namespace App\Filament\Resources\Resturant\ResturantResource\Pages;

use App\Filament\Resources\Resturant\ResturantResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewResturant extends ViewRecord
{
    protected static string $resource = ResturantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
