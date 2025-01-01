<?php

namespace App\Filament\Resources\Car\CarResource\Pages;

use App\Filament\Resources\Car\CarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCar extends EditRecord
{
    protected static string $resource = CarResource::class;

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

        // Update or create car names
        foreach ($data['car_titles_as_array'] as $languageId => $name) {
            $carName = $record->titles()->firstOrNew([
                'language_id' => $languageId,
                'car_id' => $record->id,
            ]);

            $carName->title = $name;
            $carName->save();
        }

        // Update or create car descriptions
        foreach ($data['car_descriptions_as_array'] as $languageId => $description) {
            $carDescription = $record->descriptions()->firstOrNew([
                'language_id' => $languageId,
                'car_id' => $record->id,
            ]);

            $carDescription->description = $description;
            $carDescription->save();
        }
        // Update or create car types
        foreach ($data['car_types_as_array'] as $languageId => $type) {
            $cartype = $record->types()->firstOrNew([
                'language_id' => $languageId,
                'car_id' => $record->id,
            ]);

            $cartype->type = $type;
            $cartype->save();
        }

        foreach ($data['package_prices_as_array'] as $currencyId => $price) {
            $packageprice = $record->prices()->firstOrNew([
                'language_id' => $currencyId,
                'package_id' => $price,
            ]);

            $packageprice->price = $price;
            $packageprice->save();
        }
    }
}
