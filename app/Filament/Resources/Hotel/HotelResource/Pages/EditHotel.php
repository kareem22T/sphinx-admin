<?php

namespace App\Filament\Resources\Hotel\HotelResource\Pages;

use App\Filament\Resources\Hotel\HotelResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHotel extends EditRecord
{
    protected static string $resource = HotelResource::class;

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

    // Update or create hotel names
    foreach ($data['hotel_names_as_array'] as $languageId => $name) {
        $hotelName = $record->names()->firstOrNew([
            'language_id' => $languageId,
            'hotel_id' => $record->id,
        ]);

        $hotelName->name = $name;
        $hotelName->save();
    }

    // Update or create hotel descriptions
    foreach ($data['hotel_descriptions_as_array'] as $languageId => $description) {
        $hotelDescription = $record->descriptions()->firstOrNew([
            'language_id' => $languageId,
            'hotel_id' => $record->id,
        ]);

        $hotelDescription->description = $description;
        $hotelDescription->save();
    }

    // Update or create hotel slogans
    foreach ($data['hotel_slogans_as_array'] as $languageId => $slogan) {
        $hotelSlogan = $record->slogans()->firstOrNew([
            'language_id' => $languageId,
            'hotel_id' => $record->id,
        ]);

        $hotelSlogan->slogan = $slogan;
        $hotelSlogan->save();
    }

    // Update or create hotel addresses
    foreach ($data['hotel_addresses_as_array'] as $languageId => $address) {
        $hotelAddress = $record->addresses()->firstOrNew([
            'language_id' => $languageId,
            'hotel_id' => $record->id,
        ]);

        $hotelAddress->address = $address;
        $hotelAddress->save();
    }
}

}
