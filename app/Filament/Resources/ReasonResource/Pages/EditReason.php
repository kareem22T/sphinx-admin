<?php

namespace App\Filament\Resources\ReasonResource\Pages;

use App\Filament\Resources\ReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditReason extends EditRecord
{
    protected static string $resource = ReasonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }

    protected function afterSave(): void
    {
        // Access the saved record
        $record = $this->record;

        // Access the form data
        $data = $this->data;

        $name = '';
        // Update or create hotel names
        foreach ($data['reasons_names_as_array'] as $languageId => $name) {
            $reasonName = $record->names()->firstOrNew([
                'language_id' => $languageId,
                'reason_id' => $record->id,
            ]);

            $reasonName->name = $name;
            $name = $reasonName->name;
            $reasonName->save();
        }
        $record->name = $name;
        $record->save();
    }
}
