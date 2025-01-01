<?php

namespace App\Filament\Resources\Resturant\ResturantResource\Pages;

use App\Filament\Resources\Resturant\ResturantResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateResturant extends CreateRecord
{
    protected static string $resource = ResturantResource::class;
    protected function afterCreate(): void
    {
        // Access the created record
        $record = $this->record;

        // Access the form data
        $data = $this->data;
        $prev_title = '';
        // Example: Create related titles
        foreach ($data['resturants_titles_as_array'] as $languageId => $title) {
            $record->titles()->create([
                'language_id' => $languageId,
                'title' => $title,
            ]);
            $prev_title = $title;
        }

        foreach ($data['resturants_descriptions_as_array'] as $languageId => $description) {
            $record->descriptions()->create([
                'language_id' => $languageId,
                'description' => $description,
            ]);
            $prev_description = $description;
        }

        $record->save();
    }
}
