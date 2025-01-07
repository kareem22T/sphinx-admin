<?php

namespace App\Filament\Resources\ReasonResource\Pages;

use App\Filament\Resources\ReasonResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateReason extends CreateRecord
{
    protected static string $resource = ReasonResource::class;

    protected function afterCreate(): void
    {
        // Access the created record
        $record = $this->record;

        // Access the form data
        $data = $this->data;
        $prev_name = '';

        // Example: Create related names
        foreach ($data['reasons_names_as_array'] as $languageId => $name) {
            $record->names()->create([
                'language_id' => $languageId,
                'name' => $name,
            ]);
            $prev_name = $name;
        }

        // Example: Create related names
        foreach ($data['reasons_descriptions_as_array'] as $languageId => $description) {
            $record->descriptions()->create([
                'language_id' => $languageId,
                'description' => $description,
            ]);
        }

        $record->name = $prev_name;
        $record->save();
    }
}
