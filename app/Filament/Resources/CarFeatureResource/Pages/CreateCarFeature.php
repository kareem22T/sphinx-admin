<?php

namespace App\Filament\Resources\CarFeatureResource\Pages;

use App\Filament\Resources\CarFeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCarFeature extends CreateRecord
{
    protected static string $resource = CarFeatureResource::class;

    protected function afterCreate(): void
    {
        // Access the created record
        $record = $this->record;

        // Access the form data
        $data = $this->data;
        $prev_name = '';


        // Example: Create related names
        foreach ($data['features_names_as_array'] as $languageId => $name) {
            $record->names()->create([
                'language_id' => $languageId,
                'name' => $name,
            ]);
            $prev_name = $name;
        }

        $record->name = $prev_name;
        $record->save();
    }
}
