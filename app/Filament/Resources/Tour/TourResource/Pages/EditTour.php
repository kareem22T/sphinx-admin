<?php

namespace App\Filament\Resources\Tour\TourResource\Pages;

use App\Filament\Resources\Tour\TourResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Log;

class EditTour extends EditRecord
{
    protected static string $resource = TourResource::class;

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
        foreach ($data['tours_titles_as_array'] as $languageId => $title) {
            $tourtitle = $record->titles()->firstOrNew([
                'language_id' => $languageId,
                'tour_id' => $record->id,
            ]);

            $tourtitle->title = $title;
            $title = $tourtitle->title;
            $tourtitle->save();
        }

        // Update or create related intros
        foreach ($data['intros_as_array'] as $languageId => $intro) {
            $tourIntro = $record->intros()->firstOrNew([
                'language_id' => $languageId,
                'tour_id' => $record->id,
            ]);

            $tourIntro->intro = $intro;
            $tourIntro->save();
        }

        // Update or create related locations
        foreach ($data['locations_as_array'] as $languageId => $location) {
            $tourLocation = $record->locations()->firstOrNew([
                'language_id' => $languageId,
                'tour_id' => $record->id,
            ]);

            $tourLocation->location = $location;
            $tourLocation->save();
        }

        // Update or create related transportation
        foreach ($data['transportation_as_array'] as $languageId => $transport) {
            $tourTransport = $record->transportations()->firstOrNew([
                'language_id' => $languageId,
                'tour_id' => $record->id,
            ]);

            $tourTransport->transportation = $transport;
            $tourTransport->save();
        }

        // Update or create related includes
        foreach ($data['includes_as_array'] as $languageId => $include) {
            $tourInclude = $record->includes()->firstOrNew([
                'language_id' => $languageId,
                'tour_id' => $record->id,
            ]);

            $tourInclude->include = $include;
            $tourInclude->save();
        }

        // Update or create related excludes
        foreach ($data['excludes_as_array'] as $languageId => $exclude) {
            $tourExclude = $record->excludes()->firstOrNew([
                'language_id' => $languageId,
                'tour_id' => $record->id,
            ]);

            $tourExclude->exclude = $exclude;
            $tourExclude->save();
        }

        $record->title = $title;
        $record->save();
    }
}
