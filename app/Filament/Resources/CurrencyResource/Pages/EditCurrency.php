<?php

namespace App\Filament\Resources\CurrencyResource\Pages;

use App\Filament\Resources\CurrencyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCurrency extends EditRecord
{
    protected static string $resource = CurrencyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
    protected function afterSave(): void
    {
        // Access the created record
        $record = $this->record;

        // Access the form data
        $data = $this->data;

        // Loop through the currency names array and update or create names
        foreach ($data['currency_names_as_array'] as $languageId => $name) {
            $currencyName = $record->names()->firstOrNew([
                'language_id' => $languageId,
                'currency_id' => $record->id,
            ]);

            $currencyName->name = $name;
            $currencyName->save();
        }
    }
}
