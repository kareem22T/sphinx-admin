<?php

namespace App\Filament\Resources\Tour\TourResource\Pages;

use App\Filament\Resources\Tour\TourResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Log;

class CreateTour extends CreateRecord
{
    protected static string $resource = TourResource::class;

    protected function afterCreate(): void
    {
        // Access the created record
        $record = $this->record;

        // Access the form data
        $data = $this->data;
        $prev_title = '';

        Log::info($record);
        Log::info($data);

        // Example: Create related titles
        foreach ($data['tours_titles_as_array'] as $languageId => $title) {
            $record->titles()->create([
                'language_id' => $languageId,
                'title' => $title,
            ]);
            $prev_title = $title;
        }
        // Create related intros
        foreach ($data['intros_as_array'] as $languageId => $intro) {
            $record->intros()->create([
                'language_id' => $languageId,
                'intro' => $intro,
            ]);
        }

        // Create related locations
        foreach ($data['locations_as_array'] as $languageId => $location) {
            $record->locations()->create([
                'language_id' => $languageId,
                'location' => $location,
            ]);
        }

        // Create related transportation
        foreach ($data['transportation_as_array'] as $languageId => $transport) {
            $record->transportations()->create([
                'language_id' => $languageId,
                'transportation' => $transport,
            ]);
        }

        // Create related includes
        foreach ($data['includes_as_array'] as $languageId => $include) {
            $record->includes()->create([
                'language_id' => $languageId,
                'include' => $include,
            ]);
        }

        // Create related excludes
        foreach ($data['excludes_as_array'] as $languageId => $exclude) {
            $record->excludes()->create([
                'language_id' => $languageId,
                'exclude' => $exclude,
            ]);
        }

        $record->title = $prev_title;
        $record->save();
    }
}
