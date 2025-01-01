<?php

namespace App\Filament\Resources\Car\CarResource\Pages;

use App\Filament\Resources\Car\CarResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateCar extends CreateRecord
{
    protected static string $resource = CarResource::class;

    protected function afterCreate(): void
    {
        // Access the created record
        $record = $this->record;

        // Access the form data
        $data = $this->data;

        // Example: Create related names
        foreach ($data['car_titles_as_array'] as $languageId => $name) {
            $record->titles()->create([
                'language_id' => $languageId,
                'title' => $name,
            ]);
        }
        // Example: Create related names
        foreach ($data['car_descriptions_as_array'] as $languageId => $description) {
            $record->descriptions()->create([
                'language_id' => $languageId,
                'description' => $description,
            ]);
        }
        // Example: Create related names
        foreach ($data['car_types_as_array'] as $languageId => $type) {
            $record->types()->create([
                'language_id' => $languageId,
                'type' => $type,
            ]);
        }

        foreach ($data['package_prices_as_array'] as $currencyId => $price) {
            $record->prices()->create([
                'currency_id' => $currencyId,
                'price' => $price,
            ]);
        }
    }
}
