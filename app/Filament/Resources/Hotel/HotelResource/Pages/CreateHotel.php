<?php

namespace App\Filament\Resources\Hotel\HotelResource\Pages;

use App\Filament\Resources\Hotel\HotelResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateHotel extends CreateRecord
{
    protected static string $resource = HotelResource::class;

    protected function afterCreate(): void
{
    // Access the created record
    $record = $this->record;

    // Access the form data
    $data = $this->data;

    // Example: Create related names
    foreach ($data['hotel_names_as_array'] as $languageId => $name) {
        $record->names()->create([
            'language_id' => $languageId,
            'name' => $name,
        ]);
    }

    // Example: Create related descriptions
    foreach ($data['hotel_descriptions_as_array'] as $languageId => $description) {
        $record->descriptions()->create([
            'language_id' => $languageId,
            'description' => $description,
        ]);
    }

    // Example: Create related slogans
    foreach ($data['hotel_slogans_as_array'] as $languageId => $slogan) {
        $record->slogans()->create([
            'language_id' => $languageId,
            'slogan' => $slogan,
        ]);
    }

    // Example: Create related addresses
    foreach ($data['hotel_addresses_as_array'] as $languageId => $address) {
        $record->addresses()->create([
            'language_id' => $languageId,
            'address' => $address,
        ]);
    }
}

}
