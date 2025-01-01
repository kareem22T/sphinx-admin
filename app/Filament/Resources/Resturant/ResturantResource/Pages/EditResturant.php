<?php

namespace App\Filament\Resources\Resturant\ResturantResource\Pages;

use App\Filament\Resources\Resturant\ResturantResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditResturant extends EditRecord
{
    protected static string $resource = ResturantResource::class;

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

        $title = '';
        // Update or create hotel titles
        foreach ($data['resturants_titles_as_array'] as $languageId => $title) {
            $resturanttitle = $record->titles()->firstOrNew([
                'language_id' => $languageId,
                'resturant_id' => $record->id,
            ]);

            $resturanttitle->title = $title;
            $resturanttitle->save();
        }

        foreach ($data['resturants_descriptions_as_array'] as $languageId => $description) {
            $resturantdescription = $record->descriptions()->firstOrNew([
                'language_id' => $languageId,
                'resturant_id' => $record->id,
            ]);

            $resturantdescription->description = $description;
            $description = $resturantdescription->description;
            $resturantdescription->save();
        }

        $record->title = $title;
        $record->save();
    }
}
