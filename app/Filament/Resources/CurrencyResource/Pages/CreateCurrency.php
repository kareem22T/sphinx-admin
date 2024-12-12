<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateCurrency extends CreateRecord
{
    protected static string $resource = CurrencyResource::class;

    /**
     * Perform actions after the record is created.
     */
    protected function afterCreate(): void
    {
        // Access the created record
        $record = $this->record;

        // Access the form data
        $data = $this->data;

        // Example: Create related names
        foreach ($data['currency_names_as_array'] as $languageId => $name) {
            $record->names()->create([
                'language_id' => $languageId,
                'name' => $name,
            ]);
        }
    }
}
