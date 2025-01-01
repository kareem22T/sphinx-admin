<?php

namespace App\Filament\Resources\ReasonResource\Pages;

use App\Filament\Resources\ReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListReasons extends ListRecords
{
    protected static string $resource = ReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
