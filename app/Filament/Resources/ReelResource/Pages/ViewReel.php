<?php

namespace App\Filament\Resources\ReelResource\Pages;

use App\Filament\Resources\ReelResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReel extends ViewRecord
{
    protected static string $resource = ReelResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
