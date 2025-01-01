<?php

namespace App\Filament\Resources\ReasonResource\Pages;

use App\Filament\Resources\ReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewReason extends ViewRecord
{
    protected static string $resource = ReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
