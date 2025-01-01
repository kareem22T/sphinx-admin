<?php

namespace App\Filament\Resources\FeatureResource\Pages;

use App\Filament\Resources\FeatureResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFeature extends EditRecord
{
    protected static string $resource = FeatureResource::class;

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

        $name = '';
        // Update or create hotel names
        foreach ($data['features_names_as_array'] as $languageId => $name) {
            $FeatureName = $record->names()->firstOrNew([
                'language_id' => $languageId,
                'feature_id' => $record->id,
            ]);

            $FeatureName->name = $name;
            $name = $FeatureName->name;
            $FeatureName->save();
        }
        $record->name = $name;
        $record->save();
    }
}
