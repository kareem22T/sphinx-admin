<?php

namespace App\Filament\Resources\Car\CarResource\Pages;

use App\Filament\Resources\Car\CarResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

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
        $record = $this->record;
        $data = $this->data;

        foreach ($data['car_titles_as_array'] as $languageId => $name) {
            $carName = $record->titles()->firstOrNew([
                'language_id' => $languageId,
                'car_id' => $record->id,
            ]);
            $carName->title = $name;
            $carName->save();
            $record->titles()->where('language_id', $languageId)->where('id', '!=', $carName->id)->delete();
        }

        foreach ($data['car_descriptions_as_array'] as $languageId => $description) {
            $carDescription = $record->descriptions()->firstOrNew([
                'language_id' => $languageId,
                'car_id' => $record->id,
            ]);
            $carDescription->description = $description;
            $carDescription->save();
            $record->descriptions()->where('language_id', $languageId)->where('id', '!=', $carDescription->id)->delete();
        }

        foreach ($data['car_types_as_array'] as $languageId => $type) {
            $carType = $record->types()->firstOrNew([
                'language_id' => $languageId,
                'car_id' => $record->id,
            ]);
            $carType->type = $type;
            $carType->save();
            $record->types()->where('language_id', $languageId)->where('id', '!=', $carType->id)->delete();
        }

        foreach ($data['package_prices_as_array'] as $currencyId => $price) {
            $packagePrice = $record->prices()->firstOrNew([
                'currency_id' => $currencyId,
            ]);
            $packagePrice->price = $price;
            $packagePrice->save();
            $record->prices()->where('currency_id', $currencyId)->where('id', '!=', $packagePrice->id)->delete();
        }
    }
}