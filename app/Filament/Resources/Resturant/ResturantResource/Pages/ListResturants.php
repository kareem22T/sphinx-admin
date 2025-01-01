<?php

namespace App\Filament\Resources\Resturant\ResturantResource\Pages;

use App\Filament\Resources\Resturant\ResturantResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListResturants extends ListRecords
{
    protected static string $resource = ResturantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
